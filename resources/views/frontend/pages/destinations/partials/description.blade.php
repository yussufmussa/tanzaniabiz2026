<div class="block-card mb-4">
    <div class="block-card-header">
        <h2 class="widget-title">About {{$destination->name}}</h2>
        <div class="stroke-shape"></div>
    </div><!-- end block-card-header -->
    <div class="block-card-body">

        <div class="font-weight-medium line-height-30 pb-3 description-container">
            <img src="{{asset('photos/destinations/'.$destination->thumbnail)}}" alt="" class="img-fluid">
            <p>
                {!! $destination->description !!}
            </p>
        </div>

    </div><!-- end block-card-body -->
</div><!-- end block-card -->