<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Property;
use App\Models\PropertyRoom;
use App\Models\InventoryCategory;
use App\Models\PropertyRoomInventory;
use App\Models\PropertyImage;
use App\Models\Banner;

class HomeControllerInApi extends Controller
{
    public function homePage()
    {
        try {
            $user = auth()->user();
            
            $top_banner=[];
            $propertyimages = Banner::where('banner_type', '=', 'Home Top Banner')->get(); 
            foreach ($propertyimages as $item)
            {
                $top_banner[] = array('id'=>$item->id,'image'=>asset('uploads/banner') . '/' . $item->profile);
            }


            $remaining_key=50;
            $total_revenue=50000;
            $total_customer=10;
            $total_sell=20;
            $active_emi=4;
            $completed_emi=9;
            $pending_emi=9;
            $bounce_emi=9;

            $data['top_banner'] = $top_banner;
            
            $data['remaining_key'] = $remaining_key;
            $data['total_revenue'] = $total_revenue;
            $data['total_customer'] = $total_customer;
            $data['total_sell'] = $total_sell;
            $data['active_emi'] = $active_emi;
            $data['completed_emi'] = $completed_emi;
            $data['pending_emi'] = $pending_emi;
            $data['bounce_emi'] = $bounce_emi;

            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Home Page.';
            $result['data'] = $data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    


}
