<div class="row margin-bottom-50px">
    <div class="col-lg-12">
        <h3 class="widget-title font-size-24 pb-4">Related Posts</h3>
    </div><!-- end col-lg-12 -->
    @foreach($relatedPosts as $post)
    <div class="col-lg-6 responsive-column">
        <div class="card-item card-item-layout-2">
            <div class="card-image">
                <a href="{{ route('post.details', ['slug' => $post->slug]) }}" class="d-block">
                    <img src="{{ asset('photos/posts/'.$post->thumbnail ) }}" data-src="{{ asset('photos/posts/'.$post->thumbnail ) }}" class="card__img lazy" alt="{{$post->title}}" height="300px">
                </a>

            </div><!-- end card-image -->
            <div class="card-content">
                <a href="#" class="user-thumb d-inline-block" data-toggle="tooltip" data-placement="top" title="utalii directory">
                    <img src="{{ asset('photos/general/'.$setting->first()->favicon) }}" alt="utalii directory">
                </a>
                <h4 class="card-title pt-2">
                    <a href="{{ route('post.details', ['slug' => $post->slug]) }}">{{$post->title}}</a>
                </h4>
            </div><!-- end card-content -->
        </div><!-- end card-item -->
    </div><!-- end col-lg-4 -->
    @endforeach
</div><!-- end row -->