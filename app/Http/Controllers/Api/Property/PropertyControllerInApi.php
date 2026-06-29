<?php

namespace App\Http\Controllers\Api\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Property;
use App\Models\PropertyRoom;
use App\Models\InventoryCategory;
use App\Models\PropertyRoomInventory;

class PropertyControllerInApi extends Controller
{
    public function getProperty(Request $request)
    {
        try {
            $user = auth()->user();
            
            if($request->page){
                $page_id=$request->page;
            }else{
                $page_id=1;
            }
            
            $properties = Property::where('id', '!=', '')
                ->where('status', '=', '1')
                ->orderByDesc('id')
                ->paginate(10, ['*'], 'page', $page_id);
                
            
            $propertyCount = Property::where('status', '=', '1')->count();

            // Transform the properties collection to include the desired columns
            $transformedProperties = $properties->map(function ($property) {
                
                $roomShared = PropertyRoom::where('property_id', $property->id)->where('room_type', '28')->first();
                $roomPrivate = PropertyRoom::where('property_id', $property->id)->where('room_type', '27')->first();
                
                if(@$roomShared->id>0){
                    $property_type='Shared Room';
                    $price=@$roomShared->room_rent_per_month;
                }elseif(@$roomPrivate->id>0){
                    $property_type='Private Room';
                    $price=@$roomShared->room_rent_per_month;
                }else{
                    $property_type='Shared Room';
                    $price=0;
                }
                  
                $propertyimages = $property->getPropertyImages;
                foreach ($propertyimages as $item)
                {
                    $property_image = asset('uploads/property') . '/' . $item->image;
                }
                
                return [
                    'id' => $property->id ?? '',
                    'property_type' => $property_type,
                    'property_name' => $property->property_name ?? '',
                    'property_image' => $property_image ?? '',
                    'country' => @$property->getPropertyCountry->name ?? '',
                    'state' => @$property->getPropertyState->name ?? '',
                    'city' => @$property->getPropertyCity->name ?? '',
                    'pincode' => $property->pincode ?? '',
                    'area' => $property->area ?? '',
                    'street' => $property->street ?? '',
                    'price' => $price ?? 0,
                    'is_wishlist' => 0 ?? '',
                    'rating' => 4.5 ?? '',
                    'gender_type' => 'Men' ?? '',
                    
                ];
            });

            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Property Lists.';
            $result['count'] = $propertyCount;
            $result['data'] = $transformedProperties;
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getPropertyDetails(Request $request)
    {
        try {
            $user = auth()->user();
            
            $property=   $properties = Property::where('id', $request->property_id)->first(); 
                
       
            $roomShared = PropertyRoom::where('property_id', $property->id)->where('room_type', '28')->first();
            $roomPrivate = PropertyRoom::where('property_id', $property->id)->where('room_type', '27')->first();
            //return $roomShared->id;
            if(@$roomShared->id>0){
                $property_type_id='28';
                $property_type='Shared Room';
                $price=@$roomShared->room_rent_per_month;
            }elseif(@$roomPrivate->id>0){
                $property_type_id='27';
                $property_type='Private Room';
                $price=@$roomShared->room_rent_per_month;
            }else{
                $property_type_id='28';
                $property_type='Shared Room';
                $price=0;
            }
            
            $propertyimages = $property->getPropertyImages;
            foreach ($propertyimages as $item)
            {
                $property_image[] = array('id'=>$item->id,'image'=>asset('uploads/property') . '/' . $item->image);
            }
            
            $propertyinventory = $property->getPropertyInventory;
            foreach ($propertyinventory as $iteminv)
            {
                $property_inventory[] = array(
                                        'id'=>$iteminv->id,
                                        'inventory_type'=>@$iteminv->getInventoryType->MasterValue,
                                        'inventory_category'=>@$iteminv->getInventoryCategory->category_name,
                                        'inventory_sub_category'=>@$iteminv->getInventorySubCategory->category_name,
                                        'image'=>asset('uploads/inventory') . '/' . $iteminv->profile
                                    );
            
            }
            
            $total_bed=0;
            $total_bath=0;
            $propertyrooms = $property->getPropertyRooms;
            foreach ($propertyrooms as $itemroom)
            {
                
                if($itemroom->room_type=='27'){
                    
                    $icon=asset('uploads') . '/' . 'human1.png';
                    
                    $total_bed=$total_bed+1;
                    
                }elseif($itemroom->room_type=='28'){
                    
                    $total_bed=$total_bed+$itemroom->room_bed;
                    
                    if($itemroom->room_bed>2){
                        $icon=asset('uploads') . '/' . 'human3.png'; 
                    }else{
                       $icon=asset('uploads') . '/' . 'human2.png'; 
                    }
                    
                }
                
                if($itemroom->bathroom=='33'){
                    
                    $total_bath=$total_bath+1;
                    
                }elseif($itemroom->bathroom=='34'){
                    
                    $total_bath=$total_bath+0;
                   
                }
                
                $property_room[] = array(
                                        'id'=>$itemroom->id,
                                        'room_type_id'=>@$itemroom->room_type,
                                        'room_type'=>@$itemroom->getRoomType->MasterValue,
                                        'room_name'=>@$itemroom->rooms,
                                        'price'=>@$itemroom->room_rent_per_month,
                                        'icon'=>@$icon
                                    );
            
            }
            
            
                $propertyDet['id'] = $property->id ?? '';
                $propertyDet['property_type_id'] = $property_type_id;
                $propertyDet['property_type'] = $property_type;
                $propertyDet['property_name'] = $property->property_name ?? '';
                $propertyDet['country'] = @$property->getPropertyCountry->name ?? '';
                $propertyDet['state'] = @$property->getPropertyState->name ?? '';
                $propertyDet['city'] = @$property->getPropertyCity->name ?? '';
                $propertyDet['pincode'] = $property->pincode ?? '';
                $propertyDet['area'] = $property->area ?? '';
                $propertyDet['street'] = $property->street ?? '';
                $propertyDet['price'] = $price ?? 0;
                $propertyDet['is_wishlist'] = 0 ?? '';
                $propertyDet['rating'] = 4.5 ?? '';
                $propertyDet['total_review'] = 256 ?? '';
                $propertyDet['gender_type'] = 'Men' ?? '';
                
                $propertyDet['total_bed'] = $total_bed ?? '';
                $propertyDet['total_bath'] = $total_bath ?? '';
                $propertyDet['total_area'] = ($property->property_size ?? 0).' sqft';
                
                $propertyDet['about'] = 'Realtydart is a cutting-edge co-living, property management company that utilises technology to provide top-notch services to its clients.
                                        We offer a variety of services to our clients, including co-living arrangements, property management, and maintenance solutions. Our co-living options allow individuals and groups to live in fully furnished, modern apartments with all the amenities they need to feel at home. Our property management services include rent collection, tenant screening, and maintenance coordination';
                
                $propertyDet['property_images'] = $property_image ?? [];
                $propertyDet['property_inventory'] = $property_inventory ?? [];
                $propertyDet['property_room'] = $property_room ?? [];
            
        

            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Property Details.';
            $result['data'] = $propertyDet;
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getPropertyRoom(Request $request)
    {
        try {
            $user = auth()->user();
            
            $property=   $properties = Property::where('id', $request->property_id)->first(); 
          
            $propertyrooms = $property->getPropertyRooms;
            foreach ($propertyrooms as $itemroom)
            {
                
                if($itemroom->room_type=='27'){
                    
                    $room_bed='';
                    $icon=asset('uploads') . '/' . 'human1.png';
                   
                }elseif($itemroom->room_type=='28'){
                    
                    $room_bed=$itemroom->room_bed.' bed';
                    if($itemroom->room_bed>2){
                        $icon=asset('uploads') . '/' . 'human3.png'; 
                    }else{
                       $icon=asset('uploads') . '/' . 'human2.png'; 
                    }
                    
                }
                
                if($itemroom->bathroom=='33'){
                    
                    $bathroom='Attached Bathroom';
                    
                }elseif($itemroom->bathroom=='34'){
                    
                    $bathroom='Common Bathroom';
                   
                }
                
                if($itemroom->kitchen=='31'){
                    
                    $kitchen='Attached Kitchen';
                    
                }elseif($itemroom->kitchen=='32'){
                    
                    $kitchen='Common Kitchen';
                   
                }
                
                $property_room[] = array(
                                        'id'=>$itemroom->id,
                                        'property_id'=>@$itemroom->property_id,
                                        'room_type_id'=>@$itemroom->room_type,
                                        'room_type'=>@$itemroom->getRoomType->MasterValue,
                                        'room_name'=>@$itemroom->rooms,
                                        'price'=>@$itemroom->room_rent_per_month,
                                        'room_bed'=>@$room_bed,
                                        'room_area'=>'104 sqft',
                                        'bathroom'=>@$bathroom,
                                        'kitchen'=>@$kitchen,
                                        'icon'=>@$icon,
                                        'available'=>@$itemroom->available
                                    );
            
            }
            
          
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Property Room List.';
            $result['data'] = $property_room;
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getRoomBed(Request $request)
    {
        try {
            $user = auth()->user();
            
            $property=   $properties = Property::where('id', $request->property_id)->first(); 
            $itemroom=   $properties = PropertyRoom::where('id', $request->room_id)->first(); 
            
            $propertyrooms = $property->getPropertyRooms;
            
            if($itemroom->room_bed>0){
                for($i=1; $i<=$itemroom->room_bed; $i++)
                {
                    
                    if($itemroom->room_type=='27'){
                        
                        $room_bed='';
                        $icon=asset('uploads') . '/' . 'human1.png';
                       
                    }elseif($itemroom->room_type=='28'){
                        
                        $room_bed=$itemroom->room_bed.' bed';
                        if($itemroom->room_bed>2){
                            $icon=asset('uploads') . '/' . 'human3.png'; 
                        }else{
                           $icon=asset('uploads') . '/' . 'human2.png'; 
                        }
                        
                    }
                    
                    if($itemroom->bathroom=='33'){
                        
                        $bathroom='Attached Bathroom';
                        
                    }elseif($itemroom->bathroom=='34'){
                        
                        $bathroom='Common Bathroom';
                       
                    }
                    
                    if($itemroom->kitchen=='31'){
                        
                        $kitchen='Attached Kitchen';
                        
                    }elseif($itemroom->kitchen=='32'){
                        
                        $kitchen='Common Kitchen';
                       
                    }
                    
                    $available_b='available_b'.$i;
                    
                    $property_room[] = array(
                                            'id'=>$i,
                                            'room_id'=>$itemroom->id,
                                            'property_id'=>@$itemroom->property_id,
                                            'room_type_id'=>@$itemroom->room_type,
                                            'room_type'=>@$itemroom->getRoomType->MasterValue,
                                            'room_name'=>@$itemroom->rooms,
                                            'bed_name'=>'Bed '.$i,
                                            'price'=>@$itemroom->room_rent_per_month,
                                            'room_area'=>'104 sqft',
                                            'bathroom'=>@$bathroom,
                                            'kitchen'=>@$kitchen,
                                            'available'=>$itemroom->$available_b
                                            
                                        );
                
                }
            }
          
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Room Bed List.';
            $result['data'] = $property_room;
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    

}
