<?php

namespace App\Livewire\Backend\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UpdateProfilePicture extends Component
{ 
    
    use WithFileUploads;

    public $photo;
    public $user;
    public $success = false;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function updatedPhoto()
    {
        $this->validate([
             'photo' => 'required|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    }

    public function updateProfilePicture()
    {
        $this->validate([
            'photo' => 'required|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

       if ($this->photo) {
            if (Auth::user()->profile_picture !== 'user.png') {
                $path = public_path() . '/uploads/profilePictures/' .Auth::user()->profile_picture;
                File::delete($path);
            }

            $fileName = Str::uuid() . '.' . $this->photo->extension();

            $this->photo->storeAs('uploads/profilePictures/', $fileName, 'public_real');

            $user = Auth::user();
            $user->profile_picture = $fileName;
            $user->save();


            $this->photo = null;
            $this->user = $this->user->fresh();
            $this->success = true;

    }
}

    public function render()
    {
        return view('livewire.backend.profile.update-profile-picture',
            [
                'user' => $this->user,
                'currentPhoto' => '/uploads/profilePictures/'.Auth::user()->profile_picture,
            ]
        );
    }
}
