<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\PropertyCategory;

use Carbon\Carbon;


class AjaxCommonControllerInAdmin extends Controller
{
    
   
    public function getState(Request $request)
    {
        $state = State::where('country_id', $request->counId)->get();
        $country = Country::where('id', $request->counId)->first();
        $stateoptions = '<option value="">Select</option>';
        foreach ($state as $value) {
            $checkedState = $request->checkedState == $value->id ? 'selected' : '';
            $stateoptions .= '<option value="' . $value->id . '"' . $checkedState . '>' . $value->name . '</option>';
        }
        return response()->json(['status' => 'success', 'data' => $stateoptions, 'phoneCode' => $country->phonecode]);
    }

    public function getcities(Request $request)
    {
        $cities = City::where('state_id', $request->stateId)->get();
        // $country    = DB::table('countries')->where('id',$request->counId)->first();
        $citiesoptions = '<option value="">Select</option>';
        if (count($cities) == 0) {
            $citiesoptions = '<option value="">City Not Found.</option>';
        } else {
            foreach ($cities as $value) {
                $checkedCity = $request->checkedCity == $value->id ? 'selected' : '';
                $citiesoptions .= '<option value="' . $value->id . '" ' . $checkedCity . '>' . $value->name . '</option>';
            }
        }

        return response()->json(['status' => 'success', 'data' => $citiesoptions]);
    }

    public function getPropertySubCatByCat(Request $request)
    {
        //$sub_categories = PropertyCategory::where('parent_id', $request->category_id)->get();
        //$sub_categories = PropertyCategory::whereJsonContains('parent_ids', strval($request->category_ids))->get();
        
        $query = PropertyCategory::query();
        foreach ($request->category_ids as $category_id) {
            $query->orWhereJsonContains('parent_ids', strval($category_id));
        }
        $sub_categories = $query->get();
        
        $options = '<option value="">Select</option>';
        if (count($sub_categories) == 0) {
            $options = '<option value="">Item Not Found.</option>';
        } else {
            if($request->checkedSubCategory!=''){
                $checkedSubCategory = is_array($request->checkedSubCategory) ? $request->checkedSubCategory : json_decode($request->checkedSubCategory, true);
            }
            foreach ($sub_categories as $value) {
                if($request->checkedSubCategory!=''){
                    $selected = in_array(strval($value->id), $checkedSubCategory) ? 'selected' : '';
                }else{
                    $selected = '';
                }
                $options .= '<option value="' . $value->id . '" ' . $selected . '>' . $value->category_name . '</option>';
            }
        }
        return response()->json(['status' => 'success', 'data' => $options]);
    }

    public function getPropertySubCondByCond(Request $request)
    {
        //$sub_categories = PropertyCategory::where('parent_id', $request->category_id)->get();
        //$sub_categories = PropertyCategory::whereJsonContains('parent_ids', strval($request->category_id))->get();
        
        $query = PropertyCategory::query();
        foreach ($request->category_ids as $category_id) {
            $query->orWhereJsonContains('parent_ids', strval($category_id));
        }
        $sub_categories = $query->get();
        
        $options = '<option value="">Select</option>';
        if (count($sub_categories) == 0) {
            $options = '<option value="">Item Not Found.</option>';
        } else {
            if($request->checkedSubCategory!=''){
                $checkedSubCategory = is_array($request->checkedSubCategory) ? $request->checkedSubCategory : json_decode($request->checkedSubCategory, true);
            }
            foreach ($sub_categories as $value) {
                if($request->checkedSubCategory!=''){
                    $selected = in_array(strval($value->id), $checkedSubCategory) ? 'selected' : '';
                }else{
                    $selected = '';
                }
                $options .= '<option value="' . $value->id . '" ' . $selected . '>' . $value->category_name . '</option>';
            }
        }
        return response()->json(['status' => 'success', 'data' => $options]);
    }

    
}
