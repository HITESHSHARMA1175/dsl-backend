@extends('frontend.layout.app')

@section('content')

<script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>

<style>
.product-cart-box {
    position: relative;
    display: flex;
    /*flex-direction: column;*/
    gap: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background: #fff;
    margin-bottom: 5px;
}

.remove-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 5px;
}

</style>

<?php 

use App\Models\Property;

if(session('app_locale')=='cn'){
    if($category->icon_large_cn!=''){
    $icon_large11 = $category->icon_large_cn;
    }else{
    $icon_large11 = $category->icon_large;
    }
    $category_name11 = $category->category_name_cn;
    $description11 = $category->description_cn;
    $youtube_link11 = $category->youtube_link_cn;
    if($category->icon2_cn!=''){
    $icon211 = $category->icon2_cn;
    }else{
    $icon211 = $category->icon2;
    }
    $description311 = $category->description3_cn;
}elseif(session('app_locale')=='ar'){
    if($category->icon_large_ar!=''){
    $icon_large11 = $category->icon_large_ar;
    }else{
    $icon_large11 = $category->icon_large;
    }
    $category_name11 = $category->category_name_ar;
    $description11 = $category->description_ar;
    $youtube_link11 = $category->youtube_link_ar;
    if($category->icon2_ar!=''){
    $icon211 = $category->icon2_ar;
    }else{
    $icon211 = $category->icon2;
    }
    $description311 = $category->description3_ar;
}else{
    $icon_large11 = $category->icon_large;
    $category_name11 = $category->category_name;
    $description11 = $category->description;
    $youtube_link11 = $category->youtube_link;
    $icon211 = $category->icon2;
    $description311 = $category->description3;
}
?>

    <div class="breadcrumb-cell" aria-label="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <a href="{{ url('/') }}"> Home </a> &gt; {{ $category_name11 }}
                    </ol>
                </div>
            </div>
        </div>
    </div>
<section class="banner-acne p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <a href="https://share.google/NNg1CDBV051jzMDVD" target="_blank" rel="noopener noreferrer">
                    <img 
                        src="{{ !empty($icon_large11) ? asset('uploads/servicecat/' . $icon_large11) : asset('assets/img/media/1.jpg') }}" 
                        alt="{{ $category_name11 }}"
                        style="width:100%; height:auto; cursor:pointer;"
                    >
                </a>
            </div>
        </div>
    </div>
</section>

    <section class="acne">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h4>{{ $category_name11 }}</h4>
                    <p>{{ $description11 }}</p>
                </div>
            </div>
        </div>
    </section>
    @if(session('app_locale')=='cn')
    <section class="regulated-by-the">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>ڈاکٹر اور نرس کی زیرقیادت کلینک</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>لیزر میں NVQ لیول 4 کے ساتھ ماہر تربیت یافتہ پریکٹیشنرز</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>15 سال سے زیادہ کام کر رہا ہے۔</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>کسٹمر سروس کی اعلی ترین سطح</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @elseif(session('app_locale')=='ar')
    <section class="regulated-by-the">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>عيادة بقيادة طبيب وممرضة</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>ممارسون مدربون بخبرة حاصلون على شهادة NVQ المستوى 4 في الليزر</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>تعمل منذ أكثر من 15 عامًا</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>أعلى مستوى من خدمة العملاء</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
    <section class="regulated-by-the">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>Doctor and nurse-led clinic</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>Expertly trained practitioners with NVQ Level 4 in Laser</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>Operating for over 15 years</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="regulated-box">
                        <h4>Highest level of customer service</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <section class="what-is-acne">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-6 acne-youtube">
                    @if($youtube_link11!='')
                    <iframe width="100%" src="{{ $youtube_link11 }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    @elseif($icon211!='')
                    <img src="{{ !empty($icon211) ? asset('uploads/servicecat/' . $icon211) : asset('assets/img/media/1.jpg') }}" >
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="show-text-box">
                    <?= \Illuminate\Support\Str::limit($description311, 800) ?><br>
                    @if(strlen($description311) > 800)
                    <a href="javascript:void(0)" class="bigbtn primary-btn btn mt-3 readmorehidden">Read more</a>
                    </div>
                    @endif
                    <div class="hidden-text-box">
                        <?= $description311 ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="treatments-for-scne d-none">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2>Treatments for Acne at Pulse Light Clinic</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <a href="" class="treatment-acne">
                        <div class="acne-img-box">
                            <img src="{{ asset('frontend/images/lasemd2.webp') }}" alt="">
                        </div>
                        <div class="laseMD">
                            <h4>LaseMD</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="" class="treatment-acne">
                        <div class="acne-img-box">
                            <img src="{{ asset('frontend/images/Acne-Treatments-Banner.jpg') }}" alt="">
                        </div>
                        <div class="laseMD">
                            <h4>LaseMD</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="" class="treatment-acne">
                        <div class="acne-img-box">
                            <img src="{{ asset('frontend/images/LED2.webp') }}" alt="">
                        </div>
                        <div class="laseMD">
                            <h4>LaseMD</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="" class="treatment-acne">
                        <div class="acne-img-box">
                            <img src="{{ asset('frontend/images/acnescar.webp') }}" alt="">
                        </div>
                        <div class="laseMD">
                            <h4>LaseMD</h4>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="javascript:void(0)" class="bigbtn primary-btn btn mt-5 book-a-free"><b>Book a Free Consultation</b></a>
                </div>
            </div>
        </div>
    </section>
    <section class="acne-laser">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2>{{ $category_name11 }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills mb-3 justify-content-center gap-md-4 gap-2" id="pills-tab" role="tablist">
                        
                        @if(count($subcategories) > 0)
                            @foreach ($subcategories as $subcategory)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="pills-{{ $subcategory->id }}-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-{{ $subcategory->id }}" type="button" role="tab" aria-controls="pills-{{ $subcategory->id }}"
                                    aria-selected="true">
                                    @if(session('app_locale')=='cn')
                                    {{ $subcategory->category_name_cn }}
                                    @elseif(session('app_locale')=='ar')
                                    {{ $subcategory->category_name_ar }}
                                    @else
                                    {{ $subcategory->category_name }}
                                    @endif
                                    </button>
                            </li>
                            @endforeach
                        @else
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">{{ $category_name11 }}</button>
                        </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">
                                @if(session('app_locale')=='cn')
                                لچکدار، سود سے پاک ادائیگی کے اختیارات
                                @elseif(session('app_locale')=='ar')
                                خيارات دفع مرنة وخالية من الفوائد
                                @else
                                Flexible, Interest-Free Payment Options
                                @endif
                                </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false">
                                @if(session('app_locale')=='cn')
                                ایک دوست سے رجوع کریں۔
                                @elseif(session('app_locale')=='ar')
                                أحل صديقًا
                                @else
                                Refer a Friend
                                @endif
                                </button>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        @if(count($subcategories) > 0)
                            @foreach ($subcategories as $subcategory)
                            @php 
                                
                                $services = Property::whereJsonContains('property_sub_category', strval($subcategory->id))
                                ->orWhereJsonContains('skin_sub_condition', strval($subcategory->id))->get();
                                
                            @endphp
                            <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="pills-{{ $subcategory->id }}" role="tabpanel"
                                aria-labelledby="pills-{{ $subcategory->id }}-tab" tabindex="0">
                                <div class="acne-new">
                                    <div class="row mt-5">
                                        <div class="col-12 text-center">
                                            <h3>
                                            @if(session('app_locale')=='cn')
                                            {{ $subcategory->category_name_cn }}
                                            @elseif(session('app_locale')=='ar')
                                            {{ $subcategory->category_name_ar }}
                                            @else
                                            {{ $subcategory->category_name }}
                                            @endif
                                            </h3>
                                            <div class="divider-new"></div>
                                            <p>Pay with Klarna in Instalments & 0% APR –T&Cs apply.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach ($services as $service)
                                        
                                        <?php
                                        
                                        if($service->session1>0){
                                            $liwidth = 1;
                                        }
                                        
                                        if($service->session2>0){
                                            $liwidth += 1;
                                        }
                                        
                                        if($service->session3>0){
                                            $liwidth += 1;
                                        }
                                        
                                        if($service->session4>0){
                                            $liwidth += 1;
                                        }
                                        
                                        
                                        ?>
                                        
                                        <div class="col-lg-4">
                                            <div class="acne-treatment-card">
                                                <h3 style="height: 42px; align-items: center; display: flex; overflow: hidden;">{{ $service->property_name }}</h3>
                                                <div class="limited-time-promo-text mb-2" style="height: 47px; align-items: center; display: flex; overflow: hidden;font-size: 14px;"><?= \Illuminate\Support\Str::limit($service->description, 80) ?> </div>
                                                <span class="sub-text"> Select Number of Sessions</span>
                                                <div class="tab-acne">
                                                    <ul class="nav nav-pills mb-3 gap-0" id="pills-tab" role="tablist">
                                                        @if($service->session1>0)
                                                        <li class="nav-item" role="presentation" style="width: {{ 100/$liwidth }}%;">
                                                            <button class="nav-link active" id="pills-{{ $service->id }}{{ $service->session1 }}xx"
                                                                data-bs-toggle="pill" data-bs-target="#pills-{{ $service->id }}{{ $service->session1 }}x"
                                                                type="button" role="tab" aria-controls="pills-{{ $service->id }}{{ $service->session1 }}x"
                                                                aria-selected="true">{{ $service->session1 }}x</button>
                                                        </li>
                                                        @endif
                                                        @if($service->session2>0)
                                                        <li class="nav-item" role="presentation"  style="width: {{ 100/$liwidth }}%;">
                                                            <button class="nav-link" id="pills-{{ $service->id }}{{ $service->session2 }}xx"
                                                                data-bs-toggle="pill" data-bs-target="#pills-{{ $service->id }}{{ $service->session2 }}x"
                                                                type="button" role="tab" aria-controls="pills-{{ $service->id }}{{ $service->session2 }}x"
                                                                aria-selected="true">{{ $service->session2 }}x</button>
                                                        </li>
                                                        @endif
                                                        @if($service->session3>0)
                                                        <li class="nav-item" role="presentation"  style="width: {{ 100/$liwidth }}%;">
                                                            <button class="nav-link" id="pills-{{ $service->id }}{{ $service->session3 }}xx" data-bs-toggle="pill"
                                                                data-bs-target="#pills-{{ $service->id }}{{ $service->session3 }}x" type="button" role="tab"
                                                                aria-controls="pills-{{ $service->id }}{{ $service->session3 }}x" aria-selected="false">{{ $service->session3 }}x</button>
                                                        </li>
                                                        @endif
                                                        @if($service->session4>0)
                                                        <li class="nav-item" role="presentation"  style="width: {{ 100/$liwidth }}%;">
                                                            <button class="nav-link" id="pills-{{ $service->id }}{{ $service->session4 }}xx" data-bs-toggle="pill"
                                                                data-bs-target="#pills-{{ $service->id }}{{ $service->session4 }}x" type="button" role="tab"
                                                                aria-controls="pills-{{ $service->id }}{{ $service->session4 }}x" aria-selected="false">{{ $service->session4 }}x</button>
                                                        </li>
                                                        @endif
    
                                                    </ul>
                                                    <div class="tab-content" id="pills-tabContent">
                                                        @if($service->session1>0)
                                                        <div class="tab-pane fade show active" id="pills-{{ $service->id }}{{ $service->session1 }}x" role="tabpanel"
                                                            aria-labelledby="pills-{{ $service->id }}{{ $service->session1 }}xx" tabindex="0">
                                                            <div class="package-pricing-wrapper">
                                                                <div class="package-price has-was-price">
                                                                    @if($service->discounted_price>0)
                                                                    <div class="price-was">
                                                                        <span class="package-price-prepended-text">Was</span>
                                                                        £<span data-value="price-was">{{ $service->price }}</span> 
                                                                        <span class="package-price-appended-text"></span>
                                                                    </div>
                                                                    @endif
                                                                    <div class="price-now2">
                                                                        Now £{{ ($service->price-$service->discounted_price) }} Total
                                                                    </div>
                                                                    <div class="limited-time-promo-text"> Limited Time Only!
                                                                    </div>
                                                                </div>
                                                                <div class="session-pricing">
                                                                    <div class="session-price-wrapper"> £<span
                                                                            data-value="session-price">{{ ceil(($service->price-$service->discounted_price)/$service->session1) }}</span> <span
                                                                            class="package-price-appended-text session-price">
                                                                            per session </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" onclick="addRemoveService('service','{{ $service->id }}','add','{{ $service->session1 }}','{{ ($service->price-$service->discounted_price) }}')" class="w-100 bigbtn primary-btn btn mt-3" >Buy</a>
                                                        </div>
                                                        @endif
                                                        @if($service->session2>0)
                                                        <div class="tab-pane fade " id="pills-{{ $service->id }}{{ $service->session2 }}x" role="tabpanel"
                                                            aria-labelledby="pills-{{ $service->id }}{{ $service->session2 }}xx" tabindex="0">
                                                            <div class="package-pricing-wrapper">
                                                                <div class="package-price has-was-price">
                                                                    @if($service->discounted_price2>0)
                                                                    <div class="price-was">
                                                                        <span class="package-price-prepended-text">Was</span>
                                                                        £<span data-value="price-was">{{ $service->price2 }}</span> 
                                                                        <span class="package-price-appended-text"></span>
                                                                    </div>
                                                                    @endif
                                                                    <div class="price-now2">
                                                                        Now £{{ ($service->price2-$service->discounted_price2) }} Total
                                                                    </div>
                                                                    <div class="limited-time-promo-text"> Limited Time Only!
                                                                    </div>
                                                                </div>
                                                                <div class="session-pricing">
                                                                    <div class="session-price-wrapper"> £<span
                                                                            data-value="session-price">{{ ceil(($service->price2-$service->discounted_price2)/$service->session2) }}</span> <span
                                                                            class="package-price-appended-text session-price">
                                                                            per session </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" onclick="addRemoveService('service','{{ $service->id }}','add','{{ $service->session2 }}','{{ ($service->price2-$service->discounted_price2) }}')" class="w-100 bigbtn primary-btn btn mt-3" >Buy</a>
                                                        </div>
                                                        @endif
                                                        @if($service->session3>0)
                                                        <div class="tab-pane fade " id="pills-{{ $service->id }}{{ $service->session3 }}x" role="tabpanel"
                                                            aria-labelledby="pills-{{ $service->id }}{{ $service->session3 }}xx" tabindex="0">
                                                            <div class="package-pricing-wrapper">
                                                                <div class="package-price has-was-price">
                                                                    @if($service->discounted_price3>0)
                                                                    <div class="price-was">
                                                                        <span class="package-price-prepended-text">Was</span>
                                                                        £<span data-value="price-was">{{ $service->price3 }}</span> 
                                                                        <span class="package-price-appended-text"></span>
                                                                    </div>
                                                                    @endif
                                                                    <div class="price-now2">
                                                                        Now £{{ ($service->price3-$service->discounted_price3) }} Total
                                                                    </div>
                                                                    <div class="limited-time-promo-text"> Limited Time Only!
                                                                    </div>
                                                                </div>
                                                                <div class="session-pricing">
                                                                    <div class="session-price-wrapper"> £<span
                                                                            data-value="session-price">{{ ceil(($service->price3-$service->discounted_price3)/$service->session3) }}</span> <span
                                                                            class="package-price-appended-text session-price">
                                                                            per session </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" onclick="addRemoveService('service','{{ $service->id }}','add','{{ $service->session3 }}','{{ ($service->price3-$service->discounted_price3) }}')" class="w-100 bigbtn primary-btn btn mt-3" >Buy</a>
                                                        </div>
                                                        @endif
                                                        @if($service->session4>0)
                                                        <div class="tab-pane fade " id="pills-{{ $service->id }}{{ $service->session4 }}x" role="tabpanel"
                                                            aria-labelledby="pills-{{ $service->id }}{{ $service->session4 }}xx" tabindex="0">
                                                            <div class="package-pricing-wrapper">
                                                                <div class="package-price has-was-price">
                                                                    @if($service->discounted_price4>0)
                                                                    <div class="price-was">
                                                                        <span class="package-price-prepended-text">Was</span>
                                                                        £<span data-value="price-was">{{ $service->price4 }}</span> 
                                                                        <span class="package-price-appended-text"></span>
                                                                    </div>
                                                                    @endif
                                                                    <div class="price-now2">
                                                                        Now £{{ ($service->price4-$service->discounted_price4) }} Total
                                                                    </div>
                                                                    <div class="limited-time-promo-text"> Limited Time Only!
                                                                    </div>
                                                                </div>
                                                                <div class="session-pricing">
                                                                    <div class="session-price-wrapper"> £<span
                                                                            data-value="session-price">{{ ceil(($service->price4-$service->discounted_price4)/$service->session4) }}</span> <span
                                                                            class="package-price-appended-text session-price">
                                                                            per session </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" onclick="addRemoveService('service','{{ $service->id }}','add','{{ $service->session4 }}','{{ ($service->price4-$service->discounted_price4) }}')" class="w-100 bigbtn primary-btn btn mt-3" >Buy</a>
                                                        </div>
                                                        @endif
                                                        
                                                    </div>
    
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-12 text-center">
                                            <a href="javascript:void(0)" class="bigbtn primary-btn btn mt-3 view-all"><i class="fa-solid fa-angle-down"></i> View All</a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <div class="acne-new">
                                <div class="row mt-5">
                                    <div class="col-12 text-center">
                                        <h3>{{ $category_name11 }}</h3>
                                        <div class="divider-new"></div>
                                        <p>Pay with Klarna in Instalments & 0% APR –T&Cs apply.</p>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($services as $service)
                                    
                                    <?php
                                    
                                    if($service->session1!=''){
                                        $liwidth = 1;
                                    }
                                    
                                    if($service->session2!=''){
                                        $liwidth += 1;
                                    }
                                    
                                    if($service->session3!=''){
                                        $liwidth += 1;
                                    }
                                    
                                    if($service->session4!=''){
                                        $liwidth += 1;
                                    }
                                    
                                    
                                    ?>
                                    
                                    <div class="col-lg-4">
                                        <div class="acne-treatment-card">
                                            <h3>{{ $service->property_name }}</h3>
                                            <div class="limited-time-promo-text mb-2"><?= \Illuminate\Support\Str::limit($service->description, 50) ?><span style="visibility:hidden;">11</span></div>
                                            <span class="sub-text"> Select Number of Sessions</span>
                                            <div class="tab-acne">
                                                <ul class="nav nav-pills mb-3 gap-0" id="pills-tab" role="tablist">
                                                    @if($service->session1!='')
                                                    <li class="nav-item" role="presentation" style="width: {{ 100/$liwidth }}%;">
                                                        <button class="nav-link active" id="pills-{{ $service->id }}{{ $service->session1 }}xx"
                                                            data-bs-toggle="pill" data-bs-target="#pills-{{ $service->id }}{{ $service->session1 }}x"
                                                            type="button" role="tab" aria-controls="pills-{{ $service->id }}{{ $service->session1 }}x"
                                                            aria-selected="true">{{ $service->session1 }}x</button>
                                                    </li>
                                                    @endif
                                                    @if($service->session2!='')
                                                    <li class="nav-item" role="presentation"  style="width: {{ 100/$liwidth }}%;">
                                                        <button class="nav-link" id="pills-{{ $service->id }}{{ $service->session2 }}xx"
                                                            data-bs-toggle="pill" data-bs-target="#pills-{{ $service->id }}{{ $service->session2 }}x"
                                                            type="button" role="tab" aria-controls="pills-{{ $service->id }}{{ $service->session2 }}x"
                                                            aria-selected="true">{{ $service->session2 }}x</button>
                                                    </li>
                                                    @endif
                                                    @if($service->session3!='')
                                                    <li class="nav-item" role="presentation"  style="width: {{ 100/$liwidth }}%;">
                                                        <button class="nav-link" id="pills-{{ $service->id }}{{ $service->session3 }}xx" data-bs-toggle="pill"
                                                            data-bs-target="#pills-{{ $service->id }}{{ $service->session3 }}x" type="button" role="tab"
                                                            aria-controls="pills-{{ $service->id }}{{ $service->session3 }}x" aria-selected="false">{{ $service->session3 }}x</button>
                                                    </li>
                                                    @endif
                                                    @if($service->session4!='')
                                                    <li class="nav-item" role="presentation"  style="width: {{ 100/$liwidth }}%;">
                                                        <button class="nav-link" id="pills-{{ $service->id }}{{ $service->session4 }}xx" data-bs-toggle="pill"
                                                            data-bs-target="#pills-{{ $service->id }}{{ $service->session4 }}x" type="button" role="tab"
                                                            aria-controls="pills-{{ $service->id }}{{ $service->session4 }}x" aria-selected="false">{{ $service->session4 }}x</button>
                                                    </li>
                                                    @endif

                                                </ul>
                                                <div class="tab-content" id="pills-tabContent">
                                                    @if($service->session1!='')
                                                    <div class="tab-pane fade show active" id="pills-{{ $service->id }}{{ $service->session1 }}x" role="tabpanel"
                                                        aria-labelledby="pills-{{ $service->id }}{{ $service->session1 }}xx" tabindex="0">
                                                        <div class="package-pricing-wrapper">
                                                            <div class="package-price has-was-price">
                                                                @if($service->discounted_price>0)
                                                                <div class="price-was">
                                                                    <span class="package-price-prepended-text">Was</span>
                                                                    £<span data-value="price-was">{{ $service->price }}</span> 
                                                                    <span class="package-price-appended-text"></span>
                                                                </div>
                                                                @endif
                                                                <div class="price-now2">
                                                                    Now £{{ ($service->price-$service->discounted_price) }} Total
                                                                </div>
                                                                <div class="limited-time-promo-text"> Limited Time Only!
                                                                </div>
                                                            </div>
                                                            <div class="session-pricing">
                                                                <div class="session-price-wrapper"> £<span
                                                                        data-value="session-price">{{ ceil(($service->price-$service->discounted_price)/$service->session1) }}</span> <span
                                                                        class="package-price-appended-text session-price">
                                                                        per session </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)" onclick="addRemoveService('service','{{ $service->id }}','add','{{ $service->session1 }}','{{ ($service->price-$service->discounted_price) }}')" class="w-100 bigbtn primary-btn btn mt-3" >Buy</a>
                                                    </div>
                                                    @endif
                                                    @if($service->session2!='')
                                                    <div class="tab-pane fade " id="pills-{{ $service->id }}{{ $service->session2 }}x" role="tabpanel"
                                                        aria-labelledby="pills-{{ $service->id }}{{ $service->session2 }}xx" tabindex="0">
                                                        <div class="package-pricing-wrapper">
                                                            <div class="package-price has-was-price">
                                                                @if($service->discounted_price2>0)
                                                                <div class="price-was">
                                                                    <span class="package-price-prepended-text">Was</span>
                                                                    £<span data-value="price-was">{{ $service->price2 }}</span> 
                                                                    <span class="package-price-appended-text"></span>
                                                                </div>
                                                                @endif
                                                                <div class="price-now2">
                                                                    Now £{{ ($service->price2-$service->discounted_price2) }} Total
                                                                </div>
                                                                <div class="limited-time-promo-text"> Limited Time Only!
                                                                </div>
                                                            </div>
                                                            <div class="session-pricing">
                                                                <div class="session-price-wrapper"> £<span
                                                                        data-value="session-price">{{ ceil(($service->price2-$service->discounted_price2)/$service->session2) }}</span> <span
                                                                        class="package-price-appended-text session-price">
                                                                        per session </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)" onclick="addRemoveService('service','{{ $service->id }}','add','{{ $service->session2 }}','{{ ($service->price2-$service->discounted_price2) }}')" class="w-100 bigbtn primary-btn btn mt-3" >Buy</a>
                                                    </div>
                                                    @endif
                                                    @if($service->session3!='')
                                                    <div class="tab-pane fade " id="pills-{{ $service->id }}{{ $service->session3 }}x" role="tabpanel"
                                                        aria-labelledby="pills-{{ $service->id }}{{ $service->session3 }}xx" tabindex="0">
                                                        <div class="package-pricing-wrapper">
                                                            <div class="package-price has-was-price">
                                                                @if($service->discounted_price3>0)
                                                                <div class="price-was">
                                                                    <span class="package-price-prepended-text">Was</span>
                                                                    £<span data-value="price-was">{{ $service->price3 }}</span> 
                                                                    <span class="package-price-appended-text"></span>
                                                                </div>
                                                                @endif
                                                                <div class="price-now2">
                                                                    Now £{{ ($service->price3-$service->discounted_price3) }} Total
                                                                </div>
                                                                <div class="limited-time-promo-text"> Limited Time Only!
                                                                </div>
                                                            </div>
                                                            <div class="session-pricing">
                                                                <div class="session-price-wrapper"> £<span
                                                                        data-value="session-price">{{ ceil(($service->price3-$service->discounted_price3)/$service->session3) }}</span> <span
                                                                        class="package-price-appended-text session-price">
                                                                        per session </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)" onclick="addRemoveService('service','{{ $service->id }}','add','{{ $service->session3 }}','{{ ($service->price3-$service->discounted_price3) }}')" class="w-100 bigbtn primary-btn btn mt-3" >Buy</a>
                                                    </div>
                                                    @endif
                                                    @if($service->session4!='')
                                                    <div class="tab-pane fade " id="pills-{{ $service->id }}{{ $service->session4 }}x" role="tabpanel"
                                                        aria-labelledby="pills-{{ $service->id }}{{ $service->session4 }}xx" tabindex="0">
                                                        <div class="package-pricing-wrapper">
                                                            <div class="package-price has-was-price">
                                                                @if($service->discounted_price4>0)
                                                                <div class="price-was">
                                                                    <span class="package-price-prepended-text">Was</span>
                                                                    £<span data-value="price-was">{{ $service->price4 }}</span> 
                                                                    <span class="package-price-appended-text"></span>
                                                                </div>
                                                                @endif
                                                                <div class="price-now2">
                                                                    Now £{{ ($service->price4-$service->discounted_price4) }} Total
                                                                </div>
                                                                <div class="limited-time-promo-text"> Limited Time Only!
                                                                </div>
                                                            </div>
                                                            <div class="session-pricing">
                                                                <div class="session-price-wrapper"> £<span
                                                                        data-value="session-price">{{ ceil(($service->price4-$service->discounted_price4)/$service->session4) }}</span> <span
                                                                        class="package-price-appended-text session-price">
                                                                        per session </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)" onclick="addRemoveService('service','{{ $service->id }}','add','{{ $service->session4 }}','{{ ($service->price4-$service->discounted_price4) }}')" class="w-100 bigbtn primary-btn btn mt-3" >Buy</a>
                                                    </div>
                                                    @endif
                                                    
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <!-- <div class="row">
                                    <div class="col-12 text-center">
                                        <a href="javascript:void(0)" class="bigbtn primary-btn btn mt-3 view-all"><i class="fa-solid fa-angle-down"></i> View All</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        @endif
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">
                        
                            <div class="finance-option mt-4">
                                @if(session('app_locale')=='cn')
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h2>0% فنانس آپشن</h2>
                                    </div>
                                    <ul>
                                        <li>ڈائمنڈ سکن کلینک میں، ہم سمجھتے ہیں کہ بہترین جلد قابل رسائی ہونی چاہیے۔ اسی لیے ہم Klarna اور Payl8r کے ذریعے مالیاتی کے لچکدار اختیارات پیش کرتے ہیں، تاکہ آپ اپنے علاج کی لاگت کو آسانی سے پھیلا سکیں۔</li>
                                        <li>دستیاب منصوبے:</li>
                                        <li>Klarna - 3 میں ادائیگی کریں۔</li>
                                        <li>بغیر کسی سیٹ اپ فیس اور فوری منظوری کے بغیر سود سے پاک قرض تین مساوی ادائیگیوں پر تقسیم ہوتا ہے۔</li>
                                        <li>• Payl8r - ماہانہ ادائیگی کریں۔</li>
                                        <li>اپنے علاج کی لاگت کو 0% سود کے ساتھ 6، 12، 18 یا 24 ماہ تک پھیلائیں (منظوری سے مشروط)۔</li>
                                        <li>• تیز اور آسان درخواست</li>
                                        <li>منظوری کے فیصلے فوری طور پر کیے جاتے ہیں، اس لیے انتظار کا کوئی وقت نہیں ہے۔</li>
                                        <li>آپ کی خریداری کلارنا اور Payl8r کے تعاون سے اسی اعلیٰ سطح کی سیکیورٹی کے ساتھ محفوظ ہے۔</li>
                                        <li>حیثیت کے تابع۔ شرائط و ضوابط لاگو ہوتے ہیں۔ صرف برطانیہ کے رہائشی۔ Klarna اور Payl8r ذمہ دار قرض دہندہ ہیں۔ ادائیگی کی کارکردگی آپ کے کریڈٹ سکور کو متاثر کر سکتی ہے۔</li>
                                    </ul>
                                    <div class="text-center">
                                        <p>* حیثیت سے مشروط۔ Klarna کی شرائط و ضوابط لاگو ہیں۔ Omni Capital Retail Finance Limited کی شرائط و ضوابط لاگو ہیں۔ صرف برطانیہ کے رہائشی۔ کلارنا ایک ذمہ دار قرض دہندہ ہے۔ 3 کارکردگی میں ادائیگی آپ کے کریڈٹ سکور کو متاثر کر سکتی ہے۔</p>
                                    <br>
                                    <p>** صرف اہل خریداریوں پر دستیاب ہے۔</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="javascript:void(0)" class="bigbtn2 primary-btn btn book-a-free rounded-pill"><b>مزید معلومات حاصل کریں۔</b></a>
                                    </div> 
                                </div>
                                @elseif(session('app_locale')=='ar')
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h2>خيار التمويل 0%</h2>
                                    </div>
                                    <ul>
                                        <li>في عيادة دايموند للبشرة، نؤمن بأن الحصول على بشرة رائعة أمرٌ في متناول الجميع. ولذلك، نوفر خيارات تمويل مرنة عبر Klarna وPayl8r، لتتمكن من تقسيط تكلفة علاجاتك بسهولة.</li>
                                        <li>الخطط المتاحة:</li>
                                        <li>• كلارنا - ادفع على 3 دفعات</li>
                                        <li>قرض بدون فوائد مقسم على ثلاث دفعات متساوية، بدون رسوم إعداد وموافقة فورية.</li>
                                        <li>• Payl8r – الدفع الشهري</li>
                                        <li>قم بتقسيم تكلفة العلاج على مدى 6 أو 12 أو 18 أو 24 شهرًا بدون فوائد (وفقًا للموافقة).</li>
                                        <li>• تطبيق سريع وبسيط</li>
                                        <li>يتم اتخاذ قرارات الموافقة على الفور، لذلك لا يوجد وقت انتظار.</li>
                                        <li>سيتم حماية عملية الشراء الخاصة بك بنفس مستوى الأمان العالي الذي تدعمه Klarna وPayl8r.</li>
                                        <li>يخضع للحالة. تُطبق الشروط والأحكام. للمقيمين في المملكة المتحدة فقط. كلارنا وبايلر هما مُقرضان مسؤولان. قد يؤثر أداء السداد على تقييمك الائتماني.</li>
                                    </ul>
                                    <div class="text-center">
                                        <p>* يخضع للحالة. تُطبق شروط وأحكام كلارنا. تُطبق شروط وأحكام أومني كابيتال ريتيل فاينانس المحدودة. للمقيمين في المملكة المتحدة فقط. كلارنا مُقرض مسؤول. قد يؤثر أداء "الدفع على 3 دفعات" على تقييمك الائتماني.</p>
                                    <br>
                                    <p>**متوفر على المشتريات المؤهلة فقط.</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="javascript:void(0)" class="bigbtn2 primary-btn btn book-a-free rounded-pill"><b>اكتشف المزيد</b></a>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h2>Flexible, Interest-Free Payment Options</h2>
                                    </div>
                                    <ul>
                                        <li>At Diamond Skin Clinic, we believe great skin should be accessible. That is why we offer flexible finance options through Klarna and Payl8r, so you can spread the cost of your treatments with ease.</li>
                                        <li>Available Plans:</li>
                                        <li>•	Klarna – Pay in 3</li>
                                        <li>An interest-free loan split over three equal payments, with no setup fees and instant approval.</li>
                                        <li>•	Payl8r – Pay Monthly</li>
                                        <li>Spread your treatment cost over 6, 12, 18, or 24 months with 0% interest (subject to approval).</li>
                                        <li>•	Fast and Simple Application</li>
                                        <li>Approval decisions are made instantly, so there is no waiting time.</li>
                                        <li>Your purchase is protected with the same high level of security supported by Klarna and Payl8r.</li>
                                        <li>Subject to status. Terms and Conditions apply. UK residents only. Klarna and Payl8r are responsible lenders. Payment performance may influence your credit score.</li>
                                    </ul>
                                    <div class="text-center">
                                        <p>* Subject to status. Klarna Terms and Conditions apply. Omni Capital Retail Finance Limited Terms and Conditions apply. UK residents only. Klarna is a responsible lender. Pay in 3 performance may influence your credit score.</p>
                                    <br>
                                    <p>** Available on eligible purchases only.</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="javascript:void(0)" class="bigbtn2 primary-btn btn book-a-free rounded-pill"><b>Find out more</b></a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <div class="£50-Off">
                                @if(session('app_locale')=='cn')
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <h2>اپنے دوست سے رجوع کریں۔</h2>
                                        <img class="mb-4" src="{{ asset('frontend/images/referfriend.webp') }}" alt="">
                                        <p>کسی دوست سے رجوع کریں اور ہمارے کسی بھی کلینک میں £500 سے زیادہ کے علاج یا پیکجز پر بچت کریں۔
                                        <br>پیشکش کا دعوی کرنے کے لیے اپنی مفت مشاورت بک کریں۔
                                        <br>بکنگ کے وقت یا اپنے وزٹ کے دوران بس بکنگ پیج کا اسکرین شاٹ دکھائیں۔
                                        <br>آپ کے دوست کو بھی وہی فوائد ملتے ہیں! T&C کا اطلاق ہوتا ہے۔</p>
                                        <div class="text-center">
                                            <a href="{{ url('referral') }}" class="bigbtn2 primary-btn btn  book-a-free mt-1 rounded-pill" style="background: #0963f9"><b>Book Your Free Consultation to Redeem</b></a>
                                        </div>
                                    </div>
                                </div>
                                @elseif(session('app_locale')=='ar')
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <h2>أحل صديقك</h2>
                                        <img class="mb-4" src="{{ asset('frontend/images/referfriend.webp') }}" alt="">
                                        <p>أحل صديقًا واحصل على خصم على العلاجات أو الباقات التي تزيد قيمتها عن 500 جنيه إسترليني في أي من عياداتنا.
                                        <br>احجز استشارتك المجانية للحصول على العرض.
                                        <br>ما عليك سوى إظهار لقطة شاشة لصفحة الحجز عند الحجز أو أثناء زيارتك.
                                        <br>سيحصل صديقك على نفس المزايا! تطبق الشروط والأحكام.</p>
                                        <div class="text-center">
                                            <a href="{{ url('referral') }}" class="bigbtn2 primary-btn btn  book-a-free mt-1 rounded-pill" style="background: #0963f9"><b>Book Your Free Consultation to Redeem</b></a>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <h2>Refer Your friend</h2>
                                        <img class="mb-4" src="{{ asset('frontend/images/referfriend.webp') }}" alt="">
                                        <p>Refer a friend and save on treatments or packages over £500 at any of our clinics.
                                        <br>Book your free consultation to claim the offer.
                                        <br>Just show a screenshot of booking page at booking or during your visit.
                                        <br>Your friend gets the same benefit too! T&Cs apply.</p>
                                        <div class="text-center">
                                            <a href="{{ url('referral') }}" class="bigbtn2 primary-btn btn  book-a-free mt-1 rounded-pill" style="background: #0963f9"><b>Book Your Free Consultation to Redeem</b></a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="acne-laser" style="margin-top: -57px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2>{{ $category_name11 }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div id="gallerySlider" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if($category->image1)
                            <div class="carousel-item active">
                                <img src="{{ !empty($category->image1) ? asset('uploads/servicecat/' . $category->image1) : asset('assets/img/media/1.jpg') }}" class="d-block w-100" alt="After 1 BBL Session">
                                <div class="carousel-caption d-none d-md-block">
                                    <p></p>
                                </div>
                            </div>
                            @endif
                            @if($category->image2)
                            <div class="carousel-item ">
                                <img src="{{ !empty($category->image2) ? asset('uploads/servicecat/' . $category->image2) : asset('assets/img/media/1.jpg') }}" class="d-block w-100" alt="After 1 BBL Session">
                                <div class="carousel-caption d-none d-md-block">
                                    <p></p>
                                </div>
                            </div>
                            @endif
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#gallerySlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#gallerySlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                </div>
                <div class="col-6">
                    <div id="gallerySlider2" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            
                            @if($category->image3)
                            <div class="carousel-item active">
                                <img src="{{ !empty($category->image3) ? asset('uploads/servicecat/' . $category->image3) : asset('assets/img/media/1.jpg') }}" class="d-block w-100" alt="After 1 BBL Session">
                                <div class="carousel-caption d-none d-md-block">
                                    <p></p>
                                </div>
                            </div>
                            @endif
                            @if($category->image4)
                            <div class="carousel-item ">
                                <img src="{{ !empty($category->image4) ? asset('uploads/servicecat/' . $category->image4) : asset('assets/img/media/1.jpg') }}" class="d-block w-100" alt="After 1 BBL Session">
                                <div class="carousel-caption d-none d-md-block">
                                    <p></p>
                                </div>
                            </div>
                            @endif
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#gallerySlider2" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#gallerySlider2" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                </div>
                
            </div>
        </div>
    </section>
    <section class="common-questions">
        <div class="container-fluid bg-common">
            <div class="row">
                <div class="col-12 text-center mb-md-5 mb-2">
                    <h2>
                        @if(session('app_locale')=='cn')
                        جلد کے حالات
                        @elseif(session('app_locale')=='ar')
                        حالات الجلد
                        @else
                        Common Questions for {{ $category_name11 }} (FAQs)
                        @endif
                    </h2>
                </div>
            </div>
            
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach ($faqs as $item)
                        
                        <?php 
                        if(session('app_locale')=='cn'){
                            $question11 = $item->question_cn;
                            $answer11 = $item->answer_cn;
                            $dir11 = "rtl";
                        }elseif(session('app_locale')=='ar'){
                            $question11 = $item->question_ar;
                            $answer11 = $item->answer_ar;
                            $dir11 = "rtl";
                        }else{
                            $question11 = $item->question;
                            $answer11 = $item->answer;
                            $dir11 = "ltr";
                        }
                        ?>
                        
                        @if($question11!='')
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="flush-headingOne{{ $item->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{ $item->id }}" aria-expanded="false" aria-controls="flush-collapseOne{{ $item->id }}" dir="{{ $dir11 }}">
                                {{ $question11 }}
                            </button>
                          </h2>
                          <div id="flush-collapseOne{{ $item->id }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne{{ $item->id }}" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body" dir="{{ $dir11 }}">{{ $answer11 }}</div>
                          </div>
                        </div>
                        @endif
                        @endforeach
                      </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-experts">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>
                    @if(session('app_locale')=='cn')
                    ہمارے ماہرین
                    @elseif(session('app_locale')=='ar')
                    خبرائنا
                    @else
                    Our Experts
                    @endif
                    </h2>

                </div>
            </div>
            <div class="row">
                @foreach ($teams as $item)
                <div class="col-md-4">
                    <div class="expert-card">
                        <div>
                            <img width="200" height="200" src="{{ !empty($item->profile) ? asset('uploads/team/' . $item->profile) : asset('assets/img/media/1.jpg') }}" alt="">
                        </div>
                        <?php 
                        if(session('app_locale')=='cn'){
                            $teamdescription11 = $item->description_cn;
                        }elseif(session('app_locale')=='ar'){
                            $teamdescription11 = $item->description_ar;
                        }else{
                            $teamdescription11 = $item->description;
                        }
                        ?>
                        <p><b>{{ @$item->team_name }}, {{ @$item->profession }},  {{ @$teamdescription11 }}</b></p>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>

<!-- Acne Laser Treatment Prices modal -->

<?php 
if(session('app_locale')=='cn'){
   
    $Successfully_Added_To_Your_Cart = 'کامیابی کے ساتھ آپ کی ٹوکری میں شامل ہو گیا۔';
    $Service_total = 'سروس کل';
    $Addon_total = 'ایڈون کل';
    $Cart_total = 'کل ٹوکری';
    $I_agree_with_the = 'میں اس سے متفق ہوں۔';
    $terms_and_conditions = 'شرائط و ضوابط';
    $Add_Services = 'خدمات شامل کریں۔';
    $Make_Payment = 'ادائیگی کریں۔';
    $You_may_also_like = 'ایڈونز شامل کیے گئے۔';
    
}elseif(session('app_locale')=='ar'){
    
    $Successfully_Added_To_Your_Cart = 'تمت الإضافة بنجاح إلى سلة التسوق الخاصة بك';
    $Service_total = 'إجمالي الخدمة';
    $Addon_total = 'إجمالي الإضافات';
    $Cart_total = 'إجمالي سلة التسوق';
    $I_agree_with_the = 'انا متفق مع';
    $terms_and_conditions = 'الشروط والأحكام.';
    $Add_Services = 'إضافة الخدمات';
    $Make_Payment = 'قم بالدفع';
    $You_may_also_like = 'الإضافات المضافة';
    
}else{
    
    $Successfully_Added_To_Your_Cart = 'Successfully Added To Your Cart';
    $Service_total = 'Service total';
    $Addon_total = 'Addon total';
    $Cart_total = 'Cart total';
    $I_agree_with_the = 'I agree with the';
    $terms_and_conditions = 'terms and conditions.';
    $Add_Services = 'Add Services';
    $Make_Payment = 'Make Payment';
    $You_may_also_like = 'Added Addons';
    
}
?>

  <!-- Modal -->
  <div class="modal fade add-buy-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content" style="height: 500px; overflow: auto;">
        <div class="modal-header justify-content-center">
           <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $Successfully_Added_To_Your_Cart }}</h1>
          <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="modal-cart">
                <div class="row">
                    <div class="col-lg-6 border-right-1">
                        <div class="overflow-product" id="abc">
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="total-cart">
                            <div>
                                <form id="payment-form">
                                <div class="cart-total-product">
                                    <p>{{ $Service_total }}: <span id="tprice">£0.00</span></p>
                                    <p>{{ $Addon_total }}: <span id="tsprice">£0.00</span></p>
                                    <p>{{ $Cart_total }}: <span id="ttsprice">£0.00</span></p>
                                    
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                        <label class="form-check-label" for="flexCheckDefault">
                                           {{ $I_agree_with_the }} <a target="_blank" href="{{ url('terms-conditions') }}">{{ $terms_and_conditions }}</a>
                                        </label>
                                    </div>
                                    <input type="hidden" id="amount" placeholder="Enter Amount" required>
                                    <button type="button" class="bigbtn without-bg primary-btn btn  mb-3" data-bs-dismiss="modal" aria-label="Close">{{ $Add_Services }}</button>
                                    <button type="submit" class="bigbtn  primary-btn btn mb-3">{{ $Make_Payment }}</button>
                                    <button type="button" class="bigbtn  primary-btn btn mb-3" id="submit-button-klarna">Pay by Klarna</button>
                                    <div id="klarna_container"></div>
                                    <button type="button" id="klarna-pay-button" style="display: none;">Pay with Klarna</button>
                                </div>
                                </form>
                                <form method="post" action="{{ route('klarna.checkout') }}" id="klarnaPaymentForm" >
                                    @csrf
                                    <input type="hidden" id="amount2" name="amount2" placeholder="Enter Amount" required>
                                </form>
                                <div id="payment-result"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-block">
            <div class="text-center">
                <h2>{{ $You_may_also_like }}</h2>
                <div class="shop shop-product-scroll">
                    <div class="container">
                        <div class="row" id="sugpro">
                            
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
  </div>     
  </div>     

<script>
let client_token = null;

document.getElementById("submit-button-klarna").addEventListener("click", () => {
    
    if (!$('#flexCheckDefault').prop('checked')) {
        $('#flexCheckDefault').focus().css('outline', '2px solid red'); // better than border for checkbox
        return false;
    } else {
        $('#flexCheckDefault').css('outline', '');
    }
    
    var billingData = {
        amount2: parseInt($('#amount2').val(), 10) * 100
    };
    
    
    
    fetch('/klarna/session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            purchase_country: "GB",
            purchase_currency: "GBP",
            order_amount: billingData.amount2,
            order_tax_amount: 0,
            locale: "en-GB",
            order_lines: [
                {
                    name: "Dsl Product",
                    quantity: 1,
                    unit_price: billingData.amount2,
                    total_amount: billingData.amount2
                }
            ],
            merchant_urls: {
                confirmation: "https://dslclinic.com/order-success",
                cancel: "https://dslclinic.com/order-cancelled"
            }
        })
    })
    .then(res => res.json())
    .then(data => {
        client_token = data.client_token;
        console.log("Session Created:", data);

        Klarna.Payments.init({ client_token });

        Klarna.Payments.load({
            container: '#klarna_container',
            payment_method_category: 'pay_later' // or pay_now, pay_over_time
        }, function(res) {
            if (res.show_form) {
                //document.getElementById("klarna-pay-button").style.display = 'inline-block';
                document.getElementById("klarna_container").style.display = 'none';
                const payButton = document.getElementById("klarna-pay-button");
                payButton.click();
            }
        });
    });
});

document.getElementById("klarna-pay-button").addEventListener("click", () => {
    
    
    
    var billingData = {
        amount2: parseInt($('#amount2').val(), 10) * 100
    };
    
    
    Klarna.Payments.authorize(
        { payment_method_category: 'pay_later' },
        {},
        function (res) {
            console.log("Authorization Response:", res);
            if (res.approved && res.authorization_token) {
                fetch(`/klarna/order/${res.authorization_token}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        purchase_country: "GB",
                        purchase_currency: "GBP",
                        order_amount: billingData.amount2,
                        order_tax_amount: 0,
                        locale: "en-GB",
                        order_lines: [
                            {
                                name: "Dsl Product",
                                quantity: 1,
                                unit_price: billingData.amount2,
                                total_amount: billingData.amount2
                            }
                        ],
                        merchant_reference1: "Order_Test_001"
                    })
                })
                .then(res => res.json())
                .then(order => {
                    console.log("Order Created:", order);
                    //alert("Order Created: " + order.order_id);
                    window.location.href = "/klarna/booking-success/" + order.order_id;
                });
            }
        }
    );
});
</script>
<script>
    function submitKlarnaForm() {
        
        if (!$('#flexCheckDefault').prop('checked')) {
            $('#flexCheckDefault').focus().css('outline', '2px solid red'); // better than border for checkbox
            return false;
        } else {
            $('#flexCheckDefault').css('outline', '');
        }

        
        console.log("Button clicked! Submitting Klarna form...");
        
        // Submit the hidden form
        document.getElementById("klarnaPaymentForm").submit();
    }
</script>

<script>
    document.getElementById('payment-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        
        let amount = document.getElementById('amount').value;

        const response = await fetch("{{ route('stripe.create.payment') }}", {
            method: "POST",
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': "{{ csrf_token() }}" 
            },
            body: JSON.stringify({ amount: amount })
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = data.payment_url;
        } else {
            document.getElementById('payment-result').innerText = data.message;
        }
    });
</script>

<script>
    
function addRemoveService(stype, sid, action, ssession, sprice) {
    
    
    if(stype!='addon'){
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        myModal.show();
    }
    
    return $.ajax({
        url: "{{ route('addRemoveService') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            sid: sid,
            stype: stype,
            ssession: ssession,
            sprice: sprice,
            action: action,
        },
        beforeSend: function() {
           
        },
        success: function(res) {
            //console.log(res.sugpro);
            if (res.status === 'success') {
                
                $('#tprice').html('£'+res.tprice);
                $('#tsprice').html('£'+res.tsprice);
                $('#ttsprice').html('£'+res.ttsprice);
                $('#amount').val(res.ttsprice_num);
                $('#amount2').val(res.ttsprice_num);
                $('#abc').html(res.abc);
                $('#sugpro').html(res.sugpro);
                
                if (action === 'add') {
                    
                } else if (action === 'remove') {
                   
                }

                $('#cartCount').html(res.cartCount); // Replace `cartCount` with the correct key from the response
                
                //console.log('Cart updated successfully:', res);
            } else {
                //console.error('Failed to update the cart:', res.message);
                //alert('Something went wrong. Please try again.');
            }
        },
        error: function(err) {
            console.error('AJAX error:', err);
            alert('An error occurred while communicating with the server.');
        }
    });
}

    
</script> 


     
@endsection
