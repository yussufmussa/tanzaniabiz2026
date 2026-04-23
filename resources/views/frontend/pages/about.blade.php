@extends('frontend.layouts.base')
@section('title', 'Tanzania Free Business Directory')
@section('description', ''.$setting->first()->meta_description.'')

@section('contents')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="bg-dark py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-light">Home</a></li>
                        <li class="breadcrumb-item active theme-cl" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= About Us Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-between">

            <div class="col-xl-11 col-lg-12 col-md-6 col-sm-12">
                <div class="abt_caption">
                    <h1 class="ft-medium mb-4">About Tanzania Biz</h1>
                    <p class="mb-4">
                        <strong>TanzaniaBiz</strong> Puts Tanzanian business to the face of consumers. At <strong>TanzaniBiz</strong> we believe in the power of local enterprises and aim to create a dynamic platform that fosters growth, collaboration, and success.
                    </p>
                    <p class="mb-4">
                        Our platform is more than just a directory; it's a digital hub designed to elevate Tanzanian businesses by providing them with visibility, accessibility, and the tools they need to thrive in today's competitive market. Whether you're a small startup or an established company, <strong>TanzaniaBiz</strong> is here to be your digital partner on the path to success.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ======================= About Us End ======================== -->

<!-- ======================= Why choose Us======================== -->
<section class="space min">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h2 class="ft-bold">Why Choose TanzaniaBiz</h2>
                </div>
            </div>
        </div>

        <div class="row align-items-center">

            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="wrk-pro-box first">
                    <div class="wrk-pro-box-icon"><i class="ti-map-alt text-success"></i></div>
                    <div class="wrk-pro-box-caption">
                        <h4>Comprehensive Listings</h4>
                        <p>We go beyond basic business information, offering detailed and engaging profiles to help businesses stand out.</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="wrk-pro-box sec">
                    <div class="wrk-pro-box-icon"><i class="ti-user theme-cl"></i></div>
                    <div class="wrk-pro-box-caption">
                        <h4>User-Friendly Interface</h4>
                        <p>Our platform is designed with simplicity in mind, ensuring a smooth experience for both businesses and consumers.</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="wrk-pro-box thrd">
                    <div class="wrk-pro-box-icon"><i class="ti-shield text-sky"></i></div>
                    <div class="wrk-pro-box-caption">
                        <h4>Innovative Features</h4>
                        <p>From advanced search options to real-time updates, we provide tools that empower businesses to stay ahead in the digital landscape.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ======================= Why choose us ======================= -->

@include('frontend.partials.cta')

@endsection
