<div class="tab-pane fade" id="products" role="tabpanel">
    <form id="productsForm" enctype="multipart/form-data">
        @csrf

        <div class="alert alert-info mb-3">
            <i class="bi bi-info-circle"></i> You can add up to 3 products
        </div>

        <div id="productsContainer">
            @if (isset($listing) && $listing->products->count())
                @foreach ($listing->products->take(3) as $index => $product)
                    <div class="product-item card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text" class="form-control"
                                        name="products[{{ $index }}][product_name]" value="{{ $product->name }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" step="0.01" class="form-control"
                                        name="products[{{ $index }}][price]" value="{{ $product->price }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="2" name="products[{{ $index }}][description]">{{ $product->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Product Photo</label>
                                <input type="file" class="form-control" name="products[{{ $index }}][photo]"
                                    accept="image/*">
                                @if ($product->photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $product->photo) }}" class="img-thumbnail"
                                            style="max-height: 100px;" alt="Product Photo">
                                    </div>
                                @endif
                            </div>

                            @if ($index > 0)
                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                    <i class="bi bi-trash"></i> Remove Product
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="product-item card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" name="products[0][product_name]">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" class="form-control" name="products[0][price]">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="2" name="products[0][description]"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Photo</label>
                            <input type="file" class="form-control" name="products[0][photo]" accept="image/*">
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="addProduct">
            <i class="bi bi-plus-circle"></i> Add Another Product
        </button>
        <div class="text-muted small mb-3">Products: <span
                id="productCount">{{ isset($listing) ? $listing->products->count() : 1 }}</span>/3
        </div>

        <button type="submit" class="btn btn-primary">Save & Continue</button>
        <button type="button" class="btn btn-secondary skip-tab-btn" data-next-tab="extra-tab">Skip</button>
    </form>
</div>
