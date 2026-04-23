{{-- 6. Related Businesses --}}
                    @if ($relatedBusinesses->count() > 0)
                        <div class="bg-white rounded mb-4">
                            <div class="jbd-01 px-4 py-4">
                                <div class="jbd-details">
                                    <h5 class="ft-bold fs-lg">Related Businesses</h5>
                                    <div class="d-block mt-3">
                                        <div class="row g-3">
                                            @foreach ($relatedBusinesses as $related)
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="Goodup-grid-wrap">
                                                        <div class="Goodup-grid-upper">
                                                            @if ($related->photos->count() > 0)
                                                                <img src="{{ asset('uploads/businessListings/photos/' . $related->photos->first()->name) }}"
                                                                    class="img-fluid" alt="{{ $related->name }}"
                                                                    style="height:150px; width:100%; object-fit:cover;">
                                                            @endif
                                                        </div>
                                                        <div class="Goodup-grid-fl-wrap p-3">
                                                            <h4 class="ft-bold fs-md mb-1">
                                                                <a
                                                                    href="{{ route('business.show', $related->slug) }}">{{ $related->name }}</a>
                                                            </h4>
                                                            <p class="text-muted small mb-0">
                                                                {{ $related->city->city_name }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif