<!-- ======================= All category ======================== -->
<section class="space min">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h2 class="ft-bold">Latest Verified <span class="theme-cl">Business</span></h2>
                </div>
            </div>
        </div>

        <!-- row -->
        <div class="row justify-content-center" id="listingNormal">
            @foreach($listings as $listing)
            <div class="col-xl-3 col-lg-4 col-md-6">
            @include('frontend.pages.listings.thelist')
            </div>
            @endforeach
        </div>

        <div id="mobileCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @for($j = 0; $j < 8; $j+=2)
            <div class="carousel-item @if($j == 0) active @endif">
                <div class="row">
                    <div class="col-12">
                        @if(isset($listings[$j]))
                            @include('frontend.pages.listings.thelist', ['listing' => $listings[$j]])
                        @endif
                    </div>
                    <div class="col-12">
                        @if(isset($listings[$j + 1]))
                            @include('frontend.pages.listings.thelist', ['listing' => $listings[$j + 1]])
                        @endif
                    </div>
                </div>
            </div>
        @endfor
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mobileCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mobileCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>



    </div>
</section>
<!-- ======================= All Listings ======================== -->
