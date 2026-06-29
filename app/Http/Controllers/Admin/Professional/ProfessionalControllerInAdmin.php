<?php

namespace App\Http\Controllers\Admin\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Constants;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Str;
use Hash;
use Session;


use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Professional;


class ProfessionalControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        
       
        $query = Professional::query();
        
        if ($request->searchtext != '') {
            $query->where('professional_name', 'like', '%'.$request->searchtext.'%');
        }

        if ($request->parent_id != '') {
            $query->where('parent_id', '=', $request->parent_id);
        }
        
        
        $professionals = $query->paginate(10);
        $professionalCount = $query->count();
   
        $services = Property::where('parent_id', 0)->get();
        
        return view('admin.professional.index', compact('professionals','professionalCount', 'services','request'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $services = Property::where('parent_id', 0)->get();

        return view('admin.professional.create', compact('services','categories'));
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $rules = [
            'professional_name' => 'required',
            'email' => 'required|email|unique:professionals,email',
            'mobile' => 'required|digits:10|unique:professionals,mobile',
            'gender' => 'required',
            'designation' => 'required',
            'profession' => 'required',
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


        $saveProfessional = new Professional();
        $saveProfessional->professional_name = $request->professional_name;
        $saveProfessional->email = $request->email;
        $saveProfessional->mobile = $request->mobile;
        $saveProfessional->gender = $request->gender;
        $saveProfessional->designation = $request->designation;
        $saveProfessional->profession = $request->profession;
        if ($request->has('work_category')) {
            $saveProfessional->work_category = $result = implode(',', $request->work_category);
        }
        
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/professional'), $FileName);
            $saveProfessional->profile = $FileName;
        }
        
        
        $saveProfessional->monday = $request->boolean('monday');
        $saveProfessional->monday_start = $request->start_time[0];
        $saveProfessional->monday_end = $request->end_time[0];

        $saveProfessional->tuesday = $request->boolean('tuesday');
        $saveProfessional->tuesday_start = $request->start_time[1];
        $saveProfessional->tuesday_end = $request->end_time[1];

        $saveProfessional->wednesday = $request->boolean('wednesday');
        $saveProfessional->wednesday_start = $request->start_time[2];
        $saveProfessional->wednesday_end = $request->end_time[2];

        $saveProfessional->thursday = $request->boolean('thursday');
        $saveProfessional->thursday_start = $request->start_time[3];
        $saveProfessional->thursday_end = $request->end_time[3];

        $saveProfessional->friday = $request->boolean('friday');
        $saveProfessional->friday_start = $request->start_time[4];
        $saveProfessional->friday_end = $request->end_time[4];

        $saveProfessional->saturday = $request->boolean('saturday');
        $saveProfessional->saturday_start = $request->start_time[5];
        $saveProfessional->saturday_end = $request->end_time[5];

        $saveProfessional->sunday = $request->boolean('sunday');
        $saveProfessional->sunday_start = $request->start_time[6];
        $saveProfessional->sunday_end = $request->end_time[6];
        
        $saveProfessional->addby = auth()->user()->id;
        
        $saveProfessional->save();

      

        return redirect()
            ->back()
            ->with('success', 'Professional has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $professional_info = Professional::where('id', $id)->first();

        return view('admin.professional.details', compact('professional_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $professional_info = Professional::where('id', $id)->first();

        $categories = PropertyCategory::where('parent_id', 0)->get();

        return view('admin.professional.update', compact('professional_info', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         //dd($request->all());
        $rules = [
            'professional_name' => 'required',
            'email' => 'required|email|unique:professionals,email,' . $id,
            'mobile' => 'required|digits:10|unique:professionals,mobile,' . $id,
            'gender' => 'required',
            'designation' => 'required',
            'profession' => 'required',
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

        $professional_id = $id;
        $saveProfessional = Professional::find($id);
        $saveProfessional->professional_name = $request->professional_name;
        $saveProfessional->email = $request->email;
        $saveProfessional->mobile = $request->mobile;
        $saveProfessional->gender = $request->gender;
        $saveProfessional->designation = $request->designation;
        $saveProfessional->profession = $request->profession;
        if ($request->has('work_category')) {
            $saveProfessional->work_category = $result = implode(',', $request->work_category);
        }
        
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/professional'), $FileName);
            $saveProfessional->profile = $FileName;
        }
        
        
        $saveProfessional->monday = $request->boolean('monday');
        $saveProfessional->monday_start = $request->start_time[0];
        $saveProfessional->monday_end = $request->end_time[0];

        $saveProfessional->tuesday = $request->boolean('tuesday');
        $saveProfessional->tuesday_start = $request->start_time[1];
        $saveProfessional->tuesday_end = $request->end_time[1];

        $saveProfessional->wednesday = $request->boolean('wednesday');
        $saveProfessional->wednesday_start = $request->start_time[2];
        $saveProfessional->wednesday_end = $request->end_time[2];

        $saveProfessional->thursday = $request->boolean('thursday');
        $saveProfessional->thursday_start = $request->start_time[3];
        $saveProfessional->thursday_end = $request->end_time[3];

        $saveProfessional->friday = $request->boolean('friday');
        $saveProfessional->friday_start = $request->start_time[4];
        $saveProfessional->friday_end = $request->end_time[4];

        $saveProfessional->saturday = $request->boolean('saturday');
        $saveProfessional->saturday_start = $request->start_time[5];
        $saveProfessional->saturday_end = $request->end_time[5];

        $saveProfessional->sunday = $request->boolean('sunday');
        $saveProfessional->sunday_start = $request->start_time[6];
        $saveProfessional->sunday_end = $request->end_time[6];
        
        $saveProfessional->save();



        return redirect()
            ->back()
            ->with('success', 'Professional has been saved.');
    }

    
    public function professional_status($id)
    {
        $data = Professional::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect()
            ->back()
            ->with('success', 'Professional ' . $msg . ' Successfully!');
        }
        return redirect()
            ->back()
            ->with('error', 'Something Worng try again.!');
    }
     
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $professional = Professional::findOrFail($id);
        $professional->delete();
        return redirect()
            ->back()
            ->with('success', 'Professional has been Deleted Successfully!!');
    }
}
