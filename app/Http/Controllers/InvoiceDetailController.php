<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreInvoiceDetailRequest;
use App\Http\Requests\UpdateInvoiceDetailRequest;
use App\Models\InvoiceAttachment;
use GuzzleHttp\Psr7\Request;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceDetail $invoiceDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceDetail $invoiceDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceDetailRequest $request, InvoiceDetail $invoiceDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request){
        return $request ;
    }
    // public function destroy($id)
    // {
    //     //      $invoices = invoice_attachments::findOrFail($request->id_file);
    //     // $invoices->delete();
    //     // Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
    //     // session()->flash('delete', 'تم حذف المرفق بنجاح');
    //     // return back();
    //        try {
    //     InvoiceAttachment::findOrFail($id)->delete();
    //     session()->flash('Delete', 'تم حذف القسم بنجاح');
    // } catch (\Throwable $th) {
    //     Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
    //     session()->flash('error', 'حدث خطأ أثناء الحذف');
    // }

    // return redirect()->back();
    // }
}
