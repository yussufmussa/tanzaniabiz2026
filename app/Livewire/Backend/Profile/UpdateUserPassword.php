<?php

namespace App\Livewire\Backend\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUserPassword extends Component
{
   public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $success = false;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
        'new_password_confirmation' => 'required',
    ];

    protected $messages = [
        'current_password.required' => 'Current password is required.',
        'new_password.required' => 'New password is required.',
        'new_password.min' => 'New password must be at least 8 characters.',
        'new_password.confirmed' => 'New password confirmation does not match.',
        'new_password_confirmation.required' => 'Please confirm your new password.',
    ];

    public function updatePassword()
    {
        $this->validate();

        // Check if current password is correct
        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        // Update password
        Auth::user()->update([
            'password' => Hash::make($this->new_password)
        ]);

        // Reset form
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->success = true;

        // Hide success message after 3 seconds
        $this->dispatch('hide-alert', ['delay' => 3000]);
    }

    public function render()
    {
        return view('livewire.backend.profile.update-user-password', [
            'user' => Auth::user(),
        ]);
    }
}
