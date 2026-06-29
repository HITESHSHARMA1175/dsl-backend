<?php

namespace App\Http\Controllers\Admin\Servicecat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\PropertyCategoryMain;
use App\Models\PropertyCategory;


class ServicecatControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $query = PropertyCategory::query();
        $query->where('is_condition', '0');
        $query->where('parent_ids', null);
        if ($request->searchtext != '') {
            $query->where('category_name', 'like', '%'.$request->searchtext.'%');
        }

        
        $servicecatsCount = $query->count();
        $servicecats = $query->paginate(10);
        
        return view('admin.servicecat.index', compact('servicecats','servicecatsCount','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maincategories = PropertyCategoryMain::where('status', '1')->get();
        $servicecat_info='';
        return view('admin.servicecat.create', compact('servicecat_info','maincategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $checkcategoriesCount = PropertyCategory::where('category_name', $request->category_name)->where('is_condition','0')->where('parent_ids', null)->count();
        if($checkcategoriesCount>0){
            return redirect()
            ->back()
            ->with('error', 'Duplicate entry.');
        }
        
        $savePropertyCategory = new PropertyCategory();
        $savePropertyCategory->main_category = $request->main_category;
        $savePropertyCategory->category_name = $request->category_name;
        
        $slug = Str::slug($request->category_name, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,0);
        $savePropertyCategory->category_slug = $uniqueSlug; 
        
        $savePropertyCategory->meta_title = $request->meta_title;
        $savePropertyCategory->meta_keywords = $request->meta_keywords;
        $savePropertyCategory->meta_description = $request->meta_description;
        $savePropertyCategory->meta_scripts = $request->meta_scripts;
        
        $savePropertyCategory->description = $request->description;
        $savePropertyCategory->description3 = $request->description3;
        $savePropertyCategory->youtube_link = $request->youtube_link;
        
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon = $FileName;
        }
        
        if ($request->hasFile('icon_large')) {
            $file = $request->file('icon_large');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_large = $FileName;
        }
        
        if ($request->hasFile('image1')) {
            $file = $request->file('image1');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->image1 = $FileName;
        }
        
        if ($request->hasFile('image2')) {
            $file = $request->file('image2');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->image2 = $FileName;
        }
        
        if ($request->hasFile('image3')) {
            $file = $request->file('image3');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->image3 = $FileName;
        }
        
        if ($request->hasFile('image4')) {
            $file = $request->file('image4');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->image4 = $FileName;
        }
      
        
        if ($request->hasFile('icon2')) {
            $file = $request->file('icon2');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon2 = $FileName;
        }
        
        //Chinese
        $savePropertyCategory->category_name_cn = $request->category_name_cn;
        $savePropertyCategory->description_cn = $request->description_cn;
        $savePropertyCategory->description3_cn = $request->description3_cn;
        $savePropertyCategory->youtube_link_cn = $request->youtube_link_cn;
        
        if ($request->hasFile('icon_cn')) {
            $file = $request->file('icon_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_cn = $FileName;
        }
        
        if ($request->hasFile('icon_large_cn')) {
            $file = $request->file('icon_large_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_large_cn = $FileName;
        }
        
        if ($request->hasFile('icon2_cn')) {
            $file = $request->file('icon2_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon2_cn = $FileName;
        }
        
        //Arabic
        $savePropertyCategory->category_name_ar = $request->category_name_ar;
        $savePropertyCategory->description_ar = $request->description_ar;
        $savePropertyCategory->description3_ar = $request->description3_ar;
        $savePropertyCategory->youtube_link_ar = $request->youtube_link_ar;
        
        if ($request->hasFile('icon_ar')) {
            $file = $request->file('icon_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_ar = $FileName;
        }
        
        if ($request->hasFile('icon_large_ar')) {
            $file = $request->file('icon_large_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_large_ar = $FileName;
        }
        
        if ($request->hasFile('icon2_ar')) {
            $file = $request->file('icon2_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon2_ar = $FileName;
        }
        
       
        $savePropertyCategory->save();



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
        $maincategories = PropertyCategoryMain::where('status', '1')->get();
        $servicecat_info = PropertyCategory::where('id', $id)->first();

        return view('admin.servicecat.update', compact('servicecat_info','maincategories'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $checkcategoriesCount = PropertyCategory::where('category_name', $request->category_name)->where('is_condition','0')->where('id','!=', $id)->where('parent_ids', null)->count();
        if($checkcategoriesCount>0){
            return redirect()
            ->back()
            ->with('error', 'Duplicate entry.');
        }
        
        $servicecat_id = $id;
        $savePropertyCategory = PropertyCategory::find($id);
        $savePropertyCategory->main_category = $request->main_category;
        $savePropertyCategory->category_name = $request->category_name;
        
        $slug = Str::slug($request->category_name, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,$id);
        $savePropertyCategory->category_slug = $uniqueSlug; 
        
        $savePropertyCategory->meta_title = $request->meta_title;
        $savePropertyCategory->meta_keywords = $request->meta_keywords;
        $savePropertyCategory->meta_description = $request->meta_description;
        $savePropertyCategory->meta_scripts = $request->meta_scripts;
        
        $savePropertyCategory->description = $request->description;
        $savePropertyCategory->description3 = $request->description3;
        $savePropertyCategory->youtube_link = $request->youtube_link;
        
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon = $FileName;
        }
        
        if ($request->hasFile('icon_large')) {
            $file = $request->file('icon_large');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_large = $FileName;
        }
        
        if ($request->hasFile('image1')) {
            $file = $request->file('image1');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->image1 = $FileName;
        }
        
        if ($request->hasFile('image2')) {
            $file = $request->file('image2');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->image2 = $FileName;
        }
        
        if ($request->hasFile('image3')) {
            $file = $request->file('image3');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->image3 = $FileName;
        }
        
        if ($request->hasFile('image4')) {
            $file = $request->file('image4');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->image4 = $FileName;
        }
      
        
        if ($request->hasFile('icon2')) {
            $file = $request->file('icon2');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon2 = $FileName;
        }
        
        //Chinese
        $savePropertyCategory->category_name_cn = $request->category_name_cn;
        $savePropertyCategory->description_cn = $request->description_cn;
        $savePropertyCategory->description3_cn = $request->description3_cn;
        $savePropertyCategory->youtube_link_cn = $request->youtube_link_cn;
        
        if ($request->hasFile('icon_cn')) {
            $file = $request->file('icon_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_cn = $FileName;
        }
        
        if ($request->hasFile('icon_large_cn')) {
            $file = $request->file('icon_large_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_large_cn = $FileName;
        }
        
        if ($request->hasFile('icon2_cn')) {
            $file = $request->file('icon2_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon2_cn = $FileName;
        }
        
        //Arabic
        $savePropertyCategory->category_name_ar = $request->category_name_ar;
        $savePropertyCategory->description_ar = $request->description_ar;
        $savePropertyCategory->description3_ar = $request->description3_ar;
        $savePropertyCategory->youtube_link_ar = $request->youtube_link_ar;
        
        if ($request->hasFile('icon_ar')) {
            $file = $request->file('icon_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_ar = $FileName;
        }
        
        if ($request->hasFile('icon_large_ar')) {
            $file = $request->file('icon_large_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon_large_ar = $FileName;
        }
        
        if ($request->hasFile('icon2_ar')) {
            $file = $request->file('icon2_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/servicecat'), $FileName);
            $savePropertyCategory->icon2_ar = $FileName;
        }
        
        $savePropertyCategory->save();



        return redirect()
            ->back()
            ->with('success', 'Service category has been saved.');
    }

    public function servicecat_status($id)
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
            return redirect(route('servicecat.index'))->with('success', 'Service category ' . $msg . ' Successfully!');
        }
        return redirect(route('servicecat.index'))->with('error', 'Something Worng try again.!');
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
    
    public function servicecat_sorting(Request $request)
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
        while (PropertyCategory::where('category_slug', $slug)->where('id', '!=', $id)->where('parent_ids', null)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
}
