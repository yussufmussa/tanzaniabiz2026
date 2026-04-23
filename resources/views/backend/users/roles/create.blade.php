@extends('backend.layouts.base')
@section('title', 'New Role')

@section('contents')
<div class="row">
    @canany(['view.roles', 'manage.roles'])
        <div class="d-flex justify-content-end">
            <a type="submit" class="btn  btn-primary btn-sm  mb-1 mt-0" href="{{ route('roles.index') }}">
                <i class='bx bx-left-arrow-alt'></i>Back</a>
        </div>
    @endcanany

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user mr-2"></i>
                    Add New Role
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ route('roles.store') }}" method="post">
    @csrf

    <div class="mb-3">
        <label for="forrole" class="form-label fw-bold">Role Name</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}"
               id="forrole"
               placeholder="Enter role name">
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

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
                    // Find manage.<module>
                    $manageName = 'manage.' . $module;
                    $managePermission = $modulePermissions->firstWhere('name', $manageName);

                    // Old selected permissions
                    $oldPerms = collect(old('permissions', []));
                @endphp

                <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $module)) }}</td>

                    <td>
                        @if ($managePermission)
                            <input type="checkbox"
                                   class="group-checkbox"
                                   data-module="{{ $module }}"
                                   id="manage-{{ $module }}"
                                   name="permissions[]"
                                   value="{{ $managePermission->name }}"
                                   {{ $oldPerms->contains($managePermission->name) ? 'checked' : '' }}>
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

                                // If manage is checked in old input, show children checked too (UI only)
                                $manageChecked = $oldPerms->contains($manageName);
                                $childChecked = $oldPerms->contains($permission->name) || $manageChecked;

                                $label = ucfirst(str_replace('_', ' ', $action));
                            @endphp

                            <div class="form-check form-check-inline mb-1">
                                <input class="form-check-input permission-checkbox"
                                       type="checkbox"
                                       name="permissions[]"
                                       value="{{ $permission->name }}"
                                       id="permission-{{ $permission->id }}"
                                       data-module="{{ $module }}"
                                       {{ $childChecked ? 'checked' : '' }}>

                                <label class="form-check-label" for="permission-{{ $permission->id }}">
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
        <i class="mdi mdi-content-save me-1"></i> Create Role
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
  // 1) manage.module -> check/uncheck all children in that module
  document.querySelectorAll('.group-checkbox').forEach(groupCheckbox => {
    groupCheckbox.addEventListener('change', function () {
      const module = this.dataset.module;
      const checked = this.checked;

      document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`)
        .forEach(cb => cb.checked = checked);
    });
  });

  // 2) children -> reflect into manage.module checkbox
  document.querySelectorAll('.permission-checkbox').forEach(cb => {
    cb.addEventListener('change', function () {
      const module = this.dataset.module;
      const children = Array.from(document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`));
      const manage = document.querySelector(`#manage-${module}`);
      if (!manage) return;

      const allChecked = children.length > 0 && children.every(x => x.checked);
      manage.checked = allChecked;
    });
  });

  // 3) On load: set manage checkbox state based on children (so UI stays correct)
  document.querySelectorAll('.group-checkbox').forEach(manage => {
    const module = manage.dataset.module;
    const children = Array.from(document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`));
    if (children.length === 0) return;

    const allChecked = children.every(x => x.checked);
    manage.checked = manage.checked || allChecked;
  });
</script>
@endpush
