<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MenuItem::with('category');
        
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        $menuItems = $query->latest()->paginate(20);
        $categories = Category::all();
        
        return view('menu.index', compact('menuItems', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('menu.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            
            // Create directory if not exists
            $uploadPath = public_path('uploads/menu');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            // Generate unique filename
            $filename = time() . '_' . Str::slug($request->name) . '.' . $photo->getClientOriginalExtension();
            
            // Move file to public/uploads/menu
            $photo->move($uploadPath, $filename);
            
            // Save relative path to database
            $validated['photo_url'] = 'uploads/menu/' . $filename;
        }
        
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        
        MenuItem::create($validated);
        
        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menuItem)
    {
        return view('menu.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        $categories = Category::all();
        return view('menu.edit', compact('menuItem', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($menuItem->photo_url) {
                $oldPhotoPath = public_path($menuItem->photo_url);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }
            
            $photo = $request->file('photo');
            
            // Create directory if not exists
            $uploadPath = public_path('uploads/menu');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            // Generate unique filename
            $filename = time() . '_' . Str::slug($request->name) . '.' . $photo->getClientOriginalExtension();
            
            // Move file to public/uploads/menu
            $photo->move($uploadPath, $filename);
            
            // Save relative path to database
            $validated['photo_url'] = 'uploads/menu/' . $filename;
        }
        
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        
        $menuItem->update($validated);
        
        return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        // Delete photo if exists
        if ($menuItem->photo_url) {
            $photoPath = public_path($menuItem->photo_url);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }
        
        $menuItem->delete();
        
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Toggle menu status (active/inactive)
     */
    public function toggleStatus(MenuItem $menuItem)
    {
        $menuItem->is_active = !$menuItem->is_active;
        $menuItem->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Status menu berhasil diubah!',
            'is_active' => $menuItem->is_active
        ]);
    }
}