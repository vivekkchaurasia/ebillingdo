<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('itemCategory')->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_category_id' => 'required|exists:item_categories,id',
            'name' => 'required|string|max:255',
            'serial_name' => 'required|string|max:255',
            'serial_no' => 'required|string|max:255',
            'opening_stock' => 'required|integer',
            'wholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
        ]);

        $item = Item::create($request->all());
        return response()->json($item, 201);
    }

    public function show(Item $item)
    {
        return response()->json($item);
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'item_category_id' => 'required|exists:item_categories,id',
            'name' => 'required|string|max:255',
            'serial_name' => 'required|string|max:255',
            'serial_no' => 'required|string|max:255',
            'opening_stock' => 'required|integer',
            'wholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
        ]);

        $item->update($request->all());
        return response()->json($item);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(null, 204);
    }
}
