@extends('backend.layouts.base')
@section('title', 'Listings')

@push('extra_style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('contents')
<div class="row">
    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible ">
        {{ Session::get('message') }}
    </div>
    @endif
    @livewire('backend.admin.business.business-listing-list')
    
</div>

@endsection

@push('extra_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('StatusUpdated', (data) => {
                console.log(data[0].type);
                if (data[0].type === 'success') {
                    toastr.success(data[0].message);
                } else if (data[0].type === 'error') {
                    toastr.error(data[0].message);
                } else {
                    console.warn('Unexpected type:', data[0].type);
                }
            });
        });
    </script>
@endpush