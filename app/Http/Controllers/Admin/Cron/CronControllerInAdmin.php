<?php

namespace App\Http\Controllers\Admin\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\MasterValue;
use App\Models\Society;
use App\Models\PropertyCategory;
use App\Models\Property;
use App\Models\PropertyRoom;
use App\Models\Attribute;
use App\Models\Tenant;
use App\Models\Owner;
use App\Models\MoveDetail;
use App\Models\MoveDetailRent;
use App\Models\InventoryCategory;
use App\Models\Inventory;
use App\Models\InventoryImage;
use App\Models\InventoryAttribute;
use App\Models\MapInventoryAttribute;
use App\Models\PropertyRoomInventory;

use Carbon\Carbon;


class CronControllerInAdmin extends Controller
{
  

    public function createMoveinPayment()
    {
        $MoveDetails = MoveDetail::where('id','!=', '')->get();

        if (count($MoveDetails) > 0) {
     
            foreach ($MoveDetails as $key => $value) {
               
               $MoveDetailRent = MoveDetailRent::where('move_in_id', $value->id)->orderByDesc('id')->first();
               
               if($MoveDetailRent){
                   
                   
                    $currentDate = Carbon::now();
               
                    $date = Carbon::parse($MoveDetailRent->month_a);
                    $newDate = $date->addMonth();
                    
                    $MoveDetailRentCheck = MoveDetailRent::where('move_in_id', $value->id)->where('month_a', $currentDate->format('Y-m'))->orderByDesc('id')->first();
                        
                    if(empty($MoveDetailRentCheck)){
                       
                        $saveref = new MoveDetailRent();
                        $saveref->move_in_id = $MoveDetailRent->move_in_id;
                        $saveref->property_id = $MoveDetailRent->property_id;
                        $saveref->room_id = $MoveDetailRent->room_id;
                        $saveref->tenant_id = $MoveDetailRent->tenant_id;
                        $saveref->month_a = $currentDate->format('Y-m');
                        $saveref->rent_per_month = $MoveDetailRent->rent_per_month;
                        $saveref->ac_charges = $MoveDetailRent->ac_charges;
                        $saveref->fixed_charges = $MoveDetailRent->fixed_charges;
                        $saveref->rent_as_per_invoice = $MoveDetailRent->rent_as_per_invoice;
                        $saveref->dsl_assurance = $MoveDetailRent->dsl_assurance;
                        $saveref->meter_install = $MoveDetailRent->meter_install;
                        $saveref->discount = $MoveDetailRent->discount;
                        $saveref->this_month = $MoveDetailRent->this_month;
                        
                        $saveref->save();
                    
                    }
                    
               }
               
            }
        }
        
    }


}
