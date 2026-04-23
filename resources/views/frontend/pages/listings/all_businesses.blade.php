@extends('frontend.layouts.base')
@section('title', 'Browse Businesses in Tanzania | Tanzaniabiz')
@section('keywords', 'browse businesses tanzania, company directory tanzania, local companies tanzania')
@section('description', 'Search businesses across Tanzania by category or city. Find trusted local companies near you.')

@section('contents')

    {{-- @include('frontend.partials.top_quick_menu') --}}

    <!-- ============================ Search Tag & Filter End ================================== -->

    <!-- ============================ Main Section Start ================================== -->
    <section class="gray py-5 ">
        <div class="container">
            <livewire:frontend.pages.all-business :presetCategorySlug="$presetCategorySlug" :presetCitySlug="$presetCitySlug" :presetKeywords="$presetKeywords ?? null"/>
        </div>
    </section>
    <!-- ============================ Main Section End ================================== -->


@endsection
