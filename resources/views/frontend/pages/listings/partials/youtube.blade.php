{{-- 4. Products --}}
@if ($business->youtube_video_link)
<div class="bg-white rounded mb-4">
    <div class="jbd-01 px-4 py-4">
        <div class="jbd-details">
            <h5 class="ft-bold fs-lg">Youtube</h5>
            <div class="d-block mt-3">
                <div class="row g-3">
                    <iframe width="560" height="315" src="{{$business->youtube_video_link}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endif