<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('items.item')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $items = Item::all();
        return view('invoices.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'gst_no' => 'nullable|string|max:15',
            'price_type' => 'required|in:wholesale,retail',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        
        $invoice = new Invoice();
        $invoice->customer_name = $validated['customer_name'];
        $invoice->customer_address = $validated['customer_address'];
        $invoice->gst_no = $validated['gst_no'];
        $invoice->price_type = $validated['price_type'];
        $invoice->invoice_date = now();
        $invoice->created_by = Auth::id();
        $invoice->updated_by = Auth::id();
        $invoice->save();

        $grandTotal = 0;
        $totalTax = 0;

        foreach ($validated['items'] as $item) {
            $itemModel = Item::find($item['item_id']);
            $price = $invoice->price_type == 'wholesale' ? $itemModel->wholesale_price : $itemModel->retail_price;
            $gstRate = $itemModel->gst_rate;
            $itemTotal = $price * $item['quantity'];
            $taxAmount = $validated['gst_no'] ? $itemTotal * $gstRate / 100 : 0;

            $invoiceItem = new InvoiceItem();
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->item_id = $item['item_id'];
            $invoiceItem->quantity = $item['quantity'];
            $invoiceItem->price = $price;
            $invoiceItem->gst_rate = $gstRate;
            $invoiceItem->amount = $itemTotal;
            $invoiceItem->tax_amount = $taxAmount;
            $invoiceItem->save();

            $grandTotal += $itemTotal;
            $totalTax += $taxAmount;

            // Update current stock
            $itemModel->current_stock -= $item['quantity'];
            $itemModel->last_sale_date = now();
            $itemModel->save();
        }

        $invoice->grand_total = $grandTotal;
        $invoice->total_tax = $totalTax;
        $invoice->save();

        return response()->json(['message' => 'Invoice created successfully']);
    }

    public function show($id)
    {
        $invoice = Invoice::with('items.item')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        $items = Item::all();
        return view('invoices.edit', compact('invoice', 'items'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'gst_no' => 'nullable|string|max:15',
            'price_type' => 'required|in:wholesale,retail',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $invoice = Invoice::findOrFail($id);

        // Revert stock adjustments for existing items
        foreach ($invoice->items as $invoiceItem) {
            $item = $invoiceItem->item;
            $item->current_stock += $invoiceItem->quantity;
            $item->save();
        }

        // Delete existing invoice items
        $invoice->items()->delete();

        // Update invoice details
        $invoice->customer_name = $validated['customer_name'];
        $invoice->customer_address = $validated['customer_address'];
        $invoice->gst_no = $validated['gst_no'];
        $invoice->price_type = $validated['price_type'];
        $invoice->updated_by = Auth::id();
        $invoice->save();

        // Add updated items and adjust stock
        $grandTotal = 0;
        $totalTax = 0;

        foreach ($validated['items'] as $itemData) {
            $item = Item::find($itemData['item_id']);
            $price = $invoice->price_type == 'wholesale' ? $item->wholesale_price : $item->retail_price;
            $gstRate = $item->gst_rate;
            $itemTotal = $price * $itemData['quantity'];
            $taxAmount = $validated['gst_no'] ? $itemTotal * $gstRate / 100 : 0;

            $invoiceItem = new InvoiceItem();
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->item_id = $itemData['item_id'];
            $invoiceItem->quantity = $itemData['quantity'];
            $invoiceItem->price = $price;
            $invoiceItem->gst_rate = $gstRate;
            $invoiceItem->amount = $itemTotal;
            $invoiceItem->tax_amount = $taxAmount;
            $invoiceItem->save();

            $grandTotal += $itemTotal;
            $totalTax += $taxAmount;

            // Adjust stock
            $item->current_stock -= $itemData['quantity'];
            $item->last_sale_date = now();
            $item->save();
        }

        // Update invoice totals
        $invoice->grand_total = $grandTotal;
        $invoice->total_tax = $totalTax;
        $invoice->save();

        return response()->json(['message' => 'Invoice updated successfully']);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->items()->delete();
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}
