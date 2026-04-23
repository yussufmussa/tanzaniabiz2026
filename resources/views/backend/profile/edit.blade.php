@extends('backend.layouts.base')
@section('title', 'My Profile')
@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4">Update Profile Information</h1>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        {{-- Profile Picture Section --}}
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h2 class="card-title pb-0">Profile Picture</h2>
                                </div>
                                <div class="card-body">
                                    @livewire('backend.profile.update-profile-picture')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        {{-- General Information Section --}}
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h2 class="card-title pb-0">General Information</h2>
                                </div>
                                <div class="card-body">
                                    @livewire('backend.profile.update-profile-information')
                                </div>
                            </div>
                        </div>
                        {{-- Change Password Section --}}
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h2 class="card-title pb-0">Change Password</h2>
                                </div>
                                <div class="card-body">
                                    @livewire('backend.profile.update-user-password')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
