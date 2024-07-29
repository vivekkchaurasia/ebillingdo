@extends('layouts.master')

@section('content')
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

<script>
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
        })
        .catch(error => console.error(error));
});
</script>
@endsection
