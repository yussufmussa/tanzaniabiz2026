<div class="col-lg-4">

                <div class="sidebar mb-0 ">
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Tour Summary</h3>
                        <div class="stroke-shape mb-4"></div>
                        <ul class="list-items list-items-style-2">
                            <li><span class="text-color mr-1"><i class="la la-clock mr-2 text-color-2 font-size-18"></i>Cancellation:</span> {{$data['cancellationPolicy']['description']}}</li>
                            <li><span class="text-color mr-1"><i class="la la-glass mr-2 text-color-2 font-size-18"></i>Confirmation:</span> {{$data['bookingConfirmationSettings']['confirmationType']}}</li>
                        </ul>
                        <a href="{{$data['productUrl']}}" class="theme-btn gradient-btn w-100 mt-3">Book Now<i class="la la-arrow-right ml-2"></i></a>
                    </div><!-- end sidebar-widget -->
                </div><!-- end sidebar-widget -->

                <div class="sidebar-widget">
                    <h3 class="widget-title">Popular Attractions</h3>
                    @foreach($popularDestinations as $destination)
                    <div class="mini-list-card">
                        <div class="mini-list-img">
                            <a href="{{route('destination.details', ['slug' => $destination['slug']])}}" class="d-block">
                                <img src="{{ asset('photos/destinations/'.$destination['thumbnail']) }}" alt="similar listing image">
                            </a>
                        </div><!-- end mini-list-img -->
                        <div class="mini-list-body">
                            <h4 class="mini-list-title"><a href="{{route('destination.details', ['slug' => $destination['slug']])}}">{{$destination['name']}}</a></h4>
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