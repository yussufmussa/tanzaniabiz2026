@extends('frontend.layouts.base')
@section('title', 'Ajira Mpya - ' . date('Y'))
@section('description',
    'Discover abundant job opportunities in Tanzania. Explore careers across industries and find
    your next job today')
@section('keywords', 'Job opportunities in tanzania', ' tanzania job vacancy')

@push('extra_style')
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
    ]
}
</script>
@endpush
@section('contents')

<section class="space min pt-0 gray">
    <div class="container">

        {{-- Breadcrumb --}}
        <div class="row mb-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $pageTitle ?? 'Jobs' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Livewire list + filters --}}
        <livewire:frontend.pages.job-list
            :presetSectorSlug="$presetSectorSlug ?? null"
            :presetTypeSlug="$presetTypeSlug ?? null"
            :presetCitySlug="$presetCitySlug ?? null"
        />
    </div>
</section>
@endsection
