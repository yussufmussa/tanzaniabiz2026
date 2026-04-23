@extends('backend.layouts.base')
@section('title', 'Packages')

@push('extra_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('contents')
    <div class="row">
        <div class="d-flex justify-content-end">
            @canany(['create.packages', 'manage.packages'])
                <a type="submit" class="btn btn-primary btn-sm mb-1 mt-0" href="{{ route('packages.create') }}">
                    <i class="bx bx-plus me-1"></i> New Package</a>
            @endcanany
        </div>
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Packages</h4>
                    <p class="card-title-desc">Manage your subscription packages and pricing plans</p>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Package Name</th>
                                    <th>Price(TZS)</th>
                                    <th>Billing Period</th>
                                    <th>Features</th>
                                    <th>Status</th>
                                    <th>Sort Order</th>
                                    <th width="12%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($packages as $package)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $package->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $package->slug }}</small>
                                            @if ($package->description)
                                                <br>
                                                <small
                                                    class="text-muted">{{ Str::limit($package->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-primary">{{ number_format($package->price, 2) }}</strong>
                                        </td>
                                        <td>
                                            <span
                                                class="badge 
                                            @if ($package->billing_period == 'monthly') bg-info
                                            @elseif($package->billing_period == 'yearly') bg-success
                                            @else bg-warning @endif">
                                                {{ ucfirst($package->billing_period) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#featuresModal{{ $package->id }}">
                                                <i class="bx bx-list-ul"></i> View
                                                ({{ $package->packageFeatures->count() }})
                                            </button>

                                            {{-- Features Modal --}}
                                            <div class="modal fade" id="featuresModal{{ $package->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $package->name }} - Features</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Feature</th>
                                                                            <th>Value</th>
                                                                            <th>Type</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($package->packageFeatures as $pf)
                                                                            <tr>
                                                                                <td>
                                                                                    <strong>{{ $pf->feature->name }}</strong>
                                                                                    <br>
                                                                                    <small
                                                                                        class="text-muted">{{ $pf->feature->description }}</small>
                                                                                </td>
                                                                                <td>
                                                                                    @if ($pf->feature->type == 'boolean')
                                                                                        @if ($pf->value == 'true')
                                                                                            <i
                                                                                                class="mdi mdi-check-circle text-success"></i>
                                                                                            Enabled
                                                                                        @else
                                                                                            <i
                                                                                                class="mdi mdi-close-circle text-danger"></i>
                                                                                            Disabled
                                                                                        @endif
                                                                                    @else
                                                                                        <strong>{{ $pf->value }}</strong>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    <span
                                                                                        class="badge bg-secondary">{{ ucfirst($pf->feature->type) }}</span>
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="3"
                                                                                    class="text-center text-muted">No
                                                                                    features configured</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($package->is_active)
                                                <span class="badge bg-success">
                                                    <i class="mdi mdi-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="mdi mdi-close-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $package->sort_order }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @can('update.packages')
                                                    <a href="{{ route('packages.edit', $package) }}"
                                                        class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                @endcan

                                                @can('delete.packages')
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete({{ $package->id }})" title="Delete">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>

                                                    <form id="delete-form-{{ $package->id }}"
                                                        action="{{ route('packages.destroy', $package) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="bx bx-package" style="font-size: 48px;"></i>
                                            <p>No packages found. Create your first package to get started.</p>
                                            @can('packages.create')
                                                <a href="{{ route('packages.create') }}" class="btn btn-primary btn-sm">
                                                    <i class="bx bx-plus me-1"></i> Create Package
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($packages->hasPages())
                        <div class="mt-3">
                            {{ $packages->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@push('extra_script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(packageId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the package and all its features!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + packageId).submit();
                }
            });
        }
    </script>
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
