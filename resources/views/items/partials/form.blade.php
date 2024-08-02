<div class="mb-3">
    <select class="form-control form-control-sm" name="item_category_id" required>
        <option value="">Select Item Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ isset($item) && $item->item_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <input type="text" class="form-control form-control-sm" name="name" placeholder="Item Name" value="{{ $item->name ?? '' }}" required>
</div>
<div class="mb-3">
    <input type="text" class="form-control form-control-sm" name="serial_no" placeholder="Serial No." value="{{ $item->serial_no ?? '' }}" required>
</div>
<div class="mb-3">
    <input type="text" class="form-control form-control-sm" name="gst_rate" placeholder="GST Rate" value="{{ $item->gst_rate ?? '' }}" required>
</div>
<div class="mb-3">
    <input type="number" class="form-control form-control-sm" name="opening_stock" placeholder="Opening Stock" value="{{ $item->opening_stock ?? '' }}" required>
</div>
<div class="mb-3">
    <input type="number" class="form-control form-control-sm" step="0.01" name="wholesale_price" placeholder="Wholesale Price" value="{{ $item->wholesale_price ?? '' }}" required>
</div>
<div class="mb-3">
    <input type="number" class="form-control form-control-sm" step="0.01" name="retail_price" placeholder="Retail Price" value="{{ $item->retail_price ?? '' }}" required>
</div>
<div class="mb-3">
    <input type="file" class="form-control form-control-sm" name="image">
</div>
