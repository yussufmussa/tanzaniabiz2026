<div class="col-lg-3 col-md-12 col-sm-12 col-12">

    <!-- Categories -->
    <div class="single_widgets widget_category">
        <h4 class="title">Categories</h4>
         <ul>
            @foreach($categories as $category)
            <li><a href="{{route('posts.byCategory', $category->slug)}}">{{$category->name}} <span>{{$category->posts_count}}</span></a></li>
            @endforeach
        </ul>
    </div>

    <!-- Trending Posts -->
    <div class="single_widgets widget_thumb_post">
        <h4 class="title">Trending Posts</h4>
        <ul>
            @foreach ($relatedPosts as $post)
            <li>
                <span class="left">
                   <img src="{{ asset('uploads/posts/thumbnails/' . $post->thumbnail) }}" alt="{{ $post->name }}">
                </span>
                <span class="right">
                    <a class="feed-title" href="{{route('post.details', $post->slug)}}">{{$post->title}}</a>
                    <span class="post-date"><i class="ti-calendar"></i>{{$post->created_at->diffForHumans()}}</span>
                </span>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Tags Cloud -->
    <div class="single_widgets widget_tags">
        <h4 class="title">Tags</h4>
        <ul>
            @foreach($post->postTags as $tag)
            <li><a href="{{route('posts.byTag', $tag->slug)}}">{{$tag->name}}</a></li>
            @endforeach
        </ul>
    </div>

</div>
