@extends('backend.layouts.base')
@section('title', 'Invoices')

@push('extra_style')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('contents')
@livewire('backend.admin.invoice-filter')
    
@endsection


@push('extra_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('SuccessMessage', (data) => {
                console.log(data[0].type);
                if (data[0].type === 'success') {
                    toastr.success(data[0].message);
                } else if (data[0].type === 'error') {
                    toastr.error(data[0].message);
                } else {
                    console.warn('Unexpected type:', data[0].type);
                }
            });
            Livewire.on('confirmDelete', invoiceId => {
            if (confirm('Are you sure you want to delete this invoice?')) {
                Livewire.dispatch('deleteConfirmed', invoiceId);
            }
        });
        });
</script>
@endpush
