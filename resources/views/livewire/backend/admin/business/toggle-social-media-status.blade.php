<div>
   <button wire:click="toggleStatus"
    class="btn btn-sm {{ $socialmedia->is_active ? 'btn-success' : 'btn-secondary' }}">
    {{ $socialmedia->is_active ? 'Active' : 'Inactive' }}
</button>
</div>
