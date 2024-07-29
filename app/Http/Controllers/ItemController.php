<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('itemCategory')->get();
        $categories = ItemCategory::all();
        return view('items.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::id();

        $request->validate([
            'item_category_id' => 'required|exists:item_categories,id',
            'name' => 'required|string|max:255',
            'serial_no' => 'required|string|max:255',
            'gst_rate' => 'required|numeric',
            'opening_stock' => 'required|integer',
            'wholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }

        $data['current_stock'] = $data['opening_stock'];
        $data['last_purchase_date'] = date('Y-m-d');
        $data['created_by'] = $user;
        $data['updated_by'] = $user;

        $item = Item::create($data);

        // Correctly load the 'itemCategory' relationship instead of 'item'
        return response()->json($item->load('itemCategory'));
    }

    public function show(Item $item)
    {
        // Correctly load the 'itemCategory' relationship instead of 'item'
        return response()->json($item->load('itemCategory'));
    }

    public function update(Request $request, Item $item)
    {
        $user = Auth::id();
        
        $request->validate([
            'item_category_id' => 'required|exists:item_categories,id',
            'name' => 'required|string|max:255',
            'serial_no' => 'required|string|max:255',
            'gst_rate' => 'required|numeric',
            'opening_stock' => 'required|integer',
            'wholesale_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }
        $data['updated_by'] = Auth::id();
        $item->update($data);

        // Correctly load the 'itemCategory' relationship instead of 'item'
        return response()->json($item->load('item.itemCategory'));
    }

    public function destroy(Item $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();
        return response()->json(null, 204);
    }

    public function stockReport()
    {
        $categories = ItemCategory::all();
        $items = Item::with('itemCategory')->get();
        
        foreach ($items as $item) {
            $item->current_stock = $item->opening_stock + $item->purchased_stock - $item->sold_stock; // Adjust this logic based on your actual stock calculation
        }
        return view('items.stock_report', compact('items', 'categories'));
    }

    public function filterStockReport(Request $request)
    {
        $query = Item::with('itemCategory');

        if ($request->filled('item_category_id')) {
            $query->where('item_category_id', $request->item_category_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('serial_name')) {
            $query->where('serial_name', 'like', '%' . $request->serial_name . '%');
        }

        if ($request->filled('last_purchase_date')) {
            $query->whereDate('last_purchase_date', $request->last_purchase_date);
        }

        if ($request->filled('last_sale_date')) {
            $query->whereDate('last_sale_date', $request->last_sale_date);
        }

        $items = $query->get();

        return response()->json($items);
    }
}
