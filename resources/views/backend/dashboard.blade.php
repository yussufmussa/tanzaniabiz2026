@extends('backend.layouts.base')
@section('title', 'Dashboard')

@section('contents')
<div class="container-fluid">

    {{-- Welcome --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary">
                <div class="card-body text-white">
                    <h4 class="mb-2 text-white">Welcome back, {{ auth()->user()->name }}!</h4>
                    <p class="mb-0 text-white-50">Here's what's happening in your system today.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Key Statistics --}}
    <div class="row">

        @can('manage.users')
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-light font-size-24">
                                <i class="mdi mdi-account-group text-primary"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-muted text-uppercase fw-semibold font-size-13">Total Users</p>
                    <h4 class="mb-1 mt-1">
                        <span class="counter-value" data-target="{{ $stats['total_users'] ?? 0 }}">0</span>
                    </h4>
                    <p class="text-muted mb-0">
                        <span class="text-success fw-semibold font-size-12 me-2">
                            <i class="ri-arrow-right-up-line me-1 align-middle"></i>{{ $stats['new_users_today'] ?? 0 }}
                        </span>
                        new today
                    </p>
                </div>
            </div>
        </div>
        @endcan

        {{-- You had products.view before, but your permission system list doesn't include products.
             If you actually use packages or listings, swap this permission accordingly.
             Here I changed it to business listings as a realistic dashboard card. --}}
        @canany(['view.business_listings','manage.business_listings'])
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-light font-size-24">
                                <i class="mdi mdi-storefront text-warning"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-muted text-uppercase fw-semibold font-size-13">Business Listings</p>
                    <h4 class="mb-1 mt-1">
                        <span class="counter-value" data-target="{{ $stats['total_business_listings'] ?? 0 }}">0</span>
                    </h4>
                    <p class="text-muted mb-0">
                        <span class="text-success fw-semibold font-size-12 me-2">
                            <i class="ri-check-line me-1 align-middle"></i>{{ $stats['approved_business_listings'] ?? 0 }}
                        </span>
                        approved
                    </p>
                </div>
            </div>
        </div>
        @endcanany

    </div>

    {{-- Quick Actions --}}
    <div class="row">
        @if(
            Gate::check('create.users') ||
            Gate::check('create.posts') ||
            Gate::check('manage.general_settings') ||
            Gate::check('manage.seo')
        )
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">

                        @can('create.users')
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-account-plus me-1"></i> Add New User
                        </a>
                        @endcan

                        @can('create.posts')
                        <a href="{{ route('posts.create') }}" class="btn btn-info btn-sm">
                            <i class="mdi mdi-pencil me-1"></i> Write Post
                        </a>
                        @endcan

                        @can('manage.general_settings')
                        <a href="{{ route('general.settings') }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-cog me-1"></i> General Settings
                        </a>
                        @endcan

                        @can('manage.seo')
                        <a href="{{ route('seo') }}" class="btn btn-dark btn-sm">
                            <i class="mdi mdi-web me-1"></i> SEO Manager
                        </a>
                        @endcan

                    </div>
                </div>
            </div>

            {{-- Login History permission name fix --}}
            @can('view.login_history')
            {{-- Recent Login Activity (optional block stays commented) --}}
            {{--
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Login Activity</h4>
                </div>
                <div class="card-body">
                    @if(isset($recent_logins) && count($recent_logins) > 0)
                        @foreach($recent_logins as $login)
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary">
                                    {{ substr($login->user->name, 0, 1) }}
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 mb-1">{{ $login->user->name }}</h5>
                                <p class="text-muted font-size-13 mb-0">{{ $login->created_at->diffForHumans() }}</p>
                                <p class="text-muted font-size-12 mb-0">{{ $login->ip_address }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center mb-0">No recent activity</p>
                    @endif
                </div>
            </div>
            --}}
            @endcan
        </div>
        @endif
    </div>

    {{-- Fallback --}}
    @if(
        !Gate::check('view.users') &&
        !Gate::check('manage.users') &&
        !Gate::check('view.posts') &&
        !Gate::check('manage.posts') &&
        !Gate::check('view.business_listings') &&
        !Gate::check('manage.business_listings') &&
        !Gate::check('manage.general_settings') &&
        !Gate::check('manage.seo')
    )
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-4">
                        <span class="avatar-title rounded-circle bg-light font-size-24">
                            <i class="mdi mdi-information text-info"></i>
                        </span>
                    </div>
                    <h4>Welcome to the Dashboard</h4>
                    <p class="text-muted">Your dashboard content will appear here based on your role and permissions.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Refresh Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Counter animation
    const counters = document.querySelectorAll('.counter-value');
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        const increment = target / 200;

        const updateCounter = () => {
            const current = +counter.innerText;
            if (current < target) {
                counter.innerText = Math.ceil(current + increment);
                setTimeout(updateCounter, 20);
            } else {
                counter.innerText = target;
            }
        };

        updateCounter();
    });
});
</script>
@endpush
@endsection