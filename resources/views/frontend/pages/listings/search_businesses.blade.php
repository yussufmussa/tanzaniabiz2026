@extends('frontend.layouts.base_other_than_homepage')
@section('title', 'Seach for Business in Tanzania')

@section('contents')

<!-- ============================ Main Section Start ================================== -->
<section class="gray py-5">
    <div class="container">

        <!-- breadcrumb -->
        @include('frontend.pages.listings.search-partials.breadcrumb')
        <!-- End breadcrumb -->

        <div class="row">

            <!-- Left Side Bar -->
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">

                <div class="bg-white rounded mb-4">

                    <div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
                        <h4 class="ft-medium fs-lg mb-0">Search Filter</h4>
                        <div class="ssh-header">
                            <a href="javascript:void(0);" class="clear_all ft-medium text-muted">Clear All</a>
                            <a href="#search_open" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed _filter-ico ml-2"><i class="lni lni-text-align-right"></i></a>
                        </div>
                    </div>

                    <!-- Find New Property -->

                </div>
            </div>

            <!--End left Side Bar-->

            <!-- Item Wrap Start -->
            <div class="col-lg-6 col-md-12 col-sm-12">
                <!-- row -->

                <div class="row justify-content-center g-2">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="d-block grouping-listings">

                            <!-- Single Item -->
                            @if($business->count() != 0)
                            @foreach($business as $listing)
                            <div class="_jb_list72">
                                <div class="_jb_list72_flex">
                                    <div class="_jb_list72_first">
                                        <div class="_jb_list72_yhumb">
                                            <img src="{{asset('photos/listing/logo/'.$listing->logo)}}" class="img-fluid" alt="{{$listing->name}}">
                                        </div>
                                    </div>
                                    <div class="_jb_list72_last">
                                        <h4 class="_jb_title"><a href="{{route('listings.details', ['slug' => $listing->slug])}}"> {{$listing->name}}</a></h4>
                                        <div class="_times_jb"><i class="fas fa-map-marker-alt"></i> {{$listing->location}}</div>
                                        <div class="_times_jb"><i class="fas fa-phone"></i> {{$listing->phone}}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="grouping-listings-single">
                                <div class="vrt-list-wrap">
                                    <div class="vrt-list-wrap-head">
                                        <h3>No Results Found</h3><br />
                                        <h6>Try to browse by selecting categories <a href="/browse-business-by-category"></a></h6>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>

                        <!-- Pagination -->
                        @if($business->hasPages())
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if($business->onFirstPage())
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span class="fas fa-arrow-circle-right"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $business->previousPageUrl()}}" aria-label="Next">
                                        <span class="fas fa-arrow-circle-right"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                @endif
                                {{-- Pagination Elements --}}
                                @if ($business->lastPage() > 1)
                                @for ($i = max(1, $business->currentPage() - 2); $i <= min($business->lastPage(), $business->currentPage() + 2); $i++)
                                    <li class="page-item">
                                        <a class="{{ ($business->currentPage() == $i) ? ' page-link page-link-active' : 'page-link' }}" href="{{ $business->url($i) }}">{{$i}}</a>
                                    </li>

                                    @endfor
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if($business->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $business->nextPageUrl() }}">Next</a></li>
                                    @else
                                    <li class="page-item disabled"><a class="page-link" href="{{ $business->nextPageUrl() }}">Last</a></li>
                                    @endif
                            </ul>
                            @endif
                        </div>
                        <!-- End Pagination -->

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="list-411">
                                <div class="list-412">
                                    <h4 class="ft-bold mb-0">Can't find the business?</h4>
                                    <span>Adding a business to TanzaniaBiz is always free.</span>
                                </div>
                                <div class="list-413">
                                    <a class="btn text-light theme-bg rounded" href="/register">Add Your business</a>
                                </div>
                            </div>
                        </div>



                    </div>
                    <!-- row -->
                </div>
                <!-- Right side -->
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="bg-white rounded mb-4">

                        <div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
                            <h4 class="ft-medium fs-lg mb-0">Ads</h4>
                        </div>

                        <!-- Find New Property -->
                        <div class="sidebar-widgets collapse miz_show" id="search_open" data-bs-parent="#search_open">

                        </div>
                    </div>
                </div>
                <!-- End Right Side -->

            </div>
        </div>
    </div>
</section>
<!-- ============================ Main Section End ================================== -->


@endsection

