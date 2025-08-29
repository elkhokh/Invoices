<?php

namespace App\Http\Controllers;
use App\Models\invoices;
use Illuminate\Http\Request;

class InvoicesReportsController extends Controller
{
    public function index(){
        // return 'test';
        return view('reports.invoice');
    }

    public function search(Request $request)
        {
        // return $request ;
    $rdio = $request->rdio;
    if ($rdio == 1) {
        if ($request->type == 4) {
        $invoices = invoices::with('section')->get();
        $type = $request->type;
        return view('reports.invoice', compact('type'))->withDetails($invoices);
    }
        if ($request->type && $request->start_at =='' && $request->end_at =='') {
    $invoices = invoices::select('*')->with('section')->where('value_status','=',$request->type)->get();
    $type = $request->type;
    return view('reports.invoice',compact('type'))->withDetails($invoices);
        }
        else {
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
    // $start_at = date('Y-m-d', strtotime($request->start_at));
    // $end_at   = date('Y-m-d', strtotime($request->end_at));
        $type = $request->type;
          $type = $request->type;
$invoices = invoices::with('section')
->whereBetween('invoice_date',[$start_at,$end_at])->where('value_status','=',$request->type)->get();
        // $invoices = invoices::whereBetween('invoice_date',[$start_at,$end_at])->where('value_status','=',$request->type)->get();
        return view('reports.invoice',compact('type','start_at','end_at'))->withDetails($invoices);
        }
    }
// في البحث برقم الفاتورة
    else {
        // $invoices = invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
$invoices = invoices::with('section')->where('invoice_number','=',$request->invoice_number)->get();
        return view('reports.invoice')->withDetails($invoices);
    }
    }
}

