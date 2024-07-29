<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemCategoryController extends Controller
{
    public function index()
    {
        $categories = ItemCategory::all();
        return view('item_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['update_by'] = Auth::id();
        $category = ItemCategory::create($data);
        return response()->json($category);
    }

    public function show(ItemCategory $itemCategory)
    {
        return response()->json($itemCategory);
    }

    public function update(Request $request, ItemCategory $itemCategory)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->all();
        $data['update_by'] = Auth::id();
        $itemCategory->update($data);
        return response()->json($itemCategory);
    }

    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();
        return response()->json(null, 204);
    }
}
