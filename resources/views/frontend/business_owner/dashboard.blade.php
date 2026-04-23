@extends('frontend.business_owner.account.base')
@section('title', 'My Dashboard ')

@section('contents')
    <div class="goodup-dashboard-content">
        <div class="dashboard-tlbar d-block mb-5">
            <div class="row">
                <div class="colxl-12 col-lg-12 col-md-12">
                    <h1 class="ft-medium">Hello, {{ auth()->user()->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-muted"><a href="/" target="_blank">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('business_owner.dashboard') }}"
                                    class="theme-cl">Dashboard</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="dashboard-widg-bar d-block">

            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="dsd-boxed-widget py-5 px-4 bg-danger rounded">
                        <h2 class="ft-medium mb-1 fs-xl text-light count">
                            <a href="{{ route('business-listings.index') }}">
                                {{ $activeBusinessListingCount }}
                            </a>
                        </h2>
                        <p class="p-0 m-0 text-light fs-md">Active Listings</p>
                        <i class="lni lni-empty-file"></i>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="dsd-boxed-widget py-5 px-4 bg-success rounded">
                        <h2 class="ft-medium mb-1 fs-xl text-light count">
                            <a href="{{ route('business-listings.index') }}">
                                {{ $inactiveBusinessListingCount }}
                            </a>
                        </h2>
                        <p class="p-0 m-0 text-light fs-md">unapproved Listings</p>
                        <i class="lni lni-eye"></i>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="dsd-boxed-widget py-5 px-4 bg-warning rounded">
                        <h2 class="ft-medium mb-1 fs-xl text-light count">
                            <a href="{{ route('business-listings.index') }}">
                                {{ $totalBusinessListingCount }}
                            </a>
                        </h2>
                        <p class="p-0 m-0 text-light fs-md">Total Listings</p>
                        <i class="lni lni-comments"></i>
                    </div>
                </div>
            </div>


        </div><!-- end row -->

@endsection


@push('extra_script')

@endpush
