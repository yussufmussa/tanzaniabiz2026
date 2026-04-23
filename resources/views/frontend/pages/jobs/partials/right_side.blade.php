<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
    <div style="position: sticky; top: 20px;">
        @php
            $logo = $business?->logo
                ? asset('uploads/businessListings/logos/' . $business->logo)
                : asset('assets/img/t-1.png');
        @endphp

        <div class="jb-apply-form bg-white rounded py-4 px-4 mb-4">
            <div class="Goodup-agent-blocks">
                <div class="Goodup-agent-thumb">
                    <img src="{{ $logo }}" width="550" height="550" class="img-fluid circle" alt="{{$business->name}}">
                </div>

                <div class="Goodup-agent-caption">
                    <h4 class="ft-medium mb-0">{{ $business?->name ?? 'Business' }}</h4>
                    <span class="agd-location"><i class="lni lni-map-marker me-1"></i>{{$business->city->city_name}}</span>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="agent-cnt-info">
                <div class="row mt-3">
                    <div class="col-12">
                        <p class="text-center">Posted By</p>
                        @if ($business)
                            <a href="{{ route('listing.details', $business->slug) }}"
                                class="adv-btn full-width theme-bg text-light">
                                View Profile
                            </a>
                        @else
                            <button class="adv-btn full-width btn btn-secondary" disabled>
                                No business profile
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- 2. Sponsored Ad --}}
        @if (isset($sponsoredAd) && $sponsoredAd)
            <div class="jb-apply-form bg-white rounded py-4 px-4 mb-4 text-center">
                <h4 class="title">Sponsored</h4>
                <a href="{{ $sponsoredAd->link ?? '#' }}" target="_blank" rel="noopener sponsored">
                    <img src="{{ asset('uploads/ads/' . $sponsoredAd->banner) }}" alt="Sponsored"
                        class="img-fluid rounded">
                </a>
            </div>
        @endif

        {{-- 5. Categories --}}
        {{-- @if ($job->jobSectors->count() > 0)
            <div class="single_widgets widget_tags mb-4">
                <h4 class="title">Categories</h4>
                <ul>
                    @foreach ($job->s as $sub)
                        <li><a href="{{ route('business.category', $sub->slug) }}">{{ $sub->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

    </div>
</div>
