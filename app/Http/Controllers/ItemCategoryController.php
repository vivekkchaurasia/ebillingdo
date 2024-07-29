<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index()
    {
        $categories = ItemCategory::all();
        return view('item_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = ItemCategory::create($validated);

        return response()->json($category);
    }

    public function show(ItemCategory $itemCategory)
    {
        return response()->json($itemCategory);
    }

    public function update(Request $request, ItemCategory $itemCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $itemCategory->update($validated);

        return response()->json($itemCategory);
    }

    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();
        return response()->json(null, 204);
    }
}
