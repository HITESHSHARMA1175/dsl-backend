<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Master;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use App\Models\InventoryAttributeValue;
use App\Models\InventoryImage;
use App\Models\InventoryCategoryAttribute;
use App\Models\InventoryCategory;
use App\Models\Property;
use App\Models\PrpertyRoom;
use App\Models\PropertyRoomInventory;

class InventoryControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::paginate(10);
        $inventoriesCount = Inventory::count();
        return view('admin.inventory.index', compact('inventories','inventoriesCount'));
    }

    public function property_inventory_list(string $id)
    {
        $inventories = Inventory::where('room_id', $id)->paginate(10);
        $inventoriesCount = Inventory::where('room_id', $id)->count();
        return view('admin.inventory.property_inventory', compact('inventories','inventoriesCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryBrands = Master::where('MasterHead', 'Inventory Brand')->first()->getMasterValues ?? [];
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
        $categories = InventoryCategory::where('parent_id', 0)->get();
        return view('admin.inventory.create', compact('inventoryTypes','inventoryBrands','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveInventory = new Inventory();
        $saveInventory->inventory_type = $request->inventory_type;
        $saveInventory->inventory_category = $request->category;
        $saveInventory->inventory_sub_category = $request->sub_category;
        $saveInventory->inventory_name = $request->inventory_name;
        $saveInventory->colour = $request->colour;
        $saveInventory->brand = $request->brand;
        $saveInventory->mrp = $request->mrp;
        $saveInventory->rental_price = $request->rental_price;
        $saveInventory->warranty_start_date = $request->warranty_start_date;
        $saveInventory->warranty_end_date = $request->warranty_end_date;
        $saveInventory->penalty = $request->penalty;
        $saveInventory->sh_barcode = $request->sh_barcode;

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/inventory'), $FileName);
            $saveInventory->profile = $FileName;
        }

        $saveInventory->save();


        $inventory_category_attributes = $request->attributes_value;
        if(!empty($inventory_category_attributes)){
        foreach ($inventory_category_attributes as $attribute_key => $category_attributes) {
            $category_attributes = (object) $category_attributes;
            foreach ($category_attributes as $key => $value) {
                $saveInventoryCateAttribute = new InventoryCategoryAttribute();
                $saveInventoryCateAttribute->inventory_id = $saveInventory->id;
                $saveInventoryCateAttribute->attribute_id = $attribute_key;
                $saveInventoryCateAttribute->attribute_value_id = $value;

                $saveInventoryCateAttribute->save();
            }
        }
        }

        $images = $request->photos;
        if(!empty($images)){
        // dd($images);
        $FileName = '';
        foreach ($images as $image_key => $image) {
            $file = $image;
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/inventory'), $FileName);

            $saveInventoryImage = new InventoryImage();
            $saveInventoryImage->inventory_id = $saveInventory->id;
            $saveInventoryImage->image = $FileName;
            $saveInventoryImage->save();
        }
        }

        return redirect()
            ->back()
            ->with('success', 'Inventory has been saved.');
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
        $inventory_info = Inventory::where('id', $id)->first();

        $inventoryCategory = $inventory_info->getInventoryCategory;
        $inventorySubCategory = $inventory_info->getInventorySubCategory;
        // dd($inventoryCategory);
        $inventoryMappedAttribute = $inventorySubCategory->getMappedInventoryAttribute;
        // dd($inventoryMappedAttribute);
        $inventoryAttribute = $inventory_info->getInventoryAttributes;
        // dd($inventoryAttribute);
        $inventoryimages = $inventory_info->getInventoryImages;
        // dd($inventoryChecklist);
        $inventoryBrands = Master::where('MasterHead', 'Inventory Brand')->first()->getMasterValues ?? [];
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
       
        
        $categories = InventoryCategory::where('parent_id', 0)->get();

        return view('admin.inventory.update', compact('inventory_info','inventoryTypes','inventoryBrands','categories',
        'inventoryimages', 'inventoryMappedAttribute', 'inventoryAttribute'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventory_id = $id;
        $saveInventory = Inventory::find($id);
        $saveInventory->inventory_type = $request->inventory_type;
        $saveInventory->inventory_category = $request->category;
        $saveInventory->inventory_sub_category = $request->sub_category;
        $saveInventory->inventory_name = $request->inventory_name;
        $saveInventory->colour = $request->colour;
        $saveInventory->brand = $request->brand;
        $saveInventory->mrp = $request->mrp;
        $saveInventory->rental_price = $request->rental_price;
        $saveInventory->warranty_start_date = $request->warranty_start_date;
        $saveInventory->warranty_end_date = $request->warranty_end_date;
        $saveInventory->penalty = $request->penalty;
        $saveInventory->sh_barcode = $request->sh_barcode;

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/inventory'), $FileName);
            $saveInventory->profile = $FileName;
        }

        $saveInventory->save();


        $inventory_category_attributes = $request->attributes_value;
        $saveInventory->getInventoryAttributes()->delete();
        if($inventory_category_attributes!=''){
        foreach ($inventory_category_attributes as $attribute_key => $category_attributes) {
            $category_attributes = (object) $category_attributes;
            foreach ($category_attributes as $key => $value) {
                $saveInventoryCateAttribute = new InventoryCategoryAttribute();
                $saveInventoryCateAttribute->inventory_id = $inventory_id;
                $saveInventoryCateAttribute->attribute_id = $attribute_key;
                $saveInventoryCateAttribute->attribute_value_id = $value;

                $saveInventoryCateAttribute->save();
            }
        }
        }

        $images = $request->photos;
        // dd($images);

        $oldImages = $request->old;
        if (!empty($oldImages)) {
            $saveInventory
                ->getInventoryImages()
                ->whereNotIn('id', $oldImages)
                ->delete();
        }

        $FileName = '';
        if (!empty($images)) {
            foreach ($images as $image_key => $image) {
                $file = $image;
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/inventory'), $FileName);

                $saveInventoryImage = new InventoryImage();
                $saveInventoryImage->inventory_id = $inventory_id;
                $saveInventoryImage->image = $FileName;
                $saveInventoryImage->save();
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Inventory has been saved.');
    }

    public function inventory_status($id)
    {
        $data = Inventory::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('inventory.index'))->with('success', 'Inventory ' . $msg . ' Successfully!');
        }
        return redirect(route('inventory.index'))->with('error', 'Something Worng try again.!');
    }

    public function mapInventoryPropertyRoom(Request $request)
    {
        
        //dd($request->all());

        $inventory_ids = $request->inventory_ids;
        if($inventory_ids!=''){
        foreach ($inventory_ids as $inventory_key => $inventory_id) {
            

            $isadded = PropertyRoomInventory::where('property_id', $request->inv_property_id)->where('room_id', $request->inv_room_id)->where('inventory_id', $inventory_id)->orderBy('id', 'DESC')->pluck('id')->first();
            if($isadded<1){
                $savePropertyRoomInventory = new PropertyRoomInventory();
                $savePropertyRoomInventory->property_id = $request->inv_property_id;
                $savePropertyRoomInventory->room_id = $request->inv_room_id;
                $savePropertyRoomInventory->inventory_id = $inventory_id;
    
                $savePropertyRoomInventory->save();

                $saveInventory = Inventory::find($inventory_id);
                $saveInventory->is_available = '0';
                $saveInventory->property_id = $request->inv_property_id;
                $saveInventory->room_id = $request->inv_room_id;
                $saveInventory->map_date = date("Y-m-d H:i:s");
                $saveInventory->save();

            }
            
            
        }
        }

      
            return redirect()->back()->with('success', 'Inventory added Successfully!');
            //return redirect(route('inventory.index'))->with('success', 'Inventory ' . $msg . ' Successfully!');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
