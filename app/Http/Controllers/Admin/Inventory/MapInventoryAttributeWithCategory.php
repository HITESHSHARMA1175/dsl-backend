<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryAttribute;
use App\Models\InventoryAttributeValue;
use App\Models\MapInventoryAttribute;
use App\Models\InventoryCategory;

class MapInventoryAttributeWithCategory extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $attibutes = InventoryAttribute::get();
        $attibutesValues = InventoryAttributeValue::get();
        $mapAttributes = MapInventoryAttribute::get();
        $inventory_categories = InventoryCategory::where('parent_id', 0)->get();
        return view('admin.inventoryattributes.mapAttributeWithCategory', compact('mapAttributes', 'inventory_categories', 'attibutes', 'attibutesValues'));
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
        //return $request;
        if (request()->isMethod('get')) {
            return redirect()->route('map-inventory-category.index');
        }
        $inventory_category_id = $request->inventory_category;
        $inventory_sub_category_id = $request->inventory_sub_category;
        $attributes = $request->attribute_name;
        foreach ($attributes as $key => $value) {
            $save = new MapInventoryAttribute();
            if (!empty($request->Mapcategoryid)) {
                $save = MapInventoryAttribute::where('id', $request->Mapcategoryid)->first();
            }
            $save->inventory_category_id = $inventory_category_id;
            $save->inventory_sub_category_id = $inventory_sub_category_id;
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

    public function deleteMapInventoryCategory(Request $request)
    {
        if (!empty($request->id)) {
            $data = MapInventoryAttribute::find($request->id)->delete();
            return redirect(route('map-inventory-category.index'))->with('success', 'Item has been Deleted Successfully!');
        }
        return redirect(route('map-inventory-category.index'))->with('error', 'Something worng try again.!');
    }
}
