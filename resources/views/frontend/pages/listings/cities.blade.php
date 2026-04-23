@extends('frontend.layouts.base')
@section('title', 'Browse Tourism Business By City - Tanzania Tourism Business Listing')
@section('description', 'List of cities with their tourism based business')



@section('contents')

<section class="space min py-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/browse-business-by-category">All Cities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </nav>
                <div class="">
                    <h2 class="ft-bold">Search Tanzania Companies Easily</h2>
                </div>
            </div>

            <div class="d-block grouping-listings-title">
                <p>Your search for Tanzania Business Made easier browse through all <strong>{{$cities->count()}}</strong> Business Regions for Tanzanian Companies.</p>
            </div>
        </div>


        <div class="row mt-3">
            @foreach($cities as $city)
            <div class="col-md-3">
                <ul>
                    <li><a href="{{route('filter.city', ['city' => $city->slug])}}">{{$city->city_name}}</a> <strong>{{$city->listings->count()}}</strong></li>

                </ul>

            </div>
            @endforeach

        </div><!-- end col-lg-3 -->

    </div>
</section>

@include('frontend.partials.cta')


@endsection

