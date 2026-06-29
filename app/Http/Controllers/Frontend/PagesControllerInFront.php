<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PagesControllerInFront extends Controller
{
    public function index(Request $request)
    {
        $slug = $request->slug;

        $pageDetails = Page::where('slug', $slug)->first();
        return view('frontend.page', compact('pageDetails'));
    }
}
