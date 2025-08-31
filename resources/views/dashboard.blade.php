@extends('layouts.master')
@section('title', 'لوحة التحكم الرئيسية')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome back!</h2>
                <p class="mg-b-0">{{Auth::user()->name}}</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white"> الفواتير </h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">

                                <h4 class="tx-20 font-weight-bold mb-1 text-white">  {{ $all_count }}  عدد الفواتير  </h4>
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ number_format($all_total, 2) }} جنيه مصري</h4>
                                {{-- <p class="mb-0 tx-12 text-white op-7"> {{ \App\Models\Invoices::where('value_status', 1)->count() }}</p> --}}
                                {{-- <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ \App\Models\Invoices::where('value_status', 1)->count() }}</h4>
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">جنيه مصري{{ \App\Models\Invoices::where('value_status', 1)->sum('total') }}</h4> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير غير المدفوعة </h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white"> {{ $unpaid_count }}  عدد الفواتير</h4>
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
    {{ number_format($unpaid_total, 2) }} جنيه مصري
</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة </h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white"> {{ $paid_count }}  عدد الفواتير  </h4>
                        <h4 class="tx-20 font-weight-bold mb-1 text-white">
    {{ number_format($paid_total, 2) }} جنيه مصري
</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئيا</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">  {{ $partpaid_count }}  عدد الفواتير  </h4>
                          <h4 class="tx-20 font-weight-bold mb-1 text-white">
    {{ number_format($partpaid_total, 2) }} جنيه مصري
</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
@endsection
