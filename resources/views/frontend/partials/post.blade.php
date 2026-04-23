<!-- ======================= Blog Start ============================ -->
<section class="space min pt-0">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-4">
                    <h6 class="theme-cl mb-0">latest Posts</h6>
                    <h2 class="ft-bold">Tanzania Biz Blog</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            <!-- Single Item -->
            @foreach($posts as $post)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="gup_blg_grid_box">
                    <div class="gup_blg_grid_thumb">
                        <a href="{{route('post.details', $post->slug)}}"><img src="{{asset('photos/posts/'.$post->thumbnail)}}" class="img-fluid"  alt="{{ $post->title }}" width="640" height="200"></a>
                    </div>
                    <div class="gup_blg_grid_caption">
                        <div class="blg_title">
                            <h4><a href="{{route('post.details', $post->slug)}}">{{$post->title}}</a></h4>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>



    </div>
</section>
<!-- ======================= Blog Start ============================ -->
