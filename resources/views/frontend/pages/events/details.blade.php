@extends('frontend.layouts.base_other_than_homepage')
@section('title', $event->title)

@push('extra_style')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
        },
    ]
}
</script>
@endpush

@section('contents')
<section class="gray py-5 position-relative">
    <div class="container">
        <div class="row">

            <div class="row  mb-3">
                <div class="col-md-4 col-12"><a href="javascript:void(0);" class="adv-btn full-width"><i class="fas fa-clock"></i>Starting Date : {{$event->starting_date}} </a></div>
                <div class="col-md-4 col-12"><a href="javascript:void(0);" class="adv-btn full-width"><i class="fas fa-clock"></i>Ending Date:  {{$event->closing_date}}</a> </div>
                <div class="col-md-4 col-12"><a href="javascript:void(0);" class="adv-btn full-width"><i class="fas fa-globe"></i>Venue:  {{$event->place}}</a></div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center">
                <img src="{{asset('photos/events/'.$event->banner)}}" alt="" class="img-fluid img-thumbnail text-center" height="200px;" width="400px;">

                <!-- About The Business -->
                <div class="bg-white rounded mb-4 text-center">

                    <div class="jbd-01 px-4 py-4">
                        <div class="jbd-details">
                            <h1 class="ft-bold fs-lg">Event Details</h1>

                            <div class="d-block mt-3 text-center">
                                <p>{{$event->details}}</p>

                            </div>
                            <strong>More Details</strong> <a href="{{$event->link}}" target="_blank" rel="noopener">Click Here</a>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Sidebar -->

        </div>
    </div>
</section>
<!-- ============================ Job Details End ================================== -->
<!-- Sidebar -->

</div>
</div>
</section>
<!-- ============================ Job Details End ================================== -->

<!-- ======================= Related Job Listings ======================== -->
@include('frontend.pages.events.partials.related_events')


@endsection

@push('extra_js_script')

@endpush
