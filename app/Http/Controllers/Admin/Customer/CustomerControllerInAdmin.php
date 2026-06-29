<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Constants;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Str;
use Hash;
use Session;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Customer;
use App\Models\CustomerEmi;
use App\Models\CustomerAddress;


class CustomerControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Customer::query();
        $query->where("id","!=","0");
        if ($request->search_text != '') {
            $query->where(function ($query) use ($request) {
                $query->where("first_name","like",'%'.$request->search_text.'%')
                ->orWhere("last_name","like",'%'.$request->search_text.'%')
                ->orWhere("mobile","like",'%'.$request->search_text.'%')
                ->orWhere("email","like",'%'.$request->search_text.'%');
            });
        }
        
        $customersCount = $query->count();
        $customers = $query->orderByDesc('id')->paginate(10);
        
        return view('admin.customer.index', compact('customers','customersCount','request'));
    }

    /**
     * Display a listing of the resource.
     */
    public function customer_emi($id)
    {
        $customer = Customer::find($id);
        $customer_emis = CustomerEmi::where('customer_id',$id)->get();
        
        
        return view('admin.customer.indexemi', compact('customer','customer_emis'));
    }
    
    
    public function customer_address($id)
    {
        $customer = Customer::find($id);
        $customer_addresss = CustomerAddress::where('user_id',$id)->get();
        
        
        return view('admin.customer.indexaddress', compact('customer','customer_addresss'));
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $query = Customer::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","1");
        if ($id == 'Block Customer') {
            $query->where("status","!=","1");
        }else{
            
        }
        
        $customersCount = $query->count();
        $customers = $query->orderByDesc('id')->paginate(10);
        //$customersCount = $query->count();
        //$customersCount = Customer::where('is_admin', 0)->count();
        
        //$customers = Customer::where('is_admin', 0)->get();
        return view('admin.subadmin.index', compact('customers','customersCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        
       
    }

    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = Customer::findOrFail($id);
        
        $lead->delete();
        return redirect()
            ->back()
            ->with('success', 'Customer has been Deleted Successfully!!');
    }
    
    
    public function customer_desable($id)
    {
        $data = Customer::find($id);

        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled ';
        } else {
            $data->status = 1;
            $msg = 'Enabled ';
        }
        $data->save();
        return redirect()->back()->with('success', 'Customer ' . $msg . 'Successfully!');
    }
}
