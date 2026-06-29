@extends('frontend.layout.app')

@section('content')


   <div class="breadcrumb-cell" aria-label="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <a href="#"> Home </a> &gt; 
                        @if(session('app_locale')=='cn')
                        تمام خدمات
                        @elseif(session('app_locale')=='ar')
                        جميع الخدمات
                        @else
                        All Services
                        @endif
                     </ol>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2>
                        @if(session('app_locale')=='cn')
                        تمام خدمات
                        @elseif(session('app_locale')=='ar')
                        جميع الخدمات
                        @else
                        All Services
                        @endif
                    </h2>
                   
                </div>
            </div>
            <div class="row ">
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
                            $category_name11 = \Illuminate\Support\Str::limit($item->category_name_cn, 35);
                        }elseif(session('app_locale')=='ar'){
                            
                            if($item->icon_ar!=''){
                            $icon11 = $item->icon_ar;
                            }else{
                            $icon11 = $item->icon;
                            }
                            $category_name11 = \Illuminate\Support\Str::limit($item->category_name_ar, 35);
                        }else{
                            
                            $icon11 = $item->icon;
                            $category_name11 =  \Illuminate\Support\Str::limit($item->category_name, 35);
                        }
                        ?>
                        <a href="{{ url('/' . $item->category_slug) }}">
                        <img src="{{ !empty($item->icon) ? asset('uploads/servicecat/' . $item->icon) : asset('assets/img/media/1.jpg') }}" alt="">
                        <h4 class="mb-4" style="    height: 42px; align-items: center; display: flex;">
                            {{ $category_name11 }}
                        </h4>
                        </a>
                        <a href="{{ url('/' . $item->category_slug) }}" class="bigbtn primary-btn btn" > 
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
     
@endsection
