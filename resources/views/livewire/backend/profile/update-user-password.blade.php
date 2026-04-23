<div>
   <div>
    <form wire:submit.prevent="updatePassword">
        @csrf
        
        {{-- Current Password --}}
        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input wire:model="current_password" 
                   id="current_password"
                   class="form-control @error('current_password') is-invalid @enderror" 
                   type="password"
                   placeholder="Enter your current password">
            @error('current_password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- New Password --}}
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input wire:model="new_password" 
                   id="new_password"
                   class="form-control @error('new_password') is-invalid @enderror" 
                   type="password"
                   placeholder="Enter your new password">
            @error('new_password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <div class="form-text">Password must be at least 8 characters long.</div>
        </div>

        {{-- Confirm New Password --}}
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
            <input wire:model="new_password_confirmation" 
                   id="new_password_confirmation"
                   class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                   type="password"
                   placeholder="Confirm your new password">
            @error('new_password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Success Message --}}
        @if($success)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
               Password Updateed successful
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Save Button --}}
        <button type="submit" 
                wire:loading.attr="disabled"
                class="btn btn-primary waves-effect waves-light">
            <span wire:loading.remove wire:target="updatePassword"><i class="mdi mdi-content-save me-1"></i>Update Password</span>
            <span wire:loading wire:target="updatePassword">
                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                Updating...
            </span>
        </button>
    </form>
</div>