<div class="main-search-input">
    <div class="main-search-input-item">
        <form action="{{route('listings.search')}}" class="form-box" method="post">@csrf
            <div class="form-group mb-0">
                <span class="la la-search form-icon"></span>
                <input class="form-control @error('keywords') is-invalid @enderror" type="text" name="keywords" placeholder="What are you looking for?">
                @error('keywords')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

    </div><!-- end main-search-input-item -->
    <div class="main-search-input-item user-chosen-select-container">
        <select class="user-chosen-select" name="city_id">
            <option value="">Location</option>
            @foreach ($cities as $location )
            <option value="{{$location->id}}">{{$location->city_name}}</option>
            @endforeach
        </select>
        @error('city_id')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div><!-- end main-search-input-item -->
    <div class="main-search-input-item user-chosen-select-container">
        <select class="user-chosen-select" name="category_id">
            <option value="">Select a Category</option>
            @foreach ($allCategories as $category )
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        @error('category_id')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div><!-- end main-search-input-item -->
    <div class="main-search-input-item">
        <button class="theme-btn gradient-btn border-0 w-100" type="submit"><i class="la la-search mr-2"></i>Search</button>
    </div><!-- end main-search-input-item -->
    </form>
</div><!-- end main-search-input -->