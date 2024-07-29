@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Invoices</h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Create Invoice</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Customer Address</th>
                <th>GST No.</th>
                <th>Price Type</th>
                <th>Items</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->customer_name }}</td>
                    <td>{{ $invoice->customer_address }}</td>
                    <td>{{ $invoice->gst_no }}</td>
                    <td>{{ $invoice->price_type }}</td>
                    <td>
                        <ul>
                            @foreach($invoice->items as $item)
                                <li>{{ $item->item->name }} ({{ $item->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
