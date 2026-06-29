<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master;
use App\Models\MasterValue;
use Str;

class MasterValueControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = MasterValue::query();
        if ($request->master != '') {
            $query->where('MasterHead', $request->master);
        }
        if ($request->search_text != '') {
            $query->where('MasterValue', 'LIKE', '%'.$request->search_text.'%');
        }
        $master_values = $query->get();
        
        $master = Master::where('status', 1)->orderby('id', 'desc')->get();
        return view('admin.master_value.index', compact('master_values', 'master', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $MasterValue = explode(',', $request->MasterValue);
        $loop = sizeof($MasterValue);
        for ($i = 0; $i < $loop; $i++) {
            if (!empty($request->MasterValueid)) {
                $data = MasterValue::find($request->MasterValueid);
            } else {
                $data = new MasterValue();
            }

            $data->MasterHead = $request->MasterHead;

            $data->MasterValue = $MasterValue[$i];

            $data->created_by = auth()->user()->id;
            // if ($request->hasFile('MasterValueIcon')) {
            //     $imgname = $request->file('MasterValueIcon');
            //     $filename = $MasterValue[$i] . rand(111, 999) . date('Ymdhis') . '.' . $imgname->extension();
            //     // $imgname->move('document', $filename, 'public');
            //     $imgname->move(public_path('uploads/document'), $filename);

            //     $data['MasterValueIcon'] = $filename;
            // }

            $FileName = '';
            if ($request->hasFile('MasterValueIcon')) {
                $file = $request->file('MasterValueIcon');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('uploads/master'), $FileName);
                $data['MasterValueIcon'] = $FileName;
            }
            $data->save();
        }
        return redirect(route('mastervalues.index'))->with('success', 'Master Values Created Successfully!');
    }

    public function master_values_status($id)
    {
        $data = MasterValue::find($id);

        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('mastervalues.index'))->with('success', 'Master ' . $msg . ' Successfully!');
        }
        return redirect(route('mastervalues.index'))->with('error', 'Something Worng try again.!');
    }

    public function editmastervalue(Request $request)
    {
        $data = MasterValue::find($request->id);
        return json_encode($data, true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!empty($id)) {
            $data = MasterValue::find($id)->delete();
            return redirect(route('mastervalues.index'))->with('success', 'Master Value Has Been Deleted Successfully!');
        }
        return redirect(route('mastervalues.index'))->with('error', 'Something Worng try again.!');
    }
}
