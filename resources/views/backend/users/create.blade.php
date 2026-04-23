@extends('backend.layouts.base')
@section('title', 'Add User')


@section('contents')
    <div class="row">
        @canany(['view.users', 'manage.users'])
            <div class="d-flex justify-content-end">
                <a type="submit" class="btn  btn-primary btn-sm mb-1 mt-0" href="{{ route('users.index') }}"><i
                        class="bx bx-left-arrow-alt"></i> User's list</a>
            </div>
        @endcanany

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-user mr-2"></i>
                        Add New User
                    </h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                {{-- <span aria-hidden="true">&times;</span> --}}
                            </button>
                            <i class="fas fa-times mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf

                                <!-- Basic Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" id="name" placeholder="Enter full name">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" id="email"
                                                placeholder="Enter email address">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role <span
                                                    class="text-danger">*</span></label>
                                            <select name="role" class="form-select @error('role') is-invalid @enderror"
                                                id="role">
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ old('role') === $role->name ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="mobile_phone" class="form-label">Mobile Phone</label>
                                            <input type="number" name="mobile_phone"
                                                class="form-control @error('mobile_phone') is-invalid @enderror"
                                                value="{{ old('mobile_phone') }}" id="mobile_phone"
                                                placeholder="Enter mobile phone">
                                            @error('mobile_phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                <i class="mdi mdi-content-save me-1"></i> Add User
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end row -->
                    </div>
                </div>
            </div>
        </div>

    @endsection
