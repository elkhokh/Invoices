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
</div>


<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
        <a class="modal-effect btn btn-outline-primary" style="min-width: 300px;" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">
        إضافة قسم
        </a>
                </div>
                <form action="{{ route('sections.index') }}" method="GET" class="d-flex" style="min-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="ابحث عن قسم..." value="{{ request('search') }}">
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
                                <td>mustafa khalid</td>
                                {{-- <td>{{ $section?->user?->name}}</td> --}}
                                <td>
                                            <a class="modal-effect btn btn-sm btn-warning" data-effect="effect-scale"
                                                data-id="{{ $section->id }}"
                                                data-section_name="{{ $section->section_name }}"
                                                data-description="{{ $section->description }}" data-toggle="modal"
                                                href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>


                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}"
                                                data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                    class="las la-trash"></i></a>
                                </td>
            {{-- <td><div class="d-flex align-items-center gap-1"><a href="{{ route('sections.update',$section->id) }}" class="btn btn-warning btn-sm">تعديل</a>
            <a href="{{ route('delete',$form->id) }}" class="btn btn-danger btn-sm">Delete</a>
            <form action="{{ route('sections.destroy',$section->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
        </form>
                </div>
</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $sections->links() }}--}}
                    {{ $sections->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

<!-- Basic modal -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <form action="{{ route('sections.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title">إضافة قسم جديد</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <h6>تفاصيل القسم</h6>
                    <p>أدخل اسم القسم والوصف.</p>

                    <div class="form-group">
                        <label>اسم القسم</label>
                        <input type="text" name="section_name" class="form-control @error('section_name') is-invalid @enderror" placeholder="أدخل الاسم" value="{{ old('section_name') }}">
                        @error('section_name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>الوصف</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="أدخل الوصف">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="submit">حفظ</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Basic modal -->
</div>
    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('sections.update',$section->id) }}" method="POST" autocomplete="off">
                    {{-- <form action="sections/update" method="POST" autocomplete="off"> --}}
                    @method('PUT')
                    @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="recipient-name" class="col-form-label">اسم القسم:</label>
                            <input class="form-control" name="section_name" id="section_name" type="text" value="{{ old('section_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">ملاحظات:</label>
                            <textarea class="form-control" id="description" name="description" value="{{ old('description') }}"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تاكيد</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
                </form>
            </div>
        </div>
    </div>

 <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('sections.destroy',$section->id) }}" method="POST">
                    @method('DELETE')
                    @csrf

                {{-- <form action="sections/destroy" method="post"> --}}
                    {{-- {{ method_field('delete') }}
                    {{ csrf_field() }} --}}

                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="id" value="{{ $section->id }}">
                        <input class="form-control" name="section_name" id="section_name" type="text" readonly>
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
<script>
    @if ($errors->any())
        $(document).ready(function () {
            $('#modaldemo8').modal('show');
        });
    @endif
</script>
<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
    })

</script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
    })

</script>
@endsection
