@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Stock Purchases</h1>
    <form id="stockPurchaseForm">
        @csrf
        <div class="mb-3">
            <select class="form-control" name="item_category_id" id="item_category_id" required>
                <option value="">Select Item Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <select class="form-control" name="item_id" id="item_id" required>
                <option value="">Select Item</option>
            </select>
        </div>
        <div class="mb-3">
            <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="batch_no" placeholder="Batch No. (optional)">
        </div>
        <div class="mb-3">
            <input type="number" class="form-control" step="0.01" name="wholesale_price" id="wholesale_price" placeholder="Wholesale Price" required>
        </div>
        <div class="mb-3">
            <input type="number" class="form-control" step="0.01" name="retail_price" id="retail_price" placeholder="Retail Price" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Stock Purchase</button>
    </form>
    <ul class="list-group mt-3" id="purchaseList">
        @foreach($purchases as $purchase)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $purchase->item->name }} ({{ $purchase->category->name }}) - {{ $purchase->date }}
                <button class="btn btn-danger btn-sm" onclick="deletePurchase({{ $purchase->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
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

    document.getElementById('item_id').addEventListener('change', function() {
        const itemId = this.value;
        axios.get(`/api/items/${itemId}`)
            .then(response => {
                const item = response.data;
                document.getElementById('wholesale_price').value = item.wholesale_price;
                document.getElementById('retail_price').value = item.retail_price;
            })
            .catch(error => console.error(error));
    });

    document.getElementById('stockPurchaseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => { data[key] = value });

        axios.post('/stock-purchases', data)
            .then(response => {
                const purchase = response.data;
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `${purchase.item.name} (${purchase.category.name}) - ${purchase.date} <button class="btn btn-danger btn-sm" onclick="deletePurchase(${purchase.id})">Delete</button>`;
                document.getElementById('purchaseList').appendChild(li);
                this.reset();
            })
            .catch(error => console.error(error));
    });

    function deletePurchase(id) {
        axios.delete(`/stock-purchases/${id}`)
            .then(() => {
                const item = document.querySelector(`[onclick="deletePurchase(${id})"]`).parentElement;
                item.remove();
            })
            .catch(error => console.error(error));
    }
</script>
@endsection
