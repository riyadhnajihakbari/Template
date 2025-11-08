<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::with('category');
        
        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        $menuItems = $query->latest()->paginate(20);
        $categories = Category::all();
        
        return view('menu.index', compact('menuItems', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        
        // If no categories, redirect to create category first
        if ($categories->count() == 0) {
            return redirect()->route('menu.index')
                ->with('error', 'Silakan buat kategori terlebih dahulu');
        }
        
        return view('menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Set default is_active
        $validated['is_active'] = true;

        // Handle photo upload - LANGSUNG KE PUBLIC
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            
            // Create directory if not exists
            $uploadPath = public_path('uploads/menu');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            // Move file to public/uploads/menu
            $photo->move($uploadPath, $filename);
            
            // Save relative path (without 'public/')
            $validated['photo_url'] = 'uploads/menu/' . $filename;
        }

        MenuItem::create($validated);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = Category::where('is_active', true)->get();
        return view('menu.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle photo upload - LANGSUNG KE PUBLIC
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($menuItem->photo_url) {
                $oldPhotoPath = public_path($menuItem->photo_url);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }
            
            $photo = $request->file('photo');
            
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            
            // Create directory if not exists
            $uploadPath = public_path('uploads/menu');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            // Move file to public/uploads/menu
            $photo->move($uploadPath, $filename);
            
            // Save relative path
            $validated['photo_url'] = 'uploads/menu/' . $filename;
        }

        $menuItem->update($validated);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate');
    }

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
        
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus');
    }

    public function toggleStatus(MenuItem $menuItem)
    {
        $menuItem->update(['is_active' => !$menuItem->is_active]);
        
        $status = $menuItem->is_active ? 'aktif' : 'nonaktif';
        return back()->with('success', "Menu berhasil diubah menjadi {$status}");
    }
}