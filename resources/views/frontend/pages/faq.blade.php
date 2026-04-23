@extends('frontend.layouts.base')
@section('title', 'Frequently asked Questions')
@push('extra_style')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What types of businesses can be listed in your directory?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>We accept listings for all types of businesses operating in Tanzania, ranging from small local shops to large corporations.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "How can I add my business to your directory?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>To add your business, simply navigate to the submission page on our website and fill out the required information about your business.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "Is it free to list my business on your directory?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Yes, listing your business on our directory is completely free of charge.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "How long does it take for my business listing to be approved?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Our team typically reviews and approves business listings within 1-2 business days.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "Can I edit my business listing after it's been submitted?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Yes, you can edit your business listing at any time by logging into your account on our website and accessing the edit feature.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "Are there any restrictions on the content of business listings?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>We have guidelines in place to ensure that all listings are appropriate and accurate. Please refer to our terms of service for more information.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "How can users search for businesses in your directory?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Users can search for businesses by category, location, or keywords using our search functionality.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "Can users leave reviews for businesses on your directory?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Yes, registered users can leave reviews and ratings for businesses listed on our directory.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "How do I contact a business listed on your directory?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Contact information for each business is provided in their respective listings. You can reach out to them directly using the provided contact details.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer any advertising opportunities for businesses?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Yes, we offer various advertising packages for businesses looking to increase their visibility on our directory. Please contact our advertising department for more information.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "How often are business listings updated on your directory?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Business listings are updated regularly to ensure accuracy and relevance.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "Can businesses add images or videos to their listings?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Yes, businesses can enhance their listings by adding images, videos, and other multimedia content to showcase their products or services.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "Are there any benefits to claiming my business listing?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>Claiming your business listing allows you to manage and update your information, respond to reviews, and gain greater visibility on our directory.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "What if I can't find a specific business in your directory?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>If you can't find a specific business, you can suggest it to be added to our directory by contacting our support team.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "How can I report inaccurate information in a business listing?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>If you notice any inaccuracies in a business listing, please report it to our support team, and we will investigate and make the necessary corrections.</p>"
      }
    }
  ]
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
                        <li class="breadcrumb-item active theme-cl" aria-current="page">Faq</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Contact Page Detail ======================== -->
<section class="middle">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-4">
                    <h1 class="ft-bold mb-0">FAQ's Section</h1>
                    <h3 class="ft-medium pt-1 mb-3">Frequently Asked Questions</h3>
                </div>
            </div>
        </div>

        <div class="row align-items-center justify-content-between">
            <div class="col-xl-10 col-lg-11 col-md-12 col-sm-12">

                <div class="d-block position-relative mb-4">
                    <h4 class="ft-medium">Basic FAQ's:</h4>
                    <div id="accordion" class="accordion">
    <div class="card">
        <div class="card-header" id="h1">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                    What types of businesses can be listed in your directory?
                </button>
            </h5>
        </div>

        <div id="faq1" class="collapse show" aria-labelledby="h1" data-parent="#accordion">
            <div class="card-body">
                We accept listings for all types of businesses operating in Tanzania, ranging from small local shops to large corporations. Take a look of all <a href="/browse-business-by-category">listings categories </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h2">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                    How can I add my business to your directory?
                </button>
            </h5>
        </div>

        <div id="faq2" class="collapse" aria-labelledby="h2" data-parent="#accordion">
            <div class="card-body">
                To add your business, simply <a href="/register">Create account</a> and fill out the required information about your business.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h3">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                    Is it free to list my business on your directory?
                </button>
            </h5>
        </div>

        <div id="faq3" class="collapse" aria-labelledby="h3" data-parent="#accordion">
            <div class="card-body">
                Yes, listing your business on our directory is completely free of charge.
            </div>
        </div>
    </div>

    <!-- Additional FAQs -->
    <div class="card">
        <div class="card-header" id="h4">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                    How long does it take for my business listing to be approved?
                </button>
            </h5>
        </div>

        <div id="faq4" class="collapse" aria-labelledby="h4" data-parent="#accordion">
            <div class="card-body">
                Our team typically reviews and approves business listings within 1-2 business days.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h5">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                    Can I edit my business listing after it's been submitted?
                </button>
            </h5>
        </div>

        <div id="faq5" class="collapse" aria-labelledby="h5" data-parent="#accordion">
            <div class="card-body">
                Yes, you can edit your business listing at any time by logging into your account on our website and accessing the edit feature.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h6">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false" aria-controls="faq6">
                    Are there any restrictions on the content of business listings?
                </button>
            </h5>
        </div>

        <div id="faq6" class="collapse" aria-labelledby="h6" data-parent="#accordion">
            <div class="card-body">
                We have guidelines in place to ensure that all listings are appropriate and accurate. Please refer to our <a href="/terms-of-service">terms of service</a> for more information.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h7">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false" aria-controls="faq7">
                    How can users search for businesses in your directory?
                </button>
            </h5>
        </div>

        <div id="faq7" class="collapse" aria-labelledby="h7" data-parent="#accordion">
            <div class="card-body">
                Users can search for businesses by category, location, or keywords using our search functionality.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h8">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq8" aria-expanded="false" aria-controls="faq8">
                    Can users leave reviews for businesses on your directory?
                </button>
            </h5>
        </div>

        <div id="faq8" class="collapse" aria-labelledby="h8" data-parent="#accordion">
            <div class="card-body">
                Yes, registered users can leave reviews and ratings for businesses listed on our directory.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h9">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq9" aria-expanded="false" aria-controls="faq9">
                    How do I contact a business listed on your directory?
                </button>
            </h5>
        </div>

        <div id="faq9" class="collapse" aria-labelledby="h9" data-parent="#accordion">
            <div class="card-body">
                Contact information for each business is provided in their respective listings. You can reach out to them directly using the provided contact details.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h10">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq10" aria-expanded="false" aria-controls="faq10">
                    Do you offer any advertising opportunities for businesses?
                </button>
            </h5>
        </div>

        <div id="faq10" class="collapse" aria-labelledby="h10" data-parent="#accordion">
            <div class="card-body">
                Yes, we offer various advertising packages for businesses looking to increase their visibility on our directory. Please contact our advertising department for more information.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h11">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq11" aria-expanded="false" aria-controls="faq11">
                    How often are business listings updated on your directory?
                </button>
            </h5>
        </div>

        <div id="faq11" class="collapse" aria-labelledby="h11" data-parent="#accordion">
            <div class="card-body">
                Business listings are updated regularly to ensure accuracy and relevance.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h12">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq12" aria-expanded="false" aria-controls="faq12">
                    Can businesses add images or videos to their listings?
                </button>
            </h5>
        </div>

        <div id="faq12" class="collapse" aria-labelledby="h12" data-parent="#accordion">
            <div class="card-body">
                Yes, businesses can enhance their listings by adding images, videos, and other multimedia content to showcase their products or services.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h13">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq13" aria-expanded="false" aria-controls="faq13">
                    Are there any benefits to claiming my business listing?
                </button>
            </h5>
        </div>

        <div id="faq13" class="collapse" aria-labelledby="h13" data-parent="#accordion">
            <div class="card-body">
                Claiming your business listing allows you to manage and update your information, respond to reviews, and gain greater visibility on our directory.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h14">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq14" aria-expanded="false" aria-controls="faq14">
                    What if I can't find a specific business in your directory?
                </button>
            </h5>
        </div>

        <div id="faq14" class="collapse" aria-labelledby="h14" data-parent="#accordion">
            <div class="card-body">
                If you can't find a specific business, you can suggest it to be added to our directory by contacting our support team.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="h15">
            <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#faq15" aria-expanded="false" aria-controls="faq15">
                    How can I report inaccurate information in a business listing?
                </button>
            </h5>
        </div>

        <div id="faq15" class="collapse" aria-labelledby="h15" data-parent="#accordion">
            <div class="card-body">
                If you notice any inaccuracies in a business listing, please report it to our support team, and we will investigate and make the necessary corrections.
            </div>
        </div>
    </div>
</div>

                </div>
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
