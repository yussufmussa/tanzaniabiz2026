@extends('frontend.layouts.base')
@section('title', 'Tanzania Events In - ' . date('Y'))
@section('description', 'A list of comming events in Tanzania')
@section('keywords', 'Tanzania events, dar es salaam events, events in Tanzania')

@push('extra_style')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
        },
    ]
}
</script>
@endpush

@section('contents')
    {{-- Breadcrumb --}}
    <div class="container">
        <div class="row mb-2">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $pageTitle ?? 'Jobs' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    </div>


    <section class="gray py-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">

                    <!-- row -->
                    <div class="row justify-content-center gx-3">

                        <!-- Single -->
                        @foreach ($events as $event)
    @php
        $img = $event->thumbnail
            ? asset('uploads/businessEvents/thumbnails/' . $event->thumbnail)
            : asset('uploads/general/event_placeholder.png');

        $startDate = \Carbon\Carbon::parse($event->starting_date);
        $endDate   = \Carbon\Carbon::parse($event->closing_date);

        // If your starting_time/ending_time are stored as "H:i" -> this works.
        // If they sometimes store full datetime -> we parse and format to H:i.
        $startTime = $event->starting_time ? \Carbon\Carbon::parse($event->starting_time)->format('H:i') : null;
        $endTime   = $event->ending_time ? \Carbon\Carbon::parse($event->ending_time)->format('H:i') : null;

        $today = now()->startOfDay();
        $isEnded = $endDate->lt($today);
        $isToday = $startDate->isSameDay($today);
        $isUpcoming = !$isEnded;

        if ($isEnded) {
            $badgeText = 'Ended';
            $badgeClass = 'bg-secondary';
        } elseif ($isToday) {
            $badgeText = 'Happening today';
            $badgeClass = 'bg-warning text-dark';
        } else {
            $badgeText = 'Upcoming';
            $badgeClass = 'bg-success';
        }

        $dateLabel = $startDate->format('d M Y');
        if (!$startDate->isSameDay($endDate)) {
            $dateLabel .= ' - ' . $endDate->format('d M Y');
        }

        $timeLabel = null;
        if ($startTime && $endTime) $timeLabel = "{$startTime} - {$endTime}";
        elseif ($startTime) $timeLabel = $startTime;
    @endphp

    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="Goodup-grid-wrap">

            <div class="Goodup-grid-upper position-relative">
                <div class="Goodup-pos ab-right">
                    <div class="Goodup-featured-tag {{ $badgeClass }}">
                        {{ $badgeText }}
                    </div>
                </div>

                <div class="Goodup-grid-thumb">
                    <a href="{{ route('event.detail', $event->slug) }}" class="d-block text-center m-auto">
                        <img src="{{ $img }}" class="img-fluid" alt="{{ $event->title }}">
                    </a>
                </div>
            </div>

            <div class="Goodup-grid-fl-wrap">
                <div class="Goodup-caption px-3 py-3">
                    <h4 class="ft-medium mb-1">
                        <a href="{{ route('event.detail', $event->slug) }}" class="text-dark fs-md">
                            {{ \Illuminate\Support\Str::limit($event->title, 55) }}
                        </a>
                    </h4>

                    <div class="text-muted small mb-2">
                        <i class="lni lni-map-marker me-1"></i>
                        {{ $event->event_loction }}
                    </div>

                    {{-- Clean metadata (2 lines max) --}}
                    <div class="d-flex flex-wrap gap-3 small text-muted">
                        <div>
                            <i class="lni lni-calendar me-1"></i>{{ $dateLabel }}
                        </div>

                        @if($timeLabel)
                            <div>
                                <i class="lni lni-timer me-1"></i>{{ $timeLabel }}
                            </div>
                        @endif
                    </div>

                    <div class="Goodup-booking-button mt-3">
                        <a href="{{ route('event.detail', $event->slug) }}" class="Goodup-btn-book">
                            More info
                        </a>

                        @if($isEnded)
                            <span class="ms-2 small text-muted">This event ended</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('extra_js_script')

@endsection
