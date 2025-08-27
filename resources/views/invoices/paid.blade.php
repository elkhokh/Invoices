@extends('layouts.master')
@section("title", "الفواتير المدفوعة")
{{-- @stop  --}}
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتيرالمدفوعة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير المدفوعة كليا</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('Error'))
<script>
    window.onload = function() {
        notif({ msg: "حدث خطأ أثناء العملية",
         type: "info",
         position: "center", timeout: 3000 });
    }
</script>
@endif

    <!-- row -->
<div class="row">
<div class="container mt-3">
    @if(session()->has('not_found'))
    <div class="alert alert-warning alert-dismissible fade show fs-5 w-75 mx-auto text-center" role="alert">
        <strong>{{ session('not_found') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
</div>
        <div class="col-xl-12">
            <div class="card mg-b-20">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center flex-wrap">
    <div class="mb-2">
         {{-- @can('اضافة فاتورة') --}}
        <a href="{{ route('invoices.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i>&nbsp; اضافة فاتورة
        </a>
        {{-- @endcan --}}

        {{-- @can('تصدير EXCEL') --}}
        <a href="{{ url('export_invoices') }}" class="btn btn-info">
            <i class="fas fa-file-download"></i>&nbsp; تصدير Excel
        </a>
        {{-- @endcan --}}
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('invoices.paid') }}" class="d-flex" style="gap: 10px; max-width: 400px;">
        <input type="text" name="search" class="form-control" placeholder="ابحث برقم الفاتورة    "
            value="{{ $search}}">
        <button class="btn btn-primary" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ القاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الاجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $invoice->invoice_number }} </td>
                {{-- <td><a href="{{route('invoices.show', $invoice->id)}}"> {{$invoice->invoice_number}}</a></td> --}}
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>{{ $invoice->section->section_name }}</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}%</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="text-success">{{ $invoice->status }}</span>
                                            @elseif($invoice->value_status == 2)
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                            @endif
                                        </td>
                                        {{-- <td>{{ $invoice->note }}</td> --}}
                        <td>{{ \Illuminate\Support\Str::limit($invoice->note, 20, '..') }}</td>
<td>
    <div class="dropdown">
        <button aria-expanded="false" aria-haspopup="true"
            class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
            type="button">
            العمليات <i class="fas fa-caret-down ml-1"></i>
        </button>
        <div class="dropdown-menu tx-13">

            {{-- تعديل الفاتورة --}}
            <form action="{{ route('invoices.edit', $invoice->id) }}" method="GET">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fas fa-edit text-primary"></i> تعديل الفاتورة
                </button>
            </form>

            {{-- حذف الفاتورة --}}
            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-danger">
                    <i class="fas fa-trash-alt"></i> حذف الفاتورة
                </button>
            </form>

            {{-- تغيير حالة الدفع --}}
            <form action="{{ route('invoices.getFileStatus', $invoice->id) }}" method="GET">
    <button type="submit" class="dropdown-item">
        <i class="text-success fas fa-money-bill"></i> تغيير حالة الدفع
    </button>
                    </form>

            {{-- نقل إلى الأرشيف (يفترض أنك عندك route اسمه archive أو مشابه) --}}
            <form action="{{ route('invoices.show', $invoice->id) }}" method="POST"
                onsubmit="return confirm('هل تريد نقل الفاتورة إلى الأرشيف؟');">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item text-warning">
                    <i class="fas fa-exchange-alt"></i> نقل إلى الأرشيف
                </button>
            </form>

            {{-- رؤية تفاصيل الفاتورة --}}
            <form action="{{ route('invoices.show', $invoice->id) }}" method="GET">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fas fa-eye text-info"></i> رؤية تفاصيل الفاتورة
                </button>
            </form>

            {{-- طباعة الفاتورة --}}
            <form action="{{ url('Print_invoice', $invoice->id) }}" method="GET" target="_blank">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="text-success fas fa-print"></i> طباعة الفاتورة
                </button>
            </form>
        </div>
    </div>
</td>
                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{ $invoices->links() }}
                    {{-- {{ $invoices->appends(request()->query())->links() }} --}}
</div></div></div></div> </div></div></div></div>

@endsection
@section('js')

@endsection
