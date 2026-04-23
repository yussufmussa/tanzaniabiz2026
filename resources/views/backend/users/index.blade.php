@extends('backend.layouts.base')
@section('title', 'Users')


@push('extra_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                    <div class="d-flex justify-content-between pb-1">
                        <h4 class="mb-0">Users Management</h4>
                        @canany(['create.users', 'manage.users'])
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm ">
                                <i class="fas fa-plus"></i> Add New User
                            </a>
                        @endcanany
                    </div>
                <div class="card">
                    <div class="card-body">
                        @livewire('backend.admin.user.user-list')
                    </div>
                </div>
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
    <script>
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 4000);
    </script>
@endpush
