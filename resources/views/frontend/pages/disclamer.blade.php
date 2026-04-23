@extends('frontend.layouts.base')
@section('title', 'Disclamer')
@push('extra_style')
<style>
    ul p{
        font-size:18px;
    }
</style>
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
                        <li class="breadcrumb-item active theme-cl" aria-current="page">Disclamer</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->
<!-- ======================= Why choose Us======================== -->
<section class="space min">
    <div class="container">



        <div class="row align-items-center">

            <h1>Disclamer</h1>
            <p>
            Welcome to the Tanzania Biz website (“the Website”). Your access to and use of the Website are subject to the following disclaimer. Please review this disclaimer carefully before using the Website.
            </p>
            <ul>
                <li>
                    <p><strong>Informatin Accuracy:</strong> The content provided on the Website is intended for general informational purposes only. Although we strive to maintain the accuracy and timeliness of the information, we do not make any warranties or representations, express or implied, regarding the completeness, accuracy, reliability, suitability, or availability of the information contained on the Website.</p>
                </li>
                <li>
                    <p><strong>Business Listings:</strong> Listing businesses on our directory does not constitute an endorsement or recommendation by Pakistan Business & Classified Directory. We encourage users to independently verify the accuracy of the information provided, conduct reference checks, and make informed decisions before engaging in any business transactions with the listed entities.</p>
                </li>
                <li>
                    <p><strong>Third Party Link:</strong> he Website may contain links to third-party websites or services that are not under the control of Pakistan Business & Classified Directory. We do not endorse or assume responsibility for the content, privacy policies, or practices of any third-party websites or services. Users acknowledge and agree that Pakistan Business & Classified Directory shall not be liable for any damages or losses arising from or related to the use of such third-party content, goods, or services.</p>
                </li>
                <li>
                    <p><strong>User Generated Content:</strong> Users may contribute content, such as reviews or comments, to the Website. Pakistan Business & Classified Directory does not endorse, support, or guarantee the accuracy of user-generated content. Users are solely responsible for the content they submit, and by doing so, grant Pakistan Business & Classified Directory the right to use, reproduce, modify, adapt, publish, translate, create derivative works, distribute, and display such content worldwide in any media.</p>
                </li>
                <li>
                    <p><strong>Changes to the Disclaimer:</strong>  Tanzania Biz website directory reserves the right to amend or replace this disclaimer at any time. Users are responsible for periodically reviewing this disclaimer for updates. Continued use of or access to the Website after changes to this disclaimer are posted constitutes acceptance of those changes.</p>
                </li>
                <li>
                    <p>
                    By accessing and using the Pakistan Business & Classified Directory website, you acknowledge that you have read, understood, and agreed to the terms and conditions outlined in this disclaimer. If you do not agree with these terms, please refrain from using the Website.
                    </p>
                </li>
            </ul>



        </div>
    </div>
</section>
<!-- ======================= Why choose us ======================= -->

@include('frontend.partials.cta')

@endsection
