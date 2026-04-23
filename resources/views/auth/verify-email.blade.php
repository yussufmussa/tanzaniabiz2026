@extends('frontend.layouts.base')
@section('title', 'Verify Email')

@section('contents')
    <section class="gray">
        <div class="container">
            <div class="row align-items-start justify-content-center">
                <div class="col-xl-5 col-lg-8 col-md-12">

                    <div class="signup-screen-wrap">
                        <div class="signup-screen-single">
                            <div class="text-center mb-4">
                                <h4 class="m-0 ft-medium">Verify Your Email</h4>
                            </div>

                            <form class="submit-form" action="{{ route('verification.send') }}" method="post">
                                @csrf
                                <p class="alert alert-success">Thanks for signing up! Before getting started, could you
                                    verify your email address by clicking on the link we just emailed to you? If you didn't
                                    receive the email, we will gladly send you another.</p>
                                @if (session('status') == 'verification-link-sent')
                                    <div class="mb-4 alert alert-success">
                                        A new verification link has been sent to the email address you provided during
                                        registration.
                                    </div>
                                @endif
                                
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-md full-width bg-success text-light rounded ft-medium">Resent Email</button>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="comment-btn">
                                <button class="btn btn-md full-width theme-bg text-light rounded ft-medium" type="submit">Log out</button>
                            </div>
                        </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
