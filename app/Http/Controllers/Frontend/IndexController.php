<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Services\TwilioService;


use App\Models\Banner;
use App\Models\Property;
use App\Models\Review;
use App\Models\PropertyCategory;
use App\Models\PropertyCategoryMain;
use App\Models\ConsultationForm;
use App\Models\Blog;
use App\Models\Clinic;
use App\Models\CheckedService;
use App\Models\Master;
use App\Models\Addon;
use App\Models\Professional;
use App\Models\KiBooking;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Team;
use App\Models\Faq;
use App\Models\Search;
use App\Models\SubscribeForm;
use App\Models\Redurl;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
class IndexController extends Controller
{
    
    public function __construct()
    {
        
        // Define category mappings
        $categoriesMap = [
            'categories' => ['parent_id', 0],
            'hair_restoration' => ['main_category', 22],
            'laser_hair_removal' => ['main_category', 3],
            'tattoo_removal' => ['main_category', 23],
            'tattoo_removal_machine' => ['main_category', 24],
            'semi_tattoo_removal_machine' => ['main_category', 25],
            'skin_treatments' => ['main_category', 26],
            'skin_treatments_machine' => ['main_category', 27],
            'ipl_treatments' => ['main_category', 28],
            'skin_combination_packages' => ['main_category', 29],
            'body_treatments' => ['main_category', 30],
            'body_treatments_machines' => ['main_category', 31],
            'body_treatments_area' => ['main_category', 32],
            'body_combination_packages' => ['main_category', 33],
            'medical' => ['main_category', 34],
            'injectables' => ['main_category', 35],
            'medical_team' => ['main_category', 36],
            'dermatology' => ['main_category', 21],
            
            'body_sculpting' => ['main_category', 19],
            'medical_injectables' => ['main_category', 20],
        ];

        // Fetch categories dynamically  
        foreach ($categoriesMap as $key => [$column, $value]) {
            $this->menudata[$key] = PropertyCategory::where($column, $value)->where('status', '1')->get();
        }
        $this->menudata['conditions'] = PropertyCategory::where('is_condition', '1')->where('is_top', '1')->where('status', '1')->orderBy('sorting_order','asc')->get();
        $this->menudata['clinics'] = Clinic::where('id','!=', 0)->get();
        $this->menudata['medical_teams'] = Team::where('id','!=', 0)->where('status','1')->get();
    }

    public function sendManuallMail() {
        Mail::html('<p>This is a direct HTML message without any Blade view.</p>', function ($message) {
            $message->to('jenishghadiya43@gmail.com')
                    ->subject('Direct HTML Email')
                    ->from('devolyt.developer@gmail.com', 'Your App Name');
        });
    }
    
    public function sendTestSms(TwilioService $twilio)
    {
        $twilio->sendSms('+447538943431', 'Hello from Laravel via Twilio!');
        return "SMS sent successfully.";
    }
    
    public function index()
    {
        
        $menudata = $this->menudata;
        $home_categories = PropertyCategory::where('parent_id', 0)->where('status', '1')->where('id','!=', 1)->where('is_condition', '0')->orderBy('sorting_order', 'asc')->limit(28)->get();
        $home_drop_categories = PropertyCategory::where('parent_id', 0)->where('id','!=', 1)->where('is_condition', '0')->orderBy('sorting_order', 'asc')->get();
        
        $clinics = Clinic::where('id','!=', 0)->get();
        $customersHappiness = Banner::where('id','22')->first();
        $qrCode = Banner::where('id','23')->first();
        $clinicVideoText = Banner::where('id','24')->first();
        $topRatedDestination = Banner::where('id','25')->first();
        $forBusiness = Banner::where('id','26')->first();
        $requestAConsultation = Banner::where('id','27')->first();
        
        $customdata['customersHappiness']=$customersHappiness;
        $customdata['qrCode']=$qrCode;
        $customdata['clinicVideoText']=$clinicVideoText;
        $customdata['topRatedDestination']=$topRatedDestination;
        $customdata['forBusiness']=$forBusiness;
        $customdata['requestAConsultation']=$requestAConsultation;
        
        $home_top_banner = Banner::where('banner_type','Home Top Banner')->get();
        $reviewsHome = Review::where('status', '1')->limit(20)->get();
        $reviews = Review::where('status','1')->get();
        $recently_services = Property::where('id', '!=', '')->where('status', '=', '1')->inRandomOrder()->paginate(10);
        $recommended_services = Property::where('id', '!=', '')->where('status', '=', '1')->where('property_category', '!=', '')->inRandomOrder()->paginate(10);
        $new_services = Property::where('id', '!=', '')->where('status', '=', '1')->inRandomOrder()->paginate(10);
        $trending_services = Property::where('id', '!=', '')->where('status', '=', '1')->inRandomOrder()->paginate(10);
        
        $addons = Addon::where('id', '!=', '')->where('status', '=', '1')->inRandomOrder()->paginate(20);
        $teams = Team::where('status','1')->get();
        $home_special_offer = PropertyCategory::where('parent_id', 0)
            ->where('id', '!=', 1)
            ->where('is_condition', '0')
            ->orderBy('sorting_order', 'asc')
            ->limit(10)
            ->get();
        
        return view('frontend.index', compact('menudata','teams','home_top_banner','home_categories','home_drop_categories','recently_services','recommended_services','home_special_offer',
        'new_services','trending_services','addons','reviews','reviewsHome','clinics','customdata'));
    }
    
    public function pagenotfound(Request $request)
    {
        
        $menudata = $this->menudata;
        
        return view('frontend.pagenotfound', compact('menudata'));
    }
    
    public function team(Request $request)
    {
        
        $menudata = $this->menudata;
        $home_top_banner = Banner::where('banner_type','Team')->get();
        
        $query = Team::query();
        $query->where('status','1');
        $teams = $query->orderByDesc('id')->paginate(9);
        
        
        return view('frontend.team', compact('menudata','teams','home_top_banner'));
    }
    
    public function team_details()
    {
        $menudata = $this->menudata;
        
        //$teamdetails = Blog::where('team_slug', $id)->get()->first();
        $teamdetails = '';
        
        $teams = Team::where('status', 1)->limit(6)->get();
        return view('frontend.teamdetails', compact('menudata','teams','teamdetails'));
    }
    
    public function blog(Request $request)
    {
        
        $menudata = $this->menudata;
        $blog_category = Master::where('MasterHead', 'Blog Category')->first()->getMasterValues ?? [];
        
        $query = Blog::query();
        $query->where("status", 1);
        if ($request->search_text != '') {
            $search_textarr = explode(' ',$request->search_text);
            $query->where(function ($query) use ($request,$search_textarr) {
                $query->where("title","like",'%'.$request->search_text.'%')
                ->orWhere("description","like",'%'.$request->search_text.'%');
            });
        }
        if ($request->cat != '') {
            $query->where(function ($query) use ($request) {
                $query->where("blog_category",$request->cat);
            });
        }
        
        $blogs = $query->orderByDesc('id')->paginate(9);
        
        
        return view('frontend.blog', compact('menudata','blog_category','blogs','request'));
    }
    
    public function blog_details($id)
    {
        $menudata = $this->menudata;
        $blog_category = Master::where('MasterHead', 'Blog Category')->first()->getMasterValues ?? [];
        $requestAConsultation = Banner::where('id','27')->first();
        $customdata['requestAConsultation']=$requestAConsultation;
        
        $clinics = Clinic::where('id','!=', 0)->get();
        $blogdetails = Blog::where('blog_slug', $id)->get()->first();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $blogs = Blog::where('status', 1)->limit(6)->get();
        return view('frontend.blogdetails', compact('menudata','blog_category','clinics','blogs','blogdetails','customdata'));
    }
    
    public function allcondition()
    {
        
        $menudata = $this->menudata;
        
        $conditions = PropertyCategory::where('is_condition', '1')->where('parent_ids', null)->where('status', '1')->orderBy('sorting_order','asc')->get();
        $teams = Team::where('status','1')->get();
        
        return view('frontend.allcondition', compact('menudata','teams','conditions'));
    }
    
    public function allservices()
    {
        
        $menudata = $this->menudata;
        
        $conditions = PropertyCategory::where('is_condition', '0')->where('parent_ids', null)->where('status', '1')->orderBy('sorting_order','asc')->get();
        $teams = Team::where('status','1')->get();
        
        return view('frontend.allservices', compact('menudata','teams','conditions'));
    }
    
    
    public function allservice2($catid)
    {
    
        $menudata = $this->menudata;
        $blogdetails = Blog::where('blog_slug', $catid)->first();
        if ($blogdetails) {
            $blog_category = Master::where('MasterHead', 'Blog Category')->first()->getMasterValues ?? [];
            $requestAConsultation = Banner::where('id','27')->first();
            $customdata['requestAConsultation']=$requestAConsultation;
            
            $clinics = Clinic::where('id','!=', 0)->get();
            //$blogdetails = Blog::where('blog_slug', $id)->get()->first();
            $categories = PropertyCategory::where('parent_id', 0)->get();
            $blogs = Blog::where('status', 1)->limit(6)->get();
            return view('frontend.blogdetails', compact('menudata','blog_category','clinics','blogs','blogdetails','customdata'));
        }
        
        $menudata = $this->menudata;
        $teamdetails = Team::where('team_slug', $catid)->first();
        if ($teamdetails) {
            $work_conditionarr=explode(",",$teamdetails->work_condition);
            $work_categoryarr=explode(",",$teamdetails->work_category);
            $categories = PropertyCategory::where('is_condition', '0')->where('parent_ids', null)->where('status', '1')->whereIn('id', $work_categoryarr)->orderBy('sorting_order','asc')->get();
            $conditions = PropertyCategory::where('is_condition', '1')->where('parent_ids', null)->where('status', '1')->whereIn('id', $work_conditionarr)->orderBy('sorting_order','asc')->get();
            return view('frontend.teamdetails', compact('menudata','teamdetails','categories','conditions'));
        }
        
        $category = PropertyCategory::where('category_slug', $catid)->first();
        if (!$category) {
            $redurl = Redurl::where('old_url', $catid)->value('redirect_url'); 
            if ($redurl) {
                //$category = PropertyCategory::where('category_slug', $redurl)->first();
                return redirect(url('/'.$redurl));
            }
        }
        
        if (preg_match('/(>|%3|%22|%5C|%3C)/i', $catid)) { 
            return redirect('/');
        }
        
        if (!$category) {
            //return view('frontend.pagenotfound', compact('menudata'));
            abort(404);
        }
        
        //$subcategories = PropertyCategory::where('parent_ids', $category->id)->get();
        $subcategories = PropertyCategory::whereJsonContains('parent_ids', strval($category->id))->orWhereJsonContains('parent_ids2', strval($category->id))->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
        
        
        $services = Property::where('id', '!=', '')
        ->where(function ($query) use ($category) {
            $query->whereJsonContains('property_category', strval($category->id))
                  ->orWhereJsonContains('skin_condition', strval($category->id));
        })
        ->where('status', '1')
        ->orderByDesc('id')
        ->get();
        
        $home_top_banner = Banner::where('banner_type','Category Details Top Banner')->get();
        
        $faqs = Faq::where('category_id',$category->id)->get();
        
        $teams = Team::where('status','1')->get();
        
        return view('frontend.allservice', compact('menudata','teams','addoncats','category','subcategories','services','home_top_banner','faqs'));
    }
    
    public function allservice($catid)
    {
        
        $menudata = $this->menudata;
        $category = PropertyCategory::where('category_slug', $catid)->first();
        //$subcategories = PropertyCategory::where('parent_ids', $category->id)->get();
        $subcategories = PropertyCategory::whereJsonContains('parent_ids', strval($category->id))->orWhereJsonContains('parent_ids2', strval($category->id))->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
        
        
        $services = Property::where('id', '!=', '')
        ->where(function ($query) use ($category) {
            $query->whereJsonContains('property_category', strval($category->id))
                  ->orWhereJsonContains('skin_condition', strval($category->id));
        })
        ->where('status', '1')
        ->orderByDesc('id')
        ->get();
        
        $home_top_banner = Banner::where('banner_type','Category Details Top Banner')->get();
        
        $faqs = Faq::where('category_id',$category->id)->get();
        
        $teams = Team::where('status','1')->get();
        
        return view('frontend.allservice', compact('menudata','teams','addoncats','category','subcategories','services','home_top_banner','faqs'));
    }
    
    public function homesearchbox(Request $request)
    {
        
        $searchbox = $request->searchbox;
        if($searchbox!=''){
            $saveSearch = new Search();
            $saveSearch->searchbox = $request->searchbox;
            $saveSearch->save();
        }
        $menudata = $this->menudata;
        $category = PropertyCategory::where('id', $request->cid)->first();
        //$categories = PropertyCategory::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
        
        $services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->get();
        
        $home_top_banner = Banner::where('banner_type','Category Details Top Banner')->get();
        
        $query = Blog::query();
        $query->where("status", 1);
        $query->where(function ($query) use ($searchbox) {
            $query->where("title","like",'%'.$searchbox.'%')
            ->orWhere("description","like",'%'.$searchbox.'%');
        });
        $blogs = $query->orderByDesc('id')->paginate(9);
        
        $categories = PropertyCategory::where('category_name', 'like', '%'.$request->searchbox.'%')->where('parent_id', '0')->where('status', '1')->get();
        
        return view('frontend.search', compact('menudata','request','blogs','categories'));
    }
    
    public function homesearchservice(Request $request)
    {
        
        $menudata = $this->menudata;
        $category = PropertyCategory::where('id', $request->cid)->first();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
        
        $services = Property::where('id', '!=', '')->where('property_category', $category->id)->where('status', '=', '1')->orderByDesc('id')->get();
        
        $home_top_banner = Banner::where('banner_type','Category Details Top Banner')->get();
        
        $faqs = Faq::where('category_id',$category->id)->get();
        
        return view('frontend.allservice', compact('menudata','addoncats','category','services','home_top_banner','faqs'));
    }
    
    public function contact()
    {
        $home_top_banner = Banner::where('banner_type','Conatct Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.contact', compact('menudata','home_top_banner','categories','clinics'));
    }
    
    public function contact_us()
    {
        $home_top_banner = Banner::where('banner_type','Conatct Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.contact-us', compact('menudata','home_top_banner','categories','clinics'));
    }
    
    public function referral()
    {
        $home_top_banner = Banner::where('banner_type','Conatct Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.referral', compact('menudata','home_top_banner','categories','clinics'));
    }
    
    public function about()
    {
        $home_top_banner = Banner::where('banner_type','About Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $teams = Team::where('status','1')->get();
        return view('frontend.about', compact('menudata','teams','home_top_banner','categories','clinics'));
    }
    
    public function faq()
    {
        $home_top_banner = Banner::where('banner_type','About Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
    
        $categories = PropertyCategory::where('parent_id', 0)->get();
    
        // attach subcategories
        foreach($categories as $category)
        {
            $category->subcategories = PropertyCategory::whereJsonContains('parent_ids', strval($category->id))
                ->orWhereJsonContains('parent_ids2', strval($category->id))
                ->get();
        }
    
        $teams = Team::where('status','1')->get();
    
        return view('frontend.faq', compact('menudata','teams','home_top_banner','categories','clinics'));
    }
    
    public function reviews()
    {
        $home_top_banner = Banner::where('banner_type','About Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $teams = Team::where('status','1')->get();
    
        $reviews = Review::where('status','1')->limit(7)->get()->map(function($review)
        {
            return [
                'name'     => $review->full_name,
                'stars'    => (int) $review->rating,
                'location' => $review->location ?? 'Thérapie Clinic',
                'date'     => date('M d, Y', strtotime($review->adddate)),
                'text'     => $review->description,
                'source'   => 'Google',
            ];
        });
    
        return view('frontend.reviews', compact('menudata','reviews','teams','home_top_banner','categories','clinics'));
    }
    
    public function finance_options()
    {
        $home_top_banner = Banner::where('banner_type','About Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $teams = Team::where('status','1')->get();
        return view('frontend.finance-options', compact('menudata','teams','home_top_banner','categories','clinics'));
    }
    
    public function locations()
    {
        $home_top_banner = Banner::where('banner_type','About Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $teams = Team::where('status','1')->get();
        
        // repare JS data here (SAFE)
        $locs = [];
    
        foreach ($clinics as $c)
        {
            $now = date('H:i:s');
    
            $status = ($now < $c->clinic_close_time) ? 'Open' : 'Closed';
    
            $locs[] = [
                'id' => 'clinic_' . $c->id,
                'slug' => $c->clinic_slug,
                'name' => $c->clinic_name,
                'country' => 'UK',
                'address' => $c->address,
                'status' => $status,
                'closes' => 'Closes at ' . date('g:i A', strtotime($c->clinic_close_time)),
                'q' => !empty($c->address) ? $c->address : $c->address,
            ];
        }
        
        return view('frontend.locations', compact('menudata','teams','home_top_banner','categories','clinics','locs'));
    }
    
    public function locations_details($slug)
    {
    $id = (int) preg_replace('/\D/', '', $slug);

$clinic = Clinic::find($id);

        if (!$clinic) {
            abort(404);
        }
        
        $home_top_banner = Banner::where('banner_type','About Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $teams = Team::where('status','1')->get();
        $reviews = Review::where('status', '1')->latest()->limit(10)->get();
        return view('frontend.locations-details', compact('menudata','teams','home_top_banner','categories','clinics','clinic','reviews'));
    }
    
    public function pricing()
    {
        $home_top_banner = Banner::where('banner_type','About Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $teams = Team::where('status','1')->get();
        return view('frontend.pricing', compact('menudata','teams','home_top_banner','categories','clinics'));
    }
    
    public function pricing_detail($slug)
    {
        $home_top_banner = Banner::where('banner_type','About Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $teams = Team::where('status','1')->get();
        $childCat = $menudata[$slug];
        
        return view('frontend.pricing-detail', compact('menudata','teams','home_top_banner','categories','childCat'));
    }
    
    public function refund_policy()
    {
        $home_top_banner = Banner::where('banner_type','Refund Policy Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.refund_policy', compact('menudata','home_top_banner','categories','clinics'));
    }
    
    public function terms_conditions()
    {
        $home_top_banner = Banner::where('banner_type','Term & Condition Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.terms_conditions', compact('menudata','home_top_banner','categories','clinics'));
    }
    
    public function privacy_policy()
    {
        $home_top_banner = Banner::where('banner_type','Privacy Policy Top Banner')->get();
        $menudata = $this->menudata;
        $clinics = Clinic::where('id','!=', 0)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.privacy_policy', compact('menudata','home_top_banner','categories','clinics'));
    }
    
    public function shop()
    {
        
        $menudata = $this->menudata;
        //return $services = PropertyCategory::with('categoryServices')->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
        //$addon_categories = Master::where('MasterHead', 'Addon Category')->with('categoryAddons')->get();
        
        $addons = Addon::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(12);
        
        $home_top_banner = Banner::where('banner_type','Shop Top Banner')->get();
        
        return view('frontend.shop', compact('menudata','categories','addoncats','addons','home_top_banner'));
    }
    
    public function services($catid,$id)
    {
        $systems = CheckedService::where('stype', 'service')->where('system_id', session('uuid'))->get();
        
        //return $services = PropertyCategory::with('categoryServices')->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $service_categories = PropertyCategory::where('parent_id', 0)->with('categoryServices')->get();
        $customersHappiness = Banner::where('id','22')->first();
        $qrCode = Banner::where('id','23')->first();
        $clinicVideoText = Banner::where('id','24')->first();
        $topRatedDestination = Banner::where('id','25')->first();
        $forBusiness = Banner::where('id','26')->first();
        $requestAConsultation = Banner::where('id','27')->first();
        
        $customdata['customersHappiness']=$customersHappiness;
        $customdata['qrCode']=$qrCode;
        $customdata['clinicVideoText']=$clinicVideoText;
        $customdata['topRatedDestination']=$topRatedDestination;
        $customdata['forBusiness']=$forBusiness;
        $customdata['requestAConsultation']=$requestAConsultation;
        
        $home_top_banner = Banner::where('banner_type','Service Top Banner')->get();
        $teams = Team::where('status','1')->get();
        $clinics = Clinic::where('id', '!=', '')->get();
        $reviews = Review::where('status','1')->get();
        $recently_services = Property::where('id', '!=', '')->where('status', '=', '1')->inRandomOrder()->paginate(20);
        $recommended_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
        $new_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
        $trending_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
        
        return view('frontend.services', compact('home_top_banner','teams','recently_services','recommended_services','new_services',
        'trending_services','reviews','categories','customdata','service_categories','systems', 'clinics', 'id', 'catid'));
    }
    
    
    
    
    
    public function shop_details($id)
    {   
         $menudata = $this->menudata;
        if (is_numeric($id)) {
        $addondetails = Addon::where('id', $id)->first();
    } else {
        $addondetails = Addon::where('addon_slug', $id)->first();
    }
        $addons = Addon::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(12);
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.shopdetails', compact('menudata','categories','addons','addondetails'));
    }
    
    public function cart()
    {
        
        $menudata = $this->menudata;
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $productsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
                ->where('system_id', session('uuid'))
                ->where('stype', 'product')
                ->get();
        
        return view('frontend.cart', compact('menudata','categories','productsystems'));
    }
    
    
    public function web_checkout()
    {
        
        $menudata = $this->menudata;
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $productsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
                ->where('system_id', session('uuid'))
                ->where('stype', 'product')
                ->get();
        
        return view('frontend.web-checkout', compact('menudata','categories','productsystems'));
    }
    
    
    public function web_checkout_process(Request $request)
    {
        
        $productsystems = CheckedService::with('getCheckedAddon') 
                ->where('system_id', session('uuid'))
                ->where('stype', 'product')
                ->get();
        if ($productsystems->isEmpty()) {
            return redirect(url('shop')); // Redirect to the URL
        }
        
        $query = Customer::query();
        $query->where("mobile","=",$request->billing_phone)->whereOr("email","=",$request->billing_email);
        $customer = $query->orderByDesc('id')->first();
        
        $user_id = @$customer->id;
        
        if(@$user_id==''){
           
            
            $saveCustomer = new Customer();
            $saveCustomer->first_name = $request->billing_first_name;
            $saveCustomer->last_name = $request->billing_last_name;
            $saveCustomer->mobile = $request->billing_phone;
            $saveCustomer->email = $request->billing_email;
            
            $saveCustomer->save();
            
            $user_id = $saveCustomer->id;
            
        }
        
        
        $billing_first_name = $request->billing_first_name;
        $billing_last_name = $request->billing_last_name;
        $billing_phone = $request->billing_phone;
        $billing_email = $request->billing_email;
        $billing_company = $request->billing_company;
        $billing_country = $request->billing_country;
        $billing_address_1 = $request->billing_address_1;
        $billing_city = $request->billing_city;
        $billing_postcode = $request->billing_postcode;
        $order_amount = $request->order_amount;
        
        $payment_method = $request->payment_method;
        
            
                
        $saveOrder = new Order();
        $saveOrder->user_id = $user_id;
        $saveOrder->billing_first_name = $request->billing_first_name;
        $saveOrder->billing_last_name = $request->billing_last_name;
        $saveOrder->billing_phone = $request->billing_phone;
        $saveOrder->billing_email = $request->billing_email;
        $saveOrder->billing_company = $request->billing_company;
        $saveOrder->billing_country = $request->billing_country;
        $saveOrder->billing_address_1 = $request->billing_address_1;
        $saveOrder->billing_city = $request->billing_city;
        $saveOrder->billing_postcode = $request->billing_postcode;
        $saveOrder->order_amount = $request->order_amount;
        $saveOrder->payment_method = $request->payment_method;
        $saveOrder->cart_details = $productsystems->toJson();
        
        $saveOrder->save();
        
        $data=[
                'order_id'=>$saveOrder->id,
            ];
        
       
        
        
        session()->forget('uuid');
        
        return redirect()
            ->route('order-success')
            ->with('success', 'Order has been created successfully!!');
    }
    
    public function update_cart(Request $request)
    {
        $ids = $request->ids;
        $item = $request->item;
        
        foreach ($ids as $key => $id) {
            $service = CheckedService::find($id); // Find the record by ID
    
            if ($service) {
                $service->item = $item[$key]; // Update the item field
                $service->save(); // Save the updated record
            }
        }
        
        return redirect()
            ->back()
            ->with('success', 'Cart has been updated successfully!!');
    }
    
    public function addon()
    {
        $systems = CheckedService::where('stype', 'service')->where('system_id', session('uuid'))->get();
        if ($systems->isEmpty()) {
            return redirect(url('services/0/0')); // Redirect to the URL
        }
        
        $addonsystems = CheckedService::where('stype', 'addon')->where('system_id', session('uuid'))->get();
        
        //return $services = PropertyCategory::with('categoryServices')->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
      //  $addon_categories = Master::where('MasterHead', 'Addon Category')->with('categoryAddons')->get();
        $service_categories = PropertyCategory::where('parent_id', 0)->with('categoryServices')->get();
        $customersHappiness = Banner::where('id','22')->first();
        $qrCode = Banner::where('id','23')->first();
        $clinicVideoText = Banner::where('id','24')->first();
        $topRatedDestination = Banner::where('id','25')->first();
        $forBusiness = Banner::where('id','26')->first();
        $requestAConsultation = Banner::where('id','27')->first();
        
        $customdata['customersHappiness']=$customersHappiness;
        $customdata['qrCode']=$qrCode;
        $customdata['clinicVideoText']=$clinicVideoText;
        $customdata['topRatedDestination']=$topRatedDestination;
        $customdata['forBusiness']=$forBusiness;
        $customdata['requestAConsultation']=$requestAConsultation;
        
        $home_top_banner = Banner::where('banner_type','Addon Top Banner')->get();
        $reviews = Review::where('status','1')->get();
        $recently_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(10);
        $recommended_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(10);
        $new_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(10);
        $trending_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(10);
        
        return view('frontend.addon', compact('home_top_banner','recently_services','recommended_services','new_services',
        'trending_services','reviews','categories','customdata','service_categories','addoncats','systems','addonsystems'));
    }
    
    public function professional_time()
    {
        
        $currentMonth = Carbon::now()->format('F Y');
        $dates = [];
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays(29); // Adding 29 days to include today
    
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates[] = [
                'date' => $date->format('d'),
                'day' => $date->format('D'),
                'monthYear' => $date->format('F Y'),
                'slot_date' => $date->format('d M'),
            ];
        }
        
        
        
        $systems = CheckedService::where('stype', 'service')->where('system_id', session('uuid'))->get();
        if ($systems->isEmpty()) {
            return redirect(url('services/0/0')); // Redirect to the URL
        }
        
        $addonsystems = CheckedService::where('stype', 'addon')->where('system_id', session('uuid'))->get();
        // if ($addonsystems->isEmpty()) {
        //     return redirect(url('addon')); // Redirect to the URL
        // }
        
        $professionals = Professional::where('id','!=', 0)->orderByDesc('id')->get();
        
        //return $services = PropertyCategory::with('categoryServices')->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
        // $addon_categories = Master::where('MasterHead', 'Addon Category')->with('categoryAddons')->get();
        $service_categories = PropertyCategory::where('parent_id', 0)->with('categoryServices')->get();
        $customersHappiness = Banner::where('id','22')->first();
        $qrCode = Banner::where('id','23')->first();
        $clinicVideoText = Banner::where('id','24')->first();
        $topRatedDestination = Banner::where('id','25')->first();
        $forBusiness = Banner::where('id','26')->first();
        $requestAConsultation = Banner::where('id','27')->first();
        
        $customdata['customersHappiness']=$customersHappiness;
        $customdata['qrCode']=$qrCode;
        $customdata['clinicVideoText']=$clinicVideoText;
        $customdata['topRatedDestination']=$topRatedDestination;
        $customdata['forBusiness']=$forBusiness;
        $customdata['requestAConsultation']=$requestAConsultation;
        
        $home_top_banner = Banner::where('banner_type','Home Top Banner')->get();
        $reviews = Review::where('status','1')->get();
        $recently_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(10);
        $recommended_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(10);
        $new_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(10);
        $trending_services = Property::where('id', '!=', '')->where('status', '=', '1')->orderByDesc('id')->paginate(10);
        
        return view('frontend.professional-time', compact('home_top_banner','recently_services','recommended_services','new_services',
        'trending_services','reviews','categories','customdata','service_categories','addoncats','systems','addonsystems','professionals',
        'dates','currentMonth'));
    }
    
    public function timeSlot(Request $request)
    {
        $professional_id = $request->professional_id;
        $sdate = $request->sdate;
    
        // Generate or retrieve the session UUID
        if (session('uuid') == '') {
            $uuid = Str::uuid();
            session(['uuid' => $uuid]);
        } else {
            $uuid = session('uuid');
        }
    
        
        // Fetch all checked services for the current session
        $systems = CheckedService::with('getCheckedService') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'service')
            ->get();
            
        
            
        $addonsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'addon')
            ->get();
            
            
        $systems2 = CheckedService::with('getCheckedService')->where('system_id', session('uuid'))->where('stype', 'service')->pluck('sid');
        $totalDuration = Property::whereIn('id', $systems2)->sum('duration');
    
        
        $startTime = '10:00';
        $endTime = '17:00';
        $interval = 10; // minutes

        
        $start = \Carbon\Carbon::createFromFormat('H:i', $startTime);
        $end = \Carbon\Carbon::createFromFormat('H:i', $endTime);

        $abc = ''.$sdate;
        $slots = [];
        $i = 1;
        while ($start->lt($end)) {
            //$slots[] = $start->format('H:i');
            
            $start2 = $start->copy();
            $startTime = $start2->subMinutes($totalDuration)->format('h:i:a'); // 12-hour format with AM/PM
            $endTime = $start2->addMinutes($totalDuration*2)->format('h:i:a'); // Adds 80 mins to get 40 mins after
            
            $query = KiBooking::where('profession_id', $professional_id)
            ->where('slot_date',$sdate) // Convert slot_date to DATE format
            ->whereBetween(DB::raw("STR_TO_DATE(slot_time, '%h:%i:%p')"), [
                DB::raw("STR_TO_DATE('$startTime', '%h:%i:%p')"),
                DB::raw("STR_TO_DATE('$endTime', '%h:%i:%p')")
            ]);
            
            /*$sql = $query->toSql();
            $bindings = $query->getBindings();
            foreach ($bindings as $binding) {
                $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
            }
            dd($sql);*/
            
            $exists = $query->exists();
            
            if(!$exists){
            $abc .= '<div class="inner_child_box" id="slot-'.$i.'" slot_id="'.$i.'" slot_time="'.$start->format('h:i:a').'" tsdate="'.date('d M',strtotime($request->date)).'" onclick="selectTimeSlot(' . $i . ')">
                         <p class="color-text1">'.$start->format('H:i:A').'</p>
                    </div>';
            }
           
            $start->addMinutes($interval);
            $i++;        
        }
        
        
    
        return response()->json([
            'status' => 'success',
            'abc' => $abc,
        ]);
    }
    
    public function consultationFormSave(Request $request)
    {
        $ctype=$request->ctype;
        $first_name=$request->first_name;
        $last_name=$request->last_name;
        $email=$request->email;
        $mobile=$request->mobile;
        $clinic=$request->clinic;
        $service=$request->service;
        $message=$request->message;
        
        $saveConsultationForm = new ConsultationForm();
        $saveConsultationForm->ctype = $request->ctype;
        $saveConsultationForm->first_name = $request->first_name;
        $saveConsultationForm->last_name = $request->last_name;
        $saveConsultationForm->email = $request->email;
        $saveConsultationForm->mobile = $request->mobile;
        $saveConsultationForm->clinic = $request->clinic;
        $saveConsultationForm->service = $request->service;
        $saveConsultationForm->message = $request->message;
        
        $saveConsultationForm->save();
        
        if($saveConsultationForm){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'failed']);
        }
    }
    
    public function subscribeSave(Request $request)
    {
        $full_name=$request->full_name;
        $email=$request->email;
        $selectedTreatments=$request->selectedTreatments;
        
        $saveConsultationForm = new SubscribeForm();
        $saveConsultationForm->full_name = $request->full_name;
        $saveConsultationForm->email = $request->email;
        $saveConsultationForm->selectedTreatments = json_encode($selectedTreatments);
        
        $saveConsultationForm->save();
        
        if($saveConsultationForm){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'failed']);
        }
    }
    
    public function updatetimeslot(Request $request)
    {
       
        $id = $request->id;
        $updateBooking = KiBooking::find($id);
        $updateBooking->clinic_id = $request->clinic_id;
        $updateBooking->selected_date = $request->selected_date;
        $updateBooking->selected_time = $request->selected_time;
        $updateBooking->save();
        
       $saveBooking=''; 
       $menudata = $this->menudata;
       return view('frontend.booking-success', compact('menudata','saveBooking'));
    }
    public function bookWithoutPayment(Request $request)
    {
        
        $systems = CheckedService::where('stype', 'service')->where('system_id', session('uuid'))->get();
        if ($systems->isEmpty()) {
            return redirect(url('services/0/0')); // Redirect to the URL
        }
        
        
        $query = Customer::query();
        $query->where("mobile","=",$request->mobile)->whereOr("email","=",$request->email);
        $customer = $query->orderByDesc('id')->first();
        
        $user_id = @$customer->id;
        
        if(@$user_id==''){
           
            
            $saveCustomer = new Customer();
            $saveCustomer->first_name = $request->first_name;
            $saveCustomer->last_name = $request->last_name;
            $saveCustomer->mobile = $request->mobile;
            $saveCustomer->email = $request->email;
            
            $saveCustomer->save();
            
            $user_id = $saveCustomer->id;
            
        }
        
        $systems = CheckedService::with('getCheckedService') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'service')
            ->pluck('sid');
            
        $addonsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'addon')
            ->pluck('sid');
        
        $saveBooking = new KiBooking();
        $saveBooking->user_id = $user_id;
        $saveBooking->service_id = $systems;
        $saveBooking->addon_id = $addonsystems;
        $saveBooking->profession_id = session('professional_id');
        $saveBooking->total_service_duration = $request->total_service_duration;
        $saveBooking->total_addon_duration = $request->total_addon_duration;
        $saveBooking->ddate = $request->date;
        $saveBooking->slot_id = session('slot_id');
        $saveBooking->slot_date = session('slot_date');
        $saveBooking->slot_time = session('slot_time'); 
        $saveBooking->first_name = $request->first_name;
        $saveBooking->last_name = $request->last_name;
        $saveBooking->email = $request->email;
        $saveBooking->mobile = $request->mobile;
        
        $saveBooking->save();
        
        $data=[
                'booking_id'=>$saveBooking->id,
            ];
        
       
        
        if($saveBooking){
            session()->forget('uuid');
            return response()->json(['status' => 'success', 'data' => $data]);
        }else{
            return response()->json(['status' => 'failed']);
        }
    }
    
    public function saveSelectedData(Request $request)
    {
        $professional_id=$request->professional_id;
        $slot_date=$request->slot_date;
        $slot_id=$request->slot_id;
        $slot_time=$request->slot_time;
        
        session(['professional_id' => $professional_id]);
        session(['slot_date' => $slot_date]);
        session(['slot_id' => $slot_id]);
        session(['slot_time' => $slot_time]);
        
        return response()->json(['status' => 'success', 'abc' => session('professional_id')]);
        
    }
    
    public function changeLanguage(Request $request)
    {
        $lang = $request->lang;
        
        $abc = '';
        
        session(['app_locale' => $lang]);
       
        return response()->json([
            'status' => 'success',
            'abc' => $abc,
        ]);
    }
    
    public function hidePopup(Request $request)
    {
        $abc = '';
        
        session(['footerPopupClosed' => '1']);
       
        return response()->json([
            'status' => 'success',
            'abc' => $abc,
        ]);
    }
    
    public function searchResult(Request $request)
    {
        $searchbox = $request->searchbox;
        
        $abc = '';
        
        $systems = PropertyCategory::where('category_name', 'like', '%'.$request->searchbox.'%')->where('status', '1')->get();
        if ($systems->isNotEmpty()) {
            foreach ($systems as $system) {
                
                $abc .= '<div class="searchwp-live-search-result p-2">
                    <p><a href="' . url('allservice/' . $system->category_slug) . '" class="text-decoration-none">' . $system->category_name . ' »</a></p>
                </div>';
    
            }
        }else{
            $abc .= '<div class="searchwp-live-search-result p-2 text-center">
                <p>No results found.</p>
            </div>';
        }
        
        
    
        return response()->json([
            'status' => 'success',
            'abc' => $abc,
        ]);
    }
    
    public function addRemoveService(Request $request)
    {
        $stype = $request->stype;
        $sid = $request->sid;
        $ssession = $request->ssession;
        $sprice = $request->sprice;
        $quantity = $request->quantity;
        $action = $request->action;
    
        // Generate or retrieve the session UUID
        if (session('uuid') == '') {
            $uuid = Str::uuid();
            session(['uuid' => $uuid]);
        } else {
            $uuid = session('uuid');
        }
    
        // Check if the service already exists in the checked services
        $system = CheckedService::where('stype', $stype)->where('sid', $sid)->where('system_id', $uuid)->first();
        if($stype=='addon'){
            $system->delete();
        }else{
            if ($system) {
               if($action=='remove'){
                    $system->delete();
                }else{
                    //$system->delete();
                    //$system->update(['ssession' => $ssession, 'sprice' => $sprice]);
                    $system->ssession = $ssession;
                    $system->sprice = $sprice;
                    $system->save();
                }
                
            } else {
                // Add the service to the checked services
                $saveCheckedService = new CheckedService();
                $saveCheckedService->stype = $stype;
                $saveCheckedService->sid = $sid;
                $saveCheckedService->ssession = $ssession;
                $saveCheckedService->sprice = $sprice;
                $saveCheckedService->system_id = $uuid;
                $saveCheckedService->save();
                
                $system1 = CheckedService::where('stype', 'addon')->where('sid', 2)->where('system_id', $uuid)->first();
                if (!$system1) {
                    $saveCheckedService1 = new CheckedService();
                    $saveCheckedService1->stype = 'addon';
                    $saveCheckedService1->sid = 2;
                    $saveCheckedService1->system_id = $uuid;
                    $saveCheckedService1->save();
                }
                
                $system2 = CheckedService::where('stype', 'addon')->where('sid', 3)->where('system_id', $uuid)->first();
                if (!$system2) {
                    $saveCheckedService2 = new CheckedService();
                    $saveCheckedService2->stype = 'addon';
                    $saveCheckedService2->sid = 3;
                    $saveCheckedService2->system_id = $uuid;
                    $saveCheckedService2->save();
                }
                
                $system3 = CheckedService::where('stype', 'addon')->where('sid', 4)->where('system_id', $uuid)->first();
                if (!$system3) {
                    $saveCheckedService3 = new CheckedService();
                    $saveCheckedService3->stype = 'addon';
                    $saveCheckedService3->sid = 4;
                    $saveCheckedService3->system_id = $uuid;
                    $saveCheckedService3->save();
                }
                
                
            }
        }
        // Fetch all checked services for the current session
        $systems = CheckedService::with('getCheckedService') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'service')
            ->get();
        
    
        $abc = '';
        $sugpro = '';
        $totalprice = 0;
        $tsprice = 0;
    
        foreach ($systems as $system) {
            if ($system->getCheckedService) { // Ensure the relationship exists
    $checked_service = $system->getCheckedService;
    $totalprice += $system->sprice;
    $catimg = PropertyCategory::where('id', $checked_service->property_category)->first();

    $imgSrc = !empty($catimg->icon) ? asset('uploads/servicecat/' . $catimg->icon) : asset('frontend/images/Diamond%20Skin.png');

    $abc .= '<div class="product-cart-box position-relative p-3">
                <a href="javascript:void(0)" 
                   onclick="addRemoveService(\'service\', ' . $checked_service->id . ', \'remove\')" 
                   class="remove-btn btn btn-danger">
                    Remove
                </a>

                <img src="' . $imgSrc . '" alt="">

                <div>
                    <h6>' . htmlspecialchars($checked_service->property_name, ENT_QUOTES, 'UTF-8') . '</h6>
                    <p class="color-cart-product">Session: ' . $system->ssession . 'x</p>
                    <p class="price-cart-product">£' . number_format($system->sprice, 2) . '</p>
                </div>
            </div>';
}

        }
        
        
        $addonsystems = CheckedService::with('getCheckedAddon') // Ensure relationship is loaded
            ->where('system_id', session('uuid'))
            ->where('stype', 'addon')
            ->get(); // Fetch full models instead of pluck()
        
        foreach ($addonsystems as $addonsystem) {
            if ($addonsystem->getCheckedAddon) { // Ensure the relationship exists
                $checked_addon = $addonsystem->getCheckedAddon;
                $tsprice += $checked_addon->price;
        
                $sugpro .= '<div class="col-lg-2 col-md-4">
                                <div class="product-box">
                                    <a href="#">
                                        <div class="product-img">
                                            <img src="' . (!empty($checked_addon->profile) ? asset('uploads/addon/' . $checked_addon->profile) : asset('assets/img/media/1.jpg')) . '" alt="">
                                        </div>
                                    </a>
                                    <div class="product-detail-box">
                                        <a href="#">
                                            <h3 class="product-title">' . htmlspecialchars($checked_addon->addon_name, ENT_QUOTES, 'UTF-8') . '</h3>
                                            <p class="product-prise">Price: £' . number_format($checked_addon->price, 2) . '</p>
                                            <p class="category-product">' . htmlspecialchars($checked_addon->category, ENT_QUOTES, 'UTF-8') . '</p>
                                        </a>
                                        <a href="javascript:void(0)" onclick="addRemoveService(\'addon\', ' . $checked_addon->id . ', \'remove\')" class="w-100 bigbtn4 btn btn-danger">Remove</a>
                                    </div>
                                </div>
                            </div>';
            }
        }

        
      
    
        return response()->json([
            'status' => 'success',
            'abc' => $abc,
            'tprice' => number_format($totalprice, 2),
            'tsprice' => number_format($tsprice, 2),
            'ttsprice' => number_format($totalprice+$tsprice, 2),
            'ttsprice_num' => $totalprice+$tsprice,
            'sugpro' => $sugpro,
        ]);
    }
    
    public function addRemoveProduct(Request $request)
    {
        $sid = $request->sid;
        $stype = $request->stype;
        $quantity = $request->quantity;
    
        // Generate or retrieve the session UUID
        if (session('uuid') == '') {
            $uuid = Str::uuid();
            session(['uuid' => $uuid]);
        } else {
            $uuid = session('uuid');
        }
    
        // Check if the service already exists in the checked services
        $system = CheckedService::where('stype', $stype)->where('sid', $sid)->where('system_id', $uuid)->first();
    
        if ($system) {
            if($quantity>0){
                //$system->update(['item' => $system->item + $quantity]);
                $system->update(['item' => $quantity]);
            }else{
                $system->delete();
            }
        } else {
            // Add the service to the checked services
            $saveCheckedService = new CheckedService();
            $saveCheckedService->stype = $stype;
            $saveCheckedService->sid = $sid;
            $saveCheckedService->system_id = $uuid;
            $saveCheckedService->save();
        }
    
        
        
        if($stype=='product'){ 
            $productsystems = '0';
            $productsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
                ->where('system_id', session('uuid'))
                ->where('stype', 'product')
                ->count();
            
            return response()->json([
                'status' => 'success',
                'abc' => $productsystems,
            ]);
            
        }
    
      
    }

    
    
    
    public function checkout()
    {
        
        $systems = CheckedService::where('stype', 'service')->where('system_id', session('uuid'))->get();
        if ($systems->isEmpty()) {
            return redirect(url('services/0/0')); // Redirect to the URL
        }
        
        $addonsystems = CheckedService::where('stype', 'addon')->where('system_id', session('uuid'))->get();
        
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.checkout', compact('categories','systems','addonsystems'));
    }
    
    public function booking_success()
    {
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.booking-success', compact('categories'));
    }
    
    public function order_success()
    {
        $menudata = $this->menudata;
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.order-success', compact('menudata','categories'));
    }
    
    public function offer()
    {
        $menudata = $this->menudata;
        $home_top_banner = Banner::where('banner_type','Offer Top Banner')->get();
        $offer_services = Property::where('id', '!=', '')->where('status', '=', '1')->where('offer_status', '=', '1')->orderByDesc('id')->paginate(10);
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.offer', compact('menudata','categories','offer_services','home_top_banner'));
    }
    

    public function addToCart(Request $request)
{
    $ip = $request->ip();

    $productId = $request->product_id;
    $qty = $request->qty ?? 1;

    $cart = DB::table('guest_carts')
        ->where('ip_address', $ip)
        ->where('product_id', $productId)
        ->where('session', $request->session) // ✅ IMPORTANT (avoid merge different packages)
        ->first();

    if ($cart) {

        DB::table('guest_carts')
            ->where('id', $cart->id)
            ->update([
                'qty' => $cart->qty + $qty,
                'updated_at' => now()
            ]);

    } else {

        DB::table('guest_carts')->insert([
            'ip_address'   => $ip,
            'product_id'   => $request->product_id,
            'product_name' => $request->name,
            'price'        => $request->price,
            'qty'          => $qty,
            'image'        => $request->image,

            // ✅ NEW
            'type'         => $request->type,
            'session'      => $request->session,

            'created_at'   => now(),
            'updated_at'   => now()
        ]);
    }

    $cartItems = DB::table('guest_carts')
        ->where('ip_address', $ip)
        ->get();

    $cartCount = $cartItems->sum('qty');

    $subtotal = $cartItems->sum(function ($item) {
        return $item->price * $item->qty;
    });

    return response()->json([
        'status' => 'success',
        'items' => $cartItems,
        'count' => $cartCount,
        'subtotal' => $subtotal
    ]);
}
    
  public function addToCart1(Request $request)
{
    $ip = $request->ip();

    $productId = $request->product_id;
    $qty = $request->qty ?? 1; // ✅ NEW

    // ✅ Check existing cart item
    $cart = DB::table('guest_carts')
        ->where('ip_address', $ip)
        ->where('product_id', $productId)
        ->first();

    if ($cart) {
        // ✅ Update qty
        DB::table('guest_carts')
            ->where('id', $cart->id)
            ->update([
                'qty' => $cart->qty + $qty, // ✅ UPDATED
                'updated_at' => now()
            ]);
    } else {
        // ✅ Insert new record
        DB::table('guest_carts')->insert([
            'ip_address'   => $ip,
            'product_id'   => $request->product_id,
            'product_name' => $request->name,
            'price'        => $request->price,
            'qty'          => $qty, // ✅ UPDATED
            'image'        => $request->image,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);
    }

    // ✅ RETURN FULL CART (same as your system)
    $cartItems = DB::table('guest_carts')
        ->where('ip_address', $ip)
        ->get();

    $cartCount = $cartItems->sum('qty');

    $subtotal = $cartItems->sum(function ($item) {
        return $item->price * $item->qty;
    });

    return response()->json([
        'status' => 'success',
        'items' => $cartItems,
        'count' => $cartCount,
        'subtotal' => $subtotal
    ]);
}

public function getCart(Request $request)
{
    $ip = $request->ip();

    $cartItems = DB::table('guest_carts')
        ->where('ip_address', $ip)
        ->get();

    $cartCount = $cartItems->sum('qty');

    $subtotal = $cartItems->sum(function ($item) {
        return $item->price * $item->qty;
    });

    return response()->json([
        'status' => 'success',
        'items' => $cartItems,
        'count' => $cartCount,
        'subtotal' => $subtotal
    ]);
}
public function updateQty(Request $request)
{
    $ip = $request->ip();

    $item = DB::table('guest_carts')
        ->where('ip_address', $ip)
        ->where('product_id', $request->product_id)
        ->first();

    if ($item) {

        $newQty = $item->qty;

        if ($request->type == 'inc') {
            $newQty++;
        } elseif ($request->type == 'dec') {
            $newQty--;
        }

        // ❌ if qty <= 0 remove item
        if ($newQty <= 0) {
            DB::table('guest_carts')
                ->where('id', $item->id)
                ->delete();
        } else {
            DB::table('guest_carts')
                ->where('id', $item->id)
                ->update([
                    'qty' => $newQty,
                    'updated_at' => now()
                ]);
        }
    }

    return $this->getCart($request); // reuse same response
}
public function removeItem(Request $request)
{
    $ip = $request->ip();

    DB::table('guest_carts')
        ->where('ip_address', $ip)
        ->where('id', $request->product_id)
        ->delete();

    return $this->getCart($request); // return updated cart
}
    
    
}
