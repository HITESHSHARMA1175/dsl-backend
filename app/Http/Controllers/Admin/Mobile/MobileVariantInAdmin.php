<?php

namespace App\Http\Controllers\Admin\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\Mmodel;
use App\Models\Variant;


class MobileVariantInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Variant::query();
        
        if ($request->search_text != '') {
            $query->where('name', 'LIKE', '%'.$request->search_text.'%');
        }
        if ($request->brand != '') {
            $query->where('brand', $request->brand);
        }
        if ($request->model != '') {
            $query->where('model', $request->model);
        }
        
        $variants = $query->paginate(10);
        $variantsCount = $query->count();
        
        $brands=Brand::where('id','!=','')->get();
        $models=Mmodel::where('id','!=','')->where('brand',$request->brand)->get();
        
        return view('admin.variant.index', compact('variants','variantsCount','brands','models','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $variant_info='';
        $brands=Brand::where('id','!=','')->get();
        return view('admin.variant.create', compact('variant_info','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveVariant = new Variant();
        $saveVariant->brand = $request->brand;
        $saveVariant->model = $request->model;
        $saveVariant->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveVariant->profile = $FileName;
        }

        $saveVariant->save();



        return redirect()
            ->back()
            ->with('success', 'Variant has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $variant_info = Variant::where('id', $id)->first();
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.variant.update', compact('variant_info','brands'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveVariant = Variant::find($id);
        $saveVariant->brand = $request->brand;
        $saveVariant->model = $request->model;
        $saveVariant->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveVariant->profile = $FileName;
        }
        
        $saveVariant->save();



        return redirect()
            ->back()
            ->with('success', 'Variant has been saved.');
    }

    public function banner_status($id)
    {
        $data = Variant::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'Variant ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = Variant::findOrFail($id);
        $variant->delete();
        return redirect()
            ->back()
            ->with('success', 'Variant has been Deleted Successfully!!');
    }
}
