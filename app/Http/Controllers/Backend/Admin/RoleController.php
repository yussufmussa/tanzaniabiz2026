<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {

        $roles = Role::with('permissions', 'users')
            ->orderBy('name', 'asc')
            ->get();

        return view('backend.users.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::query()
            ->orderBy('name')
            ->get()
            ->groupBy(function ($perm) {
                $parts = explode('.', $perm->name, 2);
                return $parts[1] ?? 'misc';
            });

        return view('backend.users.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80|unique:roles,name',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create(['name' => $validated['name']]);

        $normalized = $this->normalizePermissions($validated['permissions']);

        $role->syncPermissions($normalized);

            return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    private function normalizePermissions(array $permissions): array
    {
        $perms = collect($permissions)->filter()->unique()->values();

        $byModule = $perms->groupBy(function ($p) {
            $parts = explode('.', $p, 2);
            return $parts[1] ?? $p;
        });

        $out = $byModule->flatMap(function ($items, $module) {
            $manage = "manage.$module";

            return $items->contains($manage) ? [$manage] : $items->all();
        });


        return $out->unique()->values()->all();
    }

    public function edit(Role $role)
    {
        $permissions = $this->groupPermissionsByModule();

        // Use direct permissions assigned to the role
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('backend.users.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80|unique:roles,name,' . $role->id,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->update(['name' => $validated['name']]);

        // Normalize: if manage.<module> selected, store only manage.<module>
        $normalized = $this->normalizePermissions($validated['permissions']);

        $role->syncPermissions($normalized);

        // safe redirect (optional)
        if (auth()->user()->can('view.roles') || auth()->user()->can('manage.roles')) {
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        }

        return redirect()->route('dashboard')->with('success', 'Role updated successfully');
    }

    private function groupPermissionsByModule()
    {
        // groups by module (part after dot)
        // view.users -> users
        return Permission::query()
            ->orderBy('name')
            ->get()
            ->groupBy(function ($perm) {
                $parts = explode('.', $perm->name, 2);
                return $parts[1] ?? 'misc';
            });
    }

    // private function normalizePermissions(array $permissions): array
    // {
    //     $perms = collect($permissions)->filter()->unique()->values();

    //     $byModule = $perms->groupBy(function ($p) {
    //         $parts = explode('.', $p, 2);
    //         return $parts[1] ?? $p;
    //     });

    //     return $byModule->flatMap(function ($items, $module) {
    //         $manage = "manage.$module";
    //         return $items->contains($manage) ? [$manage] : $items->all();
    //     })->unique()->values()->all();
    // }

    public function destroy(Role $role){

        $role->delete();

        return redirect()->route('roles.index')->with(['success' => 'User role deleted successfully']);
    }

}
