@extends('frontend.layout.app')
@section('content')

<?php 
if(session('app_locale')=='cn'){
    $Team = 'Team';
}elseif(session('app_locale')=='ar'){
    $Team = 'Team';
}else{
    $Team = 'Team';
}
?>

<div class="breadcrumb-cell" aria-label="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb mb-0">
                    <a href="https://dslclinic.com"> Home </a> &gt; {{ $Team }}
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="banner-hero p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="homepage-slider-banner">
                    @foreach ($home_top_banner as $item)  
                    <a href="#">
                        <img src="{{ !empty($item->profile) ? asset('uploads/banner/' . $item->profile) : asset('uploads/userimage/no-banner.jpg') }}" alt="">
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
</section>
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
<section class="our-experts">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>
                    Our Experts
                </h2>
            </div>
        </div>
        <div class="row">
            @foreach ($teams as $item)
            <div class="col-md-4">
                <div class="expert-card">
                    <a href="{{ url('/' . $item->team_slug) }}">
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
                    <h4>{{ @$item->team_name }}</h4>
                    <p><b>{{ @$item->profession }},  {{ @$teamdescription11 }}</b></p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection