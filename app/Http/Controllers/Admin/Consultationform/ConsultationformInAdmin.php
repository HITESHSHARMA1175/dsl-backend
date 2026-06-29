<?php

namespace App\Http\Controllers\Admin\Consultationform;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\ConsultationForm;
use App\Models\Clinic;
use App\Models\PropertyCategory;
use App\Models\SubscribeForm;


class ConsultationformInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = ConsultationForm::query();
        
        $query->where('ctype', 'form');
        if ($request->search_text != '') {
            $query->where('first_name', 'LIKE', '%'.$request->search_text.'%');
        }
        
        $consultationforms = $query->paginate(10);
        $consultationformsCount = $query->count();
        
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.consultationform.index', compact('consultationforms','consultationformsCount','brands','request'));
    }
    
    
    public function consultation_refer(Request $request)
    {
        
        $query = ConsultationForm::query();
        
        $query->where('ctype', 'refer');
        if ($request->search_text != '') {
            $query->where('first_name', 'LIKE', '%'.$request->search_text.'%');
        }
        
        $consultationforms = $query->paginate(10);
        $consultationformsCount = $query->count();
        
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.consultationform.refer', compact('consultationforms','consultationformsCount','brands','request'));
    }

    public function subscribed_form(Request $request)
    {
        
        $query = SubscribeForm::query();
        
        if ($request->search_text != '') {
            $query->where('full_name', 'LIKE', '%'.$request->search_text.'%');
        }
        
        $consultationforms = $query->paginate(10);
        $consultationformsCount = $query->count();
        
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.consultationform.subscribed', compact('consultationforms','consultationformsCount','brands','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $consultationform_info='';
        $brands=Brand::where('id','!=','')->get();
        return view('admin.consultationform.create', compact('consultationform_info','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveConsultationForm = new ConsultationForm();
        $saveConsultationForm->rating = $request->rating;
        $saveConsultationForm->title = $request->title;
        $saveConsultationForm->description = $request->description;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveConsultationForm->profile = $FileName;
        }

        $saveConsultationForm->save();



        return redirect()
            ->back()
            ->with('success', 'ConsultationForm has been saved.');
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
        $consultationform_info = ConsultationForm::where('id', $id)->first();
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.consultationform.update', compact('consultationform_info','brands'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveConsultationForm = ConsultationForm::find($id);
        $saveConsultationForm->rating = $request->rating;
        $saveConsultationForm->title = $request->title;
        $saveConsultationForm->description = $request->description;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveConsultationForm->profile = $FileName;
        }
        
        $saveConsultationForm->save();



        return redirect()
            ->back()
            ->with('success', 'ConsultationForm has been saved.');
    }

    public function banner_status($id)
    {
        $data = ConsultationForm::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'ConsultationForm ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $consultationform = ConsultationForm::findOrFail($id);
        $consultationform->delete();
        return redirect()
            ->back()
            ->with('success', 'ConsultationForm has been Deleted Successfully!!');
    }
}
