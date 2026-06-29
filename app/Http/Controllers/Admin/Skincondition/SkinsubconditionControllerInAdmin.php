<?php

namespace App\Http\Controllers\Admin\Skincondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\PropertyCategoryMain;
use App\Models\PropertyCategory;


class SkinsubconditionControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $query = PropertyCategory::query();
        $query->where('is_condition', '1');
        //$query->where('parent_id','!=', '0');
        $query->whereNotNull('parent_ids');
        
        if ($request->parent_id != '') {
            $query->where('parent_id', $request->parent_id);
        }
        
        if ($request->searchtext != '') {
            $query->where('category_name', 'like', '%'.$request->searchtext.'%');
        }

        
        $skinsubconditionsCount = $query->count();
        $skinsubconditions = $query->paginate(10);
        
        $parentcategories = PropertyCategory::where('parent_id', '0')->get();
        
        return view('admin.skinsubcondition.index', compact('skinsubconditions','skinsubconditionsCount','parentcategories','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maincategories = PropertyCategoryMain::where('status', '1')->get();
        $parentcategories = PropertyCategory::where('is_condition', '1')->where('parent_ids', null)->get();
        $parentcategories2 = PropertyCategory::where('is_condition', '0')->where('parent_ids', null)->get();
        $skinsubcondition_info='';
        return view('admin.skinsubcondition.create', compact('skinsubcondition_info','maincategories','parentcategories','parentcategories2'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $checkcategoriesCount = PropertyCategory::where('category_name', $request->category_name)->where('is_condition', '1')->whereNotNull('parent_ids')->count();
        if($checkcategoriesCount>0){
            return redirect()
            ->back()
            ->with('error', 'Duplicate entry.');
        }
        
        $savePropertyCategory = new PropertyCategory();
        $savePropertyCategory->is_condition = '1';
        $savePropertyCategory->parent_id = 2;
        $savePropertyCategory->parent_ids = json_encode($request->parent_id); // Convert array to JSON
        $savePropertyCategory->parent_ids2 = json_encode($request->parent_id2); // Convert array to JSON
        $savePropertyCategory->category_name = $request->category_name;
        
        $slug = Str::slug($request->category_name, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,0);
        $savePropertyCategory->category_slug = ''; 
        
       
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/skinsubcondition'), $FileName);
            $savePropertyCategory->icon = $FileName;
        }
        
        //Chinese
        $savePropertyCategory->category_name_cn = $request->category_name_cn;
        if ($request->hasFile('icon_cn')) {
            $file = $request->file('icon_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/skinsubcondition'), $FileName);
            $savePropertyCategory->icon_cn = $FileName;
        }
       
        
        //Arabic
        $savePropertyCategory->category_name_ar = $request->category_name_ar;
        if ($request->hasFile('icon_ar')) {
            $file = $request->file('icon_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/skinsubcondition'), $FileName);
            $savePropertyCategory->icon_ar = $FileName;
        }
        
       
        $savePropertyCategory->save();



        return redirect()
            ->back()
            ->with('success', 'Service sub category has been saved.');
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
        $parentcategories = PropertyCategory::where('is_condition', '1')->where('parent_ids', null)->get();
        $parentcategories2 = PropertyCategory::where('is_condition', '0')->where('parent_ids', null)->get();
        $maincategories = PropertyCategoryMain::where('status', '1')->get();
        $skinsubcondition_info = PropertyCategory::where('id', $id)->first();

        return view('admin.skinsubcondition.update', compact('skinsubcondition_info','maincategories','parentcategories','parentcategories2'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $checkcategoriesCount = PropertyCategory::where('category_name', $request->category_name)->where('is_condition','1')->where('id','!=', $id)->whereNotNull('parent_ids')->count();
        if($checkcategoriesCount>0){
            return redirect()
            ->back()
            ->with('error', 'Duplicate entry.');
        }
        
        $skinsubcondition_id = $id;
        $savePropertyCategory = PropertyCategory::find($id);
        $savePropertyCategory->is_condition = '1';
        $savePropertyCategory->parent_id = 2;
        $savePropertyCategory->parent_ids = json_encode($request->parent_id); // Convert array to JSON
        $savePropertyCategory->parent_ids2 = json_encode($request->parent_id2); // Convert array to JSON
        $savePropertyCategory->category_name = $request->category_name;
        
        $slug = Str::slug($request->category_name, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,$id);
        $savePropertyCategory->category_slug = ''; 
        
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/skinsubcondition'), $FileName);
            $savePropertyCategory->icon = $FileName;
        }
        
        //Chinese
        $savePropertyCategory->category_name_cn = $request->category_name_cn;
        if ($request->hasFile('icon_cn')) {
            $file = $request->file('icon_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/skinsubcondition'), $FileName);
            $savePropertyCategory->icon_cn = $FileName;
        }
       
        
        //Arabic
        $savePropertyCategory->category_name_ar = $request->category_name_ar;
        if ($request->hasFile('icon_ar')) {
            $file = $request->file('icon_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/skinsubcondition'), $FileName);
            $savePropertyCategory->icon_ar = $FileName;
        }
        
        $savePropertyCategory->save();



        return redirect()
            ->back()
            ->with('success', 'Service category has been saved.');
    }

    public function skinsubcondition_status($id)
    {
        $data = PropertyCategory::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('skinsubcondition.index'))->with('success', 'Service category ' . $msg . ' Successfully!');
        }
        return redirect(route('skinsubcondition.index'))->with('error', 'Something Worng try again.!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $property = PropertyCategory::findOrFail($id);
        $property->delete();
        return redirect()
            ->back()
            ->with('success', 'Service category has been Deleted Successfully!!');
        
    }
    
    public function skinsubcondition_sorting(Request $request)
    {
        $sortingData = $request->input('sorting'); // Expect an array with category IDs and sorting values
    
        // Loop through the input data and update sorting order for each category
        foreach ($sortingData as $id => $order) {
            PropertyCategory::where('id', $id)->update(['sorting_order' => $order]);
        }
    
        return redirect()->back()->with('success', 'Sorting order updated successfully.');
    }
    
    
    private function generateUniqueSlug($slug,$id)
    {
        $originalSlug = $slug;
        $counter = 1;
    
        // Check for existing slug in the database
        while (PropertyCategory::where('category_slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
}
