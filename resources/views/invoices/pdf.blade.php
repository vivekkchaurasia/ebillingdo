<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <div class="invoice-header">
        <img src="{{ public_path('assets/images/logo-full2.png') }}" alt="Company Logo" style="max-height: 100px;">
        <p>Raebareli</p>
        <p>+91 9876543210</p>
    </div>
    <h1>Invoice #{{ $invoice->id }}</h1>
    <div class="mb-3">
        <strong>Date:</strong> {{ date('d-m-Y', strtotime($invoice->invoice_date)) }}
    </div>
    <div class="mb-3">
        <strong>Customer Name:</strong> {{ $invoice->customer_name }}
    </div>
    <div class="mb-3">
        <strong>Customer Address:</strong> {{ $invoice->customer_address }}
    </div>
    @if($invoice->gst_no)
    <div class="mb-3">
        <strong>GST No:</strong> {{ $invoice->gst_no }}
    </div>
    @endif
    <table class="table table-bordered mt-4" cellpadding="5">
        <thead>
            <tr>
                <th style="border: 0.5px solid #333;">Item</th>
                <th style="border: 0.5px solid #333;">Quantity</th>
                <th style="border: 0.5px solid #333;">Price</th>
                <th style="border: 0.5px solid #333;">GST Rate</th>
                <th style="border: 0.5px solid #333;">Amount</th>
                <th style="border: 0.5px solid #333;">Tax Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $invoiceItem)
            <tr>
                <td style="border: 0.5px solid #666;">{{ $invoiceItem->item->name }}</td>
                <td style="border: 0.5px solid #666;">{{ $invoiceItem->quantity }}</td>
                <td style="border: 0.5px solid #666;">{{ $invoiceItem->price }}</td>
                <td style="border: 0.5px solid #666;">{{ $invoiceItem->gst_rate }}%</td>
                <td style="border: 0.5px solid #666;">{{ $invoiceItem->amount }}</td>
                <td style="border: 0.5px solid #666;">{{ $invoiceItem->tax_amount }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Grand Total:</th>
                <th colspan="2">{{ $invoice->grand_total }}</th>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Total Tax:</th>
                <th colspan="2">{{ $invoice->total_tax }}</th>
            </tr>
        </tfoot>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace()
    </script>
