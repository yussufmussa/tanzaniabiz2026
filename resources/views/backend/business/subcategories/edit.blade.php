@extends('backend.layouts.base')
@section('title', $subcategory->name)

@section('contents')
    <div class="row">
        @canany(['categories.edit', 'categories.manage'])
            <div class="d-flex justify-content-end">
                <a type="submit" class="btn  btn-primary btn-sm mb-1 mt-0" href="{{ route('subcategories.index') }}"><i
                        class="fa fa-arrow-left"></i>Back</a>
            </div>
        @endcanany
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('subcategories.update', $subcategory->id) }}"
                                enctype="multipart/form-data" method="post">
                                @csrf
                                @method('patch')
                                <div class="mb-3">
                                    <label for="forCategory" class="form-label fw-bold">Main Category</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                        name="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $category->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="forCategory" class="form-label fw-bold">Sub Category Photo/Icon (optional)</label>
                                    <input class="form-control @error('photo') is-invalid @enderror" type="file"
                                        name="photo" id="photoInput" accept="image/*">
                                    @error('photo')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Image Preview -->
                                    <div id="photoPreview" class="mt-3"
                                        style="{{ $subcategory->photo ? 'display:block;' : 'display:none;' }}">
                                        <img id="previewPhoto"
                                            src="{{ $subcategory->photo ? asset('uploads/SubCategoryPhotos/' . $subcategory->photo) : '' }}"
                                            alt="Preview"
                                            style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                                        <button type="button" id="removePhotoBtn" class="btn btn-sm btn-danger mt-2">
                                            <i class="mdi mdi-close"></i> Remove
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="forCategory" class="form-label fw-bold">Sub Category Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" value="{{ old('name', $subcategory->name) }}">
                                    @error('name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Update Sub Category</button>
                        </div>

                        </form>
                    </div> <!-- end row -->
                </div>
            </div>
        </div>
    </div>

@endsection
@push('extra_script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const photoInput = document.getElementById('photoInput');
            const photoPreview = document.getElementById('photoPreview');
            const previewPhoto = document.getElementById('previewPhoto');
            const removePhotoButton = document.getElementById('removePhotoBtn');

            // Preview image when file is selected
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewPhoto.src = e.target.result;
                        photoPreview.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Remove image preview
            removePhotoButton.addEventListener('click', function() {
                photoInput.value = '';
                previewPhoto.src = '';
                photoPreview.style.display = 'none';
            });
        });
    </script>
@endpush
