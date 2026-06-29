<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::paginate(10);
        return view('admin.designation.index', compact('designations'));
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
        if (!empty($request->name)) {
            $save = new Designation();

            if ($request->DesignationID) {
                $save = Designation::find($request->DesignationID);
            }
            $save->name = $request->name;
            $save->save();
            if ($save->save()) {
                return redirect()
                    ->back()
                    ->with('success', 'Designation ' . $request->name . 'Saved Successfully!');
            }
        } else {
            return redirect()
                ->back()
                ->with('error', 'Please Enter Designation Name.!');
        }

        return redirect()
            ->back()
            ->with('error', 'Something Worng try again.!');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!empty($id)) {
            $data = Designation::find($id)->delete();
            return redirect(route('designations.index'))->with('success', 'Master Has Been Deleted Successfully!');
        }
        return redirect(route('designations.index'))->with('error', 'Something Worng try again.!');
    }
}
