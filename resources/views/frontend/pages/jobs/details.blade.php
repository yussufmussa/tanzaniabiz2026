@extends('frontend.layouts.base')
@section('title', $job->title)

@push('extra_style')

<!-- Facebook Card -->
<meta property="og:url" content="{{ route('job.detail', $job->slug) }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $job->title }}">
<meta property="og:description" content="Current job opportunities in Tanzania job market">
<meta property="og:image" content="https://tanzaniabiz.com/photos/general/{{$setting->logo}}">
<!-- End facebook card -->

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="{{ route('job.detail', $job->slug) }}">
<meta property="twitter:url" content="{{ route('job.detail', $job->slug) }}">
<meta name="twitter:title" content="{{ $job->title }}">
<meta name="twitter:description" content="Current job opportunities in Tanzania job market">
<meta name="twitter:image" content="https://tanzaniabiz.com/photos/general/{{$setting->logo}}">
<!-- End twitter Card -->

<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@type": "JobPosting",
  "title": "{{$job->title}}",
  "description": "{{ strip_tags($job->description) }}",
  "identifier": {
    "@type": "PropertyValue",
    "name": "{{$business->name}}",
    "value": "{{$business->id}}"
  },
  "hiringOrganization" : {
    "@type": "Organization",
    "name": "{{$business->name}}",
    "sameAs": "{{route('listing.details', $business->slug)}}",
    "logo": "https://tanzaniabiz.com/uploads/businessListings/logos/{{$business->logo}}"
  },
  "industry": "{{$jobSector->name}}",
  "datePosted": "{{$job->created_at->format('Y-m-d')}}",
  "validThrough": "{{$job->job_closing_date->format('Y-m-d')}}",
  "jobLocation": {
    "@type": "Place",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "{{$job->city->city_name}}",
      "addressLocality": "{{$job->city->city_name}}",
      "postalCode": "0000",
      "addressCountry": "TZ"
    }
  }
}
</script>
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
        {
            "@type": "ListItem",
            "position": 2,
            "name": "{{ $jobSector->name }}",
            "item": "{{ route('jobs.by.sector', $job->jobSector->slug) }}"
        },
    ]
}
</script>
@endpush


@section('contents')

 <!-- ============================ Listing Details Start ================================== -->
    <section class="gray py-1 position-relative">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="row mb-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('jobs.by.sector', $job->jobSector->slug) }}">{{ $job->jobSector->name }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $job->title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end BreadCrumb -->

            <div class="row">

                {{-- LEFT COLUMN --}}
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                {{-- About / Description --}}
                <div class="bg-white rounded mb-4">
                    <div class="px-4 py-4">
                        <h5 class="ft-bold fs-lg mb-3">Job Highlights</h5>

                        <div class="d-block">
                           <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Job sector</th>
                                        <td>
                                                <a href="{{ route('jobs.by.sector', $jobSector->slug) }}">{{ $jobSector->name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Job type</th>
                                        <td>
                                                <a href="{{ route('jobs.by.type', $jobType->slug) }}">{{ $jobType->name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td>
                                            @if($jobCity)
                                                <a href="{{ route('jobs.by.city', $jobCity->slug) }}">{{ $jobCity->city_name }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Vacancies</th>
                                        <td>{{ $job->no_to_employed }}</td>
                                    </tr>
                                    <tr>
                                        <th>Opening date</th>
                                        <td>{{ optional($job->job_opening_date)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Closing date</th>
                                        <td>{{ optional($job->job_closing_date)->format('d M Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h5 class="ft-bold fs-lg mb-3 mt-3">Job Description</h5>
                            {!! $job->description !!}
                        </div>
                    </div>
                </div>

                </div>

                {{-- RIGHT COLUMN (sticky sidebar) --}}
                @include('frontend.pages.jobs.partials.right_side')

            </div>
        </div>
    </section>
    <!-- ============================ Listing Details End ================================== -->

    <!-- ======================= Related Job Listings ======================== -->
    @include('frontend.pages.jobs.partials.related_jobs')

@endsection

