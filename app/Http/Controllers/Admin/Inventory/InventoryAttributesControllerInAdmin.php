<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryAttribute;

class InventoryAttributesControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = InventoryAttribute::orderByDesc('id')->get();
        return view('admin.inventoryattributes.attributes', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new InventoryAttribute();
        $data->attribute_name = $request->attribute_name;
        // $data->alias = $request->alias;
        $data->attribute_type = $request->attribute_type;
        $data->description = $request->description;
        // $data->status = $request->status;
        $data->save();
        return redirect(route('inventory-attribute.index'))->with('success', 'Attribute Created successfully!');
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
        $item = InventoryAttribute::find($id);
        $attributes = InventoryAttribute::orderByDesc('id')->get();
        return view('admin.inventoryattributes.attributes', compact('attributes', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = InventoryAttribute::find($id);
        $data->attribute_name = $request->attribute_name;
        // $data->alias = $request->alias;
        $data->attribute_type = $request->attribute_type;
        $data->description = $request->description;
        // $data->status = $request->status;
        $data->save();
        return redirect(route('inventory-attribute.index'))->with('success', 'Attribute Created successfully!');
    }

    public function deleteInventoryAttribute(Request $request)
    {
        if (!empty($request->id)) {
            $data = InventoryAttribute::find($request->id)->delete();
            return redirect()
                ->back()
                ->with('success', 'Item has been Deleted Successfully!');
        }
        return redirect()
            ->back()
            ->with('error', 'Something Worng try again.!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
