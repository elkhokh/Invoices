<?php
//BUG:  lllllllll
//HACK: lllllllll
//INFO: lllllllll
//TODO: 111111111
//IDEA: 111111111
//FIXME:111111111
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    try {
        $search = $request->input('search');
        $sections = sections::all();
        $query = Product::with('section');
        if ($search) {
            $query->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
        }
        $products = $query->orderBy('id', 'asc')->paginate(7);

        if ($search && $products->isEmpty()) {
            session()->flash('not_found', 'لا يوجد نتائج مطابقة لكلمة البحث "' . $search . '"');
            $search = '';
        }
        return view('products.index', compact('sections', 'products', 'search'));
    } catch (\Throwable $th) {
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        return redirect()->back()->with('error', 'حدث خطأ أثناء عرض المنتجات');
    }
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

public function store(StoreProductRequest $request)
{
// dd($request->all());
    try {
        $data = $request->validated();

        Product::create([
            'Product_name' => $data['Product_name'],
            'section_id' => $data['section_id'],
            'description'  => $data['description'],
            'created_by'   => Auth::user()->name,
        ]);

        session()->flash('Add', "تمت إضافة القسم بنجاح");
        return redirect()->back();

    } catch (\Exception $th) {
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        // return redirect()->back()->with('error', 'حدث خطأ أثناء تحميل المنتج');
        return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة المنتج')->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $rules = [
        'description' => 'required|string',
        'section_id' => 'required|exists:sections,id',
    ];

    if ($request->Product_name !== $product->Product_name) {
        $rules['Product_name'] = 'required|string|unique:products,Product_name';
    } else {
        $rules['Product_name'] = 'required|string';
    }

    $request->validate($rules, [
        'Product_name.required' => 'اسم المنتج مطلوب',
        'Product_name.unique' => 'اسم المنتج موجود بالفعل',
        'section_id.required' => 'القسم مطلوب',
        'section_id.exists' => 'القسم غير موجود',
        'description.required' => 'الوصف مطلوب',
    ]);

    DB::beginTransaction();

    try {
        $product->update([
            'Product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);

        DB::commit();
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
    } catch (\Exception $th) {
        DB::rollBack();
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        session()->flash('error', 'حدث خطأ أثناء التعديل: ' . $th->getMessage());
    }

    return redirect()->back();
}


    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
{
    try {
        Product::findOrFail($id)->delete();
        session()->flash('Delete', 'تم حذف القسم بنجاح');
    } catch (\Throwable $th) {
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        session()->flash('error', 'حدث خطأ أثناء الحذف');
    }

    return redirect()->back();
}
}
