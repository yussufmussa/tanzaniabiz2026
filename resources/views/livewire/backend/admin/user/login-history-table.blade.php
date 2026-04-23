<div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Login History</h4>

                <!-- Filters and Search Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Search Box -->
                                    <div class="col-md-4">
                                        <label class="form-label">Search</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" wire:model.live.debounce.300ms="search"
                                                class="form-control" placeholder="Email, Name, or IP Address">
                                            @if ($search)
                                                <button class="btn btn-outline-secondary" type="button"
                                                    wire:click="$set('search', '')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Date Range -->
                                    <div class="col-md-3">
                                        <label class="form-label">From Date</label>
                                        <input type="date" wire:model.live="date_from" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">To Date</label>
                                        <input type="date" wire:model.live="date_to" class="form-control">
                                    </div>

                                    <!-- Device Type -->
                                    <div class="col-md-2">
                                        <label class="form-label">Device Type</label>
                                        <select class="form-select" wire:model.live="device_type">
                                            <option value="">All Devices</option>
                                            <option value="mobile">Mobile</option>
                                            <option value="desktop">Desktop</option>
                                            <option value="tablet">Tablet</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <!-- Quick Filters -->
                                    <div class="col-md-6">
                                        <label class="form-label">Quick Filters</label>
                                        <div class="btn-group" role="group">
                                            <button wire:click="setQuickFilter(0)" type="button"
                                                class="btn btn-outline-primary btn-sm">Today</button>
                                            <button wire:click="setQuickFilter(7)" type="button"
                                                class="btn btn-outline-primary btn-sm">Last 7 Days</button>
                                            <button wire:click="setQuickFilter(30)" type="button"
                                                class="btn btn-outline-primary btn-sm">Last 30 Days</button>
                                            <button wire:click="setQuickFilter(90)" type="button"
                                                class="btn btn-outline-primary btn-sm">Last 90 Days</button>
                                        </div>
                                    </div>

                                    <!-- Filter Actions -->
                                    <div class="col-md-6 text-end">
                                        <button wire:click="resetFilters" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-times"></i> Clear Filters
                                        </button>
                                        <button wire:click="exportExcel" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-download" wire:loding.remove wire:target="exportExcel"></i>
                                            Export Excel
                                            <i class="fas fa-spinner fa-spin" wire:loading
                                                wire:target="exportExcel"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            wire:click="exportPdf" wire:loading.attr="disabled">
                                            <i class="fas fa-file-pdf" wire:loading.remove wire:target="exportPdf"></i>
                                            <i class="fas fa-spinner fa-spin" wire:loading wire:target="exportPdf"></i>
                                            Export PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Summary -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle"></i>
                            Showing {{ $logins->firstItem() ?? 0 }} to {{ $logins->lastItem() ?? 0 }}
                            of {{ $logins->total() }} results
                            @if ($search || $date_from || $date_to || $device_type)
                                <span class="badge bg-info">Filtered</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="btn-group btn-group-sm" role="group">
                            @foreach ([10, 15, 25, 50] as $size)
                                <input type="radio" class="btn-check" wire:model="per_page"
                                    id="per_page_{{ $size }}" value="{{ $size }}">
                                <label class="btn btn-outline-secondary"
                                    for="per_page_{{ $size }}">{{ $size }}</label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Table & Pagination -->
                @if ($logins->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>
                                        <a href="#" wire:click.prevent="sortBy('email')">
                                            Email
                                            @if ($sort === 'email')
                                                <i class="fas fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" wire:click.prevent="sortBy('name')">
                                            Name
                                            @if ($sort === 'name')
                                                <i class="fas fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" wire:click.prevent="sortBy('login_time')">
                                            Last Login
                                            @if ($sort === 'login_time')
                                                <i class="fas fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="#" wire:click.prevent="sortBy('ip_address')">
                                            IP Address
                                            @if ($sort === 'ip_address')
                                                <i class="fas fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="fas fa-sort text-muted"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Device/Browser</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logins as $login)
                                    <tr>
                                        <td>{{ $loop->iteration + ($logins->currentPage() - 1) * $logins->perPage() }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <span class="avatar-title bg-primary rounded-circle">
                                                        {{ strtoupper(substr($login->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                {{ $login->user->email }}
                                            </div>
                                        </td>
                                        <td>{{ $login->user->name }}</td>
                                        <td>
                                            <div>{{ $login->login_time->format('M d, Y') }}</div>
                                            <small
                                                class="text-muted">{{ $login->login_time->format('h:i A') }}</small>
                                            <br><small
                                                class="badge bg-light text-dark">{{ $login->login_time->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <span class="font-monospace">{{ $login->ip_address }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $userAgent = $login->user_agent;
                                                $deviceType = 'desktop';
                                                $deviceIcon = 'fas fa-desktop';

                                                if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
                                                    if (preg_match('/iPad/', $userAgent)) {
                                                        $deviceType = 'tablet';
                                                        $deviceIcon = 'fas fa-tablet-alt';
                                                    } else {
                                                        $deviceType = 'mobile';
                                                        $deviceIcon = 'fas fa-mobile-alt';
                                                    }
                                                }

                                                $browser = 'Unknown';
                                                if (preg_match('/Chrome/', $userAgent)) {
                                                    $browser = 'Chrome';
                                                } elseif (preg_match('/Firefox/', $userAgent)) {
                                                    $browser = 'Firefox';
                                                } elseif (preg_match('/Safari/', $userAgent)) {
                                                    $browser = 'Safari';
                                                } elseif (preg_match('/Edge/', $userAgent)) {
                                                    $browser = 'Edge';
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <i class="{{ $deviceIcon }} text-primary me-2"></i>
                                                <div>
                                                    <div class="fw-bold">{{ ucfirst($deviceType) }}</div>
                                                    <small class="text-muted">{{ $browser }}</small>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($logins->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $logins->previousPageUrl() }}">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($logins->getUrlRange(1, $logins->lastPage()) as $page => $url)
                                        <li class="page-item {{ $logins->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($logins->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $logins->nextPageUrl() }}">
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
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">
                            {{ $search || $date_from || $date_to || $device_type ? 'No login records found matching your criteria' : 'No Login History Yet' }}
                        </h5>
                        @if ($search || $date_from || $date_to || $device_type)
                            <button wire:click="resetFilters" class="btn btn-outline-primary">
                                <i class="fas fa-times"></i> Clear Filters
                            </button>
                        @endif
                    </div>
                @endif
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
