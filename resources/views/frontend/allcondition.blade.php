@extends('frontend.layout.app')

@section('content')


   <div class="breadcrumb-cell" aria-label="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb mb-0">
                        <a href="#"> Home </a> &gt; 
                        @if(session('app_locale')=='cn')
                        اکثر پوچھے جانے والے سوالات
                        @elseif(session('app_locale')=='ar')
                        الأسئلة الشائعة
                        @else
                        Skin Conditions
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
                        اکثر پوچھے جانے والے سوالات
                        @elseif(session('app_locale')=='ar')
                        الأسئلة الشائعة
                        @else
                        Skin Conditions
                        @endif
                    </h2>
                    <h4>
                        @if(session('app_locale')=='cn')
                        مختلف حالتوں کے لیے جلد اور جسمانی علاج
                        @elseif(session('app_locale')=='ar')
                        علاجات البشرة والجسم لحالات مختلفة
                        @else
                        Skin and Body Treatments for Different Conditions
                        @endif
                    </h4>
                    <p>
                        @if(session('app_locale')=='cn')
                        ڈی ایس ایل کلینک (یو کے) لمیٹڈ میں، ہم جلد اور جسمانی حالات کی ایک وسیع رینج کے لیے موزوں علاج پیش کرتے ہیں، ہلکے خدشات سے لے کر جلد کے پیچیدہ مسائل تک۔ ہماری ماہر ٹیم مہاسوں، rosacea، ہائپر پگمنٹیشن اور بہت کچھ جیسے حالات سے نمٹنے کے لیے ہمدردانہ دیکھ بھال کے ساتھ جدید ٹیکنالوجی کو یکجا کرتی ہے۔ ہمیں صحت مند جلد اور تجدید اعتماد کے خواہاں افراد کے لیے ایک قابل اعتماد منزل ہونے پر فخر ہے۔
                        @elseif(session('app_locale')=='ar')
                        في عيادة DSL (المملكة المتحدة) المحدودة، نقدم علاجات مُصممة خصيصًا لمجموعة واسعة من مشاكل البشرة والجسم، بدءًا من الحالات البسيطة وصولًا إلى المشاكل الجلدية الأكثر تعقيدًا. يجمع فريقنا من الخبراء بين أحدث التقنيات والرعاية الرحيمة لمعالجة حالات مثل حب الشباب، والوردية، وفرط التصبغ، وغيرها. نفخر بكوننا وجهةً موثوقةً لمن يبحثون عن بشرة أكثر صحة وثقةً متجددة.
                        @else
                        At DSL Clinic (UK) Ltd, we offer tailored treatments for a wide range of skin and body conditions, from mild concerns to more complex dermatological issues. Our expert team combines cutting-edge technology with compassionate care to address conditions such as acne, rosacea, hyperpigmentation, and more. We take pride in being a trusted destination for those seeking healthier skin and renewed confidence.
                        @endif
                    </p>
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
