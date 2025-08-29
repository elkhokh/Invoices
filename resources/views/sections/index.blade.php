@extends('layouts.master')
@section('title', 'الأقسام')

@section('css')
<!-- Internal Data table css -->
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الإعدادات</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
        </div>
    </div>
</div>
@endsection

@section('content')
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

    @if(session()->has('error'))
        <div class="alert alert-success alert-dismissible fade show fs-5 w-75 mx-auto text-center" role="alert">
            <strong>{{ session('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
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
                    {{-- @can('create-section') --}}
        <a class="modal-effect btn btn-outline-primary" style="min-width: 300px;" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">
        إضافة قسم
        </a>
        {{-- @endcan --}}
                </div>
                <form action="{{ route('sections.index') }}" method="GET" class="d-flex" style="min-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="ابحث عن قسم..." value="{{  $search  }}">
                    <button class="btn btn-primary ml-2" type="submit">بحث</button>
                </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم القسم</th>
                                <th>الوصف</th>
                                <th>تاريخ الانشاء</th>
                                <th>الشخص المنشئ</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($sections as $section)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $section->section_name }}</td>
                                <td title="{{ $section->description }}">
        {{ \Illuminate\Support\Str::limit($section->description, 20, '...') }}
    </td>
                                <td>{{ $section->created_at->format('Y-m-d') }}</td>
                                {{-- carbon format to edit days --}}
                        <td>{{ $section->created_by}}</td>
                                {{-- <td>{{ $section?->user?->name}}</td> --}}
    <td>
           {{-- @can('edit-section') --}}
        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal{{ $section->id }}">تعديل</button>
        {{-- @endcan --}}
           @can('delete-section')
        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $section->id }}">حذف</button>
        @endcan
    </td>
            </tr>

            <!-- edit -->
            <div class="modal fade" id="editModal{{ $section->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('sections.update', $section->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">تعديل القسم</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="section_name" class="form-control" value="{{ $section->section_name }}">
                                <textarea name="description" class="form-control mt-2">{{ $section->description }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- delete -->
            <div class="modal fade" id="deleteModal{{ $section->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('sections.destroy', $section->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">حذف القسم</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>هل أنت متأكد من حذف القسم: <strong>{{ $section->section_name }}</strong>؟</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">حذف</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach


    </tbody>
</table>
                    {{ $sections->links() }}
                    {{-- {{ $sections->appends(request()->query())->links() }} --}}
<!-- add-->
<div class="modal fade" id="modaldemo8" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('sections.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة قسم جديد</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم القسم</label>
                        <input type="text" name="section_name" class="form-control" required>
                        @error('section_name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>الوصف</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                        @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">إضافة</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
{{-- <script src="{{ URL::asset('assets/js/table-data.js') }}"></script> --}}
{{-- show pagenation --}}
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<script>
    @if ($errors->any())
        $(document).ready(function () {
            $('#modaldemo8').modal('show');
        });
    @endif
</script>

@endsection
