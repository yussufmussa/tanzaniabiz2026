@extends('frontend.layouts.base')
@section('title', 'Companies near '.$citySlug.' |  Companies in '.$citySlug.'')
@section('description', '')



@section('contents')


@include('frontend.partials.top_quick_menu')

<!-- ============================ Search Tag & Filter End ================================== -->

<!-- ============================ Main Section Start ================================== -->
<section class="gray py-5">
    <div class="container">


     @livewire('filter-business-by-city', ['city' => $city, 'top_categories' => $top_categories, 'cityName' => $cityName, 'citySlug' => $citySlug, 'classes' => 'row'])


    </div>
</section>
<!-- ============================ Main Section End ================================== -->



@endsection

