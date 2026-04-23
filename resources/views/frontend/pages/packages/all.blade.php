@extends('frontend.layouts.base')
@section('title', 'Tanzania Safari Package')
@section('description', 'List of Tanzania Safari Packages for your holiday in Tanzania')
@section('extra_style')
<style>
    /* Target the last child of the ul with class 'list-items' */
    ul.list-items li:last-child a {
        /* Apply the desired color to the last <li> element */
        color: #004AAD;
        /* Change 'red' to your desired color */
    }

    .card-area p {
        line-height: 1.5em;
        text-align: justify;
        font-size: 18px !important;
        padding: 4px;
    }

    .theme-btn.offer-btn:hover{
        background-color: #004AAD;
    color: #fff;
   }

   .offer-btn{
    border: 1px solid #004AAD !important;
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
                        <li><a href="/tanzania-safari-pacakges">Safari Package</a></li>
                    </ul>
                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container-fluid -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
    START CARD AREA
================================= -->
<section class="card-area section-padding">
    <div class="container">
        <div class="row">
            @foreach($data['products'] as $product)
            <div class="col-lg-4 responsive-column">
                <div class="card-item">
                    <div class="card-image">
                        <a href="{{route('package.details', $product['productCode'] )}}" class="d-block">
                            <img src="{{ $product['images'][0]['variants'][8]['url'] }}" class="card__img" alt="">
                        </a>

                    </div>
                    <div class="card-content">

                        <h4 class="card-title pt-3">
                            <a href="{{route('package.details', $product['productCode'] )}}">{{$product['title']}}</a>
                        </h4>
                       
                        <ul class="listing-meta d-flex align-items-center">
                            {{-- Access the VIATOR provider reviews --}}
                            
                            <li>
                                <i class="la la-clock"></i>Free Cancellation
                            </li>
                            <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top" title="Pricey">
                                   <strong class="font-weight-medium"> From  ${{ $product['pricing']['summary']['fromPrice'] }}</strong>
                                </span>
                            </li>

                        </ul>
                        <ul class="info-list padding-top-20px">
                            <li>

                                @if (isset($product['duration']['fixedDurationInMinutes']))
                                @php
                                $durationInMinutes = $product['duration']['fixedDurationInMinutes'];
                                $hours = floor($durationInMinutes / 60);
                                $minutes = $durationInMinutes % 60;
                                @endphp
                                <span class="la la-clock icon"></span> {{ $hours }} hours {{$minutes }} Minutes
                                @endif

                            </li>
                        </ul>

                        <div class="text-center">
                            <a href="{{route('package.details', $product['productCode'] )}}" class="theme-btn offer-btn border-0 w-100">View Package</a>
                        </div>
                    </div>
                </div><!-- end card-item -->
            </div><!-- end col-lg-4 -->
            @endforeach
        </div>






    </div>
    @endsection



    @section('extra_js_script')
    @endsection