@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/magnific-popup.css" integrity="sha512-UhvuUthI9VM4N3ZJ5o1lZgj2zNtANzr3zyucuZZDy67BO6Ep5+rJN2PST7kPj+fOI7M/7wVeYaSaaAICmIQ4sQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .card {
        display: flex;
        flex-direction: column;
    }

    .card-body {
        flex: 1;
    }
</style>
<div class="container">
    <h1>Stock Report</h1>
    <form id="filterForm" class="mb-3">
        @csrf
        <div class="row">
            <div class="col-md-3 mb-3">
                <select class="form-control" name="item_category_id">
                    <option value="">Select Item Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" class="form-control" name="name" placeholder="Item Name">
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" class="form-control" name="serial_name" placeholder="Serial Name">
            </div>
            <div class="col-md-3 mb-3">
                <input type="date" class="form-control" name="last_purchase_date" placeholder="Last Purchase Date">
            </div>
            <div class="col-md-3 mb-3">
                <input type="date" class="form-control" name="last_sale_date" placeholder="Last Sale Date">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" id="viewSwitch">
        <label class="form-check-label" for="viewSwitch">Toggle Card/Table View</label>
    </div>

    <div id="tableView" class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Item Name</th>
                    <th>Serial No.</th>
                    <th>Current Stock</th>
                    <th>Last Purchase Date</th>
                    <th>Last Sale Date</th>
                </tr>
            </thead>
            <tbody id="stockReportBody">
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->itemCategory->name }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->serial_no }}</td>
                        <td>{{ $item->current_stock }}</td>
                        <td>{{ $item->last_purchase_date }}</td>
                        <td>{{ $item->last_sale_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="cardView" class="row d-none">
        @foreach($items as $item)
            <div class="col-md-2 mb-3">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top img-thumbnail popup-image" alt="{{ $item->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">Category: {{ $item->itemCategory->name }}</p>
                        <p class="card-text">Serial No.: {{ $item->serial_no }}</p>
                        <p class="card-text">Current Stock: {{ $item->current_stock }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/jquery.magnific-popup.min.js" integrity="sha512-fCRpXk4VumjVNtE0j+OyOqzPxF1eZwacU3kN3SsznRPWHgMTSSo7INc8aY03KQDBWztuMo5KjKzCFXI/a5rVYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // Toggle between table and card view
    document.getElementById('viewSwitch').addEventListener('change', function() {
        document.getElementById('tableView').classList.toggle('d-none');
        document.getElementById('cardView').classList.toggle('d-none');
    });

    // Filter form submission
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const params = new URLSearchParams();
        formData.forEach((value, key) => {
            if (value) {
                params.append(key, value);
            }
        });

        axios.get('/stock-report/filter?' + params.toString())
            .then(response => {
                const items = response.data;
                updateTableView(items);
                updateCardView(items);
            })
            .catch(error => console.error(error));
    });

    // Update table view
    function updateTableView(items) {
        const tbody = document.getElementById('stockReportBody');
        tbody.innerHTML = '';
        items.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.item_category.name}</td>
                <td>${item.name}</td>
                <td>${item.serial_no}</td>
                <td>${item.current_stock}</td>
                <td>${item.last_purchase_date}</td>
                <td>${item.last_sale_date}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Update card view
    function updateCardView(items) {
        const cardView = document.getElementById('cardView');
        cardView.innerHTML = '';
        items.forEach(item => {
            const cardCol = document.createElement('div');
            cardCol.classList.add('col-md-2', 'mb-3');
            cardCol.innerHTML = `
                <div class="card h-100">
                    <img src="/storage/${item.image}" class="card-img-top img-thumbnail popup-image" alt="${item.name}">
                    <div class="card-body">
                        <h5 class="card-title">${item.name}</h5>
                        <p class="card-text">Category: ${item.item_category.name}</p>
                        <p class="card-text">Serial No.: ${item.serial_no}</p>
                        <p class="card-text">Current Stock: ${item.current_stock}</p>
                    </div>
                </div>
            `;
            cardView.appendChild(cardCol);
        });

        // Re-initialize Magnific Popup for new images
        $('.popup-image').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    }

    // Initialize Magnific Popup
    $(document).ready(function() {
        $('.popup-image').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });
</script>
@endsection
