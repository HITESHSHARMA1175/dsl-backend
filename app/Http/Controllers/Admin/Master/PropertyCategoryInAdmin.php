<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Session;

use Illuminate\Support\Str;
use App\Models\PropertyCategory;

class PropertyCategoryInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = null)
    {
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $parent_name = '';
        if ($id != null) {
            $parent_name = PropertyCategory::where('id', $id)
                ->pluck('category_name')
                ->first();
            $categories = PropertyCategory::where('parent_id', $id)->get();
        }
        $drop_categories = PropertyCategory::where('parent_id', 0)->get();
        if ($id != null) {
            return view('admin.category.propertySubCategory', compact('categories', 'parent_name', 'drop_categories'));
        }
        return view('admin.category.propertyCategory', compact('categories', 'parent_name', 'drop_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $matchId = ['id' => $request->Category_id];
        PropertyCategory::updateOrCreate($matchId, [
            'parent_id' => $request->parent_category,
            'category_name' => $request->category_name,
        ]);
        session()->flash('success', 'category has been saved Succssfully !!');
        return redirect()->back();
    }

    public function editPropertyCategory(Request $request)
    {
        $data = PropertyCategory::find($request->id);
        return json_encode($data, true);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletePropertyCategory(Request $request)
    {
        if (!empty($request->id)) {
            $data = PropertyCategory::find($request->id)->delete();
            return redirect()
                ->back()
                ->with('success', 'Item has been Deleted Successfully!');
        }
        return redirect()
            ->back()
            ->with('error', 'Something Worng try again.!');
    }
}
