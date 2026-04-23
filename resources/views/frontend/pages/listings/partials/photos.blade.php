{{-- 1. Gallery Slider --}}
@if ($business->photos->count() > 0)
    <div class="bg-white rounded mb-4">
        <div class="jbd-01 px-4 py-4">
            <div class="jbd-details">
                <h5 class="ft-bold fs-lg">Photo Gallery</h5>
                <div class="d-block mt-3">
                    <div class="featured-slick mb-2">
                        <div class="featured-gallery-slide">
                            @foreach ($business->photos as $photo)
                                <div class="dlf-flew auto">
                                    <a href="{{ asset('uploads/businessListings/photos/' . $photo->name) }}"
                                        class="mfp-gallery">
                                        <img src="{{ asset('uploads/businessListings/photos/' . $photo->name) }}"
                                            class="img-fluid mx-auto" alt="{{ $business->name }}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
