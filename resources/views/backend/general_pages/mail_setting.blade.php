@extends('backend.layouts.base')
@section('title', 'Email Configuration')

@section('contents')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-envelope mr-2"></i>
                            Mail Configuration Settings
                        </h3>
                    </div>

                    <form method="POST" action="{{ route('update.mail.settings') }}" id="mailSettingsForm">
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
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="mail_mailer">Mail Driver</label>
                                        <select class="form-control @error('mail_mailer') is-invalid @enderror"
                                            id="mail_mailer" name="mail_mailer" required>
                                            <option value="smtp"
                                                {{ old('mail_mailer', $mailSettings['mail_mailer']) == 'smtp' ? 'selected' : '' }}>
                                                SMTP</option>
                                            <option value="sendmail"
                                                {{ old('mail_mailer', $mailSettings['mail_mailer']) == 'sendmail' ? 'selected' : '' }}>
                                                Sendmail</option>
                                            <option value="mailgun"
                                                {{ old('mail_mailer', $mailSettings['mail_mailer']) == 'mailgun' ? 'selected' : '' }}>
                                                Mailgun</option>
                                            <option value="ses"
                                                {{ old('mail_mailer', $mailSettings['mail_mailer']) == 'ses' ? 'selected' : '' }}>
                                                Amazon SES</option>
                                            <option value="postmark"
                                                {{ old('mail_mailer', $mailSettings['mail_mailer']) == 'postmark' ? 'selected' : '' }}>
                                                Postmark</option>
                                        </select>
                                        @error('mail_mailer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="mail_host">SMTP Host</label>
                                        <input type="text" class="form-control @error('mail_host') is-invalid @enderror"
                                            id="mail_host" name="mail_host"
                                            value="{{ old('mail_host', $mailSettings['mail_host']) }}"
                                            placeholder="mail.example.com" required>
                                        @error('mail_host')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="mail_port">SMTP Port</label>
                                        <input type="number" class="form-control @error('mail_port') is-invalid @enderror"
                                            id="mail_port" name="mail_port"
                                            value="{{ old('mail_port', $mailSettings['mail_port']) }}" placeholder="587"
                                            min="1" max="65535" required>
                                        <small class="form-text text-muted">
                                            Common ports: 25, 465 (SSL), 587 (TLS)
                                        </small>
                                        @error('mail_port')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="mail_encryption">Encryption</label>
                                        <select class="form-control @error('mail_encryption') is-invalid @enderror"
                                            id="mail_encryption" name="mail_encryption">
                                            <option value="">None</option>
                                            <option value="tls"
                                                {{ old('mail_encryption', $mailSettings['mail_encryption']) == 'tls' ? 'selected' : '' }}>
                                                TLS</option>
                                            <option value="ssl"
                                                {{ old('mail_encryption', $mailSettings['mail_encryption']) == 'ssl' ? 'selected' : '' }}>
                                                SSL</option>
                                        </select>
                                        @error('mail_encryption')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="mail_username">SMTP Username</label>
                                        <input type="email"
                                            class="form-control @error('mail_username') is-invalid @enderror"
                                            id="mail_username" name="mail_username"
                                            value="{{ old('mail_username', $mailSettings['mail_username']) }}"
                                            placeholder="user@example.com" required>
                                        @error('mail_username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="mail_password">SMTP Password</label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control @error('mail_password') is-invalid @enderror"
                                                id="mail_password" name="mail_password" value="{{ old('mail_password') }}"
                                                placeholder="Enter password (leave blank to keep current)">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="togglePassword()">
                                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('mail_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mail_from_address">From Email Address</label>
                                        <input type="email"
                                            class="form-control @error('mail_from_address') is-invalid @enderror"
                                            id="mail_from_address" name="mail_from_address"
                                            value="{{ old('mail_from_address', $mailSettings['mail_from_address']) }}"
                                            placeholder="noreply@example.com" required>
                                        @error('mail_from_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="mail_from_name">From Name</label>
                                        <input type="text"
                                            class="form-control @error('mail_from_name') is-invalid @enderror"
                                            id="mail_from_name" name="mail_from_name"
                                            value="{{ old('mail_from_name', $mailSettings['mail_from_name']) }}"
                                            placeholder="Your Company Name" required>
                                        @error('mail_from_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
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
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('mail_password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        // Clear password field on focus if it contains placeholder dots
        document.getElementById('mail_password').addEventListener('focus', function() {
            if (this.value === '••••••••') {
                this.value = '';
            }
        });
    </script>
@endpush
