<div class="sidebar-widget">
    <h3 class="widget-title">Filter by Category</h3>
    <div class="stroke-shape mb-4"></div>
    <div class="checkbox-wrap">
        <ul>
            @foreach ($top_categories as $top)
            <li> <a id="filter-by-city" href="{{ route('filter.category', ['slug' => $top->slug]) }}"> {{$top->name}} - <span class="badge badge-success">
            @if($top->listings_count > 1000)
                {{ number_format($top->listings_count / 1000, 1) . 'k' }}
                @else
                {{$top->listings_count}}
                @endif
            </span> </a></li>
            @endforeach
        </ul>
    </div>
</div><!-- end sidebar-widget -->