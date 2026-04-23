<!-- ============================ Top Author Lists ============================= -->
<section class="space min pt-0 mt-3">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h2 class="ft-bold">Browse More Jobs</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- Single Jobs -->
            @foreach($moreJobs as $job)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="_jb_list72">
                    <div class="_jb_list72_flex">
                        <div class="_jb_list72_last">
                            <h4 class="_jb_title"><a href="{{route('job.details', ['slug' => $job->slug])}}">{{$job->title}}</a></h4>
                            <div class="_times_jb">{{$job->jobSector->name}}</div>
                            <div class="_jb_types fulltime_lite">{{$job->jobType->name}}</div>
                        </div>
                    </div>
                    <div class="_jb_list72_foot">
                    <div class="_times_jb">{{ \Carbon\Carbon::parse($job->job_closing_date)->format('d/n/Y') }}</div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>

    </div>
</section>
<!-- ============================ Top Author Lists ============================= -->