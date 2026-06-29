<?php

namespace App\Http\Controllers\Admin\MoveDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Society;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Master;
use App\Models\MoveDetail;
use App\Models\MoveDetailRent;
use App\Models\InventoryCategory;

class MoveDetailsControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movedetailsCount = MoveDetail::count();
        $movedetails = MoveDetail::paginate(10);
        return view('admin.movedetails.index', compact('movedetails','movedetailsCount'));
    }

    public function property_move_list(string $id)
    {
        $movedetails = MoveDetail::where('owner_id', $id)->paginate(20);
        $movedetailsCount = MoveDetail::where('owner_id', $id)->count();
        return view('admin.movedetails.index', compact('movedetails','movedetailsCount'));
    }

    public function tenant_move_list(string $id)
    {
        $movedetails = MoveDetail::where('tenant_id', $id)->paginate(20);
        $movedetailsCount = MoveDetail::where('tenant_id', $id)->count();
        return view('admin.movedetails.index', compact('movedetails','movedetailsCount'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $countries = Country::get();
        $properties = Property::get();
        $tenants = Tenant::get();
        $societies = Society::get();
        $inventoryCategories = InventoryCategory::where('parent_id', 0)->get();
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
        return view('admin.movedetails.create', compact('countries','properties','tenants','roomTypes','societies','users',
        'inventoryTypes','inventoryCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'property_id' => 'required',
            
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validate);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Validation Error.')
                ->withErrors($validator);
        }

        $addMoveDetail = new MoveDetail();

        $addMoveDetail->society_id = $request->society_id;
        $addMoveDetail->property_id = $request->property_id;
        $addMoveDetail->room_id = $request->room_id;
        $addMoveDetail->flat_size = $request->flat_size;
        $addMoveDetail->owner_id = $request->owner_id;
        $addMoveDetail->owner = $request->owner;
        $addMoveDetail->tenant_id = $request->tenant_id;
        $addMoveDetail->name_individual = $request->name_individual;
        $addMoveDetail->tenant_phone = $request->tenant_phone;
        $addMoveDetail->tenant_parents_phone = $request->tenant_parents_phone;
        $addMoveDetail->tenant_email = $request->tenant_email;
        $addMoveDetail->agent_name = $request->agent_name;
        $addMoveDetail->token_amount = $request->token_amount;
        $addMoveDetail->room_type = $request->room_type;
        $addMoveDetail->rooms = $request->rooms;
        $addMoveDetail->movein_date = $request->movein_date;
        $addMoveDetail->first_renewal_date = $request->first_renewal_date;
        $addMoveDetail->second_renewal_date = $request->second_renewal_date;
        $addMoveDetail->rent_payment_date = $request->rent_payment_date;
        $addMoveDetail->total_amount_of_new_client = $request->total_amount_of_new_client;
        
        $addMoveDetail->save();
        $move_in_id=$addMoveDetail->id;

        if ($request->month) {
            foreach ($request->month as $key => $value) {
                
                    if (!empty($value)) {
                        $saveref = new MoveDetailRent();
                        $saveref->move_in_id = $move_in_id;
                        $saveref->property_id = $request->property_id;
                        $saveref->room_id = $request->room_id;
                        $saveref->tenant_id = $request->tenant_id;
                        $saveref->month_a = $request->month[$key];
                        $saveref->rent_per_month = $request->rent_per_month[$key];
                        $saveref->ac_charges = $request->ac_charges[$key];
                        $saveref->fixed_charges = $request->fixed_charges[$key];
                        $saveref->rent_as_per_invoice = $request->rent_as_per_invoice[$key];
                        $saveref->dsl_assurance = $request->dsl_assurance[$key];
                        $saveref->meter_install = $request->meter_install[$key];
                        $saveref->discount = $request->discount[$key];
                        $saveref->this_month = $request->this_month[$key];
                        
                        $saveref->save();
                        
                    }
                
            }
        }


        return redirect(route('movedetails.create'))->with('success', 'Move In Details Has been Saved Successfuly.');
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

        $movein_info = MoveDetail::find($id);
        $users = User::get();
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $countries = Country::get();
        $tenants = Tenant::get();
        $societies = Society::get();
        $properties = Property::where('society_id', $movein_info->society_id)->get();
        $allrents = MoveDetailRent::where('move_in_id', $movein_info->id)->get();
        $inventoryCategories = InventoryCategory::where('parent_id', 0)->get();
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
        return view('admin.movedetails.update', compact('movein_info','countries','properties','tenants','roomTypes','societies','users',
        'inventoryTypes','inventoryCategories','allrents'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'property_id' => 'required',
            
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validate);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Validation Error.')
                ->withErrors($validator);
        }

        $addMoveDetail = MoveDetail::find($id);

        //$addMoveDetail = new MoveDetail();

        $addMoveDetail->society_id = $request->society_id;
        $addMoveDetail->property_id = $request->property_id;
        $addMoveDetail->room_id = $request->room_id;
        $addMoveDetail->flat_size = $request->flat_size;
        $addMoveDetail->owner_id = $request->owner_id;
        $addMoveDetail->owner = $request->owner;
        $addMoveDetail->tenant_id = $request->tenant_id;
        $addMoveDetail->name_individual = $request->name_individual;
        $addMoveDetail->tenant_phone = $request->tenant_phone;
        $addMoveDetail->tenant_parents_phone = $request->tenant_parents_phone;
        $addMoveDetail->tenant_email = $request->tenant_email;
        $addMoveDetail->agent_name = $request->agent_name;
        $addMoveDetail->token_amount = $request->token_amount;
        $addMoveDetail->room_type = $request->room_type;
        $addMoveDetail->rooms = $request->rooms;
        $addMoveDetail->movein_date = $request->movein_date;
        $addMoveDetail->first_renewal_date = $request->first_renewal_date;
        $addMoveDetail->second_renewal_date = $request->second_renewal_date;
        $addMoveDetail->rent_payment_date = $request->rent_payment_date;
        $addMoveDetail->total_amount_of_new_client = $request->total_amount_of_new_client;
        
        $addMoveDetail->save();
        $move_in_id=$id;

        $deleteRent = MoveDetailRent::where('move_in_id',$id)->delete();
        
        if ($request->month) {
            foreach ($request->month as $key => $value) {
                
                    if (!empty($value)) {
                        $saveref = new MoveDetailRent();
                        $saveref->move_in_id = $move_in_id;
                        $saveref->property_id = $request->property_id;
                        $saveref->room_id = $request->room_id;
                        $saveref->tenant_id = $request->tenant_id;
                        $saveref->month_a = $request->month[$key];
                        $saveref->rent_per_month = $request->rent_per_month[$key];
                        $saveref->ac_charges = $request->ac_charges[$key];
                        $saveref->fixed_charges = $request->fixed_charges[$key];
                        $saveref->rent_as_per_invoice = $request->rent_as_per_invoice[$key];
                        $saveref->dsl_assurance = $request->dsl_assurance[$key];
                        $saveref->meter_install = $request->meter_install[$key];
                        $saveref->discount = $request->discount[$key];
                        $saveref->this_month = $request->this_month[$key];
                        
                        $saveref->save();
                        
                    }
                
            }
        }


        return redirect(route('movedetails.edit', $id))->with('success', 'Move In Details Has been Saved Successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!empty($id)) {
            $data = MoveDetail::find($id)->delete();
            return redirect(route('movedetails.index'))->with('success', 'Master Has Been Deleted Successfully!');
        }
        return redirect(route('movedetails.index'))->with('error', 'Something Worng try again.!');
    }
}
