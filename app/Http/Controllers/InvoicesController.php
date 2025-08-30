<?php

namespace App\Http\Controllers;


// use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\InvoicesExport;
use App\Models\User;
use App\Models\Product;
use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;
// use PhpParser\Node\Stmt\Catch_;
use App\Models\InvoiceDetail;
use App\Mail\UpdatePaymentMail;
use Illuminate\Validation\Rule;
use App\Models\InvoiceAttachment;
use App\Notifications\AddInvoices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInvoiceRequest;
use Illuminate\Support\Facades\Notification;
use Illuminate\Routing\Controllers\Middleware;
// use Symfony\Component\Translation\CatalogueMetadataAwareInterface;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function __construct()
// {
//     // $this->middleware('auth');
//     $this->middleware('permission:view-invoice')->only(['index']);
//     $this->middleware('permission:show-invoice')->only(['show']);
//     $this->middleware('permission:create-invoice')->only(['create', 'store']);
//     $this->middleware('permission:edit-invoice')->only(['edit', 'update']);
//     $this->middleware('permission:delete-invoice')->only(['destroy']);
//     $this->middleware('permission:show-deleted-invoice')->only(['archive', 'restore', 'forceDelete']);
//     $this->middleware('permission:excel-import-invoice')->only(['export']);
//     $this->middleware('permission:print-invoice')->only(['printInvoice']);
//     $this->middleware('permission:edit-status-invoice')->only(['getFileStatus', 'updateStatus']);
// }
    public function index(Request $request)
    {
        // $invoices = invoices::with('section')->orderBy('id','asc')->paginate(7);
        // return view('invoices.index', compact('invoices'));
        try {
            $search = $request->input('search');
            $secttion = sections::all();
            $query = invoices::with('section');
            if ($search) {
                $query->where('invoice_number', 'like', "%{$search}%");
            }
            $invoices = $query->orderBy('id', 'asc')->paginate(7);
            if ($search && $invoices->isEmpty()) {
                session()->flash('not_found', 'لا يوجد نتائج مطابقة لكلمة البحث "' . $search . '"');
                $search = '';
            }
            return view('invoices.index', compact('secttion', 'invoices', 'search'));
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('Error');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
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
            Log::channel('invoice')->error("Product Fetch Error: " . $th->getMessage() . $th->getFile() . $th->getLine());
            abort(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    // ->first() to get first row without make foreach
// ->get()   to get all data and make foreach
    public function store(StoreInvoiceRequest $request)
    {
        try {
            $data = $request->validated();
            // dd($data);
            $invoice = invoices::create([
                'invoice_number' => $data['invoice_number'],
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'section_id' => $data['section_id'],
                'product' => $data['product'],
                'amount_collection' => $data['amount_collection'],
                'amount_commission' => $data['amount_commission'],
                'discount' => $data['discount'],
                'rate_vat' => $data['rate_vat'],
                'value_vat' => $data['value_vat'],
                'total' => $data['total'],
                'note' => $data['note'] ?? null,
                'status' => "غير مدفوعة",
                'value_status' => 2,
                'user_id' => Auth::id(),
            ]);
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'product' => $invoice->product,
                'section' => $invoice->section_id,
                'status' => $invoice->status,
                'value_status' => $invoice->value_status,
                'note' => $invoice->note,
                'user' => Auth::user()->name,
            ]);
            if ($request->hasFile('file_name')) {
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
            }
            // $users = User::first();
            // Notification::send($users, new AddInvoices($invoice));

            session()->flash('Add');
            return redirect()->back();
            // return view('invoices.index');

        } catch (\Exception $th) {
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
    public function show($id)
    {
        // $invoices = invoices::where('id',$id)->first();
        $invoices = invoices::findOrFail($id);
        $details = InvoiceDetail::where('invoice_id', $id)->get();
        $attachments = invoiceAttachment::where('invoice_id', $id)->get();
        return view('invoices.show', compact('invoices', 'details', 'attachments'));

        // $invoices = invoices::with(['section','invoiceDetail', 'invoiceAttachment'])->where('id', $id)->firstOrFail();
        // // return $invoices;
        //     return view('invoices.show',['invoices'=> $invoices]);
        // abort(500);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(invoices $invoices)
    // {

    // }
    public function edit($id)
    {
        // get invoices - section - invoicesDetail - invoiceAttachment
        try {
            $invoices = invoices::with(['section', 'invoiceDetail', 'invoiceAttachment'])->findOrFail($id);
            $sections = sections::all();
            return view('invoices.update', compact('invoices', 'sections'));
            // $invoice = invoices::findOrFail($id);
            // // $invoices = invoices::where('id', $id)->first();
            // $sections = sections::all();
            // return view('invoices.update', compact('sections', 'invoices'));

        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('Error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoices = invoices::findOrFail($id);
        $rules = [
            // 'invoice_number' => 'required|string|unique:invoices',
            'invoice_number' => ['required', 'string', Rule::unique('invoices', 'invoice_number')->ignore($invoices->id)],
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',//check due date
            'section_id' => 'required|exists:sections,id',
            'product' => 'required|string',
            'amount_collection' => 'required|numeric',
            'amount_commission' => 'required|numeric',
            'discount' => 'nullable|numeric|lte:amount_commission',
            'rate_vat' => 'required|numeric|in:5,10,15',
            'value_vat' => 'required|numeric',
            'total' => 'required|numeric', // is not required
            'note' => 'nullable|string', // is not required
        ];
        //    if ($request->invoice_number == $invoices->invoice_number) {
        //     $rules['invoice_number'] = 'required|unique:invoices,invoice_number,' . $id;
        // } else {
        //     $rules['invoice_number'] = 'required';
        // }
        $request->validate($rules, [
            'invoice_number.required' => 'رقم الفاتورة مطلوب',
            'invoice_number.unique' => 'رقم الفاتورة موجود بالفعل',
            'invoice_date.required' => 'تاريخ الفاتورة مطلوب',
            'due_date.required' => 'تاريخ الاستحقاق مطلوب',
            'due_date.after_or_equal' => 'تاريخ الاستحقاق يجب أن يكون بعد أو يساوي تاريخ الفاتورة',
            'section_id.required' => 'القسم مطلوب',
            'section_id.exists' => 'القسم غير موجود',
            'product.required' => 'اسم المنتج مطلوب',
            'amount_collection.required' => 'مبلغ التحصيل مطلوب',
            'amount_collection.numeric' => 'مبلغ التحصيل يجب أن يكون رقمًا',
            'amount_commission.required' => 'مبلغ العمولة مطلوب',
            // 'amount_commission.lte'        => 'العمولة يجب أن تكون أقل من أو تساوي مبلغ التحصيل',
            'discount.numeric' => 'الخصم يجب أن يكون رقمًا',
            'discount.lte' => 'الخصم لا يمكن أن يتجاوز مبلغ العمولة',
            'rate_vat.required' => 'نسبة الضريبة مطلوبة',
            'rate_vat.in' => 'نسبة الضريبة يجب أن تكون 5% أو 10% أو 15%',
            'value_vat.required' => 'قيمة الضريبة مطلوبة',
            'total.required' => 'الإجمالي مطلوب',
            'note.string' => 'الملاحظات تكون كلام ',
        ]);
        DB::beginTransaction();
        try {
            $invoices->update([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'product' => $request->product,
                'section_id' => $request->section_id,
                'amount_collection' => $request->amount_collection,
                'amount_commission' => $request->amount_commission,
                'discount' => $request->discount,
                'value_vat' => $request->value_vat,
                'rate_vat' => $request->rate_vat,
                'total' => $request->total,
                'note' => $request->note,
            ]);
            DB::commit();
            session()->flash('Edit');
        } catch (\Exception $th) {
            DB::rollBack();
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            session()->flash('Error');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // invoices::findOrFail($id)->forceDelete(); //force delete
        // invoices::findOrFail($id)->delete();// soft delete
        try {
            $invoice = invoices::with('invoiceAttachment')->findOrFail($id);
            foreach ($invoice->invoiceAttachment as $attachment) {
                $filePath = 'invoices_file/' . $attachment->file_name;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $attachment->delete();
            }
            // $invoice->forceDelete();// forece delete
            $invoice->delete();// soft delete
            session()->flash('Delete');
            // session()->flash('Delete', 'تم حذف القسم بنجاح');
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            session()->flash('Error');
        }
        return redirect()->back();
    }

    public function getFileStatus($id)
    {
        try {
            // $invoices = invoices::where('id',$id)->first();
            $invoices = invoices::findOrFail($id);
            return view('invoices.status', compact('invoices'));
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            session()->flash('Error');
            return redirect()->back();
        }
    }

    public function updateStatus($id, Request $request)
    {
        $rules = [
            'status' => 'required|in:مدفوعة,مدفوعة جزئيا',
            'payment_date' => 'required|date',
            'invoice_number' => 'required|string',
            'product' => 'required|string',
            'section' => 'required|exists:sections,id',
            'note' => 'nullable|string',
        ];
        $messages = [
            'status.required' => 'حالة الفاتورة مطلوبة',
            'status.in' => 'الحالة يجب أن تكون مدفوعة أو مدفوعة جزئيا',
            'payment_date.required' => 'تاريخ الدفع مطلوب',
            'payment_date.date' => 'تاريخ الدفع غير صالح',
            'invoice_number.required' => 'رقم الفاتورة مطلوب',
            'product.required' => 'اسم المنتج مطلوب',
            'section.required' => 'القسم مطلوب',
            'section.exists' => 'القسم غير موجود',
            'note.string' => 'الملاحظات يجب أن تكون نص',
        ];
        $request->validate($rules, $messages);
        try {
            $invoice = invoices::findOrFail($id);

            $isPaid = $request->status === 'مدفوعة';
            $statusValue = $isPaid ? 1 : 3;

            $invoice->update([
                'value_status' => $statusValue,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);

            invoiceDetail::create([
                'invoice_id' => $invoice->id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => $statusValue,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => Auth::user()->name,
            ]);
            //  $users = User::where('status' , 1)->get();
            // Notification::send($users, new invoiceDetail($invoice , $invoice->total + $invoice->amount_collection));
            // $total = $invoice->amount_collection + $invoice->amount_commission;
            //   Mail::to("test")->send(new UpdatePaymentMail($invoice,$total));
            // Mail::to($user->email)->queue(new WelcomeUserMail($user));
            // Auth::login($user);
            session()->flash('updateStates');
            // session()->flash('updateStates', 'تم تحديث حالة الفاتورة بنجاح');
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . ' in ' . $th->getFile() . ' on line ' . $th->getLine());
            session()->flash('Error');
        }
        return redirect()->route('invoices.index');
    }


    public function paidStatus(Request $request)
    {
        try {
            // $invoices = invoices::with('section')->where('value_status', 1)->orderBy('id', 'asc')->paginate(7);
            $search = $request->input('search');
            $secttion = sections::all();
            $query = invoices::with('section')->where('value_status', 1);
            if ($search) {
                $query->where('invoice_number', 'like', "%{$search}%");
            }
            $invoices = $query->orderBy('id', 'asc')->paginate(7);
            if ($search && $invoices->isEmpty()) {
                session()->flash('not_found', 'لا يوجد نتائج مطابقة لكلمة البحث "' . $search . '"');
                $search = '';
            }
            return view('invoices.paid', [
                'invoices' => $invoices,
                'search' => $search,
                'section' => $secttion
            ]);
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('Error');
        }



        // return $invoices ;

    }

    // public function paid()
// {
//     $invoices = invoices::with('section')
//         ->where('value_status', 1)
//         ->whereHas('section')
//         ->orderBy('id', 'asc')
//         ->paginate(7);
//   dd($invoices);
//     return view('invoices.paid', compact('invoices'));
// }

    public function unpaidStatus(Request $request)
    {
        try {
            // $invoices = invoices::with('section')->where('value_status', 2)->orderBy('id', 'asc')->paginate(7);
            $search = $request->input('search');
            $secttion = sections::all();
            $query = invoices::with('section')->where('value_status', 2);
            if ($search) {
                $query->where('invoice_number', 'like', "%{$search}%");
            }
            $invoices = $query->orderBy('id', 'asc')->paginate(7);
            if ($search && $invoices->isEmpty()) {
                session()->flash('not_found', 'لا يوجد نتائج مطابقة لكلمة البحث "' . $search . '"');
                $search = '';
            }
            return view('invoices.paid', [
                'invoices' => $invoices,
                'search' => $search,
                'section' => $secttion
            ]);
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('Error');
        }
    }
    public function partialPaidStatus(Request $request)
    {

        try {
            // $invoices = invoices::with('section')->where('value_status', 3)->orderBy('id', 'asc')->paginate(7);
            $search = $request->input('search');
            $secttion = sections::all();
            $query = invoices::with('section')->where('value_status', 3);
            if ($search) {
                $query->where('invoice_number', 'like', "%{$search}%");
            }
            $invoices = $query->orderBy('id', 'asc')->paginate(7);
            if ($search && $invoices->isEmpty()) {
                session()->flash('not_found', 'لا يوجد نتائج مطابقة لكلمة البحث "' . $search . '"');
                $search = '';
            }
            return view('invoices.paid', [
                'invoices' => $invoices,
                'search' => $search,
                'section' => $secttion
            ]);
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('Error');
        }
    }

    public function showArchive(Request $request)
    {
        try {
            $search = $request->input('search');
            $query = Invoices::onlyTrashed()->with('section');
            if ($search) {
                $query->where('invoice_number', 'like', "%{$search}%");
            }
            $invoices = $query->orderBy('id', 'asc')->paginate(7);
            if ($search && $invoices->isEmpty()) {
                session()->flash('not_found', 'لا يوجد نتائج مطابقة لكلمة البحث "' . $search . '"');
                $search = '';
            }
            return view('invoices.archive', compact('invoices', 'search'));
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('Error');
        }
    }

    public function forceDelete($id)
    {
        try {
            $invoice = invoices::with('invoiceAttachment')->findOrFail($id);
            foreach ($invoice->invoiceAttachment as $attachment) {
                $filePath = 'invoices_file/' . $attachment->file_name;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $attachment->delete();
            }
            $invoice->forceDelete();// forece delet       // $invoice->delete();// soft delete
            session()->flash('Delete');
            // session()->flash('Delete', 'تم حذف القسم بنجاح');
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            session()->flash('Error');
        }
        return redirect()->back();
    }

    public function restore($id)
    {
        // Invoices::withTrashed()->where('id', $id)->restore();
        try {
            Invoices::withTrashed()->where('id', $id)->firstOrFail()->restore();
            session()->flash('restore_invoice', 'تم استرجاع الفاتورة بنجاح');
            return redirect()->route('invoices.index');
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            session()->flash('Error', 'حصل خطأ أثناء استرجاع الفاتورة');
            return redirect()->back();
        }

    }
    public function printInvoice($id)
    {
        try {
            // $invoices = invoices::with(['section', 'invoiceDetail', 'invoiceAttachment'])->findOrFail($id);
            $invoices = Invoices::with('section')->findOrFail($id);
            return view('invoices.print', compact('invoices'));
        } catch (\Throwable $th) {
            Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('Error', 'حدث خطأ أثناء تحميل صفحة الطباعة');
        }
    }

    public function export()
    {
        // return 'test ';
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }





















    // composer require barryvdh/laravel-dompdf

    // public function downloadPDF($id)
    // {
    //     $invoice = Invoice::with(['section','user'])->findOrFail($id);
    //     $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
    //     return $pdf->download('invoice_'.$invoice->invoice_number.'.pdf');
    //     // return $pdf->stream('invoice_'.$invoice->invoice_number.'.pdf');
    // }

}

//   public function delete($id){
//     // return $id ;
//   DB::table('forms')->where('id',$id)->delete();
//     return redirect()->route('form');
// }

// public function deleteAll(){
//    DB::table('forms')->delete();//delete() is delete all posts but the id is increment from last id if id =30 and delete all the new post will be 31 to solve that use truncate
//    return redirect()->route('form');
// }

// public function truncateAll(){
//     DB::table('forms')->truncate();
//     return redirect()->route('form');
// }


