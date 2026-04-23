<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Jobs\PostJob;
use Illuminate\Http\Request;

class JobPageController extends Controller
{
    public function jobDetail(string $slug)
    {
        $job = PostJob::with(['jobSector', 'jobType', 'user'])
            ->where('slug', $slug)->firstOrFail();

        $business = $job->user
            ? $job->user->businessListings()
            ->oldest()
            ->with('city:id,city_name')
            ->select('id', 'user_id', 'city_id', 'name', 'slug', 'logo')
            ->first()
            : null;

        $jobSector = $job->jobSector;
        $jobType = $job->jobType;
        $jobCity = $job->city;

        $moreJobs = PostJob::query()
            ->whereDate('job_closing_date', '>=', now()->toDateString())
            ->where('id', '!=', $job->id)
            ->orderBy('job_opening_date')
            ->limit(6)
            ->get();


        return view('frontend.pages.jobs.details', compact('job', 'business', 'jobSector', 'jobType', 'jobCity', 'moreJobs'));
    }

    public function allJobs()
    {
        return view('frontend.pages.jobs.all', [
            'pageTitle' => 'Jobs in Tanzania',
        ]);
    }

    public function jobsBySector(string $slug)
    {
        return view('frontend.pages.jobs.all', [
            'pageTitle' => 'Jobs in ' . str_replace('-', ' ', $slug),
            'presetSectorSlug' => $slug,
        ]);
    }
    public function jobsByType(string $slug)
    {
        return view('frontend.pages.jobs.all', [
            'pageTitle' => 'Jobs: ' . str_replace('-', ' ', $slug),
            'presetTypeSlug' => $slug,
        ]);
    }
    public function jobsByCity(string $slug)
    {
        return view('frontend.pages.jobs.all', [
            'pageTitle' => 'Jobs in ' . str_replace('-', ' ', $slug),
            'presetCitySlug' => $slug,
        ]);
    }
}
