    <div class="_jb_list72">
        <div class="_jb_list72_flex">
            <div class="_jb_list72_first">
                <div class="_jb_list72_yhumb">
                    <img src="{{asset('uploads/businessListings/logos/'.$listing->logo)}}" loading="lazy" decoding="async" class="img-fluid" alt="{{$listing->name}}">
                </div>
            </div>
            <div class="_jb_list72_last">
                <h4 class="_jb_title"><a href="{{route('listing.details',$listing->slug)}}"> {{$listing->name}} <span class="verified-badge"><i class="fas fa-check-circle"></i></span></a></h4>
                <div class="_times_jb"><i class="fas fa-map-marker-alt"></i> {{$listing->city->city_name}}</div>
                <div class="_times_jb"><i class="fas fa-phone"></i> {{$listing->category->name}}</div>
            </div>
        </div>
    </div>

