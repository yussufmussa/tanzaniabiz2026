@extends('backend.layouts.base')
@section('title', 'SEO Manager')


@section('contents')
    @if (!is_null($seo))
        <!-- If seo is not empty -->
        <div class="row">

            {{-- Success Message --}}
            @if (Session::has('message'))
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                         <i class="fas fa-check-circle mr-2"></i>
                        {{ Session::get('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cog mr-2"></i>
                            SEO Manager
                        </h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('store.seo') }}" method="POST">
                            @csrf

                            <div class="row">

                                {{-- Meta Title --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Meta Title
                                        <span id="titleStatus" class="badge bg-secondary ms-2">—</span>
                                    </label>
                                    <input type="text" name="meta_title" class="form-control" maxlength="60"
                                        value="{{ $seo->meta_title }}" onkeyup="seoTitleCheck(this)">
                                    <small id="titleCount" class="text-muted"></small>
                                </div>


                                {{-- Meta Keywords --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Meta Keywords
                                        <span id="keywordStatus" class="badge bg-secondary ms-2">—</span>
                                    </label>
                                    <input type="text" name="meta_keywords" class="form-control"
                                        value="{{ $seo->meta_keywords }}" onkeyup="seoKeywordCheck(this)">
                                    <small class="text-muted">Comma separated</small>
                                </div>


                                {{-- Meta Description --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        Meta Description
                                        <span id="descStatus" class="badge bg-secondary ms-2">—</span>
                                    </label>
                                    <textarea name="meta_description" rows="4" maxlength="160" class="form-control" onkeyup="seoDescCheck(this)">{{ $seo->meta_description }}</textarea>
                                    <small id="descCount" class="text-muted"></small>
                                </div>


                                <hr class="my-4">

                                {{-- Tracking Codes --}}
                                <h5 class="mb-3">Tracking & Analytics</h5>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Google Analytics ID</label>
                                    <input type="text" name="google_analytics_code" class="form-control"
                                        placeholder="G-XXXXXXXXXX" value="{{ $seo->google_analytics_code }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Google Tag Manager ID</label>
                                    <input type="text" name="google_tag_manager" class="form-control"
                                        placeholder="GTM-XXXXXXX" value="{{ $seo->google_tag_manager }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Facebook Pixel ID</label>
                                    <input type="text" name="facebook_pixel" class="form-control"
                                        placeholder="XXXXXXXXXXXXXXX" value="{{ $seo->facebook_pixel }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Google Adsense Code</label>
                                    <input type="text" name="google_adsense_code" class="form-control"
                                        placeholder="ca-pub-4570026540686418" value="{{ $seo->google_adsense_code }}">
                                </div>

                                <input type="hidden" name="id" value="{{ $seo->id }}">

                                {{-- Submit --}}
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Save SEO Settings
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- if the seo iis empty create new records -->
    @endif
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

@push('extra_script')
    <script>
        function setStatus(el, status, text) {
            el.className = 'badge ms-2 ' + status;
            el.innerText = text;
        }

        function seoTitleCheck(input) {
            const count = input.value.length;
            document.getElementById('titleCount').innerText = count + '/60 characters';

            const status = document.getElementById('titleStatus');

            if (count < 30 || count > 60) {
                setStatus(status, 'bg-danger', 'Bad');
            } else if (count < 50) {
                setStatus(status, 'bg-warning text-dark', 'OK');
            } else {
                setStatus(status, 'bg-success', 'Good');
            }
        }

        function seoDescCheck(input) {
            const count = input.value.length;
            document.getElementById('descCount').innerText = count + '/160 characters';

            const status = document.getElementById('descStatus');

            if (count < 70 || count > 160) {
                setStatus(status, 'bg-danger', 'Bad');
            } else if (count < 120) {
                setStatus(status, 'bg-warning text-dark', 'OK');
            } else {
                setStatus(status, 'bg-success', 'Good');
            }
        }

        function seoKeywordCheck(input) {
            const keywords = input.value.split(',').filter(k => k.trim() !== '');
            const status = document.getElementById('keywordStatus');

            if (keywords.length === 0) {
                setStatus(status, 'bg-danger', 'Missing');
            } else if (keywords.length < 3) {
                setStatus(status, 'bg-warning text-dark', 'OK');
            } else {
                setStatus(status, 'bg-success', 'Good');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('[name="meta_title"]')?.onkeyup();
            document.querySelector('[name="meta_description"]')?.onkeyup();
            document.querySelector('[name="meta_keywords"]')?.onkeyup();
        });
    </script>
@endpush
