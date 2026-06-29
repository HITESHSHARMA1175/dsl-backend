<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Session;

use Illuminate\Support\Str;
use App\Models\InventoryCategory;

class InventoryCategoryInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = null)
    {
        $categories = InventoryCategory::where('parent_id', 0)->get();
        $parent_name = '';
        if ($id != null) {
            $parent_name = InventoryCategory::where('id', $id)
                ->pluck('category_name')
                ->first();
            $categories = InventoryCategory::where('parent_id', $id)->get();
        }
        $drop_categories = InventoryCategory::where('parent_id', 0)->get();
        if ($id != null) {
            return view('admin.category.inventorySubCategory', compact('categories', 'parent_name', 'drop_categories'));
        }
        return view('admin.category.inventoryCategory', compact('categories', 'parent_name', 'drop_categories'));
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
        InventoryCategory::updateOrCreate($matchId, [
            'parent_id' => $request->parent_category,
            'category_name' => $request->category_name,
        ]);
        session()->flash('success', 'category has been saved Succssfully !!');
        return redirect()->back();
    }

    public function editInventoryCategory(Request $request)
    {
        $data = InventoryCategory::find($request->id);
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
    public function deleteInventoryCategory(Request $request)
    {
        if (!empty($request->id)) {
            $data = InventoryCategory::find($request->id)->delete();
            return redirect()
                ->back()
                ->with('success', 'Item has been Deleted Successfully!');
        }
        return redirect()
            ->back()
            ->with('error', 'Something Worng try again.!');
    }
}
