<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class CustomersReportsController extends Controller
{
    public function index(){

    $sections = sections::all();
    return view('reports.customer',compact('sections'));

    }

public function search(Request $request)
{
        // return $request;
        // "section": "2",
        // "Product_name": "2",
    if ($request->section && $request->Product_name && $request->start_at == '' && $request->end_at == '') {
        $invoices = invoices::select('*')->where('section_id', $request->section)
            ->where('product', $request->Product_name)->get();
            return $invoices;
        $sections = sections::all();

    // return $invoices .'and'.$sections ;

        return view('reports.customer', compact('sections'))->withDetails($invoices);
    } else {
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
        $invoices = invoices::whereBetween('invoice_date', [$start_at, $end_at])
        ->where('section_id', $request->section)->where('product', $request->Product_name) ->get();
        $sections = sections::all();
        return view('reports.customer', compact('sections'))->withDetails($invoices);
    }
}


}
