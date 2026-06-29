<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master;
use App\Models\MasterValue;
use App\Models\MapWorkCategory;


class MapItemControllerInAdmin extends Controller
{
    public function mapcategory(Request $request)
    {
        $work_category_id = Master::where('MasterHead', 'Work Category')
            ->pluck('id')
            ->first();
        $work_category = MasterValue::where('MasterHead', $work_category_id)->get();
        $sub_work_category_id = Master::where('MasterHead', 'Sub Work Category')
            ->pluck('id')
            ->first();
        $sub_work_category = MasterValue::where('MasterHead', $sub_work_category_id)->get();
        $mapCategories = MapWorkCategory::get();
        return view('admin.map_item.mapcategory', compact('mapCategories', 'work_category', 'sub_work_category'));
    }

    public function savemapcategory(Request $request)
    {
        if (request()->isMethod('get')) {
            return redirect()->route('mapcategory');
        }
        $work_category = $request->work_category;
        // dd($request->all());
        $sub_work_category = $request->sub_work_category;
        foreach ($sub_work_category as $key => $value) {
            $save = new MapWorkCategory();
            if (!empty($request->Mapcategoryid)) {
                $save = MapWorkCategory::where('id', $request->Mapcategoryid)->first();
            }

            $save->work_category_id = $work_category;
            $save->sub_work_category_id = $value;
            $save->save();
        }
        return redirect()
            ->back()
            ->with('success', 'Mapped Successfully!');
    }

    public function editmapcategory(Request $request)
    {
        $data = MapWorkCategory::find($request->id);
        return json_encode($data, true);
    }

    public function editmapinventorycategory(Request $request)
    {
        $data = MapWorkCategory::find($request->id);
        return json_encode($data, true);
    }

    public function deletemapcategory(Request $request)
    {
        if (!empty($request->id)) {
            $data = MapWorkCategory::find($request->id)->delete();
            return redirect(route('mapcategory'))->with('success', 'Item has been Deleted Successfully!');
        }
        return redirect(route('mapcategory'))->with('error', 'Something Worng try again.!');
    }
}
