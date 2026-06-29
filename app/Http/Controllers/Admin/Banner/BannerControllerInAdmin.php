<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Banner;


class BannerControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        
        $query = Banner::query();
        
        if ($request->searchtext != '') {
            $query->where('banner_name', 'like', '%'.$request->searchtext.'%');
        }

        if ($request->banner_type != '') {
            $query->where('banner_type', '=', $request->banner_type);
        }
        
        
        $bannersCount = $query->count();
        $banners = $query->paginate(10);
        
        
        return view('admin.banner.index', compact('banners','bannersCount','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banner_info='';
        return view('admin.banner.create', compact('banner_info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveBanner = new Banner();
        $saveBanner->banner_type = $request->banner_type;
        $saveBanner->banner_name = $request->banner_name;
        $saveBanner->banner_url = $request->banner_url;
        $saveBanner->description = $request->description;
        $saveBanner->description_cn = $request->description_cn;
        $saveBanner->description_ar = $request->description_ar;
       
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/banner'), $FileName);
            $saveBanner->profile = $FileName;
        }
        
        if ($request->hasFile('profile_cn')) {
            $file = $request->file('profile_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/banner'), $FileName);
            $saveBanner->profile_cn = $FileName;
        }
        
        if ($request->hasFile('profile_ar')) {
            $file = $request->file('profile_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/banner'), $FileName);
            $saveBanner->profile_ar = $FileName;
        }

        $saveBanner->save();



        return redirect()
            ->back()
            ->with('success', 'Banner has been saved.');
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
        $banner_info = Banner::where('id', $id)->first();

        return view('admin.banner.update', compact('banner_info'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveBanner = Banner::find($id);
        $saveBanner->banner_type = $request->banner_type;
        $saveBanner->banner_name = $request->banner_name;
        $saveBanner->banner_url = $request->banner_url;
        $saveBanner->description = $request->description;
        $saveBanner->description_cn = $request->description_cn;
        $saveBanner->description_ar = $request->description_ar;
       
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/banner'), $FileName);
            $saveBanner->profile = $FileName;
        }
        
        if ($request->hasFile('profile_cn')) {
            $file = $request->file('profile_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/banner'), $FileName);
            $saveBanner->profile_cn = $FileName;
        }
        
        if ($request->hasFile('profile_ar')) {
            $file = $request->file('profile_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/banner'), $FileName);
            $saveBanner->profile_ar = $FileName;
        }
        
        $saveBanner->save();



        return redirect()
            ->back()
            ->with('success', 'Banner has been saved.');
    }

    public function banner_status($id)
    {
        $data = Banner::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'Banner ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

    public function mapBannerPropertyRoom(Request $request)
    {
        
        //dd($request->all());

        $banner_ids = $request->banner_ids;
        if($banner_ids!=''){
        foreach ($banner_ids as $banner_key => $banner_id) {
            

            $isadded = PropertyRoomBanner::where('property_id', $request->inv_property_id)->where('room_id', $request->inv_room_id)->where('banner_id', $banner_id)->orderBy('id', 'DESC')->pluck('id')->first();
            if($isadded<1){
                $savePropertyRoomBanner = new PropertyRoomBanner();
                $savePropertyRoomBanner->property_id = $request->inv_property_id;
                $savePropertyRoomBanner->room_id = $request->inv_room_id;
                $savePropertyRoomBanner->banner_id = $banner_id;
    
                $savePropertyRoomBanner->save();

                $saveBanner = Banner::find($banner_id);
                $saveBanner->is_available = '0';
                $saveBanner->property_id = $request->inv_property_id;
                $saveBanner->room_id = $request->inv_room_id;
                $saveBanner->map_date = date("Y-m-d H:i:s");
                $saveBanner->save();

            }
            
            
        }
        }

      
            return redirect()->back()->with('success', 'Banner added Successfully!');
            //return redirect(route('banner.index'))->with('success', 'Banner ' . $msg . ' Successfully!');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $property = Banner::findOrFail($id);
        $property->delete();
        return redirect()
            ->back()
            ->with('success', 'Banner has been Deleted Successfully!!');
        
    }
}
