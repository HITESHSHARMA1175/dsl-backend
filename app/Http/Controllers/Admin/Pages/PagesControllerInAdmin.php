<?php

namespace App\Http\Controllers\Admin\Pages;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Constants;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Str;
use Hash;
use Session;

// use App\Exports\ExportReceiving;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OwnersImport;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Tenant;


class PagesControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function emi_list()
    {
        return view('admin.pages.emi-list');
    }
    
    public function active_emi()
    {
        return view('admin.pages.active-emi');
    }
    
    public function pending_emi()
    {
        return view('admin.pages.pending-emi');
    }
    
    public function bounce_emi()
    {
        return view('admin.pages.bounce-emi');
    }
    
    public function mobile_brand_list()
    {
        return view('admin.pages.mobile-brand-list');
    }
    
    public function add_mobile_brand()
    {
        return view('admin.pages.add-mobile-brand');
    }
      
    public function mobile_list()
    {
        return view('admin.pages.mobile-list');
    }
    
    public function add_mobile()
    {
        return view('admin.pages.add-mobile');
    }
    
    public function mobile_model_list()
    {
        return view('admin.pages.mobile-model-list');
    }

    public function mobile_variant_list()
    {
        return view('admin.pages.mobile-variant-list');
    }

    public function mobile_colour_list()
    {
        return view('admin.pages.mobile-colour-list');
    }

    public function add_mobile_model()
    {
        return view('admin.pages.add-mobile-model');
    }

    public function add_mobile_variant()
    {
        return view('admin.pages.add-mobile-variant');
    }

    public function add_mobile_colour()
    {
        return view('admin.pages.add-mobile-colour');
    }

    public function seller_list()
    {
        return view('admin.pages.seller-list');
    }

    public function seller_kyc_list()
    {
        return view('admin.pages.seller-kyc-list');
    }

    public function add_seller()
    {
        return view('admin.pages.add-seller');
    }

    public function customer_list()
    {
        return view('admin.pages.customer-list');
    }

    public function add_customer()
    {
        return view('admin.pages.add-customer');
    }
    public function createmobilebrand()
    {
        return view('admin.mobile.createmobilebrand');
    }
    public function createmobilemodal()
    {
        return view('admin.mobile.createmobilemodal');
    }
    public function createmobilevariant()
    {
        return view('admin.mobile.createmobilevariant');
    }
    public function createmobilecolor()
    {
        return view('admin.mobile.createmobilecolor');
    }

    

}
