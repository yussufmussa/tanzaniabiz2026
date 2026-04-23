@if ($currentStep == 2)
    <div class="tab-pane fade show active">

         <div wire:loading.flex wire:target="savePhotos"
            class="position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center"
            style="background: rgba(255,255,255,0.7); z-index: 9999;">

            <div class="text-center">
                <img src="{{ asset('uploads/general/loading.gif') }}" alt="Saving..." style="width:80px;">
                <p class="mt-2 mb-0">Saving...</p>
            </div>
        </div>


        <form wire:submit.prevent="savePhotos">
            <div class="mb-3">
                <label for="photos" class="form-label">Upload Photos (Maximum 6 photos)</label>
                <input type="file" class="form-control" wire:model="photos" multiple accept="image/*"
                    id="photos-{{ $photoIteration }}">
                <small class="text-muted">You can add photos one at a time or select multiple at
                    once</small>

                @error('photos.*')
                    <span class="text-danger d-block">{{ $message }}</span>
                @enderror

                <div wire:loading wire:target="photos" class="text-muted mt-2">
                    <i class="bi bi-hourglass-split"></i> Processing photos...
                </div>
            </div>

            <!-- Photo Preview -->
            <div id="photoPreview" class="row mb-3">
                <!-- Existing Photos -->
                @foreach ($existingPhotos as $photo)
                    <div class="col-md-4 col-lg-2 mb-3" wire:key="existing-{{ $photo->id }}">
                        <div class="position-relative">
                            <img src="{{ asset('uploads/businessListings/photos/' . $photo->name) }}"
                                class="img-thumbnail" alt="Photo">
                            <button type="button" wire:click="deleteExistingPhoto({{ $photo->id }})"
                                wire:confirm="Are you sure you want to delete this photo?"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                <i class="fa  fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

                <!-- New Photo Previews -->
                @foreach ($photos as $index => $photo)
                    <div class="col-md-4 col-lg-2 mb-3" wire:key="new-{{ $index }}">
                        <div class="position-relative">
                            <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail" alt="Photo Preview">
                            <button type="button" wire:click="removeNewPhoto({{ $index }})"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                Existing photos: <span>{{ count($existingPhotos) }}</span>/6 |
                New photos: <span>{{ count($photos) }}</span> |
                Total: <strong>{{ count($existingPhotos) + count($photos) }}</strong>/6
            </div>

            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="savePhotos">{{ $mode == 'create' ? 'Save & Continue' : 'Update & Continue' }} </span>
                <span wire:loading wire:target="savePhotos">Saving...</span>
            </button>
            <button type="button" wire:click="skipPhotos" class="btn btn-secondary">Skip</button>
        </form>
    </div>
@endif
