<?php

namespace App\Http\Controllers\Admin\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\Mmodel;
use App\Models\Variant;
use App\Models\Colour;


class MobileColourInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Colour::query();
        
        if ($request->search_text != '') {
            $query->where('name', 'LIKE', '%'.$request->search_text.'%');
        }
        if ($request->brand != '') {
            $query->where('brand', $request->brand);
        }
        if ($request->model != '') {
            $query->where('model', $request->model);
        }
        if ($request->variant != '') {
            $query->where('variant', $request->variant);
        }
        
        $colours = $query->paginate(10);
        $coloursCount = $query->count();
        
        $brands=Brand::where('id','!=','')->get();
        $models=Mmodel::where('id','!=','')->where('brand',$request->brand)->get();
        $variants=Variant::where('id','!=','')->where('model',$request->model)->get();
        
        return view('admin.colour.index', compact('colours','coloursCount','brands','models','variants','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colour_info='';
        $brands=Brand::where('id','!=','')->get();
        return view('admin.colour.create', compact('colour_info','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveColour = new Colour();
        $saveColour->brand = $request->brand;
        $saveColour->model = $request->model;
        $saveColour->variant = $request->variant;
        $saveColour->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveColour->profile = $FileName;
        }

        $saveColour->save();



        return redirect()
            ->back()
            ->with('success', 'Colour has been saved.');
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
        $colour_info = Colour::where('id', $id)->first();
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.colour.update', compact('colour_info','brands'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveColour = Colour::find($id);
        $saveColour->brand = $request->brand;
        $saveColour->model = $request->model;
        $saveColour->variant = $request->variant;
        $saveColour->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveColour->profile = $FileName;
        }
        
        $saveColour->save();



        return redirect()
            ->back()
            ->with('success', 'Colour has been saved.');
    }

    public function banner_status($id)
    {
        $data = Colour::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'Colour ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $colour = Colour::findOrFail($id);
        $colour->delete();
        return redirect()
            ->back()
            ->with('success', 'Colour has been Deleted Successfully!!');
    }
}
