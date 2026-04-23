<!-- ======================= Listing Categories ======================== -->
<section class="space min gray">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h2 class="ft-bold">Top Business Categories</h2>
                </div>
            </div>
        </div>

        <!-- Horizontal scrollable row -->
            <div class="row ">
                @foreach($categories as $key => $category)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6  col-6">
                        <div class="cats-wrap text-center">
                            <a href="{{ route('filter.category', $category->slug) }}" class="Goodup-catg-wrap">
                                <div class="Goodup-catg-icon"><i class="{{ $category->icon }}"></i></div>
                                <div class="Goodup-catg-caption">
                                    <h4 class="fs-md mb-0 ft-medium m-catrio">{{ $category->name }}</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    @if($key == 4)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="cats-wrap text-center">
                                <a href="/browse-business-by-category" class="Goodup-catg-wrap">
                                    <div class="Goodup-catg-icon"><i class="fas fa-th-list"></i></div>
                                    <div class="Goodup-catg-caption">
                                        <h4 class="fs-md mb-0 ft-medium m-catrio">All Categories</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @break
                    @endif
                @endforeach
            </div>
        <!-- row -->

    </div>
</section>

<!-- ======================= Listing Categories End ======================== -->
