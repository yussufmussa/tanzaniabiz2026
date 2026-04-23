@extends('backend.layouts.base')
@section('title', 'Roles')


@section('contents')
    <div class="row">
        <div class="col-12">
            @canany(['create.roles', 'manage.roles'])
                <div class="d-flex justify-content-between pb-3">
                    <h4 class="mb-0">Role Managment</h4>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm w-md waves-effect waves-light">
                        <i class="fas fa-plus"></i> Add New Role</a>
                </div>
            @endcanany

            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                {{-- <span aria-hidden="true">&times;</span> --}}
                            </button>
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Permissions Count</th>
                                    <th>Users Count</th>
                                    <th>Permissions</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            <span class="badge bg-{{ $role->name === 'admin' ? 'danger' : 'info' }}">
                                                {{ $role->name }}
                                            </span>
                                        </td>

                                        <td>{{ $role->permissions->count() }}</td>
                                        <td>{{ $role->users->count() }}</td>

                                        <td>
                                            <button class="btn btn-sm btn-outline-info" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#permissionsModal-{{ $role->id }}">
                                                View Permissions
                                            </button>

                                            {{-- Permissions Modal --}}
                                            <div class="modal fade" id="permissionsModal-{{ $role->id }}" tabindex="-1"
                                                aria-labelledby="permissionsModalLabel-{{ $role->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="permissionsModalLabel-{{ $role->id }}">
                                                                Permissions: {{ $role->name }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            @if ($role->permissions->count() > 0)
                                                                @php
                                                                    $groupedPermissions = $role->permissions->groupBy(
                                                                        function ($permission) {
                                                                            $parts = explode('.', $permission->name, 2);
                                                                            return $parts[1] ?? 'other';
                                                                        },
                                                                    );

                                                                    $groupedPermissions = $groupedPermissions->sortKeys();
                                                                @endphp

                                                                @foreach ($groupedPermissions as $group => $permissions)
                                                                    <div class="mb-3">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-between">
                                                                            <strong>{{ ucfirst(str_replace('_', ' ', $group)) }}</strong>
                                                                            <span
                                                                                class="badge bg-light text-dark">{{ $permissions->count() }}</span>
                                                                        </div>

                                                                        <div class="mt-2">
                                                                            @foreach ($permissions->sortBy('name') as $permission)
                                                                                @php
                                                                                    $action =
                                                                                        explode(
                                                                                            '.',
                                                                                            $permission->name,
                                                                                            2,
                                                                                        )[0] ?? $permission->name;
                                                                                @endphp

                                                                                <span class="badge bg-secondary me-1 mb-1">
                                                                                    {{ $action }}
                                                                                </span>
                                                                            @endforeach
                                                                        </div>


                                                                        <div class="mt-2">
                                                                            @foreach ($permissions->sortBy('name') as $permission)
                                                                                <span
                                                                                    class="badge bg-light text-dark me-1 mb-1">{{ $permission->name }}</span>
                                                                            @endforeach
                                                                        </div>

                                                                    </div>
                                                                    <hr>
                                                                @endforeach
                                                            @else
                                                                <span class="text-muted">No permissions assigned</span>
                                                            @endif
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td> --}}
                                
                                {{-- @canany(['manage.roles', 'update.roles'])
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcanany --}}

                                {{-- @canany(['delete.roles', 'manage.roles'])
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $role->id }}">
                                        <i class="bx bx-trash"></i>
                                    </button>

                                    <div id="deleteModal{{ $role->id }}" class="modal fade" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Deletion
                                                            Warning!</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <h4>Are you sure?</h4>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary waves-effect"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit"
                                                            class="btn btn-danger waves-effect waves-light">
                                                            Yes, Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endcanany --}}
                            {{-- </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('extra_script')
    <script>
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endpush
