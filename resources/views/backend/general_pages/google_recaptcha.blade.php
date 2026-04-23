@extends('backend.layouts.base')
@section('title', 'Google Recaptcha Settings')

@section('contents')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-envelope mr-2"></i>
                            Google Recaptcha Keys
                        </h3>
                    </div>

                    <form method="POST" action="{{ route('update.google.recaptcha') }}" id="mailSettingsForm">
                        @csrf
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="form-group mb-3">
                                <label for="nocaptcha_secret">Captcha Secret Key</label>
                                <input type="text" class="form-control" id="nocaptcha_secret" name="nocaptcha_secret"
                                    value="{{ old('nocaptcha_secret', $recaptchaSettings['nocaptcha_secret']) }}" required>
                                      @error('nocaptcha_secret')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="nocaptcha_sitekey">Captcha Site Key</label>
                                <input type="text" class="form-control" id="nocaptcha_sitekey" name="nocaptcha_sitekey"
                                    value="{{ old('nocaptcha_sitekey', $recaptchaSettings['nocaptcha_sitekey']) }}" required>
                                      @error('nocaptcha_sitekey')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 4000);
    </script>
@endsection

