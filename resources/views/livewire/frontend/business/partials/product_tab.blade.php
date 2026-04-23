@if ($currentStep == 3)

 <div wire:loading.flex wire:target="saveProducts"
            class="position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center"
            style="background: rgba(255,255,255,0.7); z-index: 9999;">

            <div class="text-center">
                <img src="{{ asset('uploads/general/loading.gif') }}" alt="Saving..." style="width:80px;">
                <p class="mt-2 mb-0">Saving...</p>
            </div>
        </div>


    <form wire:submit.prevent="saveProducts">

        {{-- Info --}}
        <div class="alert alert-info mb-3">
            <i class="bi bi-info-circle"></i>
            Products are optional. You can add up to {{ $maxProducts }} products.
        </div>

        {{-- Empty state --}}
        @if (count($products) === 0)
            <div class="alert alert-light border mb-3">
                No products added yet.
            </div>
        @endif

        {{-- Products --}}
        <div id="productsContainer">
            @foreach ($products as $index => $product)
                <div class="product-item card mb-4" wire:key="product-{{ $index }}">
                    <div class="card-body">

                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Product {{ $index + 1 }}</h6>

                            <button type="button" wire:click="removeProduct({{ $index }})"
                                class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                        <div class="row">
                            {{-- LEFT: Details --}}
                            <div class="col-md-8">
                                {{-- Product Name --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text"
                                        class="form-control @error('products.' . $index . '.product_name') is-invalid @enderror"
                                        wire:model.defer="products.{{ $index }}.product_name">

                                    @error('products.' . $index . '.product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Price --}}
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('products.' . $index . '.price') is-invalid @enderror"
                                        wire:model.defer="products.{{ $index }}.price">

                                    @error('products.' . $index . '.price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Description *</label>
                                    <textarea rows="3" class="form-control @error('products.' . $index . '.description') is-invalid @enderror"
                                        wire:model.defer="products.{{ $index }}.description"></textarea>

                                    @error('products.' . $index . '.description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- RIGHT: Photo --}}
                            <div class="col-md-4">
                                <label class="form-label">Product Photo</label>
                                <input type="file"
                                    class="form-control @error('products.' . $index . '.photo') is-invalid @enderror"
                                    wire:model="products.{{ $index }}.photo" accept="image/*">

                                @error('products.' . $index . '.photo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                {{-- Preview --}}
                                @if (!empty($product['photo']))
                                    <img src="{{ $product['photo']->temporaryUrl() }}" class="img-thumbnail mt-2 w-100"
                                        style="max-height:150px; object-fit:cover;">
                                @elseif(!empty($product['existing_photo']))
                                    <img src="{{ asset('uploads/businessListings/products/' . $product['existing_photo']) }}"
                                        class="img-thumbnail mt-2 w-100" style="max-height:150px; object-fit:cover;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Add Product --}}
        @if (count($products) < $maxProducts)
            <button type="button" wire:click="addProduct" class="btn btn-secondary mb-3">
                <i class="bi bi-plus-circle"></i>
                {{ count($products) === 0 ? 'Add Product' : 'Add Another Product' }}
            </button>
        @endif

        {{-- Counter --}}
        <div class="text-muted small mb-3">
            Products: {{ count($products) }}/{{ $maxProducts }}
        </div>

        {{-- Actions --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveProducts">
                <span wire:loading.remove wire:target="saveProducts">
                   {{ $mode == 'create' ? 'Save & Continue' : 'Update & Continue' }} 
                </span>
                <span wire:loading wire:target="saveProducts">
                    Saving...
                </span>
            </button>

            <button type="button" wire:click="skipProducts" class="btn btn-outline-secondary">
                Skip
            </button>
        </div>

    </form>


@endif
