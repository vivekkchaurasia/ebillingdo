@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Invoice #{{ $invoice->id }}</h1>
    <div class="mb-3">
        <strong>Date:</strong> {{ $invoice->invoice_date }}
    </div>
    <div class="mb-3">
        <strong>Customer Name:</strong> {{ $invoice->customer_name }}
    </div>
    <div class="mb-3">
        <strong>Customer Address:</strong> {{ $invoice->customer_address }}
    </div>
    @if($invoice->gst_no)
    <div class="mb-3">
        <strong>GST No:</strong> {{ $invoice->gst_no }}
    </div>
    @endif
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>GST Rate</th>
                <th>Amount</th>
                <th>Tax Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $invoiceItem)
            <tr>
                <td>{{ $invoiceItem->item->name }}</td>
                <td>{{ $invoiceItem->quantity }}</td>
                <td>{{ $invoiceItem->price }}</td>
                <td>{{ $invoiceItem->gst_rate }}%</td>
                <td>{{ $invoiceItem->amount }}</td>
                <td>{{ $invoiceItem->tax_amount }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Grand Total:</th>
                <th colspan="2">{{ $invoice->grand_total }}</th>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Total Tax:</th>
                <th colspan="2">{{ $invoice->total_tax }}</th>
            </tr>
        </tfoot>
    </table>
    <a href="{{ route('invoices.downloadPdf', $invoice->id) }}" class="btn btn-primary">Download PDF</a>
</div>
@endsection