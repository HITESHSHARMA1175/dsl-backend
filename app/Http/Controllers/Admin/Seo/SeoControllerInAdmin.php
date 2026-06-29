<?php

namespace App\Http\Controllers\Admin\Seo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Seo;
use App\Models\Master;


class SeoControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        
        
        $seos = Seo::paginate(30);
        $seosCount = Seo::count();
        return view('admin.seo.index', compact('seos','seosCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $seo_info='';
        return view('admin.seo.create', compact('seo_info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveSeo = new Seo();
        $saveSeo->pageurl = $request->pageurl;
        $saveSeo->title = $request->title;
        $saveSeo->meta_title = $request->meta_title;
        $saveSeo->meta_keywords = $request->meta_keywords;
        $saveSeo->meta_description = $request->meta_description;
        $saveSeo->meta_scripts = $request->meta_scripts;
        
        $saveSeo->save();



        return redirect()
            ->back()
            ->with('success', 'Seo has been saved.');
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
        $seo_category = Master::where('MasterHead', 'Seo Category')->first()->getMasterValues ?? [];
        $seo_info = Seo::where('id', $id)->first();

        return view('admin.seo.update', compact('seo_info','seo_category'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $seo_id = $id;
        $saveSeo = Seo::find($id);
        $saveSeo->pageurl = $request->pageurl;
        $saveSeo->title = $request->title;
        $saveSeo->meta_title = $request->meta_title;
        $saveSeo->meta_keywords = $request->meta_keywords;
        $saveSeo->meta_description = $request->meta_description;
        $saveSeo->meta_scripts = $request->meta_scripts;
        
        
        $saveSeo->save();



        return redirect()
            ->back()
            ->with('success', 'Seo has been saved.');
    }

    public function seo_status($id)
    {
        $data = Seo::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('seo.index'))->with('success', 'Seo ' . $msg . ' Successfully!');
        }
        return redirect(route('seo.index'))->with('error', 'Something Worng try again.!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $property = Seo::findOrFail($id);
        $property->delete();
        return redirect()
            ->back()
            ->with('success', 'Seo has been Deleted Successfully!!');
        
    }
    
    
    private function generateUniqueSlug($slug,$id)
    {
        $originalSlug = $slug;
        $counter = 1;
    
        // Check for existing slug in the database
        while (Seo::where('seo_slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
    
}
