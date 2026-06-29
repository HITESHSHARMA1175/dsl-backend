<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Designation;
use App\Models\KiBooking;
use App\Models\Order;
use App\Models\ConsultationForm;
use App\Models\Treatment;
use App\Models\PropertyCategory;
use App\Models\Property;
use App\Models\Addon;
use App\Models\Professional;


class HomeControllerInAdmin extends Controller
{
    public function admin_dashboard(Request $request)
    {
        
        
        $query = User::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","0");
        if (@auth()->user()->is_sub_admin==1) {
            $query->where("designation","=",@auth()->user()->designation);
        }
        $allUser = $query->count();
        
        $query = User::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","0");
        $query->where("status","!=","1");
        if (@auth()->user()->is_sub_admin==1) {
            $query->where("designation","=",@auth()->user()->designation);
        }
        $allBlockUser = $query->count();
        
        $query = User::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","1");
        $allSubadmin = $query->count();
        
        $query = Designation::query();
        $allArea = $query->count();
        
        $query = KiBooking::query();
        $allKiBooking = $query->count();
        $allstats['allKiBooking']=$allKiBooking;
        
        $query = Order::query();
        $allOrder = $query->count();
        $allstats['allOrder']=$allOrder;
        
        $query = ConsultationForm::query();
        $allConsultationForm = $query->count();
        $allstats['allConsultationForm']=$allConsultationForm;
        
        $query = PropertyCategory::query();
        $allPropertyCategory = $query->count();
        $allstats['allPropertyCategory']=$allPropertyCategory;
        
        $query = Property::query();
        $allProperty = $query->count();
        $allstats['allProperty']=$allProperty;
        
        $query = Addon::query();
        $allAddon = $query->count();
        $allstats['allAddon']=$allAddon;
        
        $query = Treatment::query();
        $allTreatment = $query->count();
        $allstats['allTreatment']=$allTreatment;
        
        $query = Professional::query();
        $allProfessional = $query->count();
        $allstats['allProfessional']=$allProfessional;
        
        
        
        return view('admin.dashboard', compact('allstats'));
    }
}
