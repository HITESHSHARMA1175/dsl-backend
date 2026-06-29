<?php

namespace App\Http\Controllers\Admin\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;


class MobileBrandInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Brand::query();
        
        if ($request->search_text != '') {
            $query->where('name', 'LIKE', '%'.$request->search_text.'%');
        }
        
        $brands = $query->paginate(10);
        $brandsCount = $query->count();
        
        return view('admin.brand.index', compact('brands','brandsCount','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand_info='';
        return view('admin.brand.create', compact('brand_info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveBrand = new Brand();
        $saveBrand->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveBrand->profile = $FileName;
        }

        $saveBrand->save();



        return redirect()
            ->back()
            ->with('success', 'Brand has been saved.');
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
        $brand_info = Brand::where('id', $id)->first();

        return view('admin.brand.update', compact('brand_info'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveBrand = Brand::find($id);
        $saveBrand->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveBrand->profile = $FileName;
        }
        
        $saveBrand->save();



        return redirect()
            ->back()
            ->with('success', 'Brand has been saved.');
    }

    public function banner_status($id)
    {
        $data = Brand::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'Brand ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()
            ->back()
            ->with('success', 'Brand has been Deleted Successfully!!');
    }
}
