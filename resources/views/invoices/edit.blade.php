@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Edit Invoice</h1>
    <form id="invoice-form">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $invoice->customer_name }}" required>
        </div>
        <div class="mb-3">
            <label for="customer_address" class="form-label">Customer Address</label>
            <input type="text" class="form-control" id="customer_address" name="customer_address" value="{{ $invoice->customer_address }}" required>
        </div>
        <div class="mb-3">
            <label for="gst_no" class="form-label">GST No. (optional)</label>
            <input type="text" class="form-control" id="gst_no" name="gst_no" value="{{ $invoice->gst_no }}">
        </div>
        <div class="mb-3">
            <label for="price_type" class="form-label">Price Type</label>
            <select class="form-control" id="price_type" name="price_type" required>
                <option value="wholesale" {{ $invoice->price_type == 'wholesale' ? 'selected' : '' }}>Wholesale Price</option>
                <option value="retail" {{ $invoice->price_type == 'retail' ? 'selected' : '' }}>Retail Price</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="items" class="form-label">Items</label>
            <div id="items">
                @foreach($invoice->items as $index => $invoiceItem)
                    <div class="row mb-2">
                        <div class="col-5">
                            <select class="form-control" name="items[{{ $index }}][item_id]" required>
                                <option value="">Select Item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $invoiceItem->item_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="number" class="form-control" name="items[{{ $index }}][quantity]" value="{{ $invoiceItem->quantity }}" placeholder="Quantity" required>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger remove-item">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-success" id="add-item">Add Item</button>
        </div>
        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
</div>

<script>
    let itemIndex = {{ $invoice->items->count() }};

    document.getElementById('add-item').addEventListener('click', () => {
        const itemRow = `
            <div class="row mb-2">
                <div class="col-5">
                    <select class="form-control" name="items[${itemIndex}][item_id]" required>
                        <option value="">Select Item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <input type="number" class="form-control" name="items[${itemIndex}][quantity]" placeholder="Quantity" required>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                </div>
            </div>
        `;
        document.getElementById('items').insertAdjacentHTML('beforeend', itemRow);
        itemIndex++;
    });

    document.getElementById('items').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-item')) {
            e.target.closest('.row').remove();
        }
    });

    document.getElementById('invoice-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        axios.post('{{ route('invoices.update', $invoice->id) }}', formData)
            .then(response => {
                window.location.href = '{{ route('invoices.index') }}';
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endsection
