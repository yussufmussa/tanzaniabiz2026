<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">

    <div class="bg-white rounded mb-4">

        <div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
            <h4 class="ft-medium fs-lg mb-0">Search Filter</h4>
            <div class="ssh-header">
                <a href="javascript:void(0);" class="clear_all ft-medium text-muted">Clear All</a>
                <a href="#search_open" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed _filter-ico ml-2"><i class="lni lni-text-align-right"></i></a>
            </div>
        </div>

        <!-- Find New Property -->
        <div class="sidebar-widgets collapse miz_show" id="search_open" data-bs-parent="#search_open">
            <div class="search-inner">

                <div class="side-filter-box">
                    <div class="side-filter-box-body">
                        <!-- Suggested -->
                        <div class="inner_widget_link">
                            <h6 class="ft-medium">Related Categories</h6>
                            <ul class="no-ul-list filter-list">
                                @if($category)
                                @foreach($category->subcategories->sortBy('name') as $key => $sub)
                                <li>
                                    <input wire:model="selectedCategories" id="C{{$key}}" class="checkbox-custom" name="{{$sub->name}}" type="checkbox" value="{{$sub->id}}">
                                    <label for="C{{$key}}" class="checkbox-custom-label">{{$sub->name}} {{$sub->listings->count()}}</label>
                                </li>
                                @endforeach
                                @endif

                                @if($subcategory)
                                @foreach($subcategory->category->subcategories as $key => $sub)
                                <li>
                                    <input wire:model="selectedCategories" id="Cat{{$key}}" class="checkbox-custom" name="{{$subcategory->category->name}}" type="checkbox" value{{$sub->id}}>
                                    <label for="Cat{{$key}}" class="checkbox-custom-label">{{$sub->name}} {{$sub->listings->count()}}</label>
                                </li>
                                @endforeach

                                @endif


                            </ul>
                        </div>

                        <!-- Filter By city -->
                        <div class="inner_widget_link">
                            <h6 class="ft-medium">Filter By City</h6>
                            <ul class="no-ul-list filter-list">
                                @foreach($top_cities as $key => $top)
                                <li>
                                    <input wire:model="selectedCities" id="{{$key}}" class="checkbox-custom" name="{{$top->city_name}}" type="checkbox" value="{{$top->id}}">
                                    <label for="{{$key}}" class="checkbox-custom-label">{{$top->city_name}} {{$top->listings->count()}}</label>
                                </li>
                                @endforeach


                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
