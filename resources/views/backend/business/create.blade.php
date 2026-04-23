@extends('backend.layouts.base')
@section('title', 'Add Product')

@push('extra_style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('contents')

    <div class="col-12">
        <div class="d-flex justify-content-end mb-1">
            <a href="{{ route('listings.index') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-left-arrow-alt me-1"></i> Listings
            </a>
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

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <i class="bx bx-plus"></i> Create Business Listing
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <form action="{{ route('listings.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            {{-- ======================== BASIC INFO ======================== --}}
                                            <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Business Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" value="{{ old('name') }}"
                                                        class="form-control @error('name') is-invalid @enderror">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Logo</label>
                                                    <input type="file" name="logo" accept="image/*"
                                                        class="form-control @error('logo') is-invalid @enderror"
                                                        onchange="previewSingleImage(this, 'logo-preview')">
                                                    @error('logo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="mt-2">
                                                        <img id="logo-preview" src="#" class="img-thumbnail d-none"
                                                            style="max-height:120px;">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Category <span
                                                            class="text-danger">*</span></label>
                                                    <select name="category_id"
                                                        class="form-select @error('category_id') is-invalid @enderror">
                                                        <option value="">-- Select Category --</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                @selected(old('category_id') == $category->id)>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Sub Categories</label>
                                                    <select name="sub_category_ids[]"
                                                        class="form-select @error('sub_category_ids') is-invalid @enderror"
                                                        multiple>
                                                        @foreach ($subCategories as $sub)
                                                            <option value="{{ $sub->id }}"
                                                                {{ in_array($sub->id, old('sub_category_ids', [])) ? 'selected' : '' }}>
                                                                {{ $sub->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('sub_category_ids')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">City <span
                                                            class="text-danger">*</span></label>
                                                    <select name="city_id"
                                                        class="form-select @error('city_id') is-invalid @enderror">
                                                        <option value="">-- Select City --</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                @selected(old('city_id') == $city->id)>
                                                                {{ $city->city_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('city_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" name="email" value="{{ old('email') }}"
                                                        class="form-control @error('email') is-invalid @enderror">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Phone <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                                        class="form-control @error('phone') is-invalid @enderror">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Website</label>
                                                    <input type="url" name="website" value="{{ old('website') }}"
                                                        class="form-control @error('website') is-invalid @enderror">
                                                    @error('website')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">Description <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="description" rows="7" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- ======================== LOCATION ======================== --}}
                                            <h5 class="mb-3 border-bottom pb-2">Location</h5>
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">Location Address <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="location" value="{{ old('location') }}"
                                                        class="form-control @error('location') is-invalid @enderror">
                                                    @error('location')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">YouTube Video Link</label>
                                                    <input type="url" name="youtube_video_link"
                                                        value="{{ old('youtube_video_link') }}"
                                                        class="form-control @error('youtube_video_link') is-invalid @enderror">
                                                    @error('youtube_video_link')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- ======================== STATUS ======================== --}}
                                            <h5 class="mb-3 border-bottom pb-2">Settings</h5>
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status"
                                                            value="1" {{ old('status', 1) ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-bold">Active</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="is_featured" value="1"
                                                            {{ old('is_featured') ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-bold">Featured</label>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- ======================== GALLERY PHOTOS ======================== --}}
                                            <h5 class="mb-3 border-bottom pb-2">Gallery Photos</h5>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Upload Photos</label>
                                                <input type="file" name="photos[]" multiple accept="image/*"
                                                    class="form-control @error('photos') is-invalid @enderror"
                                                    onchange="previewMultipleImages(this, 'new-photos-preview')">
                                                @error('photos')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                                <div id="new-photos-preview" class="d-flex flex-wrap gap-2 mt-3"></div>
                                            </div>

                                            {{-- ======================== PRODUCTS ======================== --}}
                                            <h5 class="mb-3 border-bottom pb-2">Products / Services</h5>

                                            <div id="products-container"></div>

                                            <button type="button" class="btn btn-outline-primary btn-sm mb-4"
                                                onclick="addProduct()">
                                                <i class="bx bx-plus"></i> Add Product
                                            </button>

                                            {{-- ======================== WORKING HOURS ======================== --}}
                                            <h5 class="mb-3 border-bottom pb-2">Working Hours</h5>
                                            @php
                                                $timeOptions = [];
                                                for ($h = 0; $h < 24; $h++) {
                                                    for ($m = 0; $m < 60; $m += 30) {
                                                        $time24 = sprintf('%02d:%02d', $h, $m);
                                                        $time12 = date('h:i A', strtotime($time24));
                                                        $timeOptions[$time24] = $time12;
                                                    }
                                                }
                                                $defaultOpen = '09:00';
                                                $defaultClose = '17:00';
                                            @endphp

                                            <div class="table-responsive mb-4">
                                                <table class="table table-bordered align-middle" id="working-hours-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Day</th>
                                                            <th>Open Time</th>
                                                            <th>Close Time</th>
                                                            <th class="text-center">24/7</th>
                                                            <th class="text-center">Closed</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($days as $index => $day)
                                                            @php
                                                                $open = old(
                                                                    "working_hours.$index.open_time",
                                                                    $defaultOpen,
                                                                );
                                                                $close = old(
                                                                    "working_hours.$index.close_time",
                                                                    $defaultClose,
                                                                );

                                                                $is247 = (bool) old(
                                                                    "working_hours.$index.is_24_7",
                                                                    false,
                                                                );
                                                                $isClosed = (bool) old(
                                                                    "working_hours.$index.is_closed",
                                                                    false,
                                                                );

                                                                $disabled = $is247 || $isClosed;
                                                            @endphp

                                                            <tr class="wh-row" data-index="{{ $index }}"
                                                                data-default-open="{{ $defaultOpen }}"
                                                                data-default-close="{{ $defaultClose }}"
                                                                data-247-open="00:00" data-247-close="23:59">
                                                                <td class="fw-bold">{{ $day }}</td>

                                                                <td>
                                                                    <select
                                                                        name="working_hours[{{ $index }}][open_time]"
                                                                        class="form-control form-control-sm wh-open"
                                                                        @disabled($disabled)>
                                                                        <option value="">Select time</option>
                                                                        @foreach ($timeOptions as $val => $label)
                                                                            <option value="{{ $val }}"
                                                                                @selected($open === $val)>
                                                                                {{ $label }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <select
                                                                        name="working_hours[{{ $index }}][close_time]"
                                                                        class="form-control form-control-sm wh-close"
                                                                        @disabled($disabled)>
                                                                        <option value="">Select time</option>
                                                                        @foreach ($timeOptions as $val => $label)
                                                                            <option value="{{ $val }}"
                                                                                @selected($close === $val)>
                                                                                {{ $label }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td class="text-center">
                                                                    <input type="checkbox"
                                                                        name="working_hours[{{ $index }}][is_24_7]"
                                                                        class="form-check-input wh-247" value="1"
                                                                        @checked($is247)>
                                                                </td>

                                                                <td class="text-center">
                                                                    <input type="checkbox"
                                                                        name="working_hours[{{ $index }}][is_closed]"
                                                                        class="form-check-input wh-closed" value="1"
                                                                        @checked($isClosed)>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- ======================== SOCIAL MEDIA ======================== --}}
                                            <h5 class="mb-3 border-bottom pb-2">Social Media</h5>
                                            <div class="row g-3 mb-4">
                                                @foreach ($socialMedias as $sm)
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">{{ $sm->name }}</label>
                                                        <input type="url"
                                                            name="social_media[{{ $sm->id }}][link]"
                                                            class="form-control" placeholder="https://..."
                                                            value="{{ old("social_media.$sm->id.link") }}">
                                                        <input type="hidden"
                                                            name="social_media[{{ $sm->id }}][social_media_id]"
                                                            value="{{ $sm->id }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- ======================== SUBMIT ======================== --}}
                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    <i class="mdi mdi-content-save me-1"></i> Save Listing
                                                </button>
                                                <a href="{{ route('listings.index') }}"
                                                    class="btn btn-secondary ms-1">Cancel</a>
                                            </div>

                                        </form>
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
        let productIndex = 1000;

        function previewSingleImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'position-relative';
                    wrapper.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail"
                        style="height:100px;width:100px;object-fit:cover;">
                `;
                    container.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }

        function addProduct() {
            const idx = productIndex++;
            const container = document.getElementById('products-container');
            const card = document.createElement('div');
            card.className = 'card border mb-3';
            card.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>New Product</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeProduct(this)">
                        <i class="bx bx-trash"></i> Remove
                    </button>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="products[new_${idx}][name]" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Price</label>
                        <input type="number" step="0.01" name="products[new_${idx}][price]" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="products[new_${idx}][description]" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Photo</label>
                        <input type="file" name="products[new_${idx}][photo]" class="form-control" accept="image/*"
                            onchange="previewProductPhoto(this)">
                        <div class="mt-2">
                            <img class="product-photo-preview img-thumbnail d-none" style="max-height:80px;">
                        </div>
                    </div>
                </div>
            </div>
        `;
            container.appendChild(card);
        }

        function previewProductPhoto(input) {
            const preview = input.closest('.card-body').querySelector('.product-photo-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeProduct(btn) {
            btn.closest('.card').remove();
        }
    </script>

    <script>
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('working-hours-table');
            if (!table) return;

            function applyRowState(row) {
                const cb247 = row.querySelector('.wh-247');
                const cbClosed = row.querySelector('.wh-closed');
                const openInput = row.querySelector('.wh-open');
                const closeInput = row.querySelector('.wh-close');

                const is247 = cb247.checked;
                const isClosed = cbClosed.checked;

                const disabled = is247 || isClosed;
                openInput.disabled = disabled;
                closeInput.disabled = disabled;

                if (isClosed) {
                    openInput.value = '';
                    closeInput.value = '';
                } else if (is247) {
                    openInput.value = row.dataset['247Open'] || '00:00';
                    closeInput.value = row.dataset['247Close'] || '23:59';
                } else {
                    if (!openInput.value) openInput.value = row.dataset.defaultOpen || '09:00';
                    if (!closeInput.value) closeInput.value = row.dataset.defaultClose || '17:00';
                }
            }

            table.querySelectorAll('.wh-row').forEach(row => {
                const cb247 = row.querySelector('.wh-247');
                const cbClosed = row.querySelector('.wh-closed');

                cbClosed.addEventListener('change', () => {
                    if (cbClosed.checked) cb247.checked = false;
                    applyRowState(row);
                });

                cb247.addEventListener('change', () => {
                    if (cb247.checked) cbClosed.checked = false;
                    applyRowState(row);
                });

                applyRowState(row);
            });
        });
    </script>
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
