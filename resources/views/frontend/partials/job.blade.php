<!-- ============================ Top Author Lists ============================= -->
@if(count($jobs) > 0)
<section class="space min pt-0">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h2 class="ft-bold">Latest Job  Opportunities in Tanzania</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">

            <!-- Single Jobs -->
            @foreach($jobs as $job)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="_jb_list72">
                    <div class="_jb_list72_flex">
                        <div class="_jb_list72_last">
                            <h4 class="_jb_title"><a href="{{route('job.details', ['slug' => $job->slug])}}">{{$job->title}}</a></h4>
                            <div class="_times_jb">{{$job->jobsector->name}}</div>
                            <div class="_jb_types fulltime_lite">{{$job->jobtype->name}}</div>
                        </div>
                    </div>
                    <div class="_jb_list72_foot">
                    <div class="_times_jb">{{ \Carbon\Carbon::parse($job->deadline)->format('d/n/Y') }}</div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="position-relative text-center">
                    <a href="/jobs" class="btn gray rounded ft-medium">View All Jobs<i class="lni lni-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>

    </div>
</section>
@endif
<!-- ============================ Top Author Lists ============================= -->
