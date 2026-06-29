<?php

namespace App\Http\Controllers\Admin\Employee;

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
use App\Models\User;
use App\Models\Designation;
use App\Models\AdminMenu;
use App\Models\UserLocations;
use App\Models\ShopImage;

class SellerControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = User::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","0");
        $query->where("is_seller","=","1");
        if ($request->search_text != '') {
            $search_textarr = explode(' ',$request->search_text);
            $query->where(function ($query) use ($request,$search_textarr) {
                $query->where("first_name","like",'%'.$request->search_text.'%')
                ->orWhere("first_name","like",'%'.$search_textarr[0].'%')
                ->orWhere("last_name","like",'%'.$search_textarr[0].'%');
            });
        }
        
        $employeesCount = $query->count();
        $employees = $query->orderByDesc('id')->paginate(10);
        //$employeesCount = $query->count();
        //$employeesCount = User::where('is_admin', 0)->count();
        
        //$employees = User::where('is_admin', 0)->get();
        return view('admin.seller.index', compact('employees','employeesCount','request'));
    }

    /**
     * Display a listing of the seller kyc.
     */
    public function seller_kyc(Request $request)
    {
        
        $query = User::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","0");
        $query->where("is_seller","=","1");
        $query->where("is_kyc","=","0");
        if ($request->search_text != '') {
            $search_textarr = explode(' ',$request->search_text);
            $query->where(function ($query) use ($request,$search_textarr) {
                $query->where("first_name","like",'%'.$request->search_text.'%')
                ->orWhere("first_name","like",'%'.$search_textarr[0].'%')
                ->orWhere("last_name","like",'%'.$search_textarr[0].'%');
            });
        }
        
        $employeesCount = $query->count();
        $employees = $query->orderByDesc('id')->paginate(10);
        //$employeesCount = $query->count();
        //$employeesCount = User::where('is_admin', 0)->count();
        
        //$employees = User::where('is_admin', 0)->get();
        return view('admin.seller.indexkyc', compact('employees','employeesCount','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        $countries = Country::get();
        $adminmenus = AdminMenu::get();
        // $states = State::get();
        // $cites = City::get();
        $designations = Designation::where('status', 1)
            ->orderBy('name')
            ->get();
        return view('admin.seller.create', compact('fieldPersons', 'countries', 'designations', 'adminmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile_no' => 'required|digits:10|unique:users,mobile_no',
            //'password' => 'required',
            //'designation' => 'required',
            
            // 'profile' => 'required|file|max:2048|mimes:jpg,png,jpeg',
            
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
        
        @$password=$request->password;

        $addEmp = new User();
        
        $addEmp->first_name = $request->first_name;
        $addEmp->email = $request->email;
        $addEmp->mobile_no = $request->mobile_no;
        $addEmp->password = Hash::make($password);
        $addEmp->password_copy = $password;
        $addEmp->gender = $request->gender;
        $addEmp->dob = !empty($request->dob) ? date('Y-m-d', strtotime($request->dob)) : null;
        
        $addEmp->shop_name = $request->shop_name;
        $addEmp->shop_gst = $request->shop_gst;
        $addEmp->shop_pan = $request->shop_pan;
        $addEmp->shop_business_no = $request->shop_business_no;
        
        $addEmp->bank_name = $request->bank_name;
        $addEmp->account_name = $request->account_name;
        $addEmp->account_no = $request->account_no;
        $addEmp->ifcs = $request->ifcs;
        $addEmp->bank_address = $request->bank_address;
        
        $addEmp->aadhar_number = $request->aadhar_number;
        if ($request->hasFile('upload_aadhaar')) {
            $file = $request->file('upload_aadhaar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addEmp->upload_aadhaar = $FileName;
        }
        $addEmp->pan_number = $request->pan_number;
        if ($request->hasFile('upload_pan')) {
            $file = $request->file('upload_pan');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addEmp->upload_pan = $FileName;
        }
        
        $addEmp->designation = $request->designation;
        $addEmp->is_seller = '1';
        
        $addEmp->address = $request->address;
        $addEmp->country = $request->country;
        $addEmp->state = $request->state;
        $addEmp->city = $request->city;
        $addEmp->pincode = $request->pincode;
        
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addEmp->profile = $FileName;
        }
        
        
        $addEmp->save();
        
        $images = $request->photos;
        // dd($images);
        if (!empty($images)) {
        $FileName = '';
        foreach ($images as $image_key => $image) {
            $file = $image;
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/shop'), $FileName);

            $saveShopImage = new ShopImage();
            $saveShopImage->shop_id = $addEmp->id;
            $saveShopImage->image = $FileName;
            $saveShopImage->save();
        }
        }
        
        
        return redirect(route('seller.create'))->with('success', 'User Has been Created Successfuly.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $query = User::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","1");
        if ($id == 'Block User') {
            $query->where("status","!=","1");
        }else{
            
        }
        
        $employeesCount = $query->count();
        $employees = $query->orderByDesc('id')->paginate(10);
        //$employeesCount = $query->count();
        //$employeesCount = User::where('is_admin', 0)->count();
        
        //$employees = User::where('is_admin', 0)->get();
        return view('admin.subadmin.index', compact('employees','employeesCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $adminmenus = AdminMenu::get();
        $fieldPersons = User::where('emp_type','=', 'Staff')->where('id','!=', $user->id)->get();
        $countries = Country::get();
        $states = State::where('country_id', $user->country)->get();
        $cites = City::where('state_id', $user->state)->get();
        $designations = Designation::where('status', 1)
            ->orderBy('name')
            ->get();
            
        $shopimages = $user->getShopImages;
        return view('admin.seller.update', compact('fieldPersons', 'user', 'countries', 'states', 'cites', 'designations','adminmenus','shopimages'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        
        
        
        $rules = [
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_no' => 'required|digits:10|unique:users,mobile_no,' . $id,
            //'password' => 'required',
            //'designation' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Validation Error.')
                ->withErrors($validator);
        }
        
        @$password=$request->password;

        $addEmp = User::find($id);
        
        $addEmp->first_name = $request->first_name;
        $addEmp->email = $request->email;
        $addEmp->mobile_no = $request->mobile_no;
        $addEmp->password = Hash::make($password);
        $addEmp->password_copy = $password;
        $addEmp->gender = $request->gender;
        $addEmp->dob = !empty($request->dob) ? date('Y-m-d', strtotime($request->dob)) : null;
        
        $addEmp->shop_name = $request->shop_name;
        $addEmp->shop_gst = $request->shop_gst;
        $addEmp->shop_pan = $request->shop_pan;
        $addEmp->shop_business_no = $request->shop_business_no;
        
        $addEmp->bank_name = $request->bank_name;
        $addEmp->account_name = $request->account_name;
        $addEmp->account_no = $request->account_no;
        $addEmp->ifcs = $request->ifcs;
        $addEmp->bank_address = $request->bank_address;
        
        $addEmp->aadhar_number = $request->aadhar_number;
        if ($request->hasFile('upload_aadhaar')) {
            $file = $request->file('upload_aadhaar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addEmp->upload_aadhaar = $FileName;
        }
        $addEmp->pan_number = $request->pan_number;
        if ($request->hasFile('upload_pan')) {
            $file = $request->file('upload_pan');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addEmp->upload_pan = $FileName;
        }
        
        $addEmp->designation = $request->designation;
        
        $addEmp->address = $request->address;
        $addEmp->country = $request->country;
        $addEmp->state = $request->state;
        $addEmp->city = $request->city;
        $addEmp->pincode = $request->pincode;

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addEmp->profile = $FileName;
        }


        $addEmp->save();
        
        $images = $request->photos;
        // dd($images);

        $oldImages = $request->old;
        if (!empty($oldImages)) {
            $addEmp
                ->getShopImages()
                ->whereNotIn('id', $oldImages)
                ->delete();
        }

        $FileName = '';
        if (!empty($images)) {
            foreach ($images as $image_key => $image) {
                $file = $image;
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/shop'), $FileName);

                $saveShopImage = new ShopImage();
                $saveShopImage->shop_id = $id;
                $saveShopImage->image = $FileName;
                $saveShopImage->save();
            }
        }

        return redirect()
            ->back()
            ->with('success', 'User has been updated successfully.');
    }

    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = User::findOrFail($id);
        
        $lead->delete();
        return redirect()
            ->back()
            ->with('success', 'Employee has been Deleted Successfully!!');
    }
    
    public function seller_kyc_approve($id)
    {
        $data = User::find($id);

        if ($data->is_kyc == 1) {
            $data->is_kyc = '0';
            $msg = 'Reject ';
        } else {
            $data->is_kyc = '1';
            $msg = 'Approve ';
        }
        $data->save();
        return redirect()->back()->with('success', 'Kyc ' . $msg . 'Successfully!');
    }
    
    public function seller_desable($id)
    {
        $data = User::find($id);

        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled ';
        } else {
            $data->status = 1;
            $msg = 'Enabled ';
        }
        $data->save();
        return redirect()->back()->with('success', 'User ' . $msg . 'Successfully!');
    }
}
