@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Edit Stock Purchase</h1>
    <form id="stockPurchaseForm" action="{{ route('stock-purchases.update', $stockPurchase->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <select class="form-control" name="item_category_id" id="item_category_id" required>
                <option value="">Select Item Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $stockPurchase->item_category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <select class="form-control" name="item_id" id="item_id" required>
                <option value="">Select Item</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ $stockPurchase->item_id == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <input type="date" class="form-control" name="date" value="{{ $stockPurchase->date }}" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="quantity" value="{{ $stockPurchase->quantity }}" placeholder="quantity">
        </div>
        
        <button type="submit" class="btn btn-primary">Update Stock Purchase</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    new SlimSelect({ select: '#item_category_id' });
    new SlimSelect({ select: '#item_id' });

    document.getElementById('item_category_id').addEventListener('change', function() {
        const categoryId = this.value;
        axios.get(`/api/items/by-category/${categoryId}`)
            .then(response => {
                const items = response.data;
                const itemSelect = document.getElementById('item_id');
                itemSelect.innerHTML = '<option value="">Select Item</option>';
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    itemSelect.appendChild(option);
                });
                new SlimSelect({ select: '#item_id' });
            })
            .catch(error => console.error(error));
        });
    
</script>
@endsection
