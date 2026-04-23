@extends('frontend.layouts.base')
@section('title', 'Visit '.$destination->name.'')
@section('extra_style')
<style>
    /* Target the last child of the ul with class 'list-items' */
    ul.list-items li:last-child a {
        /* Apply the desired color to the last <li> element */
        color: #004AAD;
        /* Change 'red' to your desired color */
    }

    .description-container {
        /* Set the maximum width for the container to prevent overflow */
        max-width: 800px;
        /* Change this value as needed */
        word-wrap: break-word;
        text-align: justify !important;
    }
</style>
@endsection

@section('contents')
<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bg-dark-opacity py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between">
                    <div class="section-heading">
                        <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0">
                            <li><a href="/">Home</a></li>
                            <li><a href="{{route('destination.all')}}">Destinations</a></li>
                            <li><a href="#">{{ $destination->name }}</a></li>
                        </ul>
                        <div class="d-flex align-items-center pt-1">
                            <h2 class="sec__title mb-0">{{ $destination->name }}</h2>
                            
                        </div>
                    </div>
                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
    START LISTING DETAIL AREA
================================= -->
<section class="listing-detail-area padding-top-60px padding-bottom-100px">
    <div class="container">
        <div class="row">

            <div class="col-lg-8">
                <div class="listing-detail-wrap">
                    @include('frontend.pages.destinations.partials.description')
                </div>

                <div class="block-card mb-4">
                    <div class="block-card-header">
                        <h2 class="widget-title">{{$destination->name}} Tour</h2>
                        <div class="stroke-shape"></div>
                    </div><!-- end block-card-header -->
                    <div class="block-card-body">
                        
                    {!! $destination->codes !!}
                    </div><!-- end block-card-body -->
                </div><!-- end block-card -->

            </div><!-- end listing-detail-wrap -->
            @include('frontend.pages.destinations.partials.right_side_business_details')

        </div><!-- end row-->

    </div><!-- end row -->

</section><!-- end listing-detail-area -->
<!-- ================================
    END LISTING DETAIL  AREA
================================= -->



@endsection

@section('extra_js_script')
@endsection