<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة #{{ $invoices->invoice_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Tajawal', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
        }
        .print-container {
            max-width: 1000px;
            margin: auto;
            padding: 2rem;
            background: #fff;
            border-radius: 10px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .invoice-header img {
            height: 80px;
        }
        .invoice-details h4 {
            color: #065f46;
            font-weight: 600;
            text-align: center;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: right;
        }
        .table th {
            background-color: #065f46;
            color: #fff;
        }
        .btn-print {
            background-color: #065f46;
            border-color: #065f46;
            color: #fff;
            font-size: 1.2rem;
            padding: 0.6rem 2rem;
            border-radius: 30px;
            transition: 0.3s ease;
        }
        .btn-print:hover {
            background-color: #047857;
            border-color: #047857;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: #fff !important;
            }
            .print-container {
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Header -->
        <div class="invoice-header">
            <img src="{{ asset('assets/img/brand/favicon.png') }}" alt="logo">
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <h4 class="mb-4">تفاصيل الفاتورة</h4>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>رقم الفاتورة:</strong> {{ $invoices->invoice_number }}</p>
                    <p><strong>تاريخ الفاتورة:</strong> {{ $invoices->invoice_date }}</p>
                    <p><strong>تاريخ الاستحقاق:</strong> {{ $invoices->due_date }}</p>
                    <p><strong>القسم:</strong> {{ $invoices->section->section_name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>المنتج:</strong> {{ $invoices->product }}</p>
                    <p><strong>الحالة:</strong>
                        @if ($invoices->value_status == 1)
                            <span class="text-success">{{ $invoices->status }}</span>
                        @elseif ($invoices->value_status == 2)
                            <span class="text-danger">{{ $invoices->status }}</span>
                        @else
                            <span class="text-warning">{{ $invoices->status }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Invoice Financials -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الوصف</th>
                        <th>القيمة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>مبلغ التحصيل</td>
                        <td>{{ $invoices->amount_collection }}</td>
                    </tr>
                    <tr>
                        <td>مبلغ العمولة</td>
                        <td>{{ $invoices->amount_commission }}</td>
                    </tr>
                    <tr>
                        <td>الخصم</td>
                        <td>{{ $invoices->discount }}</td>
                    </tr>
                    <tr>
                        <td>نسبة الضريبة</td>
                        <td>{{ $invoices->rate_vat }}%</td>
                    </tr>
                    <tr>
                        <td>قيمة الضريبة</td>
                        <td>{{ $invoices->value_vat }}</td>
                    </tr>
                    <tr>
                        <td><strong>الإجمالي</strong></td>
                        <td><strong>{{ $invoices->total }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-4 no-print">
            <button type="button" class="btn btn-print btn-lg" onclick="window.print()">
                <i class="fas fa-print"></i> طباعة الفاتورة
            </button>
        </div>
    </div>
</body>
</html>
