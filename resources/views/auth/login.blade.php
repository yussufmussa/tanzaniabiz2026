@extends('frontend.layouts.base')
@section('title', 'Login')

@section('contents')
<!-- ======================= Login Detail ======================== -->
<section class="gray">
	<div class="container">
		<div class="row align-items-start justify-content-center">
			<div class="col-xl-5 col-lg-8 col-md-12">

				<div class="signup-screen-wrap">
					<div class="signup-screen-single">
						<div class="text-center mb-4">
							<h4 class="m-0 ft-medium">Login Your Account</h4>
						</div>

						<form class="submit-form" action="{{route('login')}}" method="post">@csrf
							@if (Session::has('status'))
							<div class="alert alert-success">
								{{ Session::get('status') }}
							</div>
							@endif
							<div class="form-group">
								<label class="mb-1">Email</label>
								<input type="text" name="email" class="form-control   @error('email') is-invalid @enderror rounded" placeholder="Email ">
								@error('email')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
							</div>

							 <div class="form-group position-relative">
                                    <label class="mb-1">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror rounded"
                                        placeholder="Password">

                                    <button type="button" class="toggle-password-btn" aria-label="Show password"
                                        data-target="password" onclick="togglePasswordVisibility(this)">
                                        <span class="fa fa-eye" aria-hidden="true"></span>
                                    </button>

                                    <div id="caps-warning-password" class="text-warning small mt-1 d-none">
                                        Caps Lock is ON
                                    </div>

                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

							<div class="form-group">
								<div class="d-flex align-items-center justify-content-between">
									<div class="flex-1">
										<input id="dd" class="checkbox-custom" name="remember" type="checkbox">
										<label for="dd" class="checkbox-custom-label">Remember Me</label>
									</div>
									<div class="eltio_k2">
										<a href="{{route('password.request')}}" class="theme-cl">Lost Your Password?</a>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit"
									class="btn btn-md full-width theme-bg text-light rounded ft-medium">Sign In</button>
							</div>

                            @include('frontend.partials.socials_login')


							<div class="form-group text-center mt-4 mb-0">
								<p class="mb-0">Not Registered Yet? <a href="/register"
										class="ft-medium text-success">Add Your Business</a></p>
							</div>

						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>
<!-- ======================= Login End ======================== -->



@endsection
@push('extra_script')
<script>
        function togglePasswordVisibility(btn) {
            const input = document.getElementById(btn.dataset.target);
            const icon = btn.querySelector('span');
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isHidden);
            icon.classList.toggle('fa-eye-slash', isHidden);
            btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        }
</script>
@endpush