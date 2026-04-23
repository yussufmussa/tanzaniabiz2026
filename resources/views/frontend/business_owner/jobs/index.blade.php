@extends('frontend.business_owner.account.base')
@section('title', 'My Jobs Post')


@section('contents')
    <div class="goodup-dashboard-content">
        <div class="dashboard-widg-bar d-block">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="dashboard-list-wraps bg-white rounded mb-4">
                        <div class="dashboard-list-wraps-head br-bottom py-3 px-3">
                            <div class="dashboard-list-wraps-flx">
                                <h4 class="mb-0 ft-medium fs-md"><i class="fa fa-file-alt me-2 theme-cl fs-sm"></i>My Business
                                    Listings</h4>
                            </div>
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if (Session::has('message'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ Session::get('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                        </div>
                        <div class="dashboard-list-wraps-body py-3 px-3">
                            <div class="dashboard-listing-wraps">
                                @if ($jobs->isNotEmpty())
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="dashboard-wraper">

                                            <div class="form-group mb-3">
                                                <a href="{{ route('jobs.create') }}"
                                                    class="btn theme-bg rounded text-light">
                                                    Post New Job
                                                </a>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Title</th>
                                                            <th>Industry</th>
                                                            <th>Job Type</th>
                                                            <th>Location</th>
                                                            <th>No. Employed</th>
                                                            <th>Opening Date</th>
                                                            <th>Closing Date</th>
                                                            <th>Status </th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @forelse($jobs as $job)
                                                            <tr>
                                                                <td>{{ $jobs->firstItem() + $loop->index }}</td>
                                                                <td>{{ $job->title }}</td>
                                                                <td>{{ $job->jobSector->name }}</td>
                                                                <td>{{ $job->jobType->name }}</td>
                                                                <td>{{ $job->city->city_name }}</td>
                                                                <td>{{ $job->no_to_employed }}</td>
                                                                <td>{{ optional($job->job_opening_date)->format('d M Y') ?? '-' }}
                                                                </td>
                                                                <td>{{ optional($job->job_closing_date)->format('d M Y') ?? '-' }}
                                                                </td>
                                                                <td>
                                                                    @if ($job->job_closing_date && $job->job_closing_date->isPast())
                                                                        <span class="badge bg-danger">Closed</span>
                                                                    @else
                                                                        <span class="badge bg-success">Open</span>
                                                                    @endif
                                                                </td>

                                                                <td class="text-nowrap">
                                                                    <a href="{{ route('jobs.edit', $job->id) }}"
                                                                        class="btn btn-sm btn-outline-primary">
                                                                        Edit
                                                                    </a>

                                                                    <form action="{{ route('jobs.destroy', $job->id) }}"
                                                                        method="POST" class="d-inline"
                                                                        onsubmit="return confirm('Are you sure you want to delete this job? This action cannot be undone.');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-danger">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </td>

                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="10" class="text-center">
                                                                    No jobs posted yet.
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-between align-items-right mt-3">
                                                    @if ($jobs->hasPages())
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <ul class="pagination">

                                                                {{-- Previous Page --}}
                                                                <li
                                                                    class="page-item {{ $jobs->onFirstPage() ? 'disabled' : '' }}">
                                                                    <a class="page-link"
                                                                        href="{{ $jobs->previousPageUrl() ?? '#' }}"
                                                                        aria-label="Previous">
                                                                        <span class="fas fa-arrow-circle-left"></span>
                                                                    </a>
                                                                </li>

                                                                {{-- Pagination Elements --}}
                                                                @foreach ($jobs->links()->elements[0] ?? [] as $page => $url)
                                                                    @if ($page == $jobs->currentPage())
                                                                        <li class="page-item active">
                                                                            <span
                                                                                class="page-link">{{ $page }}</span>
                                                                        </li>
                                                                    @else
                                                                        <li class="page-item">
                                                                            <a class="page-link"
                                                                                href="{{ $url }}">{{ $page }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach

                                                                {{-- Next Page --}}
                                                                <li
                                                                    class="page-item {{ $jobs->hasMorePages() ? '' : 'disabled' }}">
                                                                    <a class="page-link"
                                                                        href="{{ $jobs->nextPageUrl() ?? '#' }}"
                                                                        aria-label="Next">
                                                                        <span class="fas fa-arrow-circle-right"></span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                @else
                                    <div class="container text-center alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span>You have no jobs posted yet!</span>
                                        <a href="{{ route('jobs.create') }}" class="btn btn-primary ms-3">
                                            <i class="fas fa-plus me-1"></i>Post your first job
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
