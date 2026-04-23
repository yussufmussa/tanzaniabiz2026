@extends('frontend.layouts.base')
@section('title', ''.$data['title'].'')
@section('description', ''.$data['description'].'')
@section('extra_style')
<style>
    .fs-slider-item {
        width: 100%;
        height: auto;
    }

    .fs-slider-item img {
        width: 300px;
        height: 300px;
        object-fit: cover;
    }

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
<!-- og tags -->
<meta property="og:title" content="{{$data['title']}}">
<meta property="og:description" content="{{$data['description']}}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{$data['images'][0]['variants'][8]['url']}}">
<meta property="og:type" content="website">
<!-- og tags -->

@endsection

@section('contents')

<!-- ================================
    START FULL SCREEN SLIDER
================================= -->
<section class="full-screen-slider-area">
    <div class="full-screen-slider owl-trigger-action owl-trigger-action-2">
        @foreach ($data['images'] as $image)
        @if (!empty($image['variants'][3]['url']))
        <a href="{{$image['variants'][3]['url']}}" class="fs-slider-item d-block" data-fancybox="gallery" data-caption="{{$image['caption']}}">
            <img src="{{$image['variants'][3]['url']}}" alt="{{$image['caption']}}">
        </a><!-- end fs-slider-item -->
        @endif
        @endforeach
    </div>
</section><!-- end full-screen-slider-area -->
<!-- ================================
    END FULL SCREEN SLIDER
================================= -->

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
                            <li><a href="/tanzania-safari-packages">Safari Package</a></li>
                            <li><a href="{{route('package.details', $data['productCode'])}}">{{ $data['title']}}</a></li>
                        </ul>
                        <div class="d-flex align-items-center pt-1">
                            <h2 class="sec__title mb-0">{{ $data['title']}}</h2>
                            <div class="hover-tooltip-box ml-2 pt-2">

                            </div>
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
                    <div class="block-card mb-4">
                        <div class="block-card-header">
                            <h2 class="widget-title">Overview</h2>
                            <div class="stroke-shape"></div>
                        </div><!-- end block-card-header -->
                        <div class="block-card-body">

                            <div class="font-weight-medium line-height-30 pb-3 description-container">
                                <p>
                                    <span class="text-justify"> {{$data['description']}}</span>
                                <ul class="row row info-list">
                                    @if(isset($data['viatorUniqueContent']))
                                    @foreach($data['viatorUniqueContent']['highlights'] as $highlight)
                                    <li class="col-lg-12"><i class="la la-check mr-2 text-color-4"></i>{{$highlight}}</li>
                                    @endforeach
                                    @endif

                                </ul>
                                </p>
                            </div><!-- end block-card-body -->


                            <h3 class="widget-title">what's Included</h3>
                            <div class="section-block"></div>
                            <ul class="row info-list  mt-3 mb-4">
                                @foreach ($data['inclusions'] as $inclusion)
                                @if (isset($inclusion['otherDescription']))
                                <li class="col-lg-12"><i class="la la-check mr-2 text-color-4"></i>{{ $inclusion['otherDescription'] }}</li>
                                @endif
                                @if (isset($inclusion['description']))
                                <li class="col-lg-12"><i class="la la-check mr-2 text-color-4"></i>{{ $inclusion['description'] }}</li>
                                @endif
                                @endforeach
                            </ul>

                            <h2 class="widget-title">What's Excluded</h2>
                            <div class="section-block"></div>
                            <ul class="row info-list  mt-3 mb-4">
                                @foreach ($data['exclusions'] as $inclusion)
                                @if (isset($inclusion['otherDescription']))
                                <li class="col-lg-12"><i class="la la-times mr-2 text-danger"></i>{{ $inclusion['otherDescription'] }}</li>
                                @endif
                                @if (isset($inclusion['description']))
                                <li class="col-lg-12"><i class="la la-times mr-2 text-danger"></i>{{ $inclusion['description'] }}</li>
                                @endif
                                @endforeach
                            </ul>

                            <h2 class="widget-title">What To Expect</h2>
                            <div class="section-block"></div>
                            <div class="payment-option-wrap">
                                @foreach($data['itinerary']['days'] as $key => $day)
                                <div class="payment-tab {{$key == 0 ? 'is-active' : ''}}">
                                    <div class="payment-tab-toggle">
                                        <span class="badge badge-success">Day {{$day['dayNumber']}}</span>
                                        <input {{$key == 0 ? 'checked' : ''}} id="Day{{$day['dayNumber']}}" name="Day{{$day['dayNumber']}}" type="radio" value="Day{{$day['dayNumber']}}">
                                        <label for="Day{{$day['dayNumber']}}">{{$day['title']}}</label>
                                    </div>
                                    <div class="payment-tab-content">
                                        @foreach($day['items'] as $item)
                                        <p class="text-justify">{{$item['description']}}</p>
                                        @endforeach

                                        @if(isset($day['accommodations']))
                                        @foreach($day['accommodations'] as $item)
                                        <p class="mt-3><strong ">Accomodation:</strong>{{$item['description']}} </p>
                                        @endforeach
                                        @endif

                                        @if(isset($day['foodAndDrinks']))
                                        @foreach($day['foodAndDrinks'] as $item)
                                        @if(!empty($item['description']))
                                        <p><strong>Meal: </strong> {{$item['description']}}</p>
                                        @else
                                        <p><strong>Meal: </strong> {{$item['typeDescription']}}</p>
                                        @endif
                                        @endforeach
                                        @endif

                                    </div>
                                </div><!-- end payment-tab -->
                                @endforeach

                            </div><!-- end payment-option-wrap -->

                            <h2 class="widget-title">Additonal Information</h2>
                            <div class="section-block"></div>
                            <ul class="row info-list  mt-3 mb-4">
                                @foreach($data['additionalInfo'] as $info)
                                @if(isset($info['description']))
                                <li class="col-lg-6"><i class="la la-check mr-2 text-color-4"></i>{{$info['description']}}</li>
                                @endif
                                @endforeach
                            </ul>



                        </div><!-- end block-card -->


                    </div><!-- end listing-detail-wrap -->
                </div>
            </div><!-- end col-lg-8 -->

            <!-- Right hand side -->
            @include('frontend.pages.packages.partials.right_side')
            <!-- End right hand side -->
        </div><!-- end row -->

</section><!-- end listing-detail-area -->
<!-- ================================
    END LISTING DETAIL  AREA
================================= -->


@include('frontend.pages.packages.partials.related_tour')
@endsection

@section('extra_js_script')

@endsection