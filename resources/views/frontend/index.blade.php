@extends('frontend.layouts.base')

@section('title', $seo->meta_title)
@section('keywords', $seo->meta_keywords)
@section('description', $setting->meta_description)

@push('extra_style')
<style>
 .scroll-container {
    overflow-x: auto;
    white-space: nowrap;
    padding: 10px 0;
}

.scroll-container::-webkit-scrollbar {
    display: none;
}

.scroll-container {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scroll-container .row {
    flex-wrap: nowrap;
}
.home-banner {
    background-image: url("{{ asset('photos/general/'.$setting->first()->hero_bg) }}");
}
.bg-cover{
    background-image: url("{{asset('photos/general/'.$setting->first()->hero_bg)}}");
}
</style>
<script type="application/ld+json">
    {
        "@@context": "https://schema.org/",
        "@type": "LocalBusiness",
        "name": "Tanzania Biz",
        "url": "{{ url()->current() }}",
        "logo": "{{ secure_asset('photos/general/'.$setting->first()->logo) }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Kijitonyama",
            "addressLocality": "Dar es Salaam",
            "addressRegion": "Dar",
            "postalCode": "11101",
            "addressCountry": "TZ"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+255 689 532 954",
            "contactType": "customer support"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": -6.7924,
            "longitude": 39.2083
        },
        "telephone": "+255 689 532 954",
        "priceRange": "$$$"
    }
</script>

<!-- Facebook Meta Tags -->
<meta property="og:url" content="https://tanzaniabiz.com">
<meta property="og:type" content="website">
<meta property="og:title" content="{{$setting->first()->title}}">
<meta property="og:description" content="{{$setting->first()->meta_description}}">
<meta property="og:image" content="{{ asset('photos/general/'.$setting->first()->logo )}}">
<!-- End Facebook Meta Tag -->

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="tanzaniabiz.com">
<meta property="twitter:url" content="https://tanzaniabiz.com">
<meta name="twitter:title" content="{{$setting->first()->title}}">
<meta name="twitter:description" content="{{$setting->first()->meta_description}}">
<meta name="twitter:image" content="{{ asset('photos/general/'.$setting->first()->logo )}}">
<!-- End Twitter Meta Tags -->
@endpush

@section('contents')

@include('frontend.partials.hero')
@include('frontend.partials.business')
@include('frontend.partials.cta')


@endsection


