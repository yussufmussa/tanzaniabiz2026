@extends('backend.layouts.base')
@section('title', 'Edit Role')

@section('contents')
    <div class="row">
        @canany(['roles.edit', 'roles.manage'])
            <div class="d-flex justify-content-end">
                <a type="submit" class="btn  btn-primary btn-sm mb-1 mt-0" href="{{ route('roles.index') }}"><i
                        class="fa fa-arrow-left"></i>Back</a>
            </div>
        @endcanany

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user mr-2"></i>
                            Edit Role
                        </h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="forrole" class="form-label fw-bold">Role Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $role->name) }}" id="forrole" placeholder="Enter role name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @php
                                    // "Old" permissions take priority (after validation fail)
                                    $selected = collect(old('permissions', $rolePermissions ?? []));
                                @endphp

                                <div class="form-group">
                                    <label class="fw-bold">Choose Permissions</label>

                                    <table class="table table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 180px;">Module</th>
                                                <th style="width: 80px;">All</th>
                                                <th>Permission List</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($permissions as $module => $modulePermissions)
                                                @php
                                                    $manageName = 'manage.' . $module;
                                                    $managePermission = $modulePermissions->firstWhere(
                                                        'name',
                                                        $manageName,
                                                    );
                                                    $isManageChecked =
                                                        $managePermission && $selected->contains($manageName);
                                                @endphp

                                                <tr>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $module)) }}</td>

                                                    <td>
                                                        @if ($managePermission)
                                                            <input type="checkbox" class="group-checkbox"
                                                                data-module="{{ $module }}"
                                                                id="manage-{{ $module }}" name="permissions[]"
                                                                value="{{ $managePermission->name }}"
                                                                {{ $isManageChecked ? 'checked' : '' }}>
                                                        @else
                                                            <input type="checkbox" disabled>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @foreach ($modulePermissions as $permission)
                                                            @continue($permission->name === $manageName)

                                                            @php
                                                                $parts = explode('.', $permission->name, 2);
                                                                $action = $parts[0] ?? $permission->name;

                                                                // If manage is checked, show children checked (UI only)
                                                                $childChecked =
                                                                    $selected->contains($permission->name) ||
                                                                    $isManageChecked;

                                                                $label = ucfirst(str_replace('_', ' ', $action));
                                                            @endphp

                                                            <div class="form-check form-check-inline mb-1">
                                                                <input class="form-check-input permission-checkbox"
                                                                    type="checkbox" name="permissions[]"
                                                                    value="{{ $permission->name }}"
                                                                    id="permission-{{ $permission->id }}"
                                                                    data-module="{{ $module }}"
                                                                    {{ $childChecked ? 'checked' : '' }}>

                                                                <label class="form-check-label"
                                                                    for="permission-{{ $permission->id }}">
                                                                    {{ $label }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @error('permissions')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Update Role
                                </button>
                            </form>


                        </div> <!-- end row -->
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('extra_script')
        <script>
            // manage.module -> children
            document.querySelectorAll('.group-checkbox').forEach(manage => {
                manage.addEventListener('change', function() {
                    const module = this.dataset.module;
                    const checked = this.checked;

                    document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`)
                        .forEach(cb => cb.checked = checked);
                });
            });

            // children -> manage.module
            document.querySelectorAll('.permission-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    const module = this.dataset.module;
                    const children = Array.from(document.querySelectorAll(
                        `.permission-checkbox[data-module="${module}"]`));
                    const manage = document.querySelector(`#manage-${module}`);
                    if (!manage) return;

                    const allChecked = children.length > 0 && children.every(x => x.checked);
                    manage.checked = allChecked;
                });
            });

            // on load: if all children checked, tick manage
            document.querySelectorAll('.group-checkbox').forEach(manage => {
                const module = manage.dataset.module;
                const children = Array.from(document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`));
                if (children.length === 0) return;

                const allChecked = children.every(x => x.checked);
                manage.checked = manage.checked || allChecked;
            });
        </script>
    @endpush
