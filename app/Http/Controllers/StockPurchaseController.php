<?php

namespace App\Http\Controllers;

use App\Models\StockPurchase;
use App\Models\ItemCategory;
use App\Models\Item;
use Illuminate\Http\Request;

class StockPurchaseController extends Controller
{
    public function index()
    {
        $stockPurchases = StockPurchase::with(['itemCategory', 'item'])->get();
        return response()->json($stockPurchases);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_category_id' => 'required|exists:item_categories,id',
            'item_id' => 'required|exists:items,id',
            'date' => 'required|date',
            'batch_no' => 'nullable|string|max:255',
            'wholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
        ]);

        $stockPurchase = StockPurchase::create($request->all());
        return response()->json($stockPurchase, 201);
    }

    public function show(StockPurchase $stockPurchase)
    {
        return response()->json($stockPurchase);
    }

    public function update(Request $request, StockPurchase $stockPurchase)
    {
        $request->validate([
            'item_category_id' => 'required|exists:item_categories,id',
            'item_id' => 'required|exists:items,id',
            'date' => 'required|date',
            'batch_no' => 'nullable|string|max:255',
            'wholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
        ]);

        $stockPurchase->update($request->all());
        return response()->json($stockPurchase);
    }

    public function destroy(StockPurchase $stockPurchase)
    {
        $stockPurchase->delete();
        return response()->json(null, 204);
    }
}
