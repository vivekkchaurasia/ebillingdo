@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Item Categories</h1>
    <form id="categoryForm">
        @csrf
        <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Item Category Name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
    <ul class="list-group mt-3" id="categoryList">
        @foreach($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center" id="category-{{ $category->id }}">
                {{ $category->name }}
                <div>
                    <button class="btn btn-warning btn-sm" onclick="editCategory({{ $category->id }})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteCategory({{ $category->id }})">Delete</button>
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
                <h5 class="modal-title" id="editModalLabel">Edit Item Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <input type="hidden" id="editCategoryId">
                        <input type="text" class="form-control" id="editCategoryName" name="name" placeholder="Item Category Name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const name = this.name.value;
        axios.post('/item-categories', { name })
            .then(response => {
                const item = response.data;
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.id = `category-${item.id}`;
                li.innerHTML = `${item.name} 
                    <div>
                        <button class="btn btn-warning btn-sm" onclick="editCategory(${item.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCategory(${item.id})">Delete</button>
                    </div>`;
                document.getElementById('categoryList').appendChild(li);
                this.reset();
            })
            .catch(error => console.error(error));
    });

    function deleteCategory(id) {
        axios.delete(`/item-categories/${id}`)
            .then(() => {
                const item = document.getElementById(`category-${id}`);
                item.remove();
            })
            .catch(error => console.error(error));
    }

    function editCategory(id) {
        axios.get(`/item-categories/${id}`)
            .then(response => {
                const category = response.data;
                document.getElementById('editCategoryId').value = category.id;
                document.getElementById('editCategoryName').value = category.name;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            })
            .catch(error => console.error(error));
    }

    document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editCategoryId').value;
        const name = this.name.value;
        axios.put(`/item-categories/${id}`, { name })
            .then(response => {
                const updatedCategory = response.data;
                const item = document.getElementById(`category-${updatedCategory.id}`);
                item.querySelector('div').previousSibling.textContent = updatedCategory.name;
                
                document.getElementById('editCategoryForm').reset();
            })
            .catch(error => console.error(error));
    });
</script>
@endsection
