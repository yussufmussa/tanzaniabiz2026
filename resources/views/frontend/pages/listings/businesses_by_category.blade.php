@extends('frontend.layouts.base_other_than_homepage')
@section('title', ($subcategory ? $subcategory->name : $category->name) . ' Companies in Tanzania')



@section('contents')



<!-- ============================ Main Section Start ================================== -->
<section class="gray py-5">
    <div class="container">


     @livewire('website.list-business-by-category', ['category' => $category, 'top_cities' => $top_cities, 'subcategory' => $subcategory, 'classes' => 'row'])


    </div>
</section>
<!-- ============================ Main Section End ================================== -->


@endsection


