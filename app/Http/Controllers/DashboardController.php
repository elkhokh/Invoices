<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
        public function index()
    {
        $all_count  = invoices::count();
        $all_total  = invoices::sum('total');
        $paid_count  = invoices::where('value_status', 1)->count();
        $paid_total  = invoices::where('value_status', 1)->sum('total');
        $unpaid_count = invoices::where('value_status', 2)->count();
        $unpaid_total = invoices::where('value_status', 2)->sum('total');
        $partpaid_count = invoices::where('value_status', 3)->count();
        $partpaid_total = invoices::where('value_status', 3)->sum('total');

        return view('dashboard', [
            'all_count'=>$all_count ,
            'all_total'=>$all_total ,
            'paid_count'=>$paid_count ,
            'paid_total'=>$paid_total ,
            'unpaid_count'=>$unpaid_count ,
            'unpaid_total'=>$unpaid_total ,
            'partpaid_count'=>$partpaid_count ,
            'partpaid_total'=>$partpaid_total ,
        ]);
    }
}
