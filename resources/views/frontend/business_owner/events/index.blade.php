@extends('frontend.business_owner.account.base')
@section('title', 'My Events')


@section('contents')
    <div class="goodup-dashboard-content">
        <div class="dashboard-widg-bar d-block">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="dashboard-list-wraps bg-white rounded mb-4">
                        <div class="dashboard-list-wraps-head br-bottom py-3 px-3">
                            <div class="dashboard-list-wraps-flx">
                                <h4 class="mb-0 ft-medium fs-md"><i class="fa fa-file-alt me-2 theme-cl fs-sm"></i>My Events List</h4>
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
                                @if ($events->isNotEmpty())
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="dashboard-wraper">

                                            <div class="form-group mb-3">
                                                <a href="{{ route('events.create') }}"
                                                    class="btn theme-bg rounded text-light">
                                                    Add New Event
                                                </a>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Banner</th>
                                                            <th>Title</th>
                                                            <th>Location</th>
                                                            <th>Starting Date</th>
                                                            <th>Time</th>
                                                            <th>Closing Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @forelse($events as $event)
                                                            <tr>
                                                                <td>{{ $events->firstItem() + $loop->index }}</td>
                                                                <td>
                                                                    <img src="{{asset('uploads/businessEvents/thumbnails/' . $event->thumbnail)}}" width="100" height="50" class="avatar" alt="thumbnail">
                                                                </td>
                                                                <td>{{ $event->title }}</td>
                                                                <td>{{ $event->event_loction }}</td>
                                                                <td>{{ $event->starting_date->format('d/m/Y') }}
                                                                </td>
                                                                <td>
                                                                    {{$event->starting_time->format('H:i')}}
                                                                    to
                                                                    {{ $event->ending_time->format('H:i')}}
                                                                </td>
                                                                <td>{{ $event->closing_date->format('d M Y')}}
                                                                </td>
                                                                <td>
                                                                    @if ($event->closing_date && $event->closing_date->isPast())
                                                                        <span class="badge bg-danger">Ended</span>
                                                                    @else
                                                                        <span class="badge bg-success">Open</span>
                                                                    @endif
                                                                </td>

                                                                <td class="text-nowrap">
                                                                    <a href="{{ route('events.edit', $event->id) }}"
                                                                        class="btn btn-sm btn-outline-primary">
                                                                        Edit
                                                                    </a>

                                                                    <form
                                                                        action="{{ route('events.destroy', $event->id) }}"
                                                                        method="POST" class="d-inline"
                                                                        onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
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
                                                                <td colspan="8" class="text-center">
                                                                    No events posted yet.
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>

                                                <div class="d-flex justify-content-between align-items-right mt-3">
                                                    @if ($events->hasPages())
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <ul class="pagination">

                                                                {{-- Previous Page --}}
                                                                <li
                                                                    class="page-item {{ $events->onFirstPage() ? 'disabled' : '' }}">
                                                                    <a class="page-link"
                                                                        href="{{ $events->previousPageUrl() ?? '#' }}"
                                                                        aria-label="Previous">
                                                                        <span class="fas fa-arrow-circle-left"></span>
                                                                    </a>
                                                                </li>

                                                                {{-- Pagination Elements --}}
                                                                @foreach ($events->links()->elements[0] ?? [] as $page => $url)
                                                                    @if ($page == $events->currentPage())
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
                                                                    class="page-item {{ $events->hasMorePages() ? '' : 'disabled' }}">
                                                                    <a class="page-link"
                                                                        href="{{ $events->nextPageUrl() ?? '#' }}"
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
                                        <span>You have no events posted yet!</span>
                                        <a href="{{ route('events.create') }}" class="btn btn-primary ms-3">
                                            <i class="fas fa-plus me-1"></i>Post your first event
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
