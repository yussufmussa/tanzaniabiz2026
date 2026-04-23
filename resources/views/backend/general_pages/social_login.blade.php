@extends('backend.layouts.base')
@section('title', 'Social Logins')

@section('contents')
       <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fab fa-google mr-2"></i>
                    Social Login Settings
                </h3>
            </div>

            <form method="POST" action="{{ route('update.social.login.settings') }}">
                @csrf

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- GOOGLE --}}
                    <h5 class="mb-3 mt-2">
                        <i class="fab fa-google text-danger mr-1"></i> Google Login
                    </h5>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="google[enabled]" value="1"
                                        {{ old('google.enabled', $settings['google']['enabled']) ? 'checked' : '' }}>
                                    Enable Google Login
                                </label>
                            </div>
                        </div>

                        <div class="col-md-9"></div>

                        <div class="col-md-6 mb-3">
                            <label>Client ID</label>
                            <input type="text" class="form-control"
                                name="google[client_id]"
                                value="{{ old('google.client_id', $settings['google']['client_id']) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Client Secret</label>
                            <input type="password" class="form-control"
                                name="google[client_secret]"
                                placeholder="Leave blank to keep current">
                        </div>
                    </div>

                    <hr>

                    {{-- FACEBOOK --}}
                    <h5 class="mb-3">
                        <i class="fab fa-facebook text-primary mr-1"></i> Facebook Login
                    </h5>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="facebook[enabled]" value="1"
                                        {{ old('facebook.enabled', $settings['facebook']['enabled']) ? 'checked' : '' }}>
                                    Enable Facebook Login
                                </label>
                            </div>
                        </div>

                        <div class="col-md-9"></div>

                        <div class="col-md-6 mb-3">
                            <label>App ID</label>
                            <input type="text" class="form-control"
                                name="facebook[client_id]"
                                value="{{ old('facebook.client_id', $settings['facebook']['client_id']) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>App Secret</label>
                            <input type="password" class="form-control"
                                name="facebook[client_secret]"
                                placeholder="Leave blank to keep current">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-content-save me-1"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
@push('extra_script')
<script>
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 4000);
</script>
@endpush
