<?php

namespace App\Http\Controllers\Admin\Review;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\Review;


class ReviewInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Review::query();
        
        if ($request->search_text != '') {
            $query->where('title', 'LIKE', '%'.$request->search_text.'%');
        }
        if ($request->brand != '') {
            $query->where('brand', $request->brand);
        }
        
        $reviews = $query->paginate(10);
        $reviewsCount = $query->count();
        
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.review.index', compact('reviews','reviewsCount','brands','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $review_info='';
        $brands=Brand::where('id','!=','')->get();
        return view('admin.review.create', compact('review_info','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveReview = new Review();
        $saveReview->full_name = $request->full_name;
        $saveReview->rating = $request->rating;
        $saveReview->adddate = $request->adddate;
        $saveReview->title = $request->title;
        $saveReview->description = $request->description;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveReview->profile = $FileName;
        }

        $saveReview->save();



        return redirect()
            ->back()
            ->with('success', 'Review has been saved.');
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
        $review_info = Review::where('id', $id)->first();
        $brands=Brand::where('id','!=','')->get();
        
        return view('admin.review.update', compact('review_info','brands'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveReview = Review::find($id);
        $saveReview->full_name = $request->full_name;
        $saveReview->rating = $request->rating;
        $saveReview->adddate = $request->adddate;
        $saveReview->title = $request->title;
        $saveReview->description = $request->description;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveReview->profile = $FileName;
        }
        
        $saveReview->save();



        return redirect()
            ->back()
            ->with('success', 'Review has been saved.');
    }

    public function banner_status($id)
    {
        $data = Review::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'Review ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()
            ->back()
            ->with('success', 'Review has been Deleted Successfully!!');
    }
}
