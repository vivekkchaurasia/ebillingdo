@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Items</h1>
    <form id="itemForm">
        @csrf
        <div class="mb-3">
            <select class="form-control form-control-sm" name="item_category_id" required>
                <option value="">Select Item Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control form-control-sm" name="name" placeholder="Item Name" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control form-control-sm" name="serial_no" placeholder="Serial No." required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control form-control-sm" name="gst_rate" placeholder="GST Rate" required>
        </div>
        <div class="mb-3">
            <input type="number" class="form-control form-control-sm" name="opening_stock" placeholder="Opening Stock" required>
        </div>
        <div class="mb-3">
            <input type="number" class="form-control form-control-sm" step="0.01" name="wholesale_price" placeholder="Wholesale Price" required>
        </div>
        <div class="mb-3">
            <input type="number" class="form-control form-control-sm" step="0.01" name="retail_price" placeholder="Retail Price" required>
        </div>
        <div class="mb-3">
            <input type="file" class="form-control form-control-sm" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
    <ul class="list-group mt-3" id="itemList">
        @foreach($items as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center" id="item-{{ $item->id }}">
                <div>
                    <img src="/storage/{{ $item->image }}" alt="{{ $item->name }}" width="50" height="50" class="mr-3"> {{ $item->name }} ({{ $item->itemCategory->name }})
                </div>
                <div>
                    <button class="btn btn-warning btn-sm" onclick="editItem({{ $item->id }})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteItem({{ $item->id }})">Delete</button>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editItemForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editItemId" name="id">
                    <div class="mb-3 form-group">
                        <select class="form-control form-control-sm" id="editItemCategoryId" name="item_category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" id="editItemName" name="name" placeholder="Item Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" id="editSerialNo" name="serial_no" placeholder="Serial No." required>
                    </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" id="editSerialNo" name="gst_rate" placeholder="Serial No." required>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control form-control-sm" id="editOpeningStock" name="opening_stock" placeholder="Opening Stock" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control form-control-sm" step="0.01" id="editWholesalePrice" name="wholesale_price" placeholder="Wholesale Price" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control form-control-sm" step="0.01" id="editRetailPrice" name="retail_price" placeholder="Retail Price" required>
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control form-control-sm" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('itemForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        axios.post('/items', formData)
            .then(response => {
                const item = response.data;
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.id = `item-${item.id}`;
                li.innerHTML = `
                    <div>
                        <img src="/storage/${item.image}" alt="${item.name}" width="50" height="50" class="mr-3"> ${item.name} (${item.itemCategory.name})
                        <button class="btn btn-warning btn-sm" onclick="editItem(${item.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteItem(${item.id})">Delete</button>
                    </div>`;
                document.getElementById('itemList').appendChild(li);
                this.reset();
            })
            .catch(error => console.error(error));
    });

    function deleteItem(id) {
        axios.delete(`/items/${id}`)
            .then(() => {
                const item = document.getElementById(`item-${id}`);
                item.remove();
            })
            .catch(error => console.error(error));
    }

    function editItem(id) {
        axios.get(`/items/${id}`)
            .then(response => {
                const item = response.data;
                document.getElementById('editItemId').value = item.id;
                document.getElementById('editItemCategoryId').value = item.item_category_id;
                document.getElementById('editItemName').value = item.name;
                document.getElementById('editSerialNo').value = item.serial_no;
                document.getElementById('editOpeningStock').value = item.opening_stock;
                document.getElementById('editWholesalePrice').value = item.wholesale_price;
                document.getElementById('editRetailPrice').value = item.retail_price;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            })
            .catch(error => console.error(error));
    }

    document.getElementById('editItemForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editItemId').value;
        const formData = new FormData(this);

        axios.post(`/items/${id}`, formData)
            .then(response => {
                const updatedItem = response.data;
                const itemElement = document.getElementById(`item-${updatedItem.id}`);
                itemElement.querySelector('div').innerHTML = `
                    <img src="/storage/${updatedItem.image}" alt="${updatedItem.name}" width="50" height="50" class="mr-3"> ${updatedItem.name} (${updatedItem.itemCategory.name})
                    <button class="btn btn-warning btn-sm" onclick="editItem(${updatedItem.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteItem(${updatedItem.id})">Delete</button>`;
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                document.getElementById('editItemForm').reset();
            })
            .catch(error => console.error(error));
    });
</script>
@endsection
