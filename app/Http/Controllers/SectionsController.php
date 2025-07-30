<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            try {
        $search = $request->input('search');
        $query = sections::query();

        if ($search) {
            $query->where('section_name', 'like', "%{$search}%");
        }
        $sections = $query->orderBy('id', 'asc')->paginate(7);
        // $sections = sections::with('user')->orderBy('id', 'asc')->paginate(8);
        // $sections = sections::where('user_id',auth()->id())->orderBy('id', 'desc')->paginate(10);
        return view('sections.index', ['sections' => $sections,'search' => $search]);

    } catch (\Throwable $th) {
    Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        return redirect()->back()->with('error', 'حدث خطأ أثناء تحميل الأقسام');
    }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
    'section_name' => 'required|string|unique:sections,section_name',
    'description'  => 'required|string',
    ], [
    'section_name.required' => 'اسم القسم مطلوب',
    'section_name.unique'   => 'اسم القسم موجود بالفعل',
    'description.required'  => 'الوصف مطلوب',
    ]);

        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ]);

    session()->flash('Add', "تمت إضافة القسم بنجاح");
    return redirect()->back();
        // return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $section = sections::findOrFail($id);
    $rules = [
        'description' => 'required|string',
    ];

    if ($request->section_name == $section->section_name) {
        $rules['section_name'] = 'required|string|unique:sections,section_name,' . $id;
    } else {
        $rules['section_name'] = 'required|string';
    }

    $request->validate($rules, [
        'section_name.required' => 'اسم القسم مطلوب',
        'section_name.unique'   => 'اسم القسم موجود بالفعل',
        'description.required'  => 'الوصف مطلوب',
    ]);

    DB::beginTransaction();

    try {
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        DB::commit();
        session()->flash('Edit', 'تم تعديل القسم بنجاح');
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
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('Delete','تم حذف القسم بنجاح');
        return redirect()->back();
    }

    // public function destroy(sections $sections)
    // {
//  dd($sections); //Model Binding
    // try {
    //     $sections->delete();
    //     session()->flash('Delete', 'تم حذف القسم بنجاح');
    // } catch (\Throwable $th) {
    //     Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
    //     session()->flash('error', 'حدث خطأ أثناء الحذف');
    // }
    // return redirect()->back();


}

