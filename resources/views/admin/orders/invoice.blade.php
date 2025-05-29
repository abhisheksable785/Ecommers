@extends('layout.back.master')
@section('title','Invoice')
@section('content')

<div id="invoice-area" class="container bg-white p-5 rounded shadow-sm">
    <!-- all your invoice HTML here -->


<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4><i class="bi bi-cart4 me-2"></i> Ecommerce Surface</h4>
            <p class="mb-1">Invoice Number: {{ $invoice->id }}</p>
            <p>Date: {{ $invoice->created_at->format('d/m/Y') }}</p>
        </div>
        <div>
            <h1 class="text-primary fw-bold">INVOICE</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h6>Bill From:</h6>
            <p>
                BMT Fashion <br>
                I-step-Up, 413102<br>
                94954XXXX
            </p>
        </div>
        <div class="col-md-6 text-md-end">
            <h6>Bill To:</h6>
            <p>
                {{ $profile->full_name  }}<br>
                {{ $profile->address  }}<br>
                {{ $profile->mobile_number  }}
            </p>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Tax</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>$0.00</td>
                <td>${{ number_format($product->pivot->quantity * $product->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
    <p><strong>Terms & Conditions:</strong></p>
    <ul class="mb-0 ps-3">
        <li>Goods once sold will not be exchanged or refunded.</li>
        <li>Please retain the invoice for warranty and return purposes.</li>
        <li>Color of garments may slightly vary due to lighting or display settings.</li>
        <li>Alterations, if any, must be requested within 7 days of purchase.</li>
        <li>Ensure all tags are intact for any return or exchange eligibility.</li>
    </ul>
</div>

    <div class="d-flex justify-content-end">
        <table class="table table-borderless w-auto">
            <tr>
                <th>Subtotal:</th>
                <td>${{ number_format($invoice->total, 2) }}</td>
            </tr>
            <tr>
                <th>Discount:</th>
                <td>$0.00</td>
            </tr>
            <tr>
                <th>Tax:</th>
                <td>$0.00</td>
            </tr>
            <tr>
                <th>Paid:</th>
                <td>$0.00</td>
            </tr>
            <tr class="bg-primary text-white">
                <th>Total</th>
                <td><strong>${{ number_format($invoice->total, 2) }}</strong></td>
            </tr>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-4">
    <button class="btn btn-outline-primary" onclick="printInvoice()">
        <i class="bi bi-printer me-1"></i> Print Invoice
    </button>
</div>
</div>
<style>
    @media print {
        button, .btn, .no-print {
            display: none !important;
        }
    }
</style>


</div>

<script>
function printInvoice() {
    const invoiceContent = document.getElementById('invoice-area').innerHTML;
    const printWindow = window.open('', '_blank', 'width=1024,height=768');

    printWindow.document.write(`
        <html>
        <head>
            <title>Invoice</title>

            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

            <!-- Bootstrap Icons (if used) -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

            <!-- Optional: Your app CSS (if you have a custom stylesheet) -->
           

            <style>
                body {
                    padding: 30px;
                    font-family: Arial, sans-serif;
                    background: #fff;
                    color: #000;
                }

                @media print {
                    body {
                        margin: 0;
                        padding: 0;
                        box-shadow: none;
                    }

                    .table th, .table td {
                        border: 1px solid #000 !important;
                    }

                    .table-borderless td, .table-borderless th {
                        border: none !important;
                    }
                }
            </style>
        </head>
        <body>
            ${invoiceContent}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();

    // Delay print slightly to ensure resources load
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}
</script>


@endsection

