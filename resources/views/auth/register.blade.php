@extends('frontend.layouts.base')
@section('title', 'Sign up')


@section('contents')
    <!-- ======================= Login Detail ======================== -->
    <section class="gray">
        <div class="container">
            <div class="row align-items-start justify-content-center">
                <div class="col-xl-5 col-lg-8 col-md-12">

                    <div class="signup-screen-wrap">
                        <div class="signup-screen-single">
                            <div class="text-center mb-4">
                                <h4 class="m-0 ft-medium">Create Account</h4>
                            </div>

                            <form class="submit-form" action="{{ route('register') }}" method="post">
                                @csrf

                                @if (Session::has('status'))
                                    <div class="alert alert-success">
                                        {{ Session::get('status') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="mb-1">Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                                        class="form-control @error('name') is-invalid @enderror rounded"
                                        placeholder="Enter Your Name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                        class="form-control @error('email') is-invalid @enderror rounded"
                                        placeholder="Enter Email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                {{-- Password --}}
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

                                {{-- Confirm Password --}}
                                <div class="form-group position-relative">
                                    <label class="mb-1">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        autocomplete="new-password" class="form-control rounded"
                                        placeholder="Confirm Password">

                                    <button type="button" class="toggle-password-btn" aria-label="Show password"
                                        data-target="password_confirmation" onclick="togglePasswordVisibility(this)">
                                        <span class="fa fa-eye" aria-hidden="true"></span>
                                    </button>

                                    <div id="caps-warning-password_confirmation" class="text-warning small mt-1 d-none">
                                        Caps Lock is ON
                                    </div>

                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-box py-4 user-action-meta">
                                    <div class="form-group">
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}

                                        @if ($errors->has('g-recaptcha-response'))
                                            <div class="text-danger mt-2">
                                                {{ $errors->first('g-recaptcha-response') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label class="d-flex align-items-center gap-2">
                                        <input type="checkbox" name="terms" required>
                                        <span>
											<a href="/terms-of-service" target="_blank">I agree to the Terms and Privacy Policy</a>
										</span>
                                    </label>
                                    @error('terms')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="form-group">
                                    <button type="submit" class="btn btn-md full-width bg-sky text-light rounded ft-medium"
                                        onclick="this.disabled=true; this.form.submit();">
                                        Create an account
                                    </button>
                                </div>

                                @include('frontend.partials.socials_login')

                                <div class="form-group text-center mt-4 mb-0">
                                    <p class="mb-0">
                                        Already Registered?
                                        <a href="{{ route('login') }}" class="ft-medium text-success">Login</a>
                                    </p>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

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

        const emailInput = document.querySelector('input[name="email"]');
        const emailFeedback = document.createElement('div');
        emailFeedback.className = 'small mt-1';
        emailInput.after(emailFeedback);

        let emailDebounce;
        emailInput.addEventListener('input', () => {
            clearTimeout(emailDebounce);
            const email = emailInput.value.trim();

            // Basic format check first
            const validFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            if (!validFormat) {
                emailFeedback.textContent = email ? 'Enter a valid email address.' : '';
                emailFeedback.className = 'small mt-1 text-danger';
                return;
            }

            emailFeedback.textContent = 'Checking...';
            emailFeedback.className = 'small mt-1 text-muted';

            // Debounce the server check by 600ms
            emailDebounce = setTimeout(() => {
                fetch('{{ route('check.email') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            email
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.available) {
                            emailFeedback.textContent = '✓ Email is available';
                            emailFeedback.className = 'small mt-1 text-success';
                        } else {
                            emailFeedback.textContent = 'This email is already registered.';
                            emailFeedback.className = 'small mt-1 text-danger';
                        }
                    });
            }, 600);
        });

        const password = document.getElementById('password');
        const confirmation = document.getElementById('password_confirmation');
        const matchFeedback = document.createElement('div');
        matchFeedback.className = 'small mt-1';
        confirmation.after(matchFeedback);

        function checkMatch() {
            if (!confirmation.value) {
                matchFeedback.textContent = '';
                return;
            }
            if (password.value === confirmation.value) {
                matchFeedback.textContent = '✓ Passwords match';
                matchFeedback.className = 'small mt-1 text-success';
            } else {
                matchFeedback.textContent = 'Passwords do not match.';
                matchFeedback.className = 'small mt-1 text-danger';
            }
        }

        password.addEventListener('input', checkMatch);
        confirmation.addEventListener('input', checkMatch);
        /**
         * Caps Lock warning for specific input.
         * Shows warning when CapsLock is on while typing/focused.
         */
        function attachCapsLockWarning(inputId, warningId) {
            const input = document.getElementById(inputId);
            const warning = document.getElementById(warningId);
            if (!input || !warning) return;

            const update = (e) => {
                // getModifierState exists on KeyboardEvent
                const isCapsOn = e.getModifierState && e.getModifierState('CapsLock');
                warning.classList.toggle('d-none', !isCapsOn);
            };

            input.addEventListener('keydown', update);
            input.addEventListener('keyup', update);

            // Hide on blur
            input.addEventListener('blur', () => warning.classList.add('d-none'));
        }

        document.addEventListener('DOMContentLoaded', function() {
            attachCapsLockWarning('password', 'caps-warning-password');
            attachCapsLockWarning('password_confirmation', 'caps-warning-password_confirmation');
        });
    </script>
@endpush
