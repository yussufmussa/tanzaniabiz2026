@extends('backend.layouts.base')
@section('title', 'Blos Posts')

@section('contents')
    <div class="col-12">
           <div class="d-flex justify-content-end pb-1">
                <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm w-md waves-effect waves-light">
                    <i class="mdi mdi-plus-circle-outline"></i>New Blog Post</a>
            </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">All Blog Posts</h4>
                <div class="row">
                    <div class="col-lg-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <!-- Bulk Delete Form -->
                        <form id="bulkDeleteForm" action="{{ route('posts.bulk-delete') }}" method="POST"
                            style="display: none;">
                            @csrf
                            <div id="selectedPostContainer"></div>
                        </form>

                        <!-- Bulk Actions Section -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn"
                                    style="display: none;" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                                    <i class="fas fa-trash"></i> Delete Selected (<span id="selectedCount">0</span>)
                                </button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary btn-sm" id="selectAllBtn">
                                    <i class="fas fa-check-square"></i> Select All
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" id="deselectAllBtn"
                                    style="display: none;">
                                    <i class="fas fa-square"></i> Deselect All
                                </button>
                            </div>
                        </div>
                        @if ($posts->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th width="50">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th>Thumbnail</th>
                                            <th>Title</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($posts as $post)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    <input type="checkbox" name="post_checkbox"
                                                        value="{{ $post->id }}"
                                                        class="form-check-input post-checkbox">
                                                </td>
                                                <td>
                                                    <img src="{{ asset('uploads/posts/thumbnails/' . $post->thumbnail) }}"
                                                        alt="{{ $post->title }}" class="img-thumbnail"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                </td>
                                                <td>
                                                    {{ $post->title }}
                                                </td>
                                                <td>{{ $post->user->name }}</td>
                                                <td>
                                                    @canany(['publish.posts', 'manage.posts'])
                                                        <button type="button"
                                                            class="btn btn-sm {{ $post->is_published ? 'btn-success' : 'btn-secondary' }} toggle-status"
                                                            data-id="{{ $post->id }}"
                                                            data-status="{{ $post->is_published }}">
                                                            {{ $post->is_published ? 'Published' : 'Draft' }}
                                                        </button>
                                                    @else
                                                        <span
                                                            class="badge {{ $post->is_published ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $post->is_published ? 'Published' : 'Draft' }}
                                                        </span>
                                                    @endcanany
                                                </td>
                                                <td>{{ $post->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @canany(['update.posts', 'manage.posts'])
                                                            <a href="{{ route('posts.edit', $post) }}"
                                                                class="btn btn-sm btn-primary" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcanany
                                                        @canany(['delete.posts', 'manage.posts'])
                                                            <button type="button" class="btn btn-sm btn-danger delete-post"
                                                                data-id="{{ $post->id }}" data-name="{{ $post->title }}"
                                                                title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endcanany
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
                                            @if ($posts->onFirstPage())
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                        &laquo; {{-- Left arrow --}}
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $posts->previousPageUrl() }}">
                                                        &laquo; {{-- Left arrow --}}
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                                <li class="page-item {{ $posts->currentPage() == $page ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($posts->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $posts->nextPageUrl() }}">
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

                            {{-- <div class="d-flex justify-content-center">
                                        {{ $posts->links() }}
                                    </div> --}}
                        @else
                            @canany(['posts.create', 'posts.manage'])
                                <div class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Posts found</h5>
                                    <p class="text-muted">Start by creating your first post.</p>
                                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Create Post
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Posts found</h5>
                                </div>
                            @endcanany
                        @endif
                    </div>
                </div>
            </div>


             <!-- Bulk Delete Confirmation Modal -->
                <div id="bulkDeleteModal" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="bulkDeleteLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bulkDeleteLabel">Bulk Deletion Warning!</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4>Are you sure you want to delete <span id="deleteCountText">0</span> selected galleries?
                                </h4>
                                <p class="text-muted">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                    id="confirmBulkDelete">
                                    Yes, Delete All Selected
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete "<span id="product-name"></span>"?</p>
                            <p class="text-danger small">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form id="delete-form" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('extra_script')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const postCheckboxes = document.querySelectorAll('.post-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const deleteCountText = document.getElementById('deleteCountText');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDelete');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            const selectedGalleriesInput = document.getElementById('selectedGalleries');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const deselectAllBtn = document.getElementById('deselectAllBtn');

            // Update UI based on selected checkboxes
            function updateUI() {
                const selectedCheckboxes = document.querySelectorAll('.post-checkbox:checked');
                const selectedCount = selectedCheckboxes.length;

                selectedCountSpan.textContent = selectedCount;
                deleteCountText.textContent = selectedCount;

                if (selectedCount > 0) {
                    bulkDeleteBtn.style.display = 'inline-block';
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }

                // Update select all checkbox state
                if (selectedCount === postCheckboxes.length) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else if (selectedCount > 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                }
            }

            // Select/Deselect all functionality
            selectAllCheckbox.addEventListener('change', function() {
                postCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateUI();
                toggleSelectButtons();
            });

            // Individual checkbox change
            postCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateUI();
                    toggleSelectButtons();
                });
            });

            // Select All button
            selectAllBtn.addEventListener('click', function() {
                postCheckboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                selectAllCheckbox.checked = true;
                updateUI();
                toggleSelectButtons();
            });

            // Deselect All button
            deselectAllBtn.addEventListener('click', function() {
                postCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
                updateUI();
                toggleSelectButtons();
            });

            // Toggle select/deselect buttons
            function toggleSelectButtons() {
                const selectedCount = document.querySelectorAll('.post-checkbox:checked').length;
                if (selectedCount === postCheckboxes.length && selectedCount > 0) {
                    selectAllBtn.style.display = 'none';
                    deselectAllBtn.style.display = 'inline-block';
                } else {
                    selectAllBtn.style.display = 'inline-block';
                    deselectAllBtn.style.display = 'none';
                }
            }

            // Confirm bulk delete
            confirmBulkDeleteBtn.addEventListener('click', function() {
                const selectedCheckboxes = document.querySelectorAll('.post-checkbox:checked');
                const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);

                if (selectedIds.length > 0) {
                    const container = document.getElementById('selectedPostContainer');
                    container.innerHTML = '';

                    selectedIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_posts[]'; // Laravel expects an array like this
                        input.value = id;
                        container.appendChild(input);
                    });
                    bulkDeleteForm.submit();
                }
            });

            // Initial UI update
            updateUI();
            toggleSelectButtons();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Handle status toggle
            document.querySelectorAll('.toggle-status').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.dataset.id;
                    const currentStatus = this.dataset.status === '1';

                    fetch(`/posts/${postId}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.textContent = data.status ? 'Published' : 'Draft';
                                this.className =
                                    `btn btn-sm ${data.status ? 'btn-success' : 'btn-secondary'} toggle-status`;
                                this.dataset.status = data.status ? '1' : '0';

                                // Show success message
                                showAlert('success', data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('danger', 'Failed to update popular status');
                        });
                });
            });

            // Handle delete
            document.querySelectorAll('.delete-post').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.dataset.id;
                    const productName = this.dataset.name;

                    document.getElementById('product-name').textContent = productName;
                    document.getElementById('delete-form').action = `/posts/${postId}`;

                    new bootstrap.Modal(document.getElementById('deleteModal')).show();
                });
            });

            // Helper function to show alerts
            function showAlert(type, message) {
                const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

                const container = document.querySelector('.container-fluid');
                const existingAlert = container.querySelector('.alert');

                if (existingAlert) {
                    existingAlert.remove();
                }

                container.insertAdjacentHTML('afterbegin', alertHtml);

                // Auto-hide after 3 seconds
                setTimeout(() => {
                    const alert = container.querySelector('.alert');
                    if (alert) {
                        new bootstrap.Alert(alert).close();
                    }
                }, 3000);
            }

            // Auto-hide existing alerts
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endpush
