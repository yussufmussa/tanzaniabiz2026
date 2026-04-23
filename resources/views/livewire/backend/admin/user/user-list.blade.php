<div>
    {{-- Search and Filters Section --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search user...">
        </div>
        <div class="col-md-2">
            <select wire:model.live="statusFilter" class="form-select">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model.live="businessListing" class="form-select">
                <option value="all">All</option>
                <option value="with_business_listings">With Business Listings</option>
                <option value="without_business_listings">Without Business Listings</option>
            </select>
        </div>
         <div class="col-md-3">
            <button wire:click="resetFilters" class="btn btn-secondary btn-sm me-2">
                <i class="mdi mdi-refresh"></i> Reset
            </button>
            <a href="{{ route('users.export', ['format' => 'excel', 'search' => $search, 'statusFilter' => $statusFilter, 'businessListing' => $businessListing]) }}"
                class="btn btn-success btn-sm me-1">
                <i class="mdi mdi-file-excel"></i> Excel
            </a>
            <a href="{{ route('users.export', ['format' => 'pdf', 'search' => $search, 'statusFilter' => $statusFilter, 'businessListing' => $businessListing]) }}"
                class="btn btn-danger btn-sm">
                <i class="mdi mdi-file-pdf"></i> PDF
            </a>
        </div>
    </div>
    {{-- end filtering --}}
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Profile Picture</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Email Verified?</th>
                        <th>Is Active?</th>
                        <th>Created At</th>
                        <th># listings</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        @php
                            $totalPermissionsCount = $user->getAllPermissions()->count();

                            $groupedPermissions = $user
                                ->getAllPermissions()
                                ->groupBy(function ($permission) {
                                    $parts = explode('.', $permission->name, 2);
                                    return $parts[1] ?? 'other';
                                })
                                ->sortKeys();
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <img src="{{ asset('uploads/profilePictures/' . $user->profile_picture) }}"
                                    alt="{{ $user->name }}" class="avatar">
                            </td>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <td>
                                <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                </span>
                            </td>
                            <td>
                                <button wire:click="toggleStatus({{ $user->id }})"
                                    class="btn btn-sm {{ $user->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $user->is_active ? 'Active' : 'Suspended' }}
                                </button>
                            </td>

                            <td>{{ $user->created_at->format('d/m/Y H:m:i') }}</td>
                            <td>{{ $user->businessListings->count() }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="modal"
                                    data-bs-target="#userPermissionsModal-{{ $user->id }}">
                                    View Permissions
                                </button>

                                <div class="modal fade" id="userPermissionsModal-{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="userPermissionsModalLabel-{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="userPermissionsModalLabel-{{ $user->id }}">
                                                    Permissions: {{ $user->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                @if ($totalPermissionsCount > 0)
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
                                                                            explode('.', $permission->name, 2)[0] ??
                                                                            $permission->name;
                                                                    @endphp
                                                                    <span class="badge bg-secondary me-1 mb-1">
                                                                        {{ $action }}
                                                                    </span>
                                                                @endforeach
                                                            </div>

                                                            <div class="mt-2">
                                                                @foreach ($permissions->sortBy('name') as $permission)
                                                                    <span class="badge bg-light text-dark me-1 mb-1">{{ $permission->name }}</span>
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
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @canany(['view.users', 'manage.users'])
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcanany

                                @canany(['manage.users', 'update.users'])
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcanany

                                @canany(['delete.users', 'manage.users'])
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="bx bx-trash"></i>
                                    </button>

                                    <div id="deleteModal{{ $user->id }}" class="modal fade" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
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
                                @endcanany
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination mb-0">
                        {{-- Previous Page Link --}}
                        @if ($users->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    &laquo; {{-- Left arrow --}}
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}">
                                    &laquo; {{-- Left arrow --}}
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($users->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}">
                                    &raquo; {{-- Right arrow --}}
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    &raquo; {{-- Right arrow --}}
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</div>
