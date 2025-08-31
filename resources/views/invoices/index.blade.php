@extends('layouts.master')
@section('title', 'الفواتير')
@section('css')
    @media print {
    .btn-print {
    display: none;
    }
    .no-print {
    display: none;
    }
    }
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/accordion/accordion.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    {{-- @endsection --}}
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('Delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('updateStates'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث حالة الدفع بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('done'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم  اضافة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('restore_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم استعادة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('Add'))
        <script>
            window.onload = function() {
                $('#modaldemo4').modal('show');
            }
        </script>
    @endif

    @if (session()->has('Update'))
        <script>
            window.onload = function() {
                $('#modalUpdateSuccess').modal('show');
            }
        </script>
    @endif


    @if (session()->has('Error'))
        <script>
            window.onload = function() {
                notif({
                    msg: "حدث خطأ أثناء العملية",
                    type: "info",
                    position: "center",
                    timeout: 3000
                });
            }
        </script>
    @endif
    {{-- @if (session('add'))
    <div class="alert alert-success">
        {{ session('add') }}
    </div>
@endif --}}
    <!-- row -->
    <div class="row">
        <div class="container mt-3">
            @if (session()->has('not_found'))
                <div class="alert alert-warning alert-dismissible fade show fs-5 w-75 mx-auto text-center" role="alert">
                    <strong>{{ session('not_found') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session()->has('Error'))
                <div class="alert alert-warning alert-dismissible fade show fs-5 w-75 mx-auto text-center" role="alert">
                    <strong>{{ session('Error') }}</strong>
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


                        @can('create-invoice')
                            <a href="{{ route('invoices.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i>&nbsp; اضافة فاتورة
                            </a>
                        @endcan

                        @can('excel-import-invoice')
                            <a href="{{ route('invoices.export') }}" class="btn btn-info">
                                <i class="fas fa-file-download"></i>&nbsp; تصدير Excel
                            </a>
                        @endcan
                    </div>

                    {{-- Search Form --}}
                    <form method="GET" action="{{ route('invoices.index') }}" class="d-flex"
                        style="gap: 10px; max-width: 400px;">
                        <input type="text" name="search" class="form-control" placeholder="ابحث برقم الفاتورة    "
                            value="{{ $search }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap"
                            data-page-length='50'style="text-align: center">
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
                                        <td>{{ \Illuminate\Support\Str::limit($invoice->note, 20, '...') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">
                                                    العمليات <i class="fas fa-caret-down ml-1"></i>
                                                </button>
                                                <div class="dropdown-menu tx-13">

                                                    @can('edit-invoice')
                                                        <form action="{{ route('invoices.edit', $invoice->id) }}"
                                                            method="GET">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-edit text-primary"></i> تعديل الفاتورة
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    @can('archive-invoice')
                                                        <form action="{{ route('invoices.destroy', $invoice->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('هل تريد نقل الفاتورة إلى الأرشيف؟');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-warning">
                                                                <i class="fas fa-exchange-alt"></i> ارشفة الفاتورة
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    @can('edit-status-invoice')
                                                        <form action="{{ route('invoices.getFileStatus', $invoice->id) }}"
                                                            method="GET">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="text-success fas fa-money-bill"></i> تغيير حالة الدفع
                                                            </button>
                                                        </form>
                                                    @endcan

                                                    @can('delete-invoice')
                                                        <form action="{{ route('invoices.forceDelete', $invoice->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('هل تريد حذف الفاتورة  نهائيا');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash-alt"></i> حذف الفاتورة
                                                            </button>
                                                        </form>
                                                    @endcan

                                                    @can('show-invoice')
                                                        <form action="{{ route('invoices.show', $invoice->id) }}"
                                                            method="GET">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-eye text-info"></i> رؤية تفاصيل الفاتورة
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    @can('print-invoice')
                                                        <form action="{{ route('invoices.print', $invoice->id) }}"
                                                            method="POST" target="_blank" class="no-print">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="text-success fas fa-print"></i> طباعة الفاتورة
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    {{-- <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="dropdown-item">
    <i class="text-success fas fa-print"></i> طباعة الفاتورة
</a> --}}

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $invoices->links() }}


                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->


    <!-- Modal message -->
    <div class="modal fade" id="modaldemo4" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 380px;">
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
                <div class="modal-body" style="padding: 30px 25px; text-align: center;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 15px; right: 20px; opacity: 0.6;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon ion-ios-checkmark-circle-outline"
                        style="font-size: 70px; color: #28a745; margin-bottom: 20px; display: inline-block;"></i>
                    <h4 style="color: #28a745; font-size: 18px; font-weight: 600; margin-bottom: 25px;">تم اضافة الفاتورة
                    </h4>
                    <button type="button" class="btn" data-dismiss="modal"
                        style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 25px; padding: 10px 30px; color: white; font-weight: 600;">
                        متابعة </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalUpdateSuccess" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 380px;">
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
                <div class="modal-body" style="padding: 30px 25px; text-align: center;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 15px; right: 20px; opacity: 0.6;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon ion-ios-checkmark-circle-outline"
                        style="font-size: 70px; color: #2d047f; margin-bottom: 20px; display: inline-block;"></i>
                    <h4 style="color: #34059a; font-size: 18px; font-weight: 600; margin-bottom: 25px;">
                        تم التعديل الفاتورة
                    </h4>
                    <button type="button" class="btn" data-dismiss="modal"
                        style="background: linear-gradient(135deg, #00055e 0%, #001aaa 100%);
                border: none; border-radius: 25px; padding: 10px 30px; color: white; font-weight: 600;">
                        متابعة
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    {{-- <script src="{{ URL::asset('assets/js/table-data.js') }}"></script> --}}
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script src="{{ URL::asset('assets/js/accordion.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>



    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    {{-- <script>
    $('#delete_invoice').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        var modal = $(this);
        modal.find('#invoice_id').val(id);

        // غير URL الفورم
        modal.find('#deleteForm').attr('action', '/invoices/' + id);
    });
</script> --}}

@endsection
