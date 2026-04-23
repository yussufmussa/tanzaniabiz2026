<div class="form-group text-center mb-0">
    <p class="extra">Or {{ request()->is('login') ? 'Login' : (request()->is('register') ? 'Sign Up' : '') }} with</p>
    <div class="option-log">
        <div class="single-log-opt"><a href="{{ route('socialite.auth', 'google') }}" class="log-btn"><img
                    src="{{ asset('uploads/general/google.webp') }}" class="img-fluid" alt="" />Login with
                Google</a></div>
        <div class="single-log-opt"><a href="{{ route('socialite.auth', 'facebook') }}" class="log-btn"><img
                    src="{{ asset('uploads/general/facebook.webp') }}" class="img-fluid" alt="" />Login with
                Facebook</a></div>

    </div>
</div>
