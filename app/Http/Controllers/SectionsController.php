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
    public function index()
    {
        // $sections =sections::orderBy('id','asc')->paginate(7);
        // return view('sections.index',['sections'=>$sections]);
            try {
        $sections =sections::orderBy('id','asc')->paginate(7);
        // $sections = sections::with('user')->orderBy('id', 'asc')->paginate(8);
            // $sections = sections::where('user_id',auth()->id())->orderBy('id', 'desc')->paginate(10);
            return view('sections.index',['sections'=>$sections]);
        } catch (\Throwable $th) {
        Log::channel("invoice")->error($th->getMessage() . $th->getFile() . $th->getLine());
        //    Log::error($th->getMessage() . $th->getFile() . $th->getLine());
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
    $request->validate([
        'section_name' => 'required|string|unique:sections,section_name,' . $id,
        'description'  => 'required|string',
    ], [
        'section_name.required' => 'اسم القسم مطلوب',
        'section_name.unique'   => 'اسم القسم موجود بالفعل',
        'description.required'  => 'الوصف مطلوب',
    ]);

    $section = sections::findOrFail($id);

    DB::beginTransaction();

    try {
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
            // 'created_by' => Auth::user()->name,
        ]);

        DB::commit();
        session()->flash('Edit', 'تم تعديل القسم بنجاح');
    } catch (\Exception $e) {
        DB::rollBack();
        session()->flash('error', 'حدث خطأ أثناء التعديل: ' . $e->getMessage());
    }

    return redirect()->back();
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sections $sections)
    {

    }
}
