<?php

namespace App\Http\Controllers\Admin\Servicecat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\PropertyCategoryMain;


class ServicecatMainControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $query = PropertyCategoryMain::query();
        
        if ($request->searchtext != '') {
            $query->where('category_name', 'like', '%'.$request->searchtext.'%');
        }

        
        $servicecatmainsCount = $query->count();
        $servicecatmains = $query->paginate(10);
        
        return view('admin.servicecatmain.index', compact('servicecatmains','servicecatmainsCount','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicecatmain_info='';
        return view('admin.servicecatmain.create', compact('servicecatmain_info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $savePropertyCategoryMain = new PropertyCategoryMain();
        $savePropertyCategoryMain->category_name = $request->category_name;
        
        $slug = Str::slug($request->category_name, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,0);
        $savePropertyCategoryMain->category_slug = $uniqueSlug; 
        
        $savePropertyCategoryMain->meta_title = $request->meta_title;
        $savePropertyCategoryMain->meta_keywords = $request->meta_keywords;
        $savePropertyCategoryMain->meta_description = $request->meta_description;
        
        $savePropertyCategoryMain->description = $request->description;
        
        
       
        $savePropertyCategoryMain->save();



        return redirect()
            ->back()
            ->with('success', 'Service category has been saved.');
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
        $servicecatmain_info = PropertyCategoryMain::where('id', $id)->first();

        return view('admin.servicecatmain.update', compact('servicecatmain_info'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $servicecatmain_id = $id;
        $savePropertyCategoryMain = PropertyCategoryMain::find($id);
        $savePropertyCategoryMain->category_name = $request->category_name;
        
        $slug = Str::slug($request->category_name, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,$id);
        $savePropertyCategoryMain->category_slug = $uniqueSlug; 
        
        $savePropertyCategoryMain->meta_title = $request->meta_title;
        $savePropertyCategoryMain->meta_keywords = $request->meta_keywords;
        $savePropertyCategoryMain->meta_description = $request->meta_description;
        
        $savePropertyCategoryMain->description = $request->description;
        
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecatmain'), $FileName);
            $savePropertyCategoryMain->icon = $FileName;
        }
        
        $savePropertyCategoryMain->description1 = $request->description1;
        if ($request->hasFile('icon1')) {
            $file = $request->file('icon1');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecatmain'), $FileName);
            $savePropertyCategoryMain->icon1 = $FileName;
        }
        
        $savePropertyCategoryMain->description2 = $request->description2;
        if ($request->hasFile('icon2')) {
            $file = $request->file('icon2');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecatmain'), $FileName);
            $savePropertyCategoryMain->icon2 = $FileName;
        }
        
        $savePropertyCategoryMain->description3 = $request->description3;
        if ($request->hasFile('icon3')) {
            $file = $request->file('icon3');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecatmain'), $FileName);
            $savePropertyCategoryMain->icon3 = $FileName;
        }
        
        $savePropertyCategoryMain->description4 = $request->description4;
        if ($request->hasFile('icon4')) {
            $file = $request->file('icon4');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecatmain'), $FileName);
            $savePropertyCategoryMain->icon4 = $FileName;
        }
        
        $savePropertyCategoryMain->save();



        return redirect()
            ->back()
            ->with('success', 'Service category has been saved.');
    }

    public function servicecatmain_status($id)
    {
        $data = PropertyCategoryMain::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('servicecatmain.index'))->with('success', 'Service category ' . $msg . ' Successfully!');
        }
        return redirect(route('servicecatmain.index'))->with('error', 'Something Worng try again.!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $property = PropertyCategoryMain::findOrFail($id);
        $property->delete();
        return redirect()
            ->back()
            ->with('success', 'Service category has been Deleted Successfully!!');
        
    }
    
    public function servicecatmain_sorting(Request $request)
    {
        $sortingData = $request->input('sorting'); // Expect an array with category IDs and sorting values
    
        // Loop through the input data and update sorting order for each category
        foreach ($sortingData as $id => $order) {
            PropertyCategoryMain::where('id', $id)->update(['sorting_order' => $order]);
        }
    
        return redirect()->back()->with('success', 'Sorting order updated successfully.');
    }
    
    
    private function generateUniqueSlug($slug,$id)
    {
        $originalSlug = $slug;
        $counter = 1;
    
        // Check for existing slug in the database
        while (PropertyCategoryMain::where('category_slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
}
