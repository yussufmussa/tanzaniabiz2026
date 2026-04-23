@extends('backend.layouts.base')
@section('title', 'Edit Package')

@section('contents')
    <div class="row">
        <div class="d-flex justify-content-end">
            @canany(['packages.create', 'packages.manage'])
                <a type="submit" class="btn btn-primary btn-sm mb-1 mt-0" href="{{ route('packages.index') }}">
                    <i class="bx bx-list-ul me-1"></i> Packages</a>
            @endcanany
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-user mr-2"></i>
                        Edit Package
                    </h3>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Edit Package - {{ $package->name }}</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('packages.update', $package) }}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">Package Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                                name="name" id="name" value="{{ old('name', $package->name) }}"
                                                required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="slug" class="form-label fw-bold">Slug</label>
                                            <input class="form-control @error('slug') is-invalid @enderror" type="text"
                                                name="slug" id="slug" value="{{ old('slug', $package->slug) }}"
                                                required>
                                            @error('slug')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Auto-generated from name or enter custom</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="price" class="form-label fw-bold">Price</label>
                                            <input class="form-control @error('price') is-invalid @enderror" type="number"
                                                name="price" id="price" value="{{ old('price', $package->price) }}"
                                                step="0.01" min="0" required>
                                            @error('price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="billing_period" class="form-label fw-bold">Billing Period</label>
                                            <select class="form-select @error('billing_period') is-invalid @enderror"
                                                name="billing_period" id="billing_period" required>
                                                <option value="monthly"
                                                    {{ old('billing_period', $package->billing_period) == 'monthly' ? 'selected' : '' }}>
                                                    Monthly</option>
                                                <option value="yearly"
                                                    {{ old('billing_period', $package->billing_period) == 'yearly' ? 'selected' : '' }}>
                                                    Yearly</option>
                                                <option value="lifetime"
                                                    {{ old('billing_period', $package->billing_period) == 'lifetime' ? 'selected' : '' }}>
                                                    Lifetime</option>
                                            </select>
                                            @error('billing_period')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label fw-bold">Sort Order</label>
                                            <input class="form-control @error('sort_order') is-invalid @enderror"
                                                type="number" name="sort_order" id="sort_order"
                                                value="{{ old('sort_order', $package->sort_order) }}" min="0">
                                            @error('sort_order')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                        rows="3">{{ old('description', $package->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">
                                            Active Package
                                        </label>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h5 class="card-title mb-3">Package Features</h5>

                                <div id="features-container">
                                    @foreach ($features as $feature)
                                        @php
                                            $packageFeature = $package
                                                ->packageFeatures
                                                ->where('feature_id', $feature->id)
                                                ->first();
                                            $currentValue = $packageFeature ? $packageFeature->value : null;
                                        @endphp

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-5">
                                                <label class="form-label fw-bold mb-0">
                                                    {{ $feature->name }}
                                                    <small class="text-muted d-block">{{ $feature->description }}</small>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                @if ($feature->type === 'boolean')
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="features[{{ $feature->id }}]"
                                                            id="feature_{{ $feature->id }}" value="true"
                                                            {{ old('features.' . $feature->id, $currentValue) == 'true' ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="feature_{{ $feature->id }}">
                                                            Enabled
                                                        </label>
                                                    </div>
                                                @elseif($feature->type === 'numeric')
                                                    <input class="form-control" type="number"
                                                        name="features[{{ $feature->id }}]"
                                                        id="feature_{{ $feature->id }}"
                                                        value="{{ old('features.' . $feature->id, $currentValue) }}"
                                                        min="0" placeholder="Enter limit">
                                                @elseif($feature->type === 'unlimited')
                                                    <select class="form-select" name="features[{{ $feature->id }}]"
                                                        id="feature_{{ $feature->id }}">
                                                        <option value="">Not included</option>
                                                        <option value="unlimited"
                                                            {{ old('features.' . $feature->id, $currentValue) == 'unlimited' ? 'selected' : '' }}>
                                                            Unlimited</option>
                                                        <option value="custom"
                                                            {{ old('features.' . $feature->id, $currentValue) == 'custom' ? 'selected' : '' }}>
                                                            Custom Limit</option>
                                                    </select>
                                                @else
                                                    <input class="form-control" type="text"
                                                        name="features[{{ $feature->id }}]"
                                                        id="feature_{{ $feature->id }}"
                                                        value="{{ old('features.' . $feature->id, $currentValue) }}"
                                                        placeholder="Enter value">
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <span class="badge bg-secondary">{{ ucfirst($feature->type) }}</span>
                                                @if ($feature->category)
                                                    <span class="badge bg-info">{{ ucfirst($feature->category) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save me-1"></i> Update Package
                                    </button>
                                    <a href="{{ route('packages.index') }}" class="btn btn-secondary waves-effect">
                                        <i class="mdi mdi-cancel me-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extra_script')
    <script>
        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function(e) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
@endpush
