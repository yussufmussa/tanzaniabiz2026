@extends('backend.layouts.base')
@section('title', 'New Category')

@section('contents')
    <div class="row">
        <div class="d-flex justify-content-end">
        @canany(['create.categories', 'manage.categories'])
            <a type="submit" class="btn  btn-primary btn-sm mb-1 mt-0"
                href="{{ route('categories.index') }}">
                <i class="bx bx-list-ul me-1"></i> Categories</a>
        @endcanany
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">New Category</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('categories.store') }}" method="post"
                                enctype="multipart/form-data">@csrf

                                <div class="mb-3">
                                    <label for="forCategory" class="form-label fw-bold">Category Photo/Icon (optional)</label>
                                    <input class="form-control @error('icon') is-invalid @enderror" type="file"
                                        name="icon" id="photoInput" accept="image/*">
                                    @error('icon')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Image Preview -->
                                    <div id="photoPreview" class="mt-3" style="display: none;">
                                        <img id="previewPhoto" src="" alt="Preview"
                                            style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                                        <button type="button" id="removePhotoBtn" class="btn btn-sm btn-danger mt-2">
                                            <i class="mdi mdi-close"></i> Remove
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="forCategory" class="form-label fw-bold">Category Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name">
                                    @error('name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Save</button>
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
