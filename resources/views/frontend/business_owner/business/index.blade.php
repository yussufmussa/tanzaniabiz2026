@extends('frontend.business_owner.account.base')
@section('title', 'My Business Listings')
@section('extra_style')

@section('contents')
    <div class="goodup-dashboard-content">
        <div class="dashboard-widg-bar d-block">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="dashboard-list-wraps bg-white rounded mb-4">
                        <div class="dashboard-list-wraps-head br-bottom py-3 px-3">
                            <div class="dashboard-list-wraps-flx">
                                <h4 class="mb-0 ft-medium fs-md"><i class="fa fa-file-alt me-2 theme-cl fs-sm"></i>My Business
                                    Listings</h4>
                            </div>
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if (Session::has('message'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ Session::get('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                        </div>
                        <div class="dashboard-list-wraps-body py-3 px-3">
                            <div class="dashboard-listing-wraps">
                                @if (count($listings) > 0)
                                    @foreach ($listings as $listing)
                                        <!-- Single Listing Item -->
                                        <div class="dsd-single-listing-wraps">
                                            <div class="dsd-single-lst-thumb">
                                                <img src="{{ asset('uploads/businessListings/logos/' . $listing->logo) }}"
                                                    class="img-fluid" alt="{{ $listing->name }}" />
                                            </div>
                                            <div class="dsd-single-lst-caption">
                                                <div class="dsd-single-lst-title">
                                                    <h5>{{ $listing->name }}</h5>
                                                </div>
                                                <span class="agd-location"><i
                                                        class="lni lni-map-marker me-1"></i>{{ $listing->location }}</span>

                                                <div class="dsd-single-lst-meta mt-2">
                                                    @if ($listing->status == 0)
                                                        <span class="badge bg-warning text-dark me-2">
                                                            <i class="fas fa-clock me-1"></i>Pending Approval
                                                        </span>
                                                    @else($listing->status == 1)
                                                        <span class="badge bg-success me-2">
                                                            <i class="fas fa-check-circle me-1"></i>Active
                                                        </span>
                                                    @endif

                                                    @if ($listing->is_featured)
                                                        <span class="badge bg-primary">
                                                            <i class="fas fa-star me-1"></i>Featured
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="dsd-single-lst-info mt-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-tag me-1"></i>{{ $listing->category->name }}
                                                    </small>
                                                    <small class="text-muted ms-3">
                                                        <i class="fas fa-map-pin me-1"></i>{{ $listing->city->city_name }}
                                                    </small>
                                                </div>

                                                <div class="dsd-single-lst-footer mt-3">
                                                    @php
                                                        $hasPhotos = $listing->photos?->count() > 0;
                                                        $hasProducts = $listing->products?->count() > 0;
                                                        $hasExtraInfo =
                                                            $listing->workingHours?->count() > 0 ||
                                                            $listing->socialMedia?->count() > 0;
                                                        $isComplete = $hasPhotos && $hasProducts && $hasExtraInfo;
                                                    @endphp
                                                    <a href="{{ route('business-listings.edit', $listing->id) }}"
                                                        class="btn btn-edit me-2">
                                                        <i
                                                            class="fas {{ $isComplete ? 'fa-edit' : 'fa-plus-circle' }} me-1"></i>
                                                        {{ $isComplete ? 'Edit' : 'Complete Listing' }}
                                                    </a>
                                                    @if ($listing->status == 1 && $isComplete)
                                                        <a href="#" target="_blank" class="btn btn-view me-2">
                                                            <i class="fas fa-eye me-1"></i>View
                                                        </a>
                                                    @endif
                                                    <form action="#" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this listing?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash me-1"></i>Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="container text-center alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span>You have no listings yet!</span>
                                        <a href="{{ route('business-listings.add') }}" class="btn btn-primary ms-3">
                                            <i class="fas fa-plus me-1"></i>Create Your First Listing
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
@push('extra_script')
<script src="{{asset('frontend/js/select2.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('StatusUpdated', (data) => {
                console.log(data[0].type);
                if (data[0].type === 'success') {
                    toastr.success(data[0].message);
                } else if (data[0].type === 'error') {
                    toastr.error(data[0].message);
                } else {
                    console.warn('Unexpected type:', data[0].type);
                }
            });
        });
    </script>
@endpush