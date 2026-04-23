{{-- 4. Products --}}
                    @if ($business->products->count() > 0)
<div class="bg-white rounded mb-4">
    <div class="jbd-01 px-4 py-4">
        <div class="jbd-details">
            <h5 class="ft-bold fs-lg">Products</h5>
            <div class="d-block mt-3">
                <div class="row g-3">
                    @foreach ($business->products as $product)
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-6">
                        <div class="Goodup-sng-menu">
                            <div class="Goodup-sng-menu-thumb">
                                 <img
                                    src="{{ $product->photo
                                            ? asset('uploads/businessListings/products/' . $product->photo)
                                            : asset('uploads/general/placeholder.jpg') }}"
                                    class="img-fluid"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                />
                            </div>
                            <div class="Goodup-sng-menu-caption">
                                <h4 class="ft-medium fs-md">{{ $product->name }}</h4>
                                @if ($product->price)
                                <div class="lkji-oiyt">
                                    <span>Price</span>
                                    <h5 class="theme-cl ft-bold">Tsh{{ number_format($product->price, 2) }}</h5>
                                </div>
                                @endif
                                <p class="text-muted small mt-1 mb-1">{{ Str::limit($product->description, 50) }}</p>
                                <button class="btn btn-sm btn-outline-primary mt-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#productModal{{ $product->id }}">
                                    Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Product Modal --}}
                    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1"
                        aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title ft-bold" id="productModalLabel{{ $product->id }}">
                                        {{ $product->name }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-4">
                                        {{-- Photo --}}
                                        @if($product->photo)
                                        <div class="col-md-5">
                                            <img src="{{ asset('uploads/businessListings/products/' . $product->photo) }}"
                                                class="img-fluid rounded" alt="{{ $product->name }}"
                                                style="width:100%; height:250px; object-fit:cover;">
                                        </div>
                                        @endif
                                        {{-- Details --}}
                                        <div class="{{ $product->photo ? 'col-md-7' : 'col-md-12' }}">
                                            @if($product->price)
                                            <div class="mb-3">
                                                <span class="text-muted">Price</span>
                                                <h4 class="theme-cl ft-bold">Tsh{{ number_format($product->price, 2) }}</h4>
                                            </div>
                                            @endif
                                            <div class="mb-3">
                                                <span class="text-muted d-block mb-1">Description</span>
                                                <p>{{ $product->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Modal --}}

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif