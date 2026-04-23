<div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        {{ $isEditing ? 'Edit Product' : 'Create New Product' }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="row">
            {{-- Left Column - Main Content --}}
            <div class="col-lg-8">
                {{-- Basic Information Card --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle"></i> Basic Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-semibold">
                                    Product Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    wire:model="title" placeholder="Enter product title">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Price <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        wire:model="price" placeholder="0.00" min="0">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Category <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                    wire:model.live="category_id">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Sub-Category <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('sub_category_id') is-invalid @enderror"
                                    wire:model="sub_category_id" {{ !$category_id ? 'disabled' : '' }}>
                                    <option value="">Select Sub-Category</option>
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if (!$category_id)
                                    <small class="text-muted">Please select a category first</small>
                                @endif
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Brand <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('brand_id') is-invalid @enderror"
                                    wire:model="brand_id">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <div wire:ignore>
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" wire:model="description"
                                        rows="4" placeholder="Enter detailed product description">{{ $description }}</textarea>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO Section --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-search"></i> SEO Settings
                            </h6>
                            <span class="badge bg-info">Optional</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                wire:model="meta_keywords" placeholder="keyword1, keyword2, keyword3">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Separate keywords with commas</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" wire:model="meta_description"
                                rows="3" placeholder="Brief description for search engines (150-160 characters recommended)" maxlength="160"></textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">{{ strlen($meta_description ?? '') }}/160</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Images Section --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-images"></i> Product Images
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Thumbnail Section --}}
                        <div class="mb-4 pb-4 border-bottom">
                            <h6 class="mb-3">
                                Thumbnail Image <span class="text-danger">*</span>
                                <small class="text-muted fw-normal">(Main product image)</small>
                            </h6>

                            <div class="row">
                                @if ($currentThumbnail && !$thumbnail)
                                    <div class="col-md-4 mb-3">
                                        <div class="position-relative">
                                            <img src="{{ asset('uploads/products/thumbnails/' . $currentThumbnail) }}"
                                                alt="Current thumbnail" class="img-fluid rounded border"
                                                style="max-height: 200px; object-fit: cover; width: 100%;">
                                            <span
                                                class="badge bg-primary position-absolute top-0 start-0 m-2">Current</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($thumbnail)
                                    <div class="col-md-4 mb-3">
                                        <div class="position-relative">
                                            <img src="{{ $thumbnail->temporaryUrl() }}" alt="New thumbnail preview"
                                                class="img-fluid rounded border"
                                                style="max-height: 200px; object-fit: cover; width: 100%;">
                                            <span
                                                class="badge bg-success position-absolute top-0 start-0 m-2">New</span>
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                wire:click="$set('thumbnail', null)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <div class="{{ $currentThumbnail || $thumbnail ? 'col-md-8' : 'col-md-12' }}">
                                    <div class="border-2 border-dashed rounded p-4 text-center bg-light">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <h6>Upload Thumbnail Image</h6>
                                        <input type="file"
                                            class="form-control @error('thumbnail') is-invalid @enderror"
                                            wire:model="thumbnail" accept="image/*">
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-2">
                                            Recommended: 800x800px, Max 2MB (JPG, PNG, WEBP)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Gallery Photos Section --}}
                        <div>
                            <h6 class="mb-3">
                                Product Gallery
                                <small class="text-muted fw-normal">(Additional images)</small>
                            </h6>

                            {{-- Existing Photos --}}
                            @if ($isEditing && count($existingPhotos) > 0)
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Current Gallery Photos</label>
                                    <div class="row g-2">
                                        @foreach ($existingPhotos as $index => $photo)
                                            <div class="col-md-3 col-sm-4 col-6"
                                                wire:key="existing-photo-{{ $index }}">
                                                <div class="position-relative">
                                                    <img src="{{ asset('uploads/products/photos/' . $photo->photo_name) }}"
                                                        alt="Product photo" class="img-fluid rounded border"
                                                        style="height: 150px; object-fit: cover; width: 100%;">
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                                        wire:click="removeExistingPhoto({{ $photo->id }})"
                                                        wire:confirm="Are you sure you want to delete this photo?">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- New Photos Preview --}}
                            @if ($newPhotos && count($newPhotos) > 0)
                                <div class="mb-3">
                                    <label class="form-label text-muted small">New Photos to Upload</label>
                                    <div class="row g-2">
                                        @foreach ($newPhotos as $index => $photo)
                                            <div class="col-md-3 col-sm-4 col-6"
                                                wire:key="new-photo-{{ $index }}">
                                                <div class="position-relative">
                                                    <img src="{{ $photo->temporaryUrl() }}" alt="New photo preview"
                                                        class="img-fluid rounded border"
                                                        style="height: 150px; object-fit: cover; width: 100%;">
                                                    <span
                                                        class="badge bg-success position-absolute top-0 start-0 m-1">New</span>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                                        wire:click="removeNewPhoto({{ $index }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Upload New Photos --}}
                            <div class="border-2 border-dashed rounded p-4 text-center bg-light">
                                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                <h6>Add More Gallery Photos</h6>
                                <input type="file" class="form-control @error('newPhotos.*') is-invalid @enderror"
                                    wire:model="newPhotos" multiple accept="image/*">
                                @error('newPhotos')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('newPhotos.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">
                                    You can select multiple images at once. Max 5MB per image.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column - Sidebar --}}
            <div class="col-lg-4">
                {{-- Status & Visibility Card --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-cog"></i> Status & Visibility
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active"
                                    wire:model="is_active" style="width: 3em; height: 1.5em;">
                                <label class="form-check-label ms-2" for="is_active">
                                    <strong>Active Status</strong>
                                    <small class="d-block text-muted">Make this product visible to customers</small>
                                </label>
                            </div>
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_popular"
                                    wire:model="is_popular" style="width: 3em; height: 1.5em;">
                                <label class="form-check-label ms-2" for="is_popular">
                                    <strong>Popular Product</strong>
                                    <small class="d-block text-muted">Display in popular section</small>
                                </label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_featured"
                                    wire:model="is_featured" style="width: 3em; height: 1.5em;">
                                <label class="form-check-label ms-2" for="is_featured">
                                    <strong>Featured Product</strong>
                                    <small class="d-block text-muted">Highlight on homepage</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Publishing Card --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-calendar"></i> Publishing
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($isEditing)
                            <div class="mb-2">
                                <small class="text-muted">Created:</small>
                                <div class="fw-semibold">{{ $created_at ? $created_at->format('M d, Y H:i') : 'N/A' }}
                                </div>
                            </div>
                            <div>
                                <small class="text-muted">Last Updated:</small>
                                <div class="fw-semibold">{{ $updated_at ? $updated_at->format('M d, Y H:i') : 'N/A' }}
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle"></i> Product will be created with current timestamp
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Action Buttons Card --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fas fa-save"></i>
                                    {{ $isEditing ? 'Update Product' : 'Create Product' }}
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin"></i> Saving...
                                </span>
                            </button>

                            @if ($isEditing)
                                <a href="{{ route('admin.products.show', $productId) }}"
                                    class="btn btn-outline-info">
                                    <i class="fas fa-eye"></i> View Product
                                </a>
                            @endif

                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Quick Tips Card --}}
                <div class="card shadow-sm border-info">
                    <div class="card-header bg-info text-white py-2">
                        <h6 class="m-0 small">
                            <i class="fas fa-lightbulb"></i> Quick Tips
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0 ps-3">
                            <li class="mb-2">Use clear, descriptive product titles</li>
                            <li class="mb-2">Upload high-quality images (800x800px recommended)</li>
                            <li class="mb-2">Fill in SEO fields to improve search visibility</li>
                            <li class="mb-2">Mark products as "Popular" or "Featured" to increase exposure</li>
                            <li>Set products to "Inactive" to hide from customers without deleting</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('backend/assets/hugerte-dist-1.0.9/hugerte.min.js') }}"></script>
<script>
    let descriptionEditor;

    function initializeDescriptionEditor() {
        // Remove existing editor if present
        if (hugerte.get('description')) {
            hugerte.remove('#description');
        }

        // Initialize the editor
        hugerte.init({
            selector: 'textarea#description',
            plugins: 'advlist autolink lists link image charmap preview hr anchor pagebreak',
            toolbar_mode: 'sliding',
            height: 250,
            menubar: false,
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | removeformat help',
            fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt',
            block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6;',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
            setup: function(editor) {
                descriptionEditor = editor;

                // Set initial content
                editor.on('init', function() {
                    editor.setContent(@this.get('description') || '');
                });

                // Update Livewire when content changes
                editor.on('change', function() {
                    @this.set('description', editor.getContent());
                });

                editor.on('blur', function() {
                    @this.set('description', editor.getContent());
                });
            }
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            initializeDescriptionEditor();
        }, 500);
    });

    // Reinitialize after Livewire updates
    document.addEventListener('livewire:load', function() {
        Livewire.hook('message.processed', (message, component) => {
            setTimeout(() => {
                initializeDescriptionEditor();
            }, 200);
        });
    });

    // Clean up before page unload
    window.addEventListener('beforeunload', function() {
        if (hugerte.get('description')) {
            hugerte.remove('#description');
        }
    });
</script>
