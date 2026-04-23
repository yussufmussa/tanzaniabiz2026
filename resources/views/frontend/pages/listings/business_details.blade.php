@extends('frontend.layouts.base')
@section('title', '' . $business->name . '')
@section('description', \Illuminate\Support\Str::limit($business->description, 160))

@push('extra_style')
{{-- Open Graph --}}
<meta property="og:url" content="{{ route('listing.details', $business->slug) }}">
<meta property="og:type" content="business.business">
<meta property="og:title" content="{{ e($business->name) }}">
<meta property="og:description" content="{{ e(\Illuminate\Support\Str::limit(strip_tags($business->description), 160)) }}">
<meta property="og:image" content="{{ asset('uploads/businessListings/logos/' . $business->logo) }}">
<meta property="og:site_name" content="TanzaniaBiz">
{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ route('listing.details', $business->slug) }}">
<meta name="twitter:title" content="{{ e($business->name) }}">
<meta name="twitter:description" content="{{ e(\Illuminate\Support\Str::limit(strip_tags($business->description), 160)) }}">
{{-- <meta name="twitter:image" content="{{ $business->logo ? asset('uploads/businessListings/logos/' . $business->logo) : asset('images/default-business.jpg') }}"> --}}
<meta name="twitter:image" content="{{ asset('uploads/businessListings/logos/' . $business->logo) }}">
<meta name="twitter:domain" content="{{ request()->getHost() }}">

<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "{{ $business->name }}",
    "description": "{{ Str::limit(strip_tags($business->description), 200) }}",
    "url": "{{ route('listing.details', $business->slug) }}",
    @if($business->phone)
    "telephone": "{{ $business->phone }}",
    @endif
    @if($business->email)
    "email": "{{ $business->email }}",
    @endif
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ $business->location }}",
        "addressLocality": "{{ $business->city->city_name }}",
        "addressCountry": "TZ"
    },
    @if($business->latitude && $business->longitude)
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": {{ $business->latitude }},
        "longitude": {{ $business->longitude }}
    },
    @endif
    @if($business->photos->count() > 0)
    "image": [
        @foreach($business->photos as $photo)
            "{{ asset('uploads/businessListings/photos/' . $photo->name) }}"{{ !$loop->last ? ',' : '' }}
        @endforeach
    ],
    @endif
    @if($business->category)
    "category": "{{ $business->category->name }}",
    @endif
    "openingHoursSpecification": [
        @php
            $schemadays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            $lastOpen = $business->workingHours->where('is_closed', false)->last();
        @endphp
        @foreach($schemadays as $index => $day)
            @php $hours = $business->workingHours->firstWhere('day_of_week', $index); @endphp
            @if($hours && !$hours->is_closed)
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["{{ $day }}"],
                @if($hours->is_24_7)
                "opens": "00:00",
                "closes": "23:59"
                @else
                "opens": "{{ \Carbon\Carbon::parse($hours->open_time)->format('H:i') }}",
                "closes": "{{ \Carbon\Carbon::parse($hours->close_time)->format('H:i') }}"
                @endif
            }{{ $hours->id !== $lastOpen?->id ? ',' : '' }}
            @endif
        @endforeach
    ],
    @if($business->products->count() > 0)
    "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Products",
        "itemListElement": [
            @foreach($business->products as $product)
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Product",
                    "name": "{{ $product->name }}",
                    "description": "{{ Str::limit(strip_tags($product->description), 100) }}"
                    @if($product->photo)
                    ,"image": "{{ asset('uploads/businessListings/products/' . $product->photo) }}"
                    @endif
                    @if($product->price)
                    ,"offers": {
                        "@type": "Offer",
                        "price": "{{ $product->price }}",
                        "priceCurrency": "TZS"
                    }
                    @endif
                }
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
    },
    @endif
    "sameAs": [
    @php
        $sameAs = [];
        if($business->website) $sameAs[] = $business->website;
        foreach($business->social_medias as $media) {
            if($media->pivot->link) $sameAs[] = $media->pivot->link;
        }
    @endphp
    @foreach($sameAs as $url)
        "{{ $url }}"{{ !$loop->last ? ',' : '' }}
    @endforeach
]
}
</script>
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "{{ $business->category->name }}",
            "item": "{{ route('business.category', $business->category->slug) }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $business->name }}",
            "item": "{{ route('listing.details', $business->slug) }}"
        }
    ]
}
</script>
@endpush

@section('contents')

    <!-- ============================ Listing Details Start ================================== -->
    <section class="gray py-1 position-relative">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="row mb-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('business.category', $business->category->slug) }}">{{ $business->category->name }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $business->name }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end BreadCrumb -->
            <div class="row">

                {{-- LEFT COLUMN --}}
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">

                    @include('frontend.pages.listings.partials.photos')

                    @include('frontend.pages.listings.partials.description')

                    @include('frontend.pages.listings.partials.products')
                    @include('frontend.pages.listings.partials.youtube')
                    @include('frontend.pages.listings.partials.working_hours')
                    @include('frontend.pages.listings.partials.faq')

                    @include('frontend.pages.listings.partials.related_businessess')

                </div>

                {{-- RIGHT COLUMN (sticky sidebar) --}}
                @include('frontend.pages.listings.partials.right_side_business_details')

            </div>
        </div>
    </section>
    <!-- ============================ Listing Details End ================================== -->

    <!-- ======================= Related Job Listings ======================== -->
    @include('frontend.pages.listings.partials.related_businessess')

@endsection
