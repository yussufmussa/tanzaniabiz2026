@extends('frontend.layouts.base')
@section('title', 'Browse business by categories')
@section('description', 'Browse businesses by category on Tanzanibiz. Find a wide range of business based in Tanzania, organized by category for easy navigation and discovery')


@section('contents')

<!-- ================================
    START BREADCRUMB AREA
================================= -->

<!-- ================================
    END BREADCRUMB AREA
================================= -->

<section class="space min py-5">
    <div class="container">

        {{-- Breadcrumb + Heading --}}
        <div class="row mb-3">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Business Categories</li>
                    </ol>
                </nav>

                <h2 class="ft-bold mb-2">Browse business categories</h2>

                <p class="text-muted mb-0">
                    Browse <strong>{{ $subcategoriesCount }}</strong> subcategories.
                    Filter by city and category on the business page.
                </p>
            </div>
        </div>

        {{-- Categories --}}
        @foreach($categories as $key => $category)
            <div class="bg-white rounded p-4 mb-3">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <h3 class="ft-bold mb-0 fs-lg">
                        <a href="{{ route('business.by.category', $category->slug) }}" class="text-dark">
                            <span class="count-tag bg-warning me-2">{{ $key + 1 }}</span>
                            {{ $category->name }}
                        </a>
                    </h3>

                    <a href="{{ route('business.by.category', $category->slug) }}" class="btn btn-sm btn-light border">
                        View all
                    </a>
                </div>

                <div class="row g-2 mt-1">
                    @forelse($category->subcategories as $sub)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('business.by.subcategory', $sub->slug) }}"
                               class="d-block border rounded px-3 py-2 text-dark"
                               style="background:#fff;">
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <span class="small ft-medium">{{ $sub->name }}</span>
                                    <span class="badge bg-light text-dark border">
                                        {{ $sub->business_listings_count }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-muted">No subcategories found.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach

    </div>
</section>
@include('frontend.partials.cta')

@endsection

