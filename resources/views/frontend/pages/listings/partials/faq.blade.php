{{-- 5. FAQ --}}
<div class="bg-white rounded mb-4">
    <div class="jbd-01 px-4 py-4">
        <div class="jbd-details">
            <h5 class="ft-bold fs-lg">Frequently Asked Questions</h5>
            <div class="d-block mt-3">
                <div id="accordion2" class="accordion">

                    <div class="card">
                        <div class="card-header" id="h7">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#ord7"
                                    aria-expanded="true" aria-controls="ord7">
                                    Where is {{ $business->name }} located?
                                </button>
                            </h5>
                        </div>
                        <div id="ord7" class="collapse show" aria-labelledby="h7" data-parent="#accordion2">
                            <div class="card-body">
                                Visit us at <strong>{{ $business->location }},
                                    <a
                                        href="{{ route('business.city', $business->city->slug) }}">{{ $business->city->city_name }}</a></strong>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="h8">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#ord8"
                                    aria-expanded="false" aria-controls="ord8">
                                    How do I contact this business?
                                </button>
                            </h5>
                        </div>
                        <div id="ord8" class="collapse" aria-labelledby="h8" data-parent="#accordion2">
                            <div class="card-body">
                                <a href="mailto:{{ $business->email }}?subject=TanzaniaBiz">Click
                                    here</a> to send an Email
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="h9">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#ord9"
                                    aria-expanded="false" aria-controls="ord9">
                                    How do I get more information about {{ $business->name }}?
                                </button>
                            </h5>
                        </div>
                        <div id="ord9" class="collapse" aria-labelledby="h9" data-parent="#accordion2">
                            <div class="card-body">
                                Visit {{ $business->name }}
                                @if ($business->website)
                                    <a href="{{ $business->website }}" target="_blank" rel="noopener noreferrer">
                                        official website
                                    </a> for more information.
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
