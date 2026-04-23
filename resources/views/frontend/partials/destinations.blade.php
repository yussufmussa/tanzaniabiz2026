<!-- ================================
    START CAT AREA
================================= -->
<section class="cat-area position-relative section--padding overflow-hidden bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <div class="section-badge pb-3">
                        <span class="ribbon ribbon-2 bg-2 text-white">Explore</span>
                    </div>
                    <h1 class="sec__title">Popular Tanzania Attractions</h1>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="row">
                    @foreach($destinations as $destination)
                    <div class="col-lg-3 responsive-column">
                        <div class="category-item category-item-layout-2 category-item-layout--2 js-tilt-2 ">
                            <img src="{{ asset('photos/destinations/'.$destination->thumbnail) }}" data-src="{{ asset('photos/destinations/'.$destination->thumbnail) }}" alt="category-image" class="cat-img lazy cat-img-height">
                            <div class="category-content">
                                <a href="{{route('destination.details',['slug' => $destination->slug])}}" class="category-link d-flex align-items-end w-100 h-100 text-left">
                                    <div class="category-content-inner d-flex align-items-center justify-content-between">
                                        <div>
                                            <h4 class="cat__title mb-1">{{ $destination->name }}</h4>

                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div><!-- end category-item -->
                    </div><!-- end col-lg-6 -->
                    @endforeach
                </div><!-- end row -->
            </div><!-- end col-lg-7 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end cat-area -->
<!-- ================================
    END CAT AREA
================================= -->