<div class="col-lg-4">
    <div class="sidebar mb-0">
        <div class="sidebar-widget">
            <h3 class="widget-title">Filter by City</h3>
            <div class="stroke-shape mb-4"></div>
            <div class="checkbox-wrap">
                <ul>
                    @foreach ($top_cities as $top)
                    <li>
                        <a href="{{ route('filter.category.city', ['categorySlug' => $category->slug, 'citySlug' => $top->slug]) }}"> {{$top->city_name}} - <span class="badge badge-info">
                            @if($top->listings_count > 1000)
                            {{number_format($top->listings_count / 1000, 1) . 'k'}}
                            @else
                            {{ $top->listings_count }}
                            @endif
                            
                        </span> </a>
                    </li>
                    @endforeach

                </ul>
            </div>
        </div><!-- end sidebar-widget -->

    </div><!-- end sidebar -->
</div><!-- end col-lg-4 -->