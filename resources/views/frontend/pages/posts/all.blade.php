@extends('frontend.layouts.base')
@section('title', 'Tanzania Business Blog & Guides | Tanzaniabiz')
@section('description',
'Read simple guides for businesses and job seekers in Tanzania. Tips, updates, and useful
information in one place.')

@push('extra_style')
    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Tanzania Business Blog & Guides | Tanzaniabiz">
    <meta property="og:description"
        content="Read simple guides for businesses and job seekers in Tanzania. Tips, updates, and useful information in one place.">
    <meta property="og:image" content="{{ asset('uploads/general/' . $setting->logo) }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="{{ url()->current() }}">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Tanzania Business Blog & Guides | Tanzaniabiz">
    <meta name="twitter:description"
        content="Read simple guides for businesses and job seekers in Tanzania. Tips, updates, and useful information in one place.">
    <meta name="twitter:image" content="{{ asset('uploads/general/' . $setting->logo) }}">


<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [

    {
      "@type": "Blog",
      "@id": "{{ url('/blog') }}#blog",
      "name": "Tanzaniabiz Blog",
      "url": "{{ url('/blog') }}",
      "description": "Business tips and job guides for Tanzania.",
      "publisher": {
        "@type": "Organization",
        "name": "Tanzaniabiz",
        "logo": {
          "@type": "ImageObject",
          "url": "https://tanzaniabiz.com/uploads/general/{{$setting->logo}}"
        }
      }
    },

    {
      "@type": "ItemList",
      "@id": "{{ url('/blog') }}#itemlist",
      "name": "Latest blog posts",
      "itemListOrder": "http://schema.org/ItemListOrderDescending",
      "numberOfItems": {{ $posts->count() }},
      "itemListElement": [
        @foreach($posts as $index => $post)
        {
          "@type": "ListItem",
          "position": {{ $index + 1 }},
          "url": "{{ route('post.details', $post->slug) }}"
        }@if(!$loop->last),@endif
        @endforeach
      ]
    }

  ]
}
</script>
@endpush

@section('contents')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="bg-dark py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-light">Home</a></li>
                        <li class="breadcrumb-item active theme-cl" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Blog Start ============================ -->
<section class="middle">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h6 class="theme-cl mb-0">Tanzania Biz Blog</h6>
                    <h2 class="ft-bold">Simple guides for businesses and job seekers.</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">

            <!-- Single Item -->
            @foreach ($posts as $post)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="gup_blg_grid_box">
                        <div class="gup_blg_grid_thumb">
                            <a href="{{ route('post.details', $post->slug) }}"><img
                                    src="{{ asset('uploads/posts/thumbnails/' . $post->thumbnail) }}" class="img-fluid"
                                    alt="{{ $post->title }}" loading="lazy" decoding="async" width="640"
                                    height="427"></a>
                        </div>
                        <div class="gup_blg_grid_caption">
                            <div class="blg_title">
                                <h4><a href="{{ route('post.details', $post->slug) }}">{{ $post->title }}</a></h4>
                            </div>
                        </div>

                        <div class="crs_grid_foot">
                            <div class="crs_flex d-flex align-items-center justify-content-between br-top px-3 py-2">
                                <div class="crs_fl_first">
                                    <div class="crs_tutor">
                                        <div class="crs_tutor_thumb"><a href="#"><img
                                                    src="{{ asset('uploads/general/' . $post->user->profile_picture) }}"
                                                    class="img-fluid circle" width="35"
                                                    alt="{{ $post->user->name }}"></a></div>
                                    </div>
                                </div>
                                <div class="crs_fl_last">
                                    <div class="foot_list_info">
                                        <ul>
                                            {{-- <li>
                                                <div class="elsio_ic"><i class="fa fa-eye text-success"></i></div>
                                                <div class="elsio_tx">10k Views</div>
                                            </li> --}}
                                            <li>
                                                <div class="elsio_ic"><i class="fa fa-clock text-warning"></i></div>
                                                <div class="elsio_tx">{{ $post->created_at->format('d M Y') }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

    </div>
</section>
@endsection
