<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
    <div style="position: sticky; top: 20px;">
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

        {{-- 2. Contact Info --}}
        <div class="jb-apply-form bg-white rounded py-4 px-4 mb-4">
            <h4 class="title">Business Contact</h4>
            <div class="uli-list-info">
                <ul>
                    @if ($business->website)
                        <li>
                            <div class="list-uiyt">
                                <div class="list-iobk"><i class="fas fa-globe"></i></div>
                                <div class="list-uiyt-capt">
                                    <h5>Website</h5>
                                    <p><a href="{{ $business->website }}" target="_blank"
                                            rel="noopener">{{ $business->website }}</a></p>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if ($business->email)
                        <li>
                            <div class="list-uiyt">
                                <div class="list-iobk"><i class="fas fa-envelope"></i></div>
                                <div class="list-uiyt-capt">
                                    <h5>Email</h5>
                                    <p><a
                                            href="mailto:{{ $business->email }}?subject=From TanzaniaBiz">{{ $business->email }}</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if ($business->phone)
                        <li>
                            <div class="list-uiyt">
                                <div class="list-iobk"><i class="fas fa-phone"></i></div>
                                <div class="list-uiyt-capt">
                                    <h5>Phone</h5>
                                    <p><a href="tel:{{ $business->phone }}">{{ $business->phone }}</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if ($business->location)
                        <li>
                            <div class="list-uiyt">
                                <div class="list-iobk"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="list-uiyt-capt">
                                    <h5>Location</h5>
                                    <p>{{ $business->location }}, {{ $business->city->city_name }}</p>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- 3. Map --}}
        @if ($business->latitude && $business->longitude)
            <div class="jb-apply-form bg-white rounded py-4 px-4 mb-4">
                <h4 class="title">Location Map</h4>
                <div class="mt-3">
                    <iframe
                        src="https://www.google.com/maps?q={{ $business->latitude }},{{ $business->longitude }}&output=embed"
                        width="100%" height="200" style="border:0; border-radius:8px;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        @endif

        {{-- 4. Social Media --}}
        @if ($business->social_medias->count() > 0)
            <div class="jb-apply-form bg-white rounded py-4 px-4 mb-4">
                <h4 class="title">Connect With Us</h4>
                <div class="row g-2 mt-2">
                    @foreach ($business->social_medias as $media)
                        <div class="col-6">
                            <a href="{{ $media->pivot->link }}" class="adv-btn full-width" target="_blank"
                                rel="noopener">
                                <i class="fab fa-{{ strtolower($media->name) }} me-1"></i>{{ $media->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 5. Categories --}}
        @if ($business->subcategories->count() > 0)
            <div class="single_widgets widget_tags mb-4">
                <h4 class="title">Categories</h4>
                <ul>
                    @foreach ($business->subcategories as $sub)
                        <li><a href="{{ route('business.category', $sub->slug) }}">{{ $sub->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</div>
