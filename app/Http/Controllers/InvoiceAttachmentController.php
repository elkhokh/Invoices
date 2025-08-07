<?php

namespace App\Http\Controllers;


use App\Models\invoices;
use Illuminate\Http\Request;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
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
    public function store(Request $request)
    {
        try {
            $invoice = invoices::query()->findOrFail($request['invoice_id']);

            $request->validate([
                'file_name' => 'required|mimes:jpg,png,jpeg'
            ],[
                'file_name.required'=>'المرفق مطلووووووب',
                'file_name.mimes' =>'ركز وشوف امتداد الصور'
            ]);

            $file = $request->file('file_name');
            
            // file_name - upload file in storage - save to var
            // $fileName = time() . "_" . $file->getClientOriginalName();
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $url = Storage::disk("public")->putFileAs("invoices_file", $file, $fileName);
            $data['fileName'] = $url;
                $invoice->invoiceAttachment()->create([
                'file_name' => $fileName,
                'invoice_number' => $invoice->invoice_number,
                'invoice_id' => $invoice->id,
                'created_by' => Auth::user()->name,
            ]);
            return redirect()->back()->with('Add', 'تم أضافة المرفق بنجاح');
        }catch (\Exception $th) {
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('Error', 'فشل اضافة المرفق');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
        $attachment = InvoiceAttachment::findOrFail($id);
        $filePath = 'invoices_file/' . $attachment->file_name;
        if (Storage::disk('public')->exists($filePath))
            {
            Storage::disk('public')->delete($filePath);
        }
        $attachment->delete();
        session()->flash('Delete', 'تم حذف القسم بنجاح');

    } catch (\Throwable $th) {
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        session()->flash('Error', 'حدث خطأ أثناء الحذف');
    }
    return redirect()->back();
    }

}
