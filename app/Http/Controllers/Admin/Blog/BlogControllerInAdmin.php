<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Blog;
use App\Models\Master;


class BlogControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        
        
        $blogs = Blog::paginate(10);
        $blogsCount = Blog::count();
        return view('admin.blog.index', compact('blogs','blogsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blog_category = Master::where('MasterHead', 'Blog Category')->first()->getMasterValues ?? [];
        $blog_info='';
        return view('admin.blog.create', compact('blog_info','blog_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $existingBlog = Blog::where('blog_slug', $request->blog_slug)->exists();
        if ($existingBlog) {
            return redirect()->back()->with('error', 'A blog with this slug already exists.');
        }
        
        $saveBlog = new Blog();
        $saveBlog->blog_category = $request->blog_category;
        $saveBlog->title = $request->title;
        $saveBlog->meta_title = $request->meta_title;
        $saveBlog->meta_keywords = $request->meta_keywords;
        $saveBlog->meta_description = $request->meta_description;
        $saveBlog->meta_scripts = $request->meta_scripts;
        
        $saveBlog->blog_date = $request->blog_date;
        $saveBlog->profile_name = $request->profile_name;
        $saveBlog->profile_alt = $request->profile_alt;
        $saveBlog->profile2_name = $request->profile2_name;
        $saveBlog->profile2_alt = $request->profile2_alt;
        $saveBlog->profile_cn_name = $request->profile_cn_name;
        $saveBlog->profile_cn_alt = $request->profile_cn_alt;
        $saveBlog->profile2_cn_name = $request->profile2_cn_name;
        $saveBlog->profile2_cn_alt = $request->profile2_cn_alt;
        $saveBlog->profile_ar_name = $request->profile_ar_name;
        $saveBlog->profile_ar_alt = $request->profile_ar_alt;
        $saveBlog->profile2_ar_name = $request->profile2_ar_name;
        $saveBlog->profile2_ar_alt = $request->profile2_ar_alt;
        
        $slug = Str::slug($request->title, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,0);
        //$saveBlog->blog_slug = $uniqueSlug; 
        $saveBlog->blog_slug = $request->blog_slug;
        
        $saveBlog->description = $request->description;
       
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile = $FileName;
        }
        
        if ($request->hasFile('profile2')) {
            $file = $request->file('profile2');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile2 = $FileName;
        }
        
        $saveBlog->title_cn = $request->title_cn;
        $saveBlog->description_cn = $request->description_cn;
        if ($request->hasFile('profile_cn')) {
            $file = $request->file('profile_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile_cn = $FileName;
        }
        
        if ($request->hasFile('profile2_cn')) {
            $file = $request->file('profile2_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile2_cn = $FileName;
        }
        
        $saveBlog->title_ar = $request->title_ar;
        $saveBlog->description_ar = $request->description_ar;
        if ($request->hasFile('profile_ar')) {
            $file = $request->file('profile_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile_ar = $FileName;
        }
        
        if ($request->hasFile('profile2_ar')) {
            $file = $request->file('profile2_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile2_ar = $FileName;
        }

        $saveBlog->save();



        return redirect()
            ->back()
            ->with('success', 'Blog has been saved.');
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
        $blog_category = Master::where('MasterHead', 'Blog Category')->first()->getMasterValues ?? [];
        $blog_info = Blog::where('id', $id)->first();

        return view('admin.blog.update', compact('blog_info','blog_category'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $existingBlog = Blog::where('blog_slug', $request->blog_slug)->where('id', '!=', $id)->exists();
        if ($existingBlog) {
            return redirect()->back()->with('error', 'A blog with this slug already exists.');
        }
        
        $blog_id = $id;
        $saveBlog = Blog::find($id);
        $saveBlog->blog_category = $request->blog_category;
        $saveBlog->title = $request->title;
        $saveBlog->meta_title = $request->meta_title;
        $saveBlog->meta_keywords = $request->meta_keywords;
        $saveBlog->meta_description = $request->meta_description;
        $saveBlog->meta_scripts = $request->meta_scripts;
        
        $saveBlog->blog_date = $request->blog_date;
        $saveBlog->profile_name = $request->profile_name;
        $saveBlog->profile_alt = $request->profile_alt;
        $saveBlog->profile2_name = $request->profile2_name;
        $saveBlog->profile2_alt = $request->profile2_alt;
        $saveBlog->profile_cn_name = $request->profile_cn_name;
        $saveBlog->profile_cn_alt = $request->profile_cn_alt;
        $saveBlog->profile2_cn_name = $request->profile2_cn_name;
        $saveBlog->profile2_cn_alt = $request->profile2_cn_alt;
        $saveBlog->profile_ar_name = $request->profile_ar_name;
        $saveBlog->profile_ar_alt = $request->profile_ar_alt;
        $saveBlog->profile2_ar_name = $request->profile2_ar_name;
        $saveBlog->profile2_ar_alt = $request->profile2_ar_alt;
        
        
        $slug = Str::slug($request->title, '-');
        $uniqueSlug = $this->generateUniqueSlug($slug,$id);
        $saveBlog->blog_slug = $request->blog_slug; 
        
        $saveBlog->description = $request->description;
       
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile = $FileName;
        }
        
        if ($request->hasFile('profile2')) {
            $file = $request->file('profile2');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile2 = $FileName;
        }
        
        $saveBlog->title_cn = $request->title_cn;
        $saveBlog->description_cn = $request->description_cn;
        if ($request->hasFile('profile_cn')) {
            $file = $request->file('profile_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile_cn = $FileName;
        }
        
        if ($request->hasFile('profile2_cn')) {
            $file = $request->file('profile2_cn');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile2_cn = $FileName;
        }
        
        $saveBlog->title_ar = $request->title_ar;
        $saveBlog->description_ar = $request->description_ar;
        if ($request->hasFile('profile_ar')) {
            $file = $request->file('profile_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile_ar = $FileName;
        }
        
        if ($request->hasFile('profile2_ar')) {
            $file = $request->file('profile2_ar');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/blog'), $FileName);
            $saveBlog->profile2_ar = $FileName;
        }
        
        $saveBlog->save();



        return redirect()
            ->back()
            ->with('success', 'Blog has been saved.');
    }

    public function blog_status($id)
    {
        $data = Blog::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('blog.index'))->with('success', 'Blog ' . $msg . ' Successfully!');
        }
        return redirect(route('blog.index'))->with('error', 'Something Worng try again.!');
    }

    public function mapBlogPropertyRoom(Request $request)
    {
        
        //dd($request->all());

        $blog_ids = $request->blog_ids;
        if($blog_ids!=''){
        foreach ($blog_ids as $blog_key => $blog_id) {
            

            $isadded = PropertyRoomBlog::where('property_id', $request->inv_property_id)->where('room_id', $request->inv_room_id)->where('blog_id', $blog_id)->orderBy('id', 'DESC')->pluck('id')->first();
            if($isadded<1){
                $savePropertyRoomBlog = new PropertyRoomBlog();
                $savePropertyRoomBlog->property_id = $request->inv_property_id;
                $savePropertyRoomBlog->room_id = $request->inv_room_id;
                $savePropertyRoomBlog->blog_id = $blog_id;
    
                $savePropertyRoomBlog->save();

                $saveBlog = Blog::find($blog_id);
                $saveBlog->is_available = '0';
                $saveBlog->property_id = $request->inv_property_id;
                $saveBlog->room_id = $request->inv_room_id;
                $saveBlog->map_date = date("Y-m-d H:i:s");
                $saveBlog->save();

            }
            
            
        }
        }

      
            return redirect()->back()->with('success', 'Blog added Successfully!');
            //return redirect(route('blog.index'))->with('success', 'Blog ' . $msg . ' Successfully!');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $property = Blog::findOrFail($id);
        $property->delete();
        return redirect()
            ->back()
            ->with('success', 'Blog has been Deleted Successfully!!');
        
    }
    
    
    private function generateUniqueSlug($slug,$id)
    {
        $originalSlug = $slug;
        $counter = 1;
    
        // Check for existing slug in the database
        while (Blog::where('blog_slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
    
}
