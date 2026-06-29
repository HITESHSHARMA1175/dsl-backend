<?php

namespace App\Http\Controllers\Admin\Master;

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
use App\Models\Builder;

class BuildersControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $query = Builder::query();
        if ($request->search_text != '') {
            $query->where(function ($query) use ($request) {
                $userId = auth()->user()->id;
                $query->where("builder_name","like",'%'.$request->search_text.'%')
                ->orWhere("email","like",'%'.$request->search_text.'%')
                ->orWhere("mobile_no","like",'%'.$request->search_text.'%');
            });
        }
        $builders = $query->orderByDesc('id')->paginate(10);
        $buildersCount = $query->count();
        
        
        //$builders = Builder::get();

        return view('admin.builder.index', compact('builders','buildersCount','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::get();
        return view('admin.builder.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'builder_name' => 'required',
            //'email' => 'nullable|email',
            // 'mobile_no' => 'required|unique:users,mobile_no',
            // 'password' => 'required',
            // 'user_status' => 'required',
            //'address' => 'required|string:500',
            //'country' => 'required',
            //'state' => 'required',
            //'pincode' => 'required',
            //'profile' => 'nullable|file|max:2048|mimes:jpg,png,jpeg',
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
        $save = new Builder();
        $save->builder_name = $request->builder_name;
        $save->email = $request->email;
        $save->mobile_no = $request->mobile_no;
        $save->address = $request->address;
        $save->country_id = $request->country;
        $save->state_id = $request->state;
        $save->city_id = $request->city;
        $save->pincode = $request->pincode;
        $FileName = '';
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->profile = $FileName;
        }
        
        $save->addby = auth()->user()->id;

        if ($save->save()) {
            return redirect(route('builder.create'))->with('success', 'Builder Has been Created Successfuly!');
        }
        return redirect(route('builder.create'))->with('error', 'Something Wrong try Again!');
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
        $countries = Country::get();
        $builder = Builder::find($id);
        return view('admin.builder.update', compact('builder', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'email' => 'nullable|email',
            'profile' => 'sometimes|file|max:2048|mimes:jpg,png,jpeg',
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
        $save = Builder::find($id);
        if (!empty($request->builder_name)) {
            $save->builder_name = $request->builder_name;
        }
        if (!empty($request->email)) {
            $save->email = $request->email;
        }
        if (!empty($request->mobile_no)) {
            $save->mobile_no = $request->mobile_no;
        }
        if (!empty($request->address)) {
            $save->address = $request->address;
        }
        if (!empty($request->country)) {
            $save->country_id = $request->country;
        }
        if (!empty($request->state)) {
            $save->state_id = $request->state;
        }
        if (!empty($request->city)) {
            $save->city_id = $request->city;
        }
        if (!empty($request->pincode)) {
            $save->pincode = $request->pincode;
        }
        $FileName = '';
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->profile = $FileName;
        }

        if ($save->save()) {
            return redirect()
                ->back()
                ->with('success', 'Builder Has been Saved Successfuly!');
        }
        return redirect()
            ->back()
            ->with('error', 'Something Wrong try Again!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $developer = Builder::findOrFail($id);
        
        $developer->delete();
        return redirect()
            ->back()
            ->with('success', 'Developer has been Deleted Successfully!!');
    }
}
