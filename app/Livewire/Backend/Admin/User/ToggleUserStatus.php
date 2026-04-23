<?php

namespace App\Livewire\Backend\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ToggleUserStatus extends Component
{
    public $userId;
    public $Isactive;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->Isactive = User::find($this->userId)->is_active;
    }

    public function toggleStatus()
    {
        $user = User::find($this->userId);

        if ($user) {
            $user->is_active = !$this->Isactive;
            $user->save();

            $this->Isactive = $user->is_active;

            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();

            // Dispatch the event for toast notification
            $this->dispatch('StatusUpdated', [
                'message' => 'User status is updated successfully!',
                'type' => 'success',
            ]);
        } else {
            $this->dispatch('StatusUpdated', [
                'message' => 'User not found!',
                'type' => 'error',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.user.toggle-user-status');
    }
}
