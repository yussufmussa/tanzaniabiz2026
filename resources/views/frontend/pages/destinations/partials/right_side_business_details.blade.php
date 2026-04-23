<div class="col-lg-4">
    <div class="sidebar mb-0">

        <!-- sponserd ads -->
        @if($adSponsoredDetails)
        <div class="card-item">
            <a href="{{$adSponsoredDetails->link}}" class="card-image d-block">
                <img src="{{asset('photos/ads/'.$adSponsoredDetails->banner)}}" class="card__img" alt="Sponserd ads">
            </a>
        </div><!-- end card-item -->
        @endif
        <!-- sponsed ads -->

        <!-- popular categories -->
        <div class="sidebar-widget">
            <h3 class="widget-title">Popular Tanzania Attractions</h3>
            @foreach($relatedDestinations as $destination)
            <div class="mini-list-card">
                <div class="mini-list-img">
                    <a href="{{route('destination.details', ['slug' => $destination->slug])}}" class="d-block">
                        <img src="{{ asset('photos/destinations/'.$destination->thumbnail) }}" alt="{{$destination->name}}">
                    </a>
                </div><!-- end mini-list-img -->
                <div class="mini-list-body">
                    <h4 class="mini-list-title"><a href="{{route('destination.details', ['slug' => $destination->slug])}}">{{$destination->name}}</a></h4>
                    <div class="star-rating-wrap d-flex align-items-center">
                        <div class="star-rating text-color-5 font-size-16">
                            <span><i class="la la-star"></i></span>
                            <span class="ml-n1"><i class="la la-star"></i></span>
                            <span class="ml-n1"><i class="la la-star"></i></span>
                            <span class="ml-n1"><i class="la la-star"></i></span>
                            <span class="ml-n1"><i class="la la-star"></i></span>
                        </div>
                    </div>
                </div><!-- end mini-list-body -->
            </div><!-- end mini-list-card -->
            @endforeach
        </div><!-- end sidebar-widget -->

    </div><!-- end sidebar -->
</div><!-- end col-lg-4 -->