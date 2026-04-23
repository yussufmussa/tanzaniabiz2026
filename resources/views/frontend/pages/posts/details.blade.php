@extends('frontend.layouts.base')
@section('title', '' . $post->title . '')
@section('description', \Illuminate\Support\Str::limit($post->body, 160))

@push('extra_style')
    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->description }}">
    <meta property="og:image" content="{{ asset('uploads/posts/thumbnails/' . $post->thumbnail) }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="{{ url()->current() }}">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->description }}">
    <meta name="twitter:image" content="{{ asset('uploads/posts/thumbnails/' . $post->thumbnail) }}">

<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "{{ $post->title }}",
  "description": "{{ $post->meta_description }}",
  "image": "https://tanzaniabiz.com/uploads/posts/thumbnails/{{ $post->thumbnail }}",
  "datePublished": "{{ $post->created_at->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ $post->user->name }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Tanzaniabiz",
    "logo": {
      "@type": "ImageObject",
      "url": "https://tanzaniabiz.com/uploads/general/{{$setting->logo}}"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url()->current() }}"
  }
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
      "item": "https://tanzaniabiz.com"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Blog",
      "item": "https://tanzaniabiz.com/blog"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ $post->category_name }}",
      "item": "https://tanzaniabiz.com/blog/{{ $post->slug }}"
    },
    {
      "@type": "ListItem",
      "position": 4,
      "name": "{{ $post->title }}",
      "item": "{{ url()->current() }}"
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
                            <li class="breadcrumb-item"><a href="/blog" class="text-light">Blog</a></li>
                            <li class="breadcrumb-item active theme-cl" aria-current="page">{{ $post->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->
    <!-- ============================ Blog Detail Start ================================== -->
    <section>
        <div class="container">
            <!-- row Start -->
            <div class="row">

                <!-- Blog Detail -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-12">
                    <div class="article_detail_wrapss single_article_wrap format-standard">
                        <div class="article_body_wrap">

                            <div class="article_featured_image">
                                <img class="img-fluid" src="{{ asset('uploads/posts/thumbnails/' . $post->thumbnail) }}"
                                    loading="lazy" decoding="async" alt="{{ $post->title }}" width="600"
                                    height="300">
                            </div>
                            <div class="article_top_info">
                                <ul class="article_middle_info">
                                    <li><a href="#"><span class="icons"><i class="ti-user"></i></span>by
                                            {{ $post->user->name }}</a></li>
                                    <li>
                                        <span class="icons"><i class="ti-calendar"></i></span>
                                        {{ $post->created_at->format('M d, Y') }}

                                        @if($post->updated_at->gt($post->created_at))
                                            <small>(updated {{ $post->updated_at->format('M d, Y') }})</small>
                                        @endif
                                    </li>
                                    <li><a href="#"><span class="icons"><i class="ti-comment-alt"></i></span>45
                                            Comments</a></li>
                                </ul>
                            </div>

                            <h2 class="post-title">{{ $post->title }}</h2>
                            {!! $post->body !!}
                        </div>
                    </div>
                    <!-- Blog Comment -->

                </div>
                <!-- Single blog Grid -->
                @include('frontend.pages.posts.partials.right_side_business_details')

            </div>
            <!-- /row -->

        </div>

    </section>
    <!-- ============================ Blog Detail End ================================== -->
@endsection
