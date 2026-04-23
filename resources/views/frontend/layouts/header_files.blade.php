<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="author" content="Web directory by https:/yussufmussa.com ">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>@yield('title')</title>

<!-- SEO META -->
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords')">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{url()->current()}}">

<!-- Favicon -->
<link rel="icon" href="{{asset('uploads/general/'.$setting->favicon)}}" sizes="96x96" type="image/png">
<link rel="apple-touch-icon" href="{{asset('uploads/general/'.$setting->favicon)}}">
<link rel="stylesheet" href="{{ asset('frontend/css/custom_css.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Template CSS Files -->
<link rel="stylesheet" href="{{asset('frontend/css/styles.css')}}">

<!-- GA Codes -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{$seo->google_analytics_code}}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', '{{$seo->google_analytics_code}}');
</script>
<!-- end GA codes -->

{{-- adsense --}}
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{$seo->google_adsense_code}}" crossorigin="anonymous"></script>
<!-- adsense -->

<!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$seo->google_tag_manager}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', '{{$seo->google_tag_manager}}');
    </script>
@stack('extra_style')
@livewireStyles
</head>
