<div class="tab-pane fade" id="photos" role="tabpanel">
    <form id="photosForm" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="photos" class="form-label">Upload Photos (Maximum 6 photos)</label>
            <input type="file" class="form-control" id="photos" name="photos[]" accept="image/*">
            <small class="text-muted">You can add photos one at a time or select multiple at once</small>
        </div>

        <div id="photoPreview" class="row mb-3">
            @if (isset($listing) && $listing->photos->count())
                @foreach ($listing->photos as $photo)
                    <div class="col-md-4 col-lg-2 mb-3 existing-photo" data-photo-id="{{ $photo->id }}">
                        <div class="position-relative">
                            <img src="{{ asset('uploads/business/photos/' . $photo->name) }}" class="img-thumbnail"
                                alt="Photo">
                            <button type="button"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-existing-photo"
                                data-photo-id="{{ $photo->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> 
            Existing photos: <span id="existingPhotoCount">{{ isset($listing) ? $listing->photos->count() : 0 }}</span>/6 | 
            New photos: <span id="newPhotoCount">0</span> | 
            Total: <span id="totalPhotoCount">{{ isset($listing) ? $listing->photos->count() : 0 }}</span>/6
        </div>

        <button type="submit" class="btn btn-primary">Save & Continue</button>
        <button type="button" class="btn btn-secondary skip-tab-btn" data-next-tab="products-tab">Skip</button>
    </form>
</div>