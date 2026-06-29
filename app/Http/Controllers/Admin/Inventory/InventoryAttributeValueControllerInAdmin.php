<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryAttribute;
use App\Models\InventoryAttributeValue;

class InventoryAttributeValueControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        $attributesValue = InventoryAttributeValue::orderByDesc('id')->get();
        $attributes = InventoryAttribute::orderByDesc('id')->get();
        return view('admin.inventoryattributes.attributesValue', compact('attributes', 'attributesValue'));
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
        $filter_value = explode(',', $request->attribute_value);
        foreach ($filter_value as $key => $val) {
            $data = new InventoryAttributeValue();
            $data->attribute_id = $request->attribute_id;
            $data->attribute_value = $val;
            $data->status = $request->status;
            $data->save();
        }
        return redirect(route('inventory-attribute-values.index'))->with('success', 'Attribute Value Created successfully!');
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
        $attributesValue = InventoryAttributeValue::orderByDesc('id')->get();
        $attributes = InventoryAttribute::orderByDesc('id')->get();
        $item = InventoryAttributeValue::find($id);
        return view('admin.inventoryattributes.attributesValue', compact('attributesValue', 'attributes', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $data = InventoryAttributeValue::find($id);
        $data->attribute_id = $request->attribute_id;
        $data->attribute_value = $request->attribute_value;
        $data->status = $request->status;
        
        $data->save();
        return redirect(route('inventory-attribute-values.index'))->with('success', 'Attribute Created successfully!');

    }

    public function deleteInventoryAttributeValue(Request $request)
    {
        if (!empty($request->id)) {
            $data = InventoryAttributeValue::find($request->id)->delete();
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
