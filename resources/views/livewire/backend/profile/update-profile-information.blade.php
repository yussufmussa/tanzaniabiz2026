<div>
    <form wire:submit.prevent="updateProfile">
        @csrf

        {{-- Email Field --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" value="{{auth()->user()->email}}" id="email" class="form-control @error('email') is-invalid @enderror"
                type="email" disabled>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Name Field --}}
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input wire:model="name" id="name" class="form-control @error('name') is-invalid @enderror"
                type="text">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


        {{-- Success Message --}}
        @if ($success)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
                User Info Updated successful
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Save Button --}}
        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary waves-effect waves-light">
            <span wire:loading.remove wire:target="updateProfile"><i class="mdi mdi-content-save me-1"></i>Save</span>
            <span wire:loading wire:target="updateProfile">
                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                Saving...
            </span>
        </button>
    </form>

</div>
