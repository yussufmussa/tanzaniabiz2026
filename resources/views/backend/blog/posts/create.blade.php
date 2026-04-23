@extends('backend.layouts.base')
@section('title', 'New Post')

@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end pb-1">
                <a href="{{ route('posts.index') }}" class="btn btn-primary btn-sm w-md waves-effect waves-light">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

            <form enctype="multipart/form-data" method="POST" action="{{ route('posts.store') }}" data-parsley-validate
                class="form-horizontal form-label-left">
                @csrf

                <div class="row">
                    <!-- Main Content Column -->
                    <div class="col-lg-9">
                        <!-- Basic Information Card -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Basic Information</h4>

                                <!-- Title (required) -->
                                <div class="mb-3">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                <!-- Body/Content (required) -->
                                <div class="mb-3">
                                    <label for="body">Content <span class="text-danger">*</span></label>
                                    <textarea name="body" id="body" rows="12" class="form-control @error('body') is-invalid @enderror"
                                        placeholder="Write your blog post content here..">{{ old('body') }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings Card -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">SEO Settings</h5>
                            </div>
                            <div class="card-body">
                                <!-- Meta Keywords (optional) -->
                                <div class="mb-3">
                                    <label for="meta_keywords">Meta Keywords <small
                                            class="text-muted">(optional)</small></label>
                                    <input type="text" name="meta_keywords" id="meta_keywords"
                                        class="form-control @error('meta_keywords') is-invalid @enderror"
                                        value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                                    <small class="text-muted">Separate keywords with commas</small>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                <!-- Meta Description (optional) -->
                                <div class="mb-3">
                                    <label for="meta_description">Meta Description <small
                                            class="text-muted">(optional)</small></label>
                                    <textarea name="meta_description" id="meta_description" rows="3"
                                        class="form-control @error('meta_description') is-invalid @enderror"
                                        placeholder="Brief description for search engines (recommended: 150-160 characters)">{{ old('meta_description') }}</textarea>
                                    <small class="text-muted">
                                        <span id="metaDescCounter">0</span>/160 characters
                                    </small>
                                    @error('meta_description')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Column -->
                    <div class="col-lg-3">
                        <!-- Publish Settings Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Publish Settings</h5>
                            </div>
                            <div class="card-body">
                                <!-- Status (required) -->
                                <div class="mb-3">
                                    <label for="is_published">Status <span class="text-danger">*</span></label>
                                    <select name="is_published" id="is_published"
                                        class="form-control @error('is_published') is-invalid @enderror" required>

                                        {{-- Always show Draft --}}
                                        <option value="0" {{ old('is_published', 0) == 0 ? 'selected' : '' }}>
                                            Draft
                                        </option>

                                        {{-- Only show Published if user is NOT writer --}}
                                        @unless (auth()->user()->hasRole('writer'))
                                            <option value="1" {{ old('is_published') == 1 ? 'selected' : '' }}>
                                                Published
                                            </option>
                                        @endunless
                                    </select>
                                    @error('is_published')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>


                                <!-- Submit Buttons -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Create
                                        Post</button>
                                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>


                        <!-- Featured Image Card -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Featured Image</h5>
                            </div>
                            <div class="card-body">
                                <!-- Thumbnail Upload (optional) -->
                                <div class="mb-3">
                                    <label for="thumbnail">Thumbnail Image <small
                                            class="text-muted">(optional)</small></label>
                                    <input type="file" name="thumbnail" id="thumbnail"
                                        class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*"
                                        onchange="previewThumbnail(this);">
                                    <small class="text-muted">Supported formats: JPEG, PNG, JPG, GIF, WebP (Max:
                                        2MB)</small>
                                    @error('thumbnail')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                <!-- Thumbnail Preview -->
                                <div class="mb-0" id="thumbnailPreview" style="display: none;">
                                    <label>Thumbnail Preview</label><br>
                                    <img id="thumbnailImg" src="" alt="Thumbnail Preview"
                                        class="img-thumbnail w-100" style="max-height: 200px; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <!-- Categories & Tags Card -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Categories & Tags</h5>
                            </div>
                            <div class="card-body">
                                <!-- Category (optional) -->
                                <div class="mb-3">
                                    <label for="category_id">Category <small class="text-muted">(optional)</small></label>
                                    <select name="category_id" id="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Tags (optional) -->
                                <div class="mb-0">
                                    <label for="tags">Tags <small class="text-muted">(optional)</small></label>
                                    <select name="tags[]" id="tags" multiple
                                        class="form-control @error('tags') is-invalid @enderror" style="height: 120px;">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}"
                                                {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple tags</small>
                                    @error('tags')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('extra_script')
    <script>
        // Preview thumbnail image
        function previewThumbnail(input) {
            const preview = document.getElementById('thumbnailPreview');
            const img = document.getElementById('thumbnailImg');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        // Meta description character counter
        document.getElementById('meta_description').addEventListener('input', function() {
            const counter = document.getElementById('metaDescCounter');
            const length = this.value.length;
            counter.textContent = length;

            // Change color based on length
            if (length > 160) {
                counter.style.color = '#dc3545'; // Red
            } else if (length > 140) {
                counter.style.color = '#fd7e14'; // Orange
            } else {
                counter.style.color = '#28a745'; // Green
            }
        });
    </script>
    <script src="{{ asset('backend/assets/hugerte-dist-1.0.9/hugerte.min.js') }}"></script>
    <script>
        hugerte.init({
            selector: 'textarea#body',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            height: 400,
            menubar: false,
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | bullist numlist outdent indent | link image | removeformat',
            images_upload_url: '{{ route('editor.image.upload') }}',
            images_upload_handler: function(blobInfo) {
                return new Promise((resolve, reject) => {
                    let formData = new FormData();
                    formData.append('image', blobInfo.blob(), blobInfo.filename());
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('editor.image.upload') }}', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.location) {
                                resolve(data.location);
                            } else {
                                reject('Upload failed: ' + (data.message || 'Unknown error'));
                            }
                        })
                        .catch(err => reject('Upload error: ' + err.message));
                });
            },
            file_picker_types: 'image',
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    let input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', function() {
                        let file = this.files[0];
                        let formData = new FormData();
                        formData.append('image', file);
                        formData.append('_token', '{{ csrf_token() }}');

                        fetch('{{ route('editor.image.upload') }}', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.location) {
                                    callback(data.location, {
                                        title: file.name
                                    });
                                }
                            })
                            .catch(err => console.error('Upload error:', err));
                    });

                    input.click();
                }
            }
        });
    </script>
@endpush
