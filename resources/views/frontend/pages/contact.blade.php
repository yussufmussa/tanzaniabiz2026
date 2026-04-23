@extends('frontend.layouts.base')
@section('title', 'Contact Us')
@push('extra_style')
<link rel='stylesheet' href="{{asset('frontend/assets/css/sweetalert2.min.css')}}">
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ $setting->first()->title }}",
        "url": "{{ url()->current() }}",
        "logo": "{{ secure_asset('photos/general/'.$setting->first()->logo) }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "{{ $setting->first()->mobile_phone_1 }}",
            "contactType": "customer support"
        }
    }
</script>
@endpush

@section('contents')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="bg-dark py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-light">Home</a></li>
                        <li class="breadcrumb-item active theme-cl" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Contact Page Detail ======================== -->
<section class="gray">
    <div class="container">

        <div class="row justify-content-center mb-5">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h1 class="off_title">Contact Us</h1>
                </div>
            </div>
        </div>

        <div class="row align-items-start justify-content-center">

            <div class="col-xl-10 col-lg-11 col-md-12 col-sm-12">
                <form class="row submit-form py-4 px-3 rounded bg-white mb-4" action="/contact-us" method="post">@csrf

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Your Name *</label>
                            <input name="name" type="text" class="form-control" placeholder="Your Name" value="{{old('name')}}">
                            @error('name')
                            <div class="text-danger">
                                    {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="recaptcha" id="recaptcha">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Your Email *</label>
                            <input name="email" type="text" class="form-control" placeholder="Your Email" value="{{old('email')}}">
                            @error('name')
                            <div class="text-danger">
                                    {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Subject</label>
                            <input name="subject" type="text" class="form-control" placeholder="Type Your Subject" value="{{old('subject')}}">
                            @error('subject')
                            <div class="text-danger">
                                    {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="small text-dark ft-medium">Message</label>
                            <textarea name="body" class="form-control ht-80" placeholder="Your email..">{{old('body')}}</textarea>
                            @error('body')
                            <div class="text-danger">
                                    {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center">
                        <div class="form-group">
                            <button type="submit" class="btn theme-bg text-light">Send Message</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>
<!-- ======================= Contact Page End ======================== -->
@endsection

@push('extra_js_script')
<script src="{{asset('frontend/assets/js/sweetalert2.all.min.js')}}"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LfZO0soAAAAAMRuoYq2YJXtrefQYB1y74ojaZIr"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LfZO0soAAAAAMRuoYq2YJXtrefQYB1y74ojaZIr', {
            action: 'contact'
        }).then(function(token) {
            if (token) {
                document.getElementById('recaptcha').value = token;
            }
        });
    });
</script>
<script>
    let error = "{{Session::has('error')}}";
    let success = "{{Session::has('success')}}";
    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Great!',
            text: '{{ Session::get("error")}}'
        });
    }

    if (success) {
        Swal.fire({
            icon: 'success',
            title: 'Email Sent',
            text: '{{ Session::get("success")}}',
        });
    }
</script>
@endpush
