<?php

namespace App\Livewire\Backend\Admin\Post;

use App\Models\Post\PostCategory;
use Livewire\Component;

class TogglePostCategoryStatus extends Component
{
    public $postCategoryId;
    public $Isactive;

    public function mount($postCategoryId)
    {
        $this->postCategoryId = $postCategoryId;
        $this->Isactive = PostCategory::find($this->postCategoryId)->is_active;
    }

    public function toggleStatus()
    {
        $category = PostCategory::find($this->postCategoryId);

        if ($category) {
            $category->is_active = !$this->Isactive;
            $category->save();

            $this->Isactive = $category->is_active;

            // Dispatch the event for toast notification
            $this->dispatch('StatusUpdated', [
                'message' => 'Post Category status is updated successfully!',
                'type' => 'success',
            ]);
        } else {
            $this->dispatch('StatusUpdated', [
                'message' => 'Post Category not found!',
                'type' => 'error',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.post.toggle-post-category-status');
    }
}
