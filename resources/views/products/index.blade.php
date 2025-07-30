@extends('layouts.master')
@section('title', 'المنتجات')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإعدادات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
<div class="container mt-3">
    @if(session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show fs-5 w-75 mx-auto text-center" role="alert">
            <strong>{{ session('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif

    @if(session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show fs-5 w-75 mx-auto text-center" role="alert">
            <strong>{{ session('Edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session()->has('Delete'))
        <div class="alert alert-danger alert-dismissible fade show fs-5 w-75 mx-auto text-center" role="alert">
            <strong>{{ session('Delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>

<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
        {{-- @can('اضافة منتج') --}}
        <a class="modal-effect btn btn-outline-primary" style="min-width: 300px;" data-effect="effect-scale" data-toggle="modal" href="#exampleModal">
        إضافة منتج </a>
            {{-- @endcan --}}
                </div>

                <form action="{{ route('products.index') }}" method="GET" class="d-flex" style="min-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="ابحث عن قسم..." value="{{ request('search') }}">
                    <button class="btn btn-primary ml-2" type="submit">بحث</button>
                </form>

                </div>
            </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المنتج</th>
                                <th>الوصف</th>
                                <th>اسم القسم</th>
                                <th>تاريخ الإنشاء</th>
                                <th> الشخص  </th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $product->Product_name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->section->section_name ?? 'غير معروف' }}</td>
                                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $product->created_by}}</td>
                                    <td>
                                        <a class="modal-effect btn btn-sm btn-warning" data-effect="effect-scale"
                                            data-id="{{ $product->id }}"
                                            data-product_name="{{ $product->Product_name }}"
                                            data-description="{{ $product->description }}"
                                            data-section_id="{{ $product->section_id }}"
                                            data-toggle="modal" href="#editModal" title="تعديل">
                                            <i class="las la-pen"></i>
                                        </a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-id="{{ $product->id }}"
                                            data-product_name="{{ $product->Product_name }}"
                                            data-toggle="modal" href="#deleteModal" title="حذف">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                    {{-- {{ $sections->appends(request()->query())->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- store -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
            <div class="modal-header">
                    <h6 class="modal-title">إضافة منتج جديد</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <form action="{{ route('products.store') }}" method="POST">
                        {{-- {{ csrf_field() }} --}}
                        @csrf
                        <div class="modal-body">
                <div class="form-group">
    <label for="Product_name">اسم المنتج</label>
    <input type="text"
        class="form-control @error('Product_name') is-invalid @enderror"
        placeholder="أدخل الاسم"
        value="{{ old('Product_name') }}"
        id="Product_name"
        name="Product_name">
    @error('Product_name')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

{{-- القسم --}}
<div class="form-group">
    <label class="my-1 mr-2" for="section_id">القسم</label>
    <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror">
        <option value="" selected disabled> -- حدد القسم --</option>
        @foreach ($sections as $section)
            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                {{ $section->section_name }}
            </option>
        @endforeach
    </select>
    @error('section_id')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

{{-- ملاحظات / الوصف --}}
<div class="form-group">
    <label for="description">ملاحظات</label>
    <textarea class="form-control @error('description') is-invalid @enderror"
            id="description"
            name="description"
            rows="3">{{ old('description') }}</textarea>
    @error('description')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<!-- row closed -->
<!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                    @method('DELETE')
                    @csrf

                {{-- <form action="sections/destroy" method="post"> --}}
                    {{-- {{ method_field('delete') }}
                    {{ csrf_field() }} --}}

                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="id" value="{{ $product->id }}">
                        <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
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
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script>
    @if ($errors->any())
        $(document).ready(function () {
            $('#exampleModal').modal('show');
        });
    @endif
</script>

    <script>
        $('#edit_Product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Product_name = button.data('name')
            var section_name = button.data('section_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #Product_name').val(Product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #pro_id').val(pro_id);
        })


    //     $('#modaldemo9').on('show.bs.modal', function(event) {
    //         var button = $(event.relatedTarget)
    //         var pro_id = button.data('id')
    //         var product_name = button.data('Product_name')
    //         var modal = $(this)
    //         modal.find('.modal-body #pro_id').val(id);
    //         modal.find('.modal-body #product_name').val(product_name);
    //     })

    </script>

    <script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var product_name = button.data('product_name')
        var created_by = button.data('created_by')
        var section_id = button.data('section_id')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #description').val(description);
        modal.find('.modal-body #section_id').val(section_id);
        modal.find('.modal-body #created_by').val(created_by);
    })

</script>

@endsection
