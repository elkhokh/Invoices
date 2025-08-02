<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
// use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\InvoiceAttachment;

// use Symfony\Component\Translation\CatalogueMetadataAwareInterface;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $invoices = invoices::with('section')->orderBy('id','asc')->paginate(7);
        return view('invoices.index', compact('invoices'));
    //         try {
    //     $search = $request->input('search');
    //     $invoices = invoices::all();
    //     $query = Product::with('section');
    //     if ($search) {
    //         $query->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
    //     }
    //     $invoices_se = $query->orderBy('id', 'asc')->paginate(7);

    //     if ($search && $invoices_se->isEmpty()) {
    //         session()->flash('not_found', 'لا يوجد نتائج مطابقة لكلمة البحث "' . $search . '"');
    //         $search = '';
    //     }
    //     return view('invoices.index', compact('invoices', 'invoices_se', 'search'));
    // } catch (\Throwable $th) {
    //     Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
    //     return redirect()->back()->with('error', 'حدث خطأ أثناء عرض المنتجات');
    // }

    }

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    try{
    $sections = Sections::all();
    return view('invoices.create', compact('sections'));
    // return view('invoices.create', with('sections'));
    // return view('invoices.create', ['sections'=>$sections]);
        } catch (\Throwable $th) {
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        return redirect()->back()->with('error', 'حدث خطأ أثناء عرض الاقسام');
    }
}

    public function getProductsForSection($id)
    {
    //    $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
    //     return json_encode($products);

    try {
        if (!DB::table('sections')->where('id', $id)->exists()) {
        abort(400);
        }
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        //Laravel Response system best than json_encode();
        return response()->json($products);
    } catch (\Throwable $th) {
        Log::channel('invoice')->error("Product Fetch Error: " . $th->getMessage() . ' in ' . $th->getFile() . ' on line ' . $th->getLine());
        abort(500);
    }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreInvoiceRequest $request)
    {
        try{
        $data = $request->validated();

        // dd($data);
        $invoice = invoices::create([
    'invoice_number'    => $data['invoice_number'],
    'invoice_date'      => $data['invoice_date'],
    'due_date'          => $data['due_date'],
    'section_id'        => $data['section_id'],
    'product'           => $data['product'],
    'amount_collection' => $data['amount_collection'],
    'amount_commission' => $data['amount_commission'],
    'discount'          => $data['discount'],
    'rate_vat'          => $data['rate_vat'],
    'value_vat'         => $data['value_vat'],
    'total'             => $data['total'],
    'note'              => $data['note'] ?? null,
    'status'            => "غير مدفوعة",
    'value_status'      => 2,
    'user_id'           => Auth::id(),
]);

InvoiceDetail::create([
    'invoice_id'     => $invoice->id,
    'invoice_number' => $invoice->invoice_number,
    'product'        => $invoice->product,
    'section'        => $invoice->section_id,
    'status'         => $invoice->status,
    'value_status'   => $invoice->value_status,
    'note'           => $invoice->note,
    'user'           => Auth::user()->name,
]);

        if ($request->hasFile('file_name')) {
            $file = $request->file('file_name');
            // file_name - upload file in storage - save to var
            $fileName = time() . "_" . $file->getClientOriginalName();
            $url = Storage::disk("public")->putFileAs("invoices_file", $file, $fileName);
            $data['file_name'] = $url;
        }
                $invoice->invoiceAttachment()->create([
                'file_name' => $fileName,
                'invoice_number' => $invoice->invoice_number,
                'invoice_id' => $invoice->id,
                'created_by' => Auth::user()->name,
            ]);

        session()->flash('Add', "تمت إضافة الفاتورة بنجاح");
        return redirect()->back();
        // return view('invoices.index');

        }catch (\Exception $th) {
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        return redirect()->back()->with('Error', 'حدث خطأ أثناء حفظ الفاتورة ');
        }

            // "file_name":{}
        // return $request ;
    }

    // public function store(Request $request)
    // {
    //     invoices::create([
    //         'invoice_number' => $request->invoice_number,
    //         'invoice_Date' => $request->invoice_Date,
    //         'Due_date' => $request->Due_date,
    //         'product' => $request->product,
    //         'section_id' => $request->Section,
    //         'Amount_collection' => $request->Amount_collection,
    //         'Amount_Commission' => $request->Amount_Commission,
    //         'Discount' => $request->Discount,
    //         'Value_VAT' => $request->Value_VAT,
    //         'Rate_VAT' => $request->Rate_VAT,
    //         'Total' => $request->Total,
    //         'Status' => 'غير مدفوعة',
    //         'Value_Status' => 2,
    //         'note' => $request->note,
    //     ]);
    //     $invoice_id = invoices::latest()->first()->id;
    //     invoices_details::create([
    //         'id_Invoice' => $invoice_id,
    //         'invoice_number' => $request->invoice_number,
    //         'product' => $request->product,
    //         'Section' => $request->Section,
    //         'Status' => 'غير مدفوعة',
    //         'Value_Status' => 2,
    //         'note' => $request->note,
    //         'user' => (Auth::user()->name),
    //     ]);
    //     if ($request->hasFile('pic')) {
    //         $invoice_id = Invoices::latest()->first()->id;
    //         $image = $request->file('pic');
    //         $file_name = $image->getClientOriginalName();
    //         $invoice_number = $request->invoice_number;
    //         $attachments = new invoice_attachments();
    //         $attachments->file_name = $file_name;
    //         $attachments->invoice_number = $invoice_number;
    //         $attachments->Created_by = Auth::user()->name;
    //         $attachments->invoice_id = $invoice_id;
    //         $attachments->save();
    //         // move pic
    //         $imageName = $request->pic->getClientOriginalName();
    //         $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
    //     }
    //     session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
    //     return back();
    // }

    /**
     * Display the specified resource.
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices $invoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices $invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices $invoices)
    {
        //
    }
}
        // invoices::create([
        //     'invoice_number'   =>$data['invoice_number'],
        //     'invoice_date'     =>$data['invoice_date'],
        //     'due_date'         =>$data['due_date'],
        //     'section_id'       =>$data['section_id'],
        //     'product'          =>$data['product'],
        //     'amount_collection'=>$data['amount_collection'],
        //     'amount_commission'=>$data['amount_commission'],
        //     'discount'         =>$data['discount'],
        //     'rate_vat'         =>$data['rate_vat'],
        //     'value_vat'        =>$data['value_vat'],
        //     'total'            =>$data['total'],
        //     'note'             =>$data['note']??null,
        //     'status'           =>"غير مدفوعة",
        //     'value_status'     =>2,
        //     'user_id'          => Auth::id(),
        // ]);

        // $invoice_id = invoices::latest()->first()->id; // to get the last id store in invoices
        // InvoiceDetail::create([
        //     'invoice_id'       => $invoice_id,
        //     'invoice_number'   =>$data['invoice_number'],
        //     'product'          =>$data['product'],
        //     'section'          =>$data['section_id'],
        //     'status'           => 'غير مدفوعة',
        //     'value_status'     => 2,
        //     'note'             =>$data['note'],
        //     'user'             => Auth::user()->name,
        // ]);
