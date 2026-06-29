<?php

namespace App\Http\Controllers\Admin\Faq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Faq;
use App\Models\PropertyCategory;


class FaqControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $query = Faq::query();
        
        if ($request->category_id != '') {
            $query->where('category_id', 'like', '%'.$request->category_id.'%');
        }

        
        $faqsCount = $query->count();
        $faqs = $query->paginate(10);
        
        return view('admin.faq.index', compact('faqs','faqsCount','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PropertyCategory::get();
        $faq_info='';
        return view('admin.faq.create', compact('faq_info','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $saveFaq = new Faq();
        $saveFaq->category_id = $request->category_id;
        $saveFaq->question = $request->question;
        $saveFaq->answer = $request->answer;
        $saveFaq->question_cn = $request->question_cn;
        $saveFaq->answer_cn = $request->answer_cn;
        $saveFaq->question_ar = $request->question_ar;
        $saveFaq->answer_ar = $request->answer_ar;
    
        $saveFaq->save();

        return redirect()
            ->back()
            ->with('success', 'Faq has been saved.');
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
        $categories = PropertyCategory::get();
        $faq_info = Faq::where('id', $id)->first();

        return view('admin.faq.update', compact('faq_info','categories'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $faq_id = $id;
        $saveFaq = Faq::find($id);
        $saveFaq->category_id = $request->category_id;
        $saveFaq->question = $request->question;
        $saveFaq->answer = $request->answer;
        $saveFaq->question_cn = $request->question_cn;
        $saveFaq->answer_cn = $request->answer_cn;
        $saveFaq->question_ar = $request->question_ar;
        $saveFaq->answer_ar = $request->answer_ar;
        
        $saveFaq->save();

        return redirect()
            ->back()
            ->with('success', 'Faq has been saved.');
    }

    public function faq_status($id)
    {
        $data = Faq::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('faq.index'))->with('success', 'Faq ' . $msg . ' Successfully!');
        }
        return redirect(route('faq.index'))->with('error', 'Something Worng try again.!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $property = Faq::findOrFail($id);
        $property->delete();
        return redirect()
            ->back()
            ->with('success', 'Faq has been Deleted Successfully!!');
        
    }
    
    public function faq_sorting(Request $request)
    {
        $sortingData = $request->input('sorting'); // Expect an array with category IDs and sorting values
    
        // Loop through the input data and update sorting order for each category
        foreach ($sortingData as $id => $order) {
            Faq::where('id', $id)->update(['sorting_order' => $order]);
        }
    
        return redirect()->back()->with('success', 'Sorting order updated successfully.');
    }
    
    
    private function generateUniqueSlug($slug,$id)
    {
        $originalSlug = $slug;
        $counter = 1;
    
        // Check for existing slug in the database
        while (Faq::where('category_slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
}
