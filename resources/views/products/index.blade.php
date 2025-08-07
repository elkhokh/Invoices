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
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
        {{-- @can('اضافة منتج') --}}
        <a class="modal-effect btn btn-outline-primary" style="min-width: 300px;" data-effect="effect-scale" data-toggle="modal" href="#exampleModal">
        إضافة منتج </a>
            {{-- @endcan --}}
                </div>

                <form action="{{ route('products.index') }}" method="GET" class="d-flex" style="min-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="ابحث عن منتج..." value="{{ $search}}">
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
                            {{-- @forelse($products as $product) --}}
                            @foreach($products as $product)
                                <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $product->Product_name }}</td>
                            {{-- <td>{{ $product->description }}</td>--}}
                            <td title="{{ $product->description }}">
        {{ \Illuminate\Support\Str::limit($product->description, 20, '...') }}
    </td>
                                    <td>{{ $product->section->section_name ?? 'غير معروف' }}</td>
                                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $product->created_by}}</td>
                                    <td>
        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal{{ $product->id }}">تعديل</button>
        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $product->id }}">حذف</button>
    </td>
            </tr>

            <div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">تعديل المنتج</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="Product_name" class="form-control" value="{{ $product->Product_name }}">
                                <select name="section_id" class="form-control mt-2">
                                    @foreach ($sections as $section)
                                <option value="{{ $section->id }}" {{ $product->section_id == $section->id ? 'selected' : '' }}>
                                            {{ $section->section_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <textarea name="description" class="form-control mt-2">{{ $product->description }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">حفظ </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">حذف المنتج</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>هل أنت متأكد من حذف المنتج: <strong>{{ $product->Product_name }}</strong>؟</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">حذف</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        {{-- @endforelse --}}
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

@endsection
