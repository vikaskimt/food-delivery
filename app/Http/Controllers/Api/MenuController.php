<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class MenuController extends Controller
{
    // GET /api/menu -> categories with available items, admin-managed
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->with(['foodItems' => function ($q) {
                $q->where('is_available', true)->orderBy('sort_order')->with('variants');
            }])
            ->get();

        return response()->json($categories);
    }
}
