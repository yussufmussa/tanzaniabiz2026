<?php

namespace App\Livewire\Backend\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateProfileInformation extends Component
{
    public $name;
    public $user;
    public $current_password;
    public $success = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
    }

    public function rules()
    {
        $rules =  [
            'name' => 'required|string|max:255',
        ];


        return $rules;
    }

    public function updateProfile()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
        ]);

        $this->user = $this->user->fresh();
         $this->current_password = ''; 
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.backend.profile.update-profile-information', [
            'user' => $this->user,
        ]);
    }
}
