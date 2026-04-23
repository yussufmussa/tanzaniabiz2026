<!-- ======================= Home Banner ======================== -->
<div class="home-banner" data-overlay="4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="banner_caption text-center" style="margin-top: -30px !important;">
                    <h1 class="banner_title ft-bold mb-1">Business Directory in Tanzania</h1>
                    <p class="fs-md ft-medium mb-3">Find local businesses. Search by category and city.</p>

                    {{-- small trust line (no new theme classes) --}}
                    <div class="mb-3 text-light small">
                        {{ number_format($totalListings ?? 0) }} businesses • Free to list
                    </div>
                </div>

                <form class="main-search-wrap fl-wrap" method="get" action="{{ route('business.search') }}">
                    <div class="row">

                        <div class="main-search-item">
                            <span class="search-tag">Find</span>
                            <input class="form-control"
                                   type="text"
                                   name="keywords"
                                   placeholder="Business name or service"
                                   value="{{ request('keywords') }}">
                        </div>

                        {{-- Category dropdown --}}
                        <div class="main-search-item">
                            <span class="search-tag">Category</span>
                            <select name="category_id" class="form-control">
                                <option value="">All categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- City dropdown --}}
                        <div class="main-search-item">
                            <span class="search-tag">Where</span>
                            <select name="city_id" class="form-control">
                                <option value="">All cities</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c->id }}" @selected(request('city_id') == $c->id)>
                                        {{ $c->city_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="main-search-button">
                        <button class="btn full-width theme-bg text-white" type="submit">
                            Search <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- ======================= Home Banner ======================== -->