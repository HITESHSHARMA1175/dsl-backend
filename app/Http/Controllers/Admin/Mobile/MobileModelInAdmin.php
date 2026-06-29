<?php

namespace App\Http\Controllers\Admin\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\Mmodel;


class MobileModelInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Mmodel::query();
        
        if ($request->search_text != '') {
            $query->where('name', 'LIKE', '%'.$request->search_text.'%');
        }
        if ($request->brand != '') {
            $query->where('brand', $request->brand);
        }
        
        $models = $query->paginate(10);
        $modelsCount = $query->count();
        
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.model.index', compact('models','modelsCount','brands','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $model_info='';
        $brands=Brand::where('id','!=','')->get();
        return view('admin.model.create', compact('model_info','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveModel = new Mmodel();
        $saveModel->brand = $request->brand;
        $saveModel->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveModel->profile = $FileName;
        }

        $saveModel->save();



        return redirect()
            ->back()
            ->with('success', 'Model has been saved.');
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
        $model_info = Mmodel::where('id', $id)->first();
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.model.update', compact('model_info','brands'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveModel = Mmodel::find($id);
        $saveModel->brand = $request->brand;
        $saveModel->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveModel->profile = $FileName;
        }
        
        $saveModel->save();



        return redirect()
            ->back()
            ->with('success', 'Model has been saved.');
    }

    public function banner_status($id)
    {
        $data = Mmodel::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'Model ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Mmodel::findOrFail($id);
        $model->delete();
        return redirect()
            ->back()
            ->with('success', 'Model has been Deleted Successfully!!');
    }
}
