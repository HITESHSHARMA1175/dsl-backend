<?php

namespace App\Http\Controllers\Admin\Team;

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
use App\Models\Team;


class TeamControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        
       
        $query = Team::query();
        
        if ($request->searchtext != '') {
            $query->where('team_name', 'like', '%'.$request->searchtext.'%');
        }

        $teams = $query->paginate(10);
        $teamCount = $query->count();
   
        $services = Property::where('parent_id', 0)->get();
        
        return view('admin.team.index', compact('teams','teamCount', 'services','request'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $categories = PropertyCategory::where('parent_id', '0')->where('is_condition', '0')->get();
        $conditions = PropertyCategory::where('parent_id', '0')->where('is_condition', '1')->get();
        $services = Property::where('parent_id', 0)->get();

        return view('admin.team.create', compact('services','categories','conditions'));
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $rules = [
            'team_name' => 'required',
            'email' => 'required|email|unique:teams,email',
            'mobile' => 'required|digits:10|unique:teams,mobile',
            'gender' => 'required',
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
        
      

        $saveTeam = new Team();
        
        $slug = Str::slug($request->team_name, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,0);
        $saveTeam->team_slug = $uniqueSlug; 
        
        $saveTeam->team_name = $request->team_name;
        $saveTeam->email = $request->email;
        $saveTeam->mobile = $request->mobile;
        $saveTeam->gender = $request->gender;
        $saveTeam->designation = $request->designation;
        $saveTeam->profession = $request->profession;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/team'), $FileName);
            $saveTeam->profile = $FileName;
        }
        
        if ($request->has('work_category')) {
            $saveTeam->work_category = $result = implode(',', $request->work_category);
        }
        
        if ($request->has('work_condition')) {
            $saveTeam->work_condition = $result = implode(',', $request->work_condition);
        }
        
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/team'), $FileName);
            $saveTeam->banner = $FileName;
        }
        $saveTeam->long_description = $request->long_description;
        $saveTeam->description = $request->description;
        
        if ($request->hasFile('banner_cn')) {
            $file = $request->file('banner_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/team'), $FileName);
            $saveTeam->banner_cn = $FileName;
        }
        $saveTeam->long_description_cn = $request->long_description_cn;
        $saveTeam->description_cn = $request->description_cn;
        
        if ($request->hasFile('banner_ar')) {
            $file = $request->file('banner_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/team'), $FileName);
            $saveTeam->banner_ar = $FileName;
        }
        $saveTeam->long_description_ar = $request->long_description_ar;
        $saveTeam->description_ar = $request->description_ar;
        
        $saveTeam->monday = $request->boolean('monday');
        $saveTeam->monday_start = $request->start_time[0];
        $saveTeam->monday_end = $request->end_time[0];

        $saveTeam->tuesday = $request->boolean('tuesday');
        $saveTeam->tuesday_start = $request->start_time[1];
        $saveTeam->tuesday_end = $request->end_time[1];

        $saveTeam->wednesday = $request->boolean('wednesday');
        $saveTeam->wednesday_start = $request->start_time[2];
        $saveTeam->wednesday_end = $request->end_time[2];

        $saveTeam->thursday = $request->boolean('thursday');
        $saveTeam->thursday_start = $request->start_time[3];
        $saveTeam->thursday_end = $request->end_time[3];

        $saveTeam->friday = $request->boolean('friday');
        $saveTeam->friday_start = $request->start_time[4];
        $saveTeam->friday_end = $request->end_time[4];

        $saveTeam->saturday = $request->boolean('saturday');
        $saveTeam->saturday_start = $request->start_time[5];
        $saveTeam->saturday_end = $request->end_time[5];

        $saveTeam->sunday = $request->boolean('sunday');
        $saveTeam->sunday_start = $request->start_time[6];
        $saveTeam->sunday_end = $request->end_time[6];
        
        
        $saveTeam->addby = auth()->user()->id;
        
        $saveTeam->save();

      

        return redirect()
            ->back()
            ->with('success', 'Team has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team_info = Team::where('id', $id)->first();

        return view('admin.team.details', compact('team_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $team_info = Team::where('id', $id)->first();

        $categories = PropertyCategory::where('parent_id', '0')->where('is_condition', '0')->get();
        $conditions = PropertyCategory::where('parent_id', '0')->where('is_condition', '1')->get();

        return view('admin.team.update', compact('team_info', 'categories', 'conditions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         //dd($request->all());
        $rules = [
            'team_name' => 'required',
            'email' => 'required|email|unique:teams,email,' . $id,
            'mobile' => 'required|digits:10|unique:teams,mobile,' . $id,
            'gender' => 'required',
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

        $team_id = $id;
        $saveTeam = Team::find($id);
        
        $slug = Str::slug($request->team_name, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,$id);
        $saveTeam->team_slug = $uniqueSlug;
        
        $saveTeam->team_name = $request->team_name;
        $saveTeam->email = $request->email;
        $saveTeam->mobile = $request->mobile;
        $saveTeam->gender = $request->gender;
        $saveTeam->designation = $request->designation;
        $saveTeam->profession = $request->profession;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/team'), $FileName);
            $saveTeam->profile = $FileName;
        }
        
        if ($request->has('work_category')) {
            $saveTeam->work_category = $result = implode(',', $request->work_category);
        }
        
        if ($request->has('work_condition')) {
            $saveTeam->work_condition = $result = implode(',', $request->work_condition);
        }
        
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/team'), $FileName);
            $saveTeam->banner = $FileName;
        }
        $saveTeam->long_description = $request->long_description;
        $saveTeam->description = $request->description;
        
        if ($request->hasFile('banner_cn')) {
            $file = $request->file('banner_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/team'), $FileName);
            $saveTeam->banner_cn = $FileName;
        }
        $saveTeam->long_description_cn = $request->long_description_cn;
        $saveTeam->description_cn = $request->description_cn;
        
        if ($request->hasFile('banner_ar')) {
            $file = $request->file('banner_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/team'), $FileName);
            $saveTeam->banner_ar = $FileName;
        }
        $saveTeam->long_description_ar = $request->long_description_ar;
        $saveTeam->description_ar = $request->description_ar;
        
        $saveTeam->monday = $request->boolean('monday');
        $saveTeam->monday_start = $request->start_time[0];
        $saveTeam->monday_end = $request->end_time[0];

        $saveTeam->tuesday = $request->boolean('tuesday');
        $saveTeam->tuesday_start = $request->start_time[1];
        $saveTeam->tuesday_end = $request->end_time[1];

        $saveTeam->wednesday = $request->boolean('wednesday');
        $saveTeam->wednesday_start = $request->start_time[2];
        $saveTeam->wednesday_end = $request->end_time[2];

        $saveTeam->thursday = $request->boolean('thursday');
        $saveTeam->thursday_start = $request->start_time[3];
        $saveTeam->thursday_end = $request->end_time[3];

        $saveTeam->friday = $request->boolean('friday');
        $saveTeam->friday_start = $request->start_time[4];
        $saveTeam->friday_end = $request->end_time[4];

        $saveTeam->saturday = $request->boolean('saturday');
        $saveTeam->saturday_start = $request->start_time[5];
        $saveTeam->saturday_end = $request->end_time[5];

        $saveTeam->sunday = $request->boolean('sunday');
        $saveTeam->sunday_start = $request->start_time[6];
        $saveTeam->sunday_end = $request->end_time[6];
        
        $saveTeam->save();



        return redirect()
            ->back()
            ->with('success', 'Team has been saved.');
    }

    
    public function team_status($id)
    {
        $data = Team::find($id);
        
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
            ->with('success', 'Team ' . $msg . ' Successfully!');
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
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()
            ->back()
            ->with('success', 'Team has been Deleted Successfully!!');
    }
    
    
    private function generateUniqueSlug($slug,$id)
    {
        $originalSlug = $slug;
        $counter = 1;
    
        // Check for existing slug in the database
        while (Team::where('team_slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
    
}
