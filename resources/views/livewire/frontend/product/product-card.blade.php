

<div>
<section class="container pt-5 mt-2 mt-sm-3 mt-lg-4">

        <!-- Heading -->
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
            <h2 class="h3 mb-0">Trending products</h2>
            <div class="nav ms-3">
                <a class="nav-link animate-underline px-0 py-2" href="shop-catalog-electronics.html">
                    <span class="animate-target">View all</span>
                    <i class="ci-chevron-right fs-base ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Product grid -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 pt-4">
            <!-- Item -->
            @foreach($products as $product)
            <div class="col">
                <div class="product-card animate-underline hover-effect-opacity bg-body rounded">
                    <div class="position-relative">
                        <div class="dropdown d-lg-none position-absolute top-0 end-0 z-2 mt-2 me-2">
                            <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions">
                                <i class="ci-more-vertical fs-lg"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end fs-xs p-2" style="min-width: auto">
                                <li>
                                    <a class="dropdown-item" href="#!">
                                        <i class="ci-heart fs-sm ms-n1 me-2"></i>
                                        Add to Wishlist
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#!">
                                        <i class="ci-refresh-cw fs-sm ms-n1 me-2"></i>
                                        Compare
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a class="d-block rounded-top overflow-hidden p-3 p-sm-4"
                            href="{{ route('product.details', ['productSlug' => $product->slug]) }}">
                            <div class="ratio" style="--cz-aspect-ratio: calc(240 / 258 * 100%)">
                                <img src="{{ asset('uploads/products/thumbnails/' . $product->thumbnail) }}"
                                    alt="{{$product->title}}">
                            </div>
                        </a>
                    </div>
                    <div class="w-100 min-w-0 px-1 pb-2 px-sm-3 pb-sm-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="d-flex gap-1 fs-xs">
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-filled text-warning"></i>
                                <i class="ci-star-half text-warning"></i>
                            </div>
                            <span class="text-body-tertiary fs-xs">(142)</span>
                        </div>
                        <h3 class="pb-1 mb-2">
                            <a class="d-block fs-sm fw-medium text-truncate" href="{{ route('product.details', ['productSlug' => $product->slug]) }}">
                                <span class="animate-target">{{$product->title}}</span>
                            </a>
                        </h3>
                        <div class="d-flex align-items-center">
                            <div class="h5 lh-1 mb-0">Tsh {{number_format($product->price,2)}}</div>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <button type="button" wire:click="addToCart({{$product->id}})" class="btn btn-dark w-100 rounded-pill px-3">Add to cart</button>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
