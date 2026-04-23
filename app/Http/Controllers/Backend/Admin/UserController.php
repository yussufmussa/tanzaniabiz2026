<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    public function index()
    {

        return view('backend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'admin')->get();

        return view('backend.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users|lowercase',
            'mobile_phone' => 'nullable|digits:10|regex:/^0\d{9}$/',
            'role' => 'required|exists:roles,name',
        ], [
            'mobile_phone.digits' => 'Phone number must be 10 digits',
            'mobile_phone.regex' => 'Phone number must start with 0',

        ]);

        if ($request->role === 'admin') {
            return back()->withErrors(['role' => 'Admin role cannot be assigned to new users.'])->withInput();
        }

        if ($request->role === 'admin') {
            $adminExists = User::role('admin')->exists();
            if ($adminExists) {
                return back()->withErrors(['role' => 'An admin user already exists. Only one admin user is allowed.'])->withInput();
            }
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'profile_picture' => 'user.png',
                'password' => '',
                'mobile_phone' => $request->mobile_phone,

            ]);

            $user->assignRole($request->role);

            if ($request->role != 'business_owner') {
                $user->email_verified_at = now();
                $user->save();
            }


            DB::commit();

            try {
                Password::sendResetLink(['email' => $user->email]);
            } catch (\Throwable $mailException) {
                return back()->with(['error' => 'Password reset email failed' .  $mailException->getMessage()])->withInput();
            }

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with(['error' => 'Failed to create a new user. Please try again.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        $user->load([
            'roles',
            'loginHistories' => function ($query) {
                $query->orderBy('login_time', 'desc')->limit(10);
            },
        ]);

        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('roles');

        $roles = Role::with('permissions')
            ->when(!auth()->user()->hasRole('admin'), function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->get();

        return view('backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile_phone' => 'nullable|digits:10|regex:/^0\d{9}$/',
            'role' => 'required|exists:roles,name',
        ], [
            'mobile_phone.digits' => 'Phone number must be 10 digits',
            'mobile_phone.regex' => 'Phone number must start with 0',

        ]);

        if ($request->role === 'admin') {
            $adminExists = User::role('admin')->exists();
            if ($adminExists) {
                return back()->withErrors(['role' => 'An admin user already exists. Only one admin user is allowed.'])->withInput();
            }
        }

        // Prevent removing admin role if this is the only admin user
        if ($user->hasRole('admin') && $request->role !== 'admin') {
            $adminCount = User::role('admin')->count();
            if ($adminCount <= 1) {
                return back()->withErrors(['role' => 'Cannot change role. At least one admin user must exist.'])->withInput();
            }
        }

        DB::beginTransaction();

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile_phone' => $request->mobile_phone,
            ];

            $user->update($updateData);

            $user->syncRoles([$request->role]);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {

            DB::rollback();

            return back()->withErrors(['error' => 'Failed to update user. Please try again.'])->withInput();
        }
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');

        $users = User::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->statusFilter && $request->statusFilter !== 'all', function ($query) use ($request) {
                $query->where('is_active', $request->statusFilter === 'active' ? 1 : 0);
            })
            ->when($request->businessListing === 'with_business_listings', function ($query) {
                $query->has('businessListings');
            })
            ->when($request->businessListing === 'without_business_listings', function ($query) {
                $query->doesntHave('businessListings');
            })
            ->orderBy('name', 'asc')
            ->withCount('businessListings')
            ->with(['roles.permissions', 'permissions'])
            ->get();

        if ($format === 'pdf') {
            $generatedAt = now();
            $totalRecords = $users->count();

            $pdf = Pdf::loadView('backend.users.export_users_to_pdf', compact('users', 'generatedAt', 'totalRecords'));

            return $pdf->download('users_' . date('Y_m_d') . '.pdf');
        }

        return Excel::download(new UserExport($users), 'users_' . date('Y_m_d') . '.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        if ($user->hasRole('admin')) {
            $adminCount = User::role('admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('users.index')
                    ->with('error', 'Cannot delete the only admin user.');
            }
        }

        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        DB::beginTransaction();

        try {

            if ($user->profile_picture && !$user->profile_picture == 'user.png') {
                $profilePicturePath =  public_path() . '/uploads/profilePictures/' . $user->profile_picture;

                if (File::exists($profilePicturePath)) {
                    File::delete($profilePicturePath);
                }
            }

            $user->syncRoles([]);
            $user->delete();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('users.index')->with('error', 'Failed to delete user. Please try again.');
        }
    }
}
