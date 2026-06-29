@extends('frontend.layout.app')
@section('content')

<style>
    
    .error-container {
      padding: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
    }
    .error-code {
      font-size: 120px;
      font-weight: bold;
      color: #dc3545;
    }
    .error-text {
      font-size: 24px;
      color: #6c757d;
    }
    .btn-home {
      margin-top: 20px;
      margin-bottom: 40px;
    }
  </style>


<?php 
if(session('app_locale')=='cn'){
    $Page_Not_Found = 'صفحہ نہیں ملا';
}elseif(session('app_locale')=='ar'){
    $Page_Not_Found = 'لم يتم العثور على الصفحة';
}else{
    $Page_Not_Found = 'Page Not Found';
}
?>

<div class="breadcrumb-cell" aria-label="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb mb-0">
                    <a href="https://dsl.devolyt.com"> Home </a> &gt; {{ $Page_Not_Found }}
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container error-container">
    <div class="error-code">404</div>
    <div class="error-text">Oops! The page you're looking for doesn't exist.</div>
    <a href="/" class="btn btn-primary btn-home">Go to Homepage</a>
  </div>

@endsection