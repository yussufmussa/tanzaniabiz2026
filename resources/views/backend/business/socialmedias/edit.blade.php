@extends('backend.layouts.base')
@section('title', $socialmedia->name)

@section('contents')
    <div class="row">
        @canany(['update.social_medias', 'manage.social_medias'])
            <div class="d-flex justify-content-end">
                <a type="submit" class="btn  btn-primary btn-sm mb-1 mt-0" href="{{ route('socialmedias.index') }}">
                    <i class="fa fa-arrow-left"></i> Back</a>
            </div>
        @endcanany
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('socialmedias.update', $socialmedia->id) }}" method="post"
                                enctype="multipart/form-data">@csrf
                                @method('patch')

                                <div class="mb-3">
                                    <label for="forCategory" class="form-label fw-bold">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" value="{{ $socialmedia->name }}">
                                    @error('name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                   <i class="mdi mdi-content-save me-1"></i> Update Social Media</button>
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
