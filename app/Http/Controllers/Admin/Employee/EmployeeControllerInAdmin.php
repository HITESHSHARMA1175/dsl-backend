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

class EmployeeControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = User::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","0");
        if ($request->search_text != '') {
            $search_textarr = explode(' ',$request->search_text);
            $query->where(function ($query) use ($request,$search_textarr) {
                $query->where("first_name","like",'%'.$request->search_text.'%')
                ->orWhere("first_name","like",'%'.$search_textarr[0].'%')
                ->orWhere("last_name","like",'%'.$search_textarr[0].'%');
            });
        }
        
        $employees = $query->orderByDesc('id')->paginate(10);
        //$employeesCount = $query->count();
        $employeesCount = User::where('is_admin', 0)->count();
        
        //$employees = User::where('is_admin', 0)->get();
        return view('admin.employee.index', compact('employees','employeesCount','request'));
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
        return view('admin.employee.create', compact('fieldPersons', 'countries', 'designations', 'adminmenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'first_name' => 'required',
            //'email' => 'required|email|unique:users,email',
            'mobile_no' => 'required|digits:10|unique:users,mobile_no',
            'password' => 'required',
            'designation' => 'required',
            
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
        return redirect(route('employee.create'))->with('success', 'User Has been Created Successfuly.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $query = User::query();
        $query->where("is_admin","=","0");
        $query->where("is_sub_admin","=","0");
        if ($id == 'Block User') {
            $query->where("status","!=","1");
            $user_type="Block User";
        }else{
            $user_type="All User";
        }
        
        if (@auth()->user()->is_sub_admin==1) {
            $query->where("designation","=",@auth()->user()->designation);
        }
        
        if ($request->designation!='') {
            $query->where("designation","=",$request->designation);
        }
        
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
        
        $designations = Designation::where('status', 1)->orderBy('name')->get();
        return view('admin.employee.index', compact('employees','employeesCount','user_type','designations','request'));
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
        return view('admin.employee.update', compact('fieldPersons', 'user', 'countries', 'states', 'cites', 'designations','adminmenus'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        
        
        
        $rules = [
            'first_name' => 'required',
            //'email' => 'required|email|unique:users,email,' . $id,
            'mobile_no' => 'required|digits:10|unique:users,mobile_no,' . $id,
            'password' => 'required',
            'designation' => 'required',
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

        return redirect()
            ->back()
            ->with('success', 'User has been updated successfully.');
    }

    function getUserDocumentDetail(Request $request)
    {
        $user = User::find($request->user_id);
        $card_number = '';
        $title = '';
        $file_link = asset('assets/img/image_placeholder.gif');

        if ($request->doc_type == 'Aadhaar') {
            $title = 'Aadhaar Card';
            $card_number = $user->aadhar_number;
            if (!empty($user->upload_aadhaar)) {
                $file_link = asset('uploads/users_document/' . $user->upload_aadhaar);
            }
        }
        if ($request->doc_type == 'Pan Card') {
            $title = 'Pan Card';
            $card_number = $user->pan_number;
            if (!empty($user->upload_pan)) {
                $file_link = asset('uploads/users_document/' . $user->upload_pan);
            }
        }

        if ($request->doc_type == 'Cencel Cheque') {
            $title = 'Cencel Cheque';
            if (!empty($user->upload_cancel_cheque)) {
                $file_link = asset('uploads/users_document/' . $user->upload_cancel_cheque);
            }
        }
        return response()->json(['title' => $title, 'card_number' => $card_number, 'file_link' => $file_link]);
    }
    
    function getUserMap($id)
    {
        $user = User::find($id);
        
        $propertyAddressPoints = User::join('user_locations', 'users.id', '=', 'user_locations.user_id')
            ->select('users.*', 'user_locations.*')
            ->where('users.id', $id)
            ->orderBy('user_locations.id', 'desc')
            ->limit(1)
            ->get()
            ->toArray();
        
        return view('admin.employee.indexmap', compact('user','propertyAddressPoints'));

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
    
    public function employee_desable($id)
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
