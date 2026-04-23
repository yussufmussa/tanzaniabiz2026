@extends('backend.layouts.base')
@section('title', 'Show Product')
@push('extra_style')
<style>
    .hover-overlay:hover {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
    .hover-overlay:hover i {
        opacity: 1 !important;
    }
</style>
@endpush
@section('contents')

    <div class="col-12">
        <div class="d-flex justify-content-end pb-1">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm w-md waves-effect waves-light">
                <i class="bx bx-list-ul"></i> Products</a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                       <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Product Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                            <li class="breadcrumb-item active">{{ $product->title }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Product
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Left Column - Product Details --}}
        <div class="col-lg-8">
            {{-- Product Overview Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Product Overview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h3 class="mb-3">{{ $product->title }}</h3>
                            <div class="d-flex gap-2 mb-3">
                                @if($product->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                                
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark">Featured</span>
                                @endif
                                
                                @if($product->is_popular)
                                    <span class="badge bg-info">Popular</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="text-muted small">Price</label>
                            <div class="h4 text-success mb-0">
                                ${{ number_format($product->price, 2) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small">Category</label>
                            <div class="fw-semibold">{{ $product->category->name }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small">Sub-Category</label>
                            <div class="fw-semibold">{{ $product->subCategory->name }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small">Brand</label>
                            <div class="fw-semibold">{{ $product->brand->name }}</div>
                        </div>
                    </div>

                    @if($product->description)
                        <div class="mt-4">
                            <h6 class="mb-3">Description</h6>
                            <div class="border-start border-primary border-3 ps-3 bg-light p-3 rounded">
                                {!! $product->description !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Product Images Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-images"></i> Product Images
                    </h6>
                </div>
                <div class="card-body">
                    {{-- Thumbnail --}}
                    <div class="mb-4">
                        <h6 class="mb-3">Thumbnail Image</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="position-relative">
                                    <img src="{{ asset('uploads/products/thumbnails/' . $product->thumbnail) }}" 
                                         alt="{{ $product->title }}" 
                                         class="img-fluid rounded border shadow-sm"
                                         style="max-height: 400px; object-fit: cover; width: 100%;">
                                    <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                        Main Image
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gallery Images --}}
                    @if($product->productPhotos && count($product->productPhotos) > 0)
                        <div>
                            <h6 class="mb-3">Gallery Images ({{ count($product->productPhotos) }})</h6>
                            <div class="row g-3">
                                @foreach($product->productPhotos as $image)
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="position-relative">
                                            <a href="{{ asset('uploads/products/photos/' . $image->photo_name) }}" 
                                               data-lightbox="product-gallery" 
                                               data-title="{{ $product->title }}">
                                                <img src="{{ asset('uploads/products/photos/' . $image->photo_name) }}" 
                                                     alt="Product image" 
                                                     class="img-fluid rounded border shadow-sm"
                                                     style="height: 150px; object-fit: cover; width: 100%; cursor: pointer;">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 bg-dark bg-opacity-0 hover-overlay rounded d-flex align-items-center justify-content-center" 
                                                     style="transition: all 0.3s;">
                                                    <i class="fas fa-search-plus text-white" style="font-size: 1.5rem; opacity: 0;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No additional gallery images available.
                        </div>
                    @endif
                </div>
            </div>

            {{-- SEO Information Card --}}
            @if($product->meta_keywords || $product->meta_description)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-search"></i> SEO Information
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($product->meta_keywords)
                            <div class="mb-3">
                                <label class="text-muted small">Meta Keywords</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(explode(',', $product->meta_keywords) as $keyword)
                                        <span class="badge bg-light text-dark border">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($product->meta_description)
                            <div>
                                <label class="text-muted small">Meta Description</label>
                                <p class="mb-0">{{ $product->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Column - Sidebar --}}
        <div class="col-lg-4">
            {{-- Quick Actions Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                        <button type="button" class="btn btn-outline-danger" 
                                onclick="if(confirm('Are you sure you want to delete this product?')) { document.getElementById('delete-form').submit(); }">
                            <i class="fas fa-trash"></i> Delete Product
                        </button>
                        {{-- <a href="{{ route('admin.products.duplicate', $product->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-copy"></i> Duplicate Product
                        </a> --}}
                        <a href="#" class="btn btn-outline-secondary" target="_blank">
                            <i class="fas fa-external-link-alt"></i> View on Site
                        </a>
                    </div>

                    <form id="delete-form" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            {{-- Status Information Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-toggle-on"></i> Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Active Status</strong>
                                <small class="d-block text-muted">Visibility to customers</small>
                            </div>
                            <div>
                                @if($product->is_active)
                                    <span class="badge bg-success px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Popular Product</strong>
                                <small class="d-block text-muted">Popular section display</small>
                            </div>
                            <div>
                                @if($product->is_popular)
                                    <i class="fas fa-check-circle text-success fa-lg"></i>
                                @else
                                    <i class="fas fa-times-circle text-muted fa-lg"></i>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Featured Product</strong>
                                <small class="d-block text-muted">Homepage highlight</small>
                            </div>
                            <div>
                                @if($product->is_featured)
                                    <i class="fas fa-check-circle text-success fa-lg"></i>
                                @else
                                    <i class="fas fa-times-circle text-muted fa-lg"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Publishing Information Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar"></i> Publishing Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Created At</label>
                        <div class="fw-semibold">
                            {{ $product->created_at->format('M d, Y') }}
                            <small class="text-muted d-block">{{ $product->created_at->format('h:i A') }}</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Last Updated</label>
                        <div class="fw-semibold">
                            {{ $product->updated_at->format('M d, Y') }}
                            <small class="text-muted d-block">{{ $product->updated_at->format('h:i A') }}</small>
                        </div>
                    </div>

                    <div>
                        <label class="text-muted small">Product ID</label>
                        <div class="fw-semibold">#{{ $product->id }}</div>
                    </div>
                </div>
            </div>

            {{-- Product Statistics Card --}}
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white py-3">
                    <h6 class="m-0 small">
                        <i class="fas fa-chart-line"></i> Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2">
                                <h4 class="mb-0 text-primary">{{ count($product->productPhotos) }}</h4>
                                <small class="text-muted">Gallery Images</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2">
                                <h4 class="mb-0 text-success">0</h4>
                                <small class="text-muted">Total Views</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <h4 class="mb-0 text-warning">0</h4>
                                <small class="text-muted">Orders</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <h4 class="mb-0 text-info">0</h4>
                                <small class="text-muted">Reviews</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('extra_script')

    <script>
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endpush
