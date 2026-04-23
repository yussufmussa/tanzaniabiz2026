@extends('frontend.layouts.base')
@section('title', 'List of Top Tourist Attractions in Tanzania')
@section('description', 'Explore top attractions in Tanzania')
@section('extra_style')
<style>
    /* Target the last child of the ul with class 'list-items' */
    ul.list-items li:last-child a {
        /* Apply the desired color to the last <li> element */
        color: #004AAD;
        /* Change 'red' to your desired color */
    }
</style>
@endsection

@section('contents')

<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bg-dark-opacity py-4">
    <div class="container-fluid padding-right-40px padding-left-40px">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
                    <ul class="list-items bread-list bread-list-2 ">
                        <li><a href="/">Home</a></li>
                        <li><a href="/destinations">Cities</a></li>
                    </ul>

                    <div class="section-heading">
                        <h2 class="sec__title font-size-26 mb-0">Top Attractions</h2>
                    </div>

                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container-fluid -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
    START CATEGORY AREA
================================= -->
<section class="category-area position-relative bg-gray section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title">Top Attractions in Tanzania</h2>
                    <p class="sec__desc">
                        Explore top attractions in Tanzania
                    </p>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row highlighted-categories justify-content-center">
            @foreach($destinations as $destination)
            <div class="col-lg-3 responsive-column">
                <div class="category-item category-item-layout-2 category-item-layout--2 js-tilt-2 ">
                    <img src="{{ asset('photos/destinations/'.$destination->thumbnail) }}" data-src="{{ asset('photos/destinations/'.$destination->thumbnail) }}" alt="{{ $destination->name }}" class="cat-img lazy cat-img-height">
                    <div class="category-content">
                        <a href="{{route('destination.details',['slug' => $destination->slug])}}" class="category-link d-flex align-items-end w-100 h-100 text-left">
                            <div class="category-content-inner d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="cat__title mb-1">{{ $destination->name }}</h4>

                                </div>

                            </div>
                        </a>
                    </div>
                </div><!-- end category-item -->
            </div><!-- end col-lg-6 -->
            @endforeach
        </div>
    </div><!-- end container -->
</section><!-- end category-area -->
<!-- ================================
    END CATEGORY AREA
================================= -->


@endsection

@section('extra_js_script')

@endsection