<?php

namespace App\Livewire\Backend\Admin\Business;

use App\Models\Business\SocialMedia;
use Livewire\Component;

class ToggleSocialMediaStatus extends Component
{
    public $socialmedia;

    public function mount(SocialMedia $socialmedia)
    {
        $this->socialmedia = $socialmedia;
    }

    public function toggleStatus()
    {
        $this->socialmedia->is_active = !$this->socialmedia->is_active;
        $this->socialmedia->save();

        $this->dispatch('StatusUpdated', [
            'message' => 'Social Media status is updated successfully!',
            'type' => 'success',
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.business.toggle-social-media-status');
    }
}
