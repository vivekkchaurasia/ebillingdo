<?php

namespace App\Http\Controllers;

use App\Models\StockPurchase;
use App\Models\ItemCategory;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockPurchaseController extends Controller
{
    public function index()
    {
        $purchases = StockPurchase::with(['category', 'item'])->get();
        $categories = ItemCategory::all();
        $items = Item::all();
        return view('stock_purchases.index', compact('purchases', 'categories', 'items'));
    }

    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_category_id' => 'required|exists:item_categories,id',
            'item_id' => 'required|exists:items,id',
            'date' => 'required|date',
            'batch_no' => 'nullable|string',
            'wholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
        ]);

        $stockPurchase = new StockPurchase();
        $stockPurchase->item_category_id = $validated['item_category_id'];
        $stockPurchase->item_id = $validated['item_id'];
        $stockPurchase->date = $validated['date'];
        $stockPurchase->batch_no = $validated['batch_no'];
        $stockPurchase->wholesale_price = $validated['wholesale_price'];
        $stockPurchase->retail_price = $validated['retail_price'];
        $stockPurchase->created_by = Auth::id();
        $stockPurchase->updated_by = Auth::id();
        $stockPurchase->save();

        $item = Item::find($validated['item_id']);
        $item->current_stock += $stockPurchase->quantity; // Ensure quantity field is handled
        $item->last_purchase_date = now();
        $item->save();

        return response()->json(['message' => 'Stock purchase added successfully']);
    }

    public function show(StockPurchase $stockPurchase)
    {
        return response()->json($stockPurchase);
    }

    public function update(Request $request, StockPurchase $stockPurchase)
    {
        $validated = $request->validate([
            'item_category_id' => 'required|exists:item_categories,id',
            'item_id' => 'required|exists:items,id',
            'date' => 'required|date',
            'batch_no' => 'nullable|string|max:255',
            'wholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'quantity' => 'required|integer|min:1', // Add quantity validation
        ]);

        // Revert stock adjustments for the existing stock purchase
        $oldItem = Item::find($stockPurchase->item_id);
        $oldItem->current_stock -= $stockPurchase->quantity;
        $oldItem->save();

        // Update stock purchase details
        $stockPurchase->update($validated);

        // Apply new stock adjustments based on the updated data
        $newItem = Item::find($validated['item_id']);
        $newItem->current_stock += $validated['quantity'];
        $newItem->last_purchase_date = now();
        $newItem->save();

        return response()->json(['message' => 'Stock purchase updated successfully', 'stockPurchase' => $stockPurchase]);
    }


    public function destroy(StockPurchase $stockPurchase)
    {
        $stockPurchase->delete();
        return response()->json(null, 204);
    }
}
