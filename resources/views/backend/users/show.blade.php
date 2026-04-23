@extends('backend.layouts.base')
@section('title', 'View User')

@section('contents')
    <div class="row">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h4 class="card-title mb-0">User Details</h4>
            <div class="d-flex gap-2">
                @canany(['update.users', 'manage.users'])
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm waves-effect waves-light">
                    <i class="mdi mdi-pencil me-1"></i> Edit User
                </a>
                @endcanany
                @canany(['view.users', 'manage.users'])
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm waves-effect waves-light">
                    <i class="mdi mdi-arrow-left me-1"></i> Back to List
                </a>
                @endcanany
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Profile Picture Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">Profile Picture</label>
                            <div class="mt-2">
                                <img src="{{ asset('uploads/profilePictures/' . $user->profile_picture) }}"
                                    alt="Profile Picture" class="img-thumbnail"
                                    style="max-width: 200px; max-height: 200px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4">

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#basic-info" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                                <span class="d-none d-sm-block"><i class="mdi mdi-account me-1"></i> Basic
                                    Information</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#login-history" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-history"></i></span>
                                <span class="d-none d-sm-block"><i class="mdi mdi-history me-1"></i> Login History</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#orders" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-shopping-cart"></i></span>
                                <span class="d-none d-sm-block"><i class="mdi mdi-cart me-1"></i> Orders</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content p-3 text-muted">
                        <!-- Basic Information Tab -->
                        <div class="tab-pane active" id="basic-info" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Full Name</label>
                                        <p class="form-control-static">{{ $user->name }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email Address</label>
                                        <p class="form-control-static">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Role</label>
                                        <p class="form-control-static">
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-primary">{{ ucfirst($role->name) }}</span>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Mobile Phone</label>
                                        <p class="form-control-static">{{ $user->mobile_phone ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <p class="form-control-static">
                                            @if ($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email Verified</label>
                                        <p class="form-control-static">
                                            @if ($user->email_verified_at)
                                                <span class="badge bg-success">
                                                    <i class="mdi mdi-check-circle me-1"></i> Verified
                                                </span>
                                                <small class="text-muted d-block mt-1">
                                                    {{ $user->email_verified_at->format('M d, Y h:i A') }}
                                                </small>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="mdi mdi-alert-circle me-1"></i> Not Verified
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <p class="form-control-static text-muted">
                                            {{ $user->created_at->format('M d, Y h:i A') }}
                                            <small>({{ $user->created_at->diffForHumans() }})</small>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <p class="form-control-static text-muted">
                                            {{ $user->updated_at->format('M d, Y h:i A') }}
                                            <small>({{ $user->updated_at->diffForHumans() }})</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Login History Tab -->
                        <div class="tab-pane" id="login-history" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Recent Login Activity</h5>
                                <a href="{{ route('login.history', ['user_id' => $user->id]) }}"
                                    class="btn btn-sm btn-primary">
                                    View All History
                                </a>
                            </div>

                            @if ($user->loginHistories->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Login Time</th>
                                                <th>IP Address</th>
                                                <th>Device/Browser</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->loginHistories->take(10) as $index => $history)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        {{ $history->login_time->format('M d, Y h:i A') }}
                                                        <small
                                                            class="text-muted d-block">{{ $history->login_time->diffForHumans() }}</small>
                                                    </td>
                                                    <td>
                                                        <code>{{ $history->ip_address ?? 'N/A' }}</code>
                                                    </td>
                                                    <td>
                                                        <small>{{ $history->user_agent ? Str::limit($history->user_agent, 50) : 'N/A' }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if ($user->loginHistories->count() > 10)
                                    <div class="text-center mt-3">
                                        <p class="text-muted">Showing 10 of {{ $user->loginHistories->count() }} login
                                            records</p>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information me-2"></i> No login history available for this user.
                                </div>
                            @endif
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane" id="orders" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Order History</h5>
                                {{-- <a href="{{ route('orders.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-primary">
                            View All Orders
                        </a> --}}
                            </div>
                            @if (false)
                                {{-- Change to @if ($user->orders->count() > 0) when orders relationship exists --}}
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Order rows will go here --}}
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="mdi mdi-information me-2"></i> No orders found for this user.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
