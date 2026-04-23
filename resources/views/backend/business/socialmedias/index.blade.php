@extends('backend.layouts.base')
@section('title', 'Social Media')

@push('extra_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('contents')
    <div class="row">
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <i class="fas fa-check-circle mr-2"></i>
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="col-12">
            <div class="d-flex justify-content-between pb-1">
                <h4 class="mb-0">Social Medias</h4>
                @canany(['create.social_medias', 'manage.social_medias'])
                    <a href="{{ route('socialmedias.create') }}" class="btn btn-primary btn-sm w-md waves-effect waves-light">
                        <i class="mdi mdi-plus-circle-outline"></i> Add Social Media</a>
                @endcanany
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="typeDT" class="table table-bordered  dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Is Active?</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($socialmedias) > 0)
                                        @foreach ($socialmedias as $key => $socialmedia)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $socialmedia->name }}</td>
                                                <td>
                                                    <livewire:backend.admin.business.toggle-social-media-status :socialmedia="$socialmedia"
                                                        :key="'social-'.$socialmedia->id" />
                                                </td>
                                                <td>
                                                    @canany(['update.social_medias', 'manage.social_medias'])
                                                        <a href="{{ route('socialmedias.edit', $socialmedia->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                    @endcanany
                                                    @canany(['delete.social_medias', 'manage.social_medias'])
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $socialmedia->id }}"><i
                                                                class="fas fa-trash"></i>
                                                        </button>
                                                        <div id="deleteModal{{ $socialmedia->id }}" class="modal fade"
                                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form
                                                                    action="{{ route('socialmedias.destroy', $socialmedia->id) }}"
                                                                    method="post">@csrf
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="myModalLabel">Deletion
                                                                                Warning!</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>

                                                                        @method('DELETE')
                                                                        <div class="modal-body">
                                                                            <h4>Are you sure??</h4>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary waves-effect"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-danger waves-effect waves-light">Yes,
                                                                                Delete</button>
                                                                        </div>
                                                                </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        @endcanany


                        </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center"><span class="text-danger">Add Social Media</span>
                                <a href="{{ route('socialmedias.create') }}">here</a>
                            </td>
                        </tr>
                        @endif
                        </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($socialmedias->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $socialmedias->previousPageUrl() }}">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($socialmedias->getUrlRange(1, $socialmedias->lastPage()) as $page => $url)
                                        <li class="page-item {{ $socialmedias->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($socialmedias->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $socialmedias->nextPageUrl() }}">
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
@endpush
