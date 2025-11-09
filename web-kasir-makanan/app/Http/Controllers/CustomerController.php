<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Constructor - hanya untuk role pelanggan
     */
    public function __construct()
    {
        $this->middleware('role:pelanggan');
    }

    /**
     * Menampilkan halaman menu untuk pelanggan
     */
    public function menu()
    {
        // Ambil semua kategori yang aktif dan punya menu items
        $categories = Category::active()
            ->has('menuItems')
            ->orderBy('name')
            ->get();

        // Ambil semua menu items yang aktif
        $menuItems = MenuItem::with('category')
            ->active()
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        return view('customer.menu', compact('categories', 'menuItems'));
    }

    /**
     * API untuk mendapatkan menu (bisa diakses via AJAX)
     */
    public function getMenuApi()
    {
        $menuItems = MenuItem::with('category')
            ->active()
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $menuItems
        ]);
    }

    /**
     * Menampilkan detail menu item
     */
    public function showMenuItem($id)
    {
        $menuItem = MenuItem::with('category')
            ->where('id', $id)
            ->active()
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $menuItem
        ]);
    }
}