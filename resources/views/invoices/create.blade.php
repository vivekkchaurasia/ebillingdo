@extends('layouts.master')
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.css" rel="stylesheet">

@section('content')
<div class="container mb-5">
    <h1>Create Invoice</h1>
    <form id="invoice-form">
        @csrf
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="customer_address" class="form-label">Customer Address</label>
            <input type="text" class="form-control" id="customer_address" name="customer_address" required>
        </div>
        <div class="mb-3">
            <label for="gst_no" class="form-label">GST No. (optional)</label>
            <input type="text" class="form-control" id="gst_no" name="gst_no">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email (optional)</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="price_type" class="form-label">Price Type</label>
            <select class="form-control" id="price_type" name="price_type" required>
                <option value="retail" selected>Retail Price</option>
                <option value="wholesale">Wholesale Price</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="items" class="form-label">Items</label>
            <div id="items">
                <div class="row mb-2 item-row">
                    <div class="col-4">
                        <select class="form-control item-select" name="items[0][item_id]" required>
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-wholesale="{{ $item->wholesale_price }}" data-retail="{{ $item->retail_price }}" data-gst="{{ $item->gst_rate }}">
                                    {{ $item->name }} ({{ $item->serial_no }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control item-quantity" name="items[0][quantity]" placeholder="Quantity" required>
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control item-rate" name="items[0][rate]" placeholder="Rate" readonly>
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control item-tax" name="items[0][tax]" placeholder="Tax" readonly>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success" id="add-item">Add Item</button>
        </div>
        <div class="mt-2 mb-2 row">
            <div class="col-6 float right">
                <div class="mb-3">
                    <label for="total_price" class="form-label">Total Price</label>
                    <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                </div>
                <div class="mb-3">
                    <label for="total_tax" class="form-label">Total Tax</label>
                    <input type="text" class="form-control" id="total_tax" name="total_tax" readonly>
                </div>
                <div class="mb-3">
                    <label for="grand_total" class="form-label">Grand Total</label>
                    <input type="text" class="form-control" id="grand_total" name="grand_total" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Create Invoice</button>
            </div>        
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new SlimSelect({ select: '.item-select' });
        document.querySelector(`.item-select[name="items[0][item_id]"]`).addEventListener('change', (e) => {
                console.log('Item selected from new row');
                updateItemRateAndTax(e.target);
            });
        let itemIndex = 1;

        document.getElementById('add-item').addEventListener('click', () => {
            console.log('Add item button clicked');
            const itemRow = `
                <div class="row mb-2 item-row">
                    <div class="col-4">
                        <select class="form-control item-select" name="items[${itemIndex}][item_id]" required>
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-wholesale="{{ $item->wholesale_price }}" data-retail="{{ $item->retail_price }}" data-gst="{{ $item->gst_rate }}">{{ $item->name }} ({{ $item->serial_no }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control item-quantity" name="items[${itemIndex}][quantity]" placeholder="Quantity" required>
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control item-rate" name="items[${itemIndex}][rate]" placeholder="Rate" readonly>
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control item-tax" name="items[${itemIndex}][tax]" placeholder="Tax" readonly>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                    </div>
                </div>
            `;
            document.getElementById('items').insertAdjacentHTML('beforeend', itemRow);
            const newSelect = new SlimSelect({ select: `.item-select[name="items[${itemIndex}][item_id]"]` });
            document.querySelector(`.item-select[name="items[${itemIndex}][item_id]"]`).addEventListener('change', (e) => {
                console.log('Item selected from new row');
                updateItemRateAndTax(e.target);
            });
            itemIndex++;
            console.log('New item row added');
        });

        document.getElementById('items').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                console.log('Remove item button clicked');
                e.target.closest('.row').remove();
                calculateTotals();
                console.log('Item row removed');
            }
        });

        document.getElementById('items').addEventListener('change', function (e) {
            if (e.target && e.target.classList.contains('item-select')) {
                console.log('Item selected');
                updateItemRateAndTax(e.target);
            }
        });

        document.getElementById('items').addEventListener('input', function (e) {
            if (e.target && e.target.classList.contains('item-quantity')) {
                console.log('Quantity changed');
                updateItemTax(e.target);
                calculateTotals();
            }
        });

        document.getElementById('price_type').addEventListener('change', function () {
            console.log('Price type changed');
            document.querySelectorAll('.item-select').forEach(select => {
                updateItemRateAndTax(select);
            });
        });

        document.getElementById('invoice-form').addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('Form submitted');
            const formData = new FormData(this);

            axios.post('{{ route('invoices.store') }}', formData)
                .then(response => {
                    console.log('Invoice created successfully');
                    window.location.href = '{{ route('invoices.index') }}';
                })
                .catch(error => {
                    console.error('Error creating invoice:', error);
                });
        });

        // Recalculate taxes when GST No. changes
        document.getElementById('gst_no').addEventListener('blur', function () {
            const gstNo = this.value.trim();
            if(gstNo.length > 0) {
                console.log('GST No. changed');
                if (isValidGSTNumber(gstNo)) {
                    console.log('Valid GST No.');
                    document.querySelectorAll('.item-select').forEach(select => {
                        updateItemTax(select);
                    });
                    calculateTotals();
                } else {
                    console.error('Invalid GST No.');
                    alert('Invalid GST Number');
                    this.value="";
                }
            }
        });

        // Validate GST number
        function isValidGSTNumber(gstNo) {
            const gstPattern = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][0-9A-Z]$/;
            return gstPattern.test(gstNo);
        }

        function updateItemRateAndTax(selectElement) {
            const selectedItem = selectElement.selectedOptions[0];
            const row = selectElement.closest('.item-row');
            const rateField = row.querySelector('.item-rate');
            const quantityField = row.querySelector('.item-quantity');
            const gstRate = selectedItem.getAttribute('data-gst');
            const priceType = document.getElementById('price_type').value;
            const rate = selectedItem.getAttribute(`data-${priceType}`);

            // Debug statements
            console.log('updateItemRateAndTax called');
            console.log('Selected Item:', selectedItem);
            console.log('Selected Item ID:', selectedItem.value);
            console.log('GST Rate:', gstRate);
            console.log('Price Type:', priceType);
            console.log('Rate:', rate);

            rateField.value = rate;
            quantityField.value = 1; // Default quantity to 1

            updateItemTax(selectElement);
            calculateTotals();
        }

        function updateItemTax(element) {
            const row = element.closest('.item-row');
            const quantity = row.querySelector('.item-quantity').value;
            const rate = row.querySelector('.item-rate').value;
            const gstRate = row.querySelector('.item-select').selectedOptions[0].getAttribute('data-gst');
            const taxField = row.querySelector('.item-tax');
            const gstNo = document.getElementById('gst_no').value;

            console.log('updateItemTax called');
            console.log('Quantity:', quantity);
            console.log('Rate:', rate);
            console.log('GST Rate:', gstRate);
            console.log('GST No:', gstNo);

            if (gstNo && gstRate && quantity && rate) {
                const tax = (rate * quantity * gstRate) / 100;
                taxField.value = tax.toFixed(2);
                console.log('Tax calculated:', tax);
            } else {
                taxField.value = '0.00';
                console.log('Tax set to 0.00');
            }
        }

        function calculateTotals() {
            let totalPrice = 0;
            let totalTax = 0;

            document.querySelectorAll('.item-row').forEach(row => {
                const quantity = row.querySelector('.item-quantity').value;
                const rate = row.querySelector('.item-rate').value;
                const tax = row.querySelector('.item-tax').value;
                totalPrice += (quantity * rate);
                totalTax += parseFloat(tax);
            });

            document.getElementById('total_price').value = totalPrice.toFixed(2);
            document.getElementById('total_tax').value = totalTax.toFixed(2);
            document.getElementById('grand_total').value = (totalPrice + totalTax).toFixed(2);

            console.log('Totals calculated');
            console.log('Total Price:', totalPrice);
            console.log('Total Tax:', totalTax);
            console.log('Grand Total:', totalPrice + totalTax);
        }
    });
</script>
@endsection