@extends('frontend.layout.app')
@section('content')

<?php 
if(session('app_locale')=='cn'){
    if($teamdetails->banner_cn!=''){
        $banner11 = $teamdetails->banner_cn;
    }else{
        $banner11 = $teamdetails->banner;
    }
    $description11 = $teamdetails->description_cn;
    $longdescription11 = $teamdetails->long_description_cn;
    $Team_Details = 'ٹیم کی تفصیلات';
}elseif(session('app_locale')=='ar'){
    if($teamdetails->banner_ar!=''){
        $banner11 = $teamdetails->banner_ar;
    }else{
        $banner11 = $teamdetails->banner;
    }
    $description11 = $teamdetails->description_ar;
    $longdescription11 = $teamdetails->long_description_ar;
    $Team_Details = 'تفاصيل الفريق';
}else{
    $banner11 = $teamdetails->banner;
    $description11 = $teamdetails->description;
    $longdescription11 = $teamdetails->long_description;
    $Team_Details = 'Team Details';
}
?>

<div class="breadcrumb-cell" aria-label="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <a href="https://dslclinic.com"> Home </a> &gt; {{ $Team_Details }}
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if($banner11)
    <section class="banner-acne p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-0">
                    <img src="{{ !empty($banner11) ? asset('uploads/team/' . $banner11) : asset('uploads/userimage/no-banner.jpg') }}" alt="{{ $teamdetails->team_name }}">
                </div>
            </div>
        </div>
    </section>
    @endif
    <section class="acne">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h4>{{ $teamdetails->team_name }} - {{ $teamdetails->profession }}</h4>
                    <br>
                    <h4>{{ $teamdetails->team_name }} is available for consultations and treatments.</h4>
                    <p>{{ $teamdetails->team_name }}, {{ $description11 }}</p>
                    <?= $longdescription11 ?>
                </div>
            </div>
        </div>
    </section>
    
    <div class="team_detail_category ">
        <div class="container">
            <div class="row">
                <h4 class="text-center  pb-3">Work Category</h4>
                @foreach ($categories as $item)  
                <?php 
                if(session('app_locale')=='cn'){
                    if($item->icon_cn!=''){
                    $icon11 = $item->icon_cn;
                    }else{
                    $icon11 = $item->icon;
                    }
                    $category_name11 = $item->category_name_cn;
                }elseif(session('app_locale')=='ar'){
                    
                    if($item->icon_ar!=''){
                    $icon11 = $item->icon_ar;
                    }else{
                    $icon11 = $item->icon;
                    }
                    $category_name11 = $item->category_name_ar;
                }else{
                    
                    $icon11 = $item->icon;
                    $category_name11 = $item->category_name;
                }
                ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ url('/' . $item->category_slug) }}" class="skin-image">
                        <div class="skin-care-image-box">
                            <img class="skincare-image" src="{{ !empty($icon11) ? asset('uploads/servicecat/' . $icon11) : asset('uploads/servicecat/no-servicecat.jpg') }}" alt="">
                        </div>
                        <div class="text-bg">
                            <p>{{ $category_name11}}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            
            <div class="row ">
                <h4 class="text-center pb-3 pt-5">Work Condition</h4>
                @foreach ($conditions as $item)
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="skin-condtion">
                        <?php 
                        if(session('app_locale')=='cn'){
                            if($item->icon_cn!=''){
                            $icon11 = $item->icon_cn;
                            }else{
                            $icon11 = $item->icon;
                            }
                            $category_name11 = $item->category_name_cn;
                        }elseif(session('app_locale')=='ar'){
                            
                            if($item->icon_ar!=''){
                            $icon11 = $item->icon_ar;
                            }else{
                            $icon11 = $item->icon;
                            }
                            $category_name11 = $item->category_name_ar;
                        }else{
                            
                            $icon11 = $item->icon;
                            $category_name11 = $item->category_name;
                        }
                        ?>
                        <a href="{{ url('/' . $item->category_slug) }}">
                        <img src="{{ !empty($item->icon) ? asset('uploads/servicecat/' . $item->icon) : asset('assets/img/media/1.jpg') }}" alt="">
                        <h4 class="mb-4">
                            {{ $category_name11 }}
                        </h4>
                        </a>
                        <a href="{{ url('/' . $item->category_slug) }}" class="bigbtn primary-btn btn"> 
                            @if(session('app_locale')=='cn')
                            مزید معلومات حاصل کریں۔
                            @elseif(session('app_locale')=='ar')
                            اكتشف المزيد
                            @else
                            Find out more
                            @endif
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection