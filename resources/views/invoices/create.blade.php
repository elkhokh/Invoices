@extends('layouts.master')
@section('title', 'اضافة فاتورة')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    اضافة فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
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
    @if(session()->has('Error'))
        <div class="alert alert-success alert-dismissible fade show fs-5 w-75 mx-auto text-center" role="alert">
            <strong>{{ session('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
  </div>
    <!-- row -->

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf

                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                    title="يرجي ادخال رقم الفاتورة" value="{{ old('invoice_number') }}">
                                        @error('section_id')
        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                            </div>
                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" >
                        @error('invoice_date')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
                            </div>
                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                    type="text" >
                                                                        @error('due_date')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
                            </div>
                        </div>
                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                {{-- select section form opations = section ==>>  --}}
                                <select name="section_id" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد القسم</option>
                                    @foreach ($sections as $section)
                                    {{-- var SectionId take the id  from value option  >>>> --}}
                                        <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                                    @error('section_id')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="product" name="product" class="form-control">
                                </select>
                                    @error('product')
        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="number" class="form-control" id="inputName" name="amount_collection" value="{{ old('amount_collection')}}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        @error('amount_collection')
            <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- 3 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="number" class="form-control form-control-lg" id="amount_commission"
                                    name="amount_commission" title="يرجي ادخال مبلغ العمولة " value="{{ old('amount_commission')}}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                @error('amount_commission')
        <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="number" class="form-control form-control-lg" id="Discount" name="discount"
                                    title="يرجي ادخال مبلغ الخصم " value="{{ old('invoice_number')}}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value=0 >
                    @error('discount')
        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                    <option value="15">15%</option>
                                </select>
                        @error('rate_vat')
        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                            </div>
                        </div>
                        {{-- 4 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="number" class="form-control" id="Value_VAT" name="value_vat" readonly>
                @error('value_vat')
        <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="number" class="form-control" id="Total" name="total" readonly>
                    @error('total')
        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                    @error('note')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                            </div>
                        </div><br>

                        <p class="text-danger">* صيغة المرفق  jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="file_name" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                                data-height="70" />
                                @error('file_name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>
{{-- <script>
    @if ($errors->any())
        $(document).ready(function () {
            $('#exampleModal').modal('show');
        });
    @endif
</script> --}}
    <script>
        $(document).ready(function() {
            // when he select from   name = section
            $('select[name="section_id"]').on('change', function() {
                var SectionId = $(this).val(); //is take the value of section->$id from section
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('sections') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
// if ajax success first make value of product name empty after that go git data from product with relation section and show the new option
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>

    <script>
        function myFunction() {
            var Amount_Commission = parseFloat(document.getElementById("amount_commission").value);
            var Discount = parseFloat(document.getElementById("Discount").value);
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value);
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value);
            var Amount_Commission2 = Amount_Commission - Discount;
            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {
                alert('يرجي ادخال مبلغ العمولة ');
            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;
                var intResults2 = parseFloat(intResults + Amount_Commission2);
                sumq = parseFloat(intResults).toFixed(2);
                sumt = parseFloat(intResults2).toFixed(2);
                document.getElementById("Value_VAT").value = sumq;
                document.getElementById("Total").value = sumt;
            }
        }
    </script>

@endsection
