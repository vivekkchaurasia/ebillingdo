<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index()
    {
        $itemCategories = ItemCategory::all();
        return response()->json($itemCategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $itemCategory = ItemCategory::create($request->all());
        return response()->json($itemCategory, 201);
    }

    public function show(ItemCategory $itemCategory)
    {
        return response()->json($itemCategory);
    }

    public function update(Request $request, ItemCategory $itemCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $itemCategory->update($request->all());
        return response()->json($itemCategory);
    }

    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();
        return response()->json(null, 204);
    }
}
