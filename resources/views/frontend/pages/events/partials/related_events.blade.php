<!-- ============================ Top Author Lists ============================= -->
<section class="space min pt-0">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h6 class="mb-0 theme-cl">Similar Upcomming Events</h6>
                    <h2 class="ft-bold">Browse</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">

            <!-- Single Jobs -->
            @foreach($relatedEvents as $event)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="Goodup-grid-wrap">
                            <div class="Goodup-grid-upper">
                                <div class="Goodup-pos ab-right">
                                    <div class="Goodup-featured-tag">Upcomming</div>
                                </div>
                                <div class="Goodup-grid-thumb">
                                    <a href="{{route('event.details', $event->slug)}}" class="d-block text-center m-auto"><img src="{{ asset('photos/events/'.$event->banner)}}" class="img-fluid" alt="{{$event->title}}"></a>
                                </div>
                            </div>
                            <div class="Goodup-grid-fl-wrap">
                                <div class="Goodup-caption px-3 py-2">
                                    <h4 class="mb-0 ft-medium medium mb-0"><a href="{{route('event.details', $event->slug)}}" class="text-dark fs-md">{{ $event->title }}<span class="verified-badge"><i class="fas fa-check-circle"></i></span></a></h4>
                                    <div class="Goodup-distance">{{ $event->place }}</div>
                                    <div class="Goodup-middle-caption mt-3">
                                        <div class="Goodup-facilities-wrap Goodup-flx mb-0">
                                            <div class="Goodup-facility-list">
                                                <ul class="no-list-style">
                                                    <li>Date: <i class="fas fa-date"></i>{{$event->starting_date}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="Goodup-booking-button">
                                            <a href="{{route('event.details', $event->slug)}}" class="Goodup-btn-book">More info</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach


        </div>

    </div>
</section>
<!-- ============================ Top Author Lists ============================= -->