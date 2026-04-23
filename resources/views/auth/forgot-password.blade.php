@extends('frontend.layouts.base')
@section('title', 'Forgot Password')
@section('extra_style')
@endsection

@section('contents')

    <!-- ======================= Forggot Password Form ======================== -->
    <section class="gray">
        <div class="container">
            <div class="row align-items-start justify-content-center">
                <div class="col-xl-5 col-lg-8 col-md-12">

                    <div class="signup-screen-wrap">
                        <div class="signup-screen-single">
                            <div class="text-center mb-4">
                                <h4 class="m-0 ft-medium">Request New Password</h4>
                            </div>

                            <form class="submit-form" action="{{ route('password.email') }}" method="post">
                                @csrf

                                @if (Session::has('status'))
                                    <div class="alert alert-success">
                                        {{ Session::get('status') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="mb-1">Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror rounded"
                                        placeholder="Enter Email">
                                    @error('email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-md full-width theme-bg text-light rounded ft-medium">
                                        Request New Password
                                    </button>
                                </div>

                                {{-- Back to login --}}
                                <div class="text-center mt-2">
                                    <a href="{{ route('login') }}">Back to login</a>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ======================= Forgot Password  End ======================== -->

@endsection

