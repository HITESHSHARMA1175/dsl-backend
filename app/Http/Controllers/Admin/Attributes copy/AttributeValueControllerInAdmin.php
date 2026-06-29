<?php

namespace App\Http\Controllers\Admin\Attributes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeValueControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributesValue = AttributeValue::orderByDesc('id')->get();
        $attributes = Attribute::orderByDesc('id')->get();
        return view('admin.attributes.attributesValue', compact('attributes', 'attributesValue'));
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
            $data = new AttributeValue();
            $data->attribute_id = $request->attribute_id;
            $data->attribute_value = $val;
            $data->status = $request->status;
            $data->save();
        }
        return redirect(route('attribute-values.index'))->with('success', 'Attribute Value Created successfully!');
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
        $attributesValue = AttributeValue::orderByDesc('id')->get();
        $attributes = Attribute::orderByDesc('id')->get();
        $item = AttributeValue::find($id);
        return view('admin.attributes.attributesValue', compact('attributesValue', 'attributes', 'item'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $attributesValue = AttributeValue::orderByDesc('id')->get();
        // $attributes = Attribute::orderByDesc('id')->get();
        // $item = AttributeValue::find($id);
        // return view('admin.attributes.attributesValue', compact('attributesValue', 'attributes', 'item'));
    }

    public function deletePropertyAttributeValue(Request $request)
    {
        if (!empty($request->id)) {
            $data = AttributeValue::find($request->id)->delete();
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
