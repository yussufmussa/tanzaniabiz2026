@extends('backend.layouts.base')
@section('title', 'Sub Categories')

@push('extra_style')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('contents')
    <div class="row">
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="col-12">
            <div class="d-flex justify-content-between pb-1">
                <h4 class="mb-0">Product Sub Categories</h4>
                <a href="{{ route('subcategories.create') }}" class="btn btn-primary btn-sm w-md waves-effect waves-light">
                    <i class="mdi mdi-plus-circle-outline"></i> Add New Sub Category</a>
            </div>
            <div class="card">
                <div class="card-body">

                    @livewire('backend.admin.business.sub-category-list')

                </div>
            </div>
        </div>
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
