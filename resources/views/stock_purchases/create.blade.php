@extends('layouts.master')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.css.map" rel="stylesheet">
<div class="container">
    <h1>Add Stock Purchase</h1>
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
            <input type="text" class="form-control" name="quantity" placeholder="Quantity">
        </div>
        <button type="submit" class="btn btn-primary">Add Stock Purchase</button>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.min.js"></script>
<script>
    // Initialize SlimSelect for the dropdowns
    new SlimSelect({ select: '#item_category_id' });

    // Fetch items based on category selection
    document.getElementById('item_category_id').addEventListener('change', function() {
    const categoryId = this.value;
    if (categoryId) {
        axios.get(`/items/by-category/${categoryId}`)
            .then(response => {
                console.info("Response Data:", JSON.stringify(response.data, null, 2));
                const items = response.data;
                const itemSelect = document.getElementById('item_id');
                itemSelect.innerHTML = '<option value="">Select Item</option>';
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name + " - " + item.serial_no;
                    itemSelect.appendChild(option);
                });
                // Log the appended options
                console.info("Appended Options:", itemSelect.innerHTML);
                // Comment out the SlimSelect initialization for testing
                new SlimSelect({ select: '#item_id' });
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
    } else {
        document.getElementById('item_id').innerHTML = '<option value="">Select Item</option>';
        }
    });

    // Handle form submission
    document.getElementById('stockPurchaseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => { data[key] = value });

        axios.post('/stock-purchases', data)
            .then(response => {
                window.location.href = '{{ route('stock-purchases.index') }}';
            })
            .catch(error => console.error(error));
    });
</script>
@endsection
