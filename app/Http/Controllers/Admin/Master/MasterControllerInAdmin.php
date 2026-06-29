<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master;
use Str;

class MasterControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Master::query();
        
        if ($request->search_text != '') {
            $query->where('MasterHead', 'LIKE', '%'.$request->search_text.'%');
        }
        $masters = $query->get();
        return view('admin.master.index', compact('masters','request'));
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
        if ($request->MasterHead) {
            if (!empty($request->MasterHeadID)) {
                $data = Master::find($request->MasterHeadID);
            } else {
                $data = new Master();
            }
            $data->MasterHead = $request->MasterHead;
            $data->created_by = auth()->user()->id;
            $FileName = '';
            if ($request->hasFile('MasterIcon')) {
                $file = $request->file('MasterIcon');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('uploads/master'), $FileName);
                $data['MasterIcon'] = $FileName;
            }
            $data->save();
            return redirect(route('masters.index'))->with('success', 'Master Created Successfully!');
        }
        return redirect(route('masters.index'))->with('error', 'Master Head is required field!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function master_status($id)
    {
        $data = Master::find($id);

        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('masters.index'))->with('success', 'Master ' . $msg . ' Successfully!');
        }
        return redirect(route('masters.index'))->with('error', 'Something Worng try again.!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!empty($id)) {
            $data = Master::find($id)->delete();
            return redirect(route('masters.index'))->with('success', 'Master Has Been Deleted Successfully!');
        }
        return redirect(route('masters.index'))->with('error', 'Something Worng try again.!');
    }
}
