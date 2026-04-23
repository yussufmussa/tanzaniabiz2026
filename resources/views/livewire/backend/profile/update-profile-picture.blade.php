{{-- resources/views/livewire/profile/profile-picture.blade.php --}}
<div>
    <div class="d-flex align-items-center mb-4">
        <form wire:submit.prevent="updateProfilePicture" enctype="multipart/form-data">
            <div class="mb-3">
                @if ($currentPhoto)
                    <img src="{{ asset($currentPhoto) }}" alt="Profile Picture" width="150px" height="150px"
                        class="rounded">
                @endif
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Profile Picture</label>
                <input wire:model="photo" type="file" class="form-control @error('photo') is-invalid @enderror">
                @error('photo')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if ($success)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
               Profile Picture Updated successful
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
                @endif

        <button type="submit"
                    class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-content-save me-1"></i>Save</button>
        </form>

        {{-- Loading State --}}
        <div wire:loading wire:target="photo" class="text-primary small">
            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
            Uploading...
        </div>

    </div>
