<?php

namespace App\Http\Controllers\Admin\Attributes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\MapAttribute;
use App\Models\PropertyCategory;

class MapAttributeWithCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attibutes = Attribute::get();
        $attibutesValues = AttributeValue::get();
        $mapAttributes = MapAttribute::get();
        $property_categories = PropertyCategory::where('parent_id', 0)->get();
        return view('admin.attributes.mapAttributeWithCategory', compact('mapAttributes', 'property_categories', 'attibutes', 'attibutesValues'));
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
        if (request()->isMethod('get')) {
            return redirect()->route('map-property-category.index');
        }
        $property_category_id = $request->property_category;
        $property_sub_category_id = $request->property_sub_category;
        $attributes = $request->attribute_name;
        foreach ($attributes as $key => $value) {
            $save = new MapAttribute();
            if (!empty($request->Mapcategoryid)) {
                $save = MapAttribute::where('id', $request->Mapcategoryid)->first();
            }
            $save->property_category_id = $property_category_id;
            $save->property_sub_category_id = $property_sub_category_id;
            $save->attribute_id = $value;
            $save->save();
        }
        return redirect()
            ->back()
            ->with('success', 'Mapped Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function deleteMapPropertyCategory(Request $request)
    {
        if (!empty($request->id)) {
            $data = MapAttribute::find($request->id)->delete();
            return redirect(route('map-property-category.index'))->with('success', 'Item has been Deleted Successfully!');
        }
        return redirect(route('map-property-category.index'))->with('error', 'Something worng try again.!');
    }
}
