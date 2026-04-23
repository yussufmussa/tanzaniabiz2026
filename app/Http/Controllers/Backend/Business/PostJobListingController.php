<?php

namespace App\Http\Controllers\Backend\Business;

use App\Http\Controllers\Controller;
use App\Models\Business\City;
use App\Models\Jobs\JobSector;
use App\Models\Jobs\JobType;
use App\Models\Jobs\PostJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostJobListingController extends Controller
{
   private function isAdmin(): bool
    {
        $user = auth()->user();

        // Pick ONE style depending on your project:
        // 1) Spatie:
        return $user?->hasRole('admin') ?? false;

        // 2) If you use a simple column:
        // return ($user?->role === 'admin');
    }

    private function viewPath(string $view): string
    {
        return $this->isAdmin()
            ? "backend.job_posts.$view"
            : "frontend.business_owner.jobs.$view";
    }

    private function baseData(): array
    {
        return [
            'jobsectors' => JobSector::orderBy('name')->get(),
            'jobtypes'   => JobType::orderBy('name')->get(),
            'cities'     => City::orderBy('city_name')->get(),
        ];
    }

    public function index()
    {
        $query = PostJob::with(['jobSector', 'jobType', 'city'])->latest();

        // non-admin sees only own jobs
        if (! $this->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $jobs = $query->paginate();

        return view($this->viewPath('index'));
    }

    public function create()
    {
        return view($this->viewPath('create'), $this->baseData());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255', 'unique:post_jobs,title'],
            'job_sector_id'    => ['required', 'exists:job_sectors,id'],
            'job_type_id'      => ['required', 'exists:job_types,id'],
            'city_id'          => ['required', 'exists:cities,id'],
            'no_to_employed'   => ['required', 'integer'],
            'description'      => ['required', 'string'],
            'job_opening_date' => ['date', 'required', 'after_or_equal:today'],
            'job_closing_date' => ['date', 'required', 'after_or_equal:job_opening_date'],
        ], [
            'job_sector_id.required' => 'Please select job sector',
            'job_sector_id.exists'   => 'Please select valid job sector',
            'job_type_id.required'   => 'Please select job type',
            'job_type_id.exists'     => 'Please select a valid job type',
            'no_to_employed.required'=> 'Please enter number of people to be employed',
            'no_to_employed.integer' => 'People to be employed must be a number',
        ]);

        $job = new PostJob();
        $job->job_sector_id    = $validated['job_sector_id'];
        $job->job_type_id      = $validated['job_type_id'];
        $job->city_id          = $validated['city_id'];
        $job->user_id          = auth()->id();
        $job->title            = $validated['title'];
        $job->no_to_employed   = $validated['no_to_employed'];
        $job->slug             = Str::slug($validated['title']);
        $job->description      = $validated['description'];
        $job->job_opening_date = $validated['job_opening_date'];
        $job->job_closing_date = $validated['job_closing_date'];
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Job posted successfully.');
    }

    public function edit(PostJob $job)
    {
        // non-admin can only edit own job
        if (! $this->isAdmin() && $job->user_id !== auth()->id()) {
            abort(403);
        }

        return view($this->viewPath('edit'), array_merge(['job' => $job], $this->baseData()));
    }

    public function update(Request $request, PostJob $job)
    {
        if (! $this->isAdmin() && $job->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('post_jobs', 'title')->ignore($job->id),
            ],
            'job_sector_id'    => ['required', 'exists:job_sectors,id'],
            'job_type_id'      => ['required', 'exists:job_types,id'],
            'city_id'          => ['required', 'exists:cities,id'],
            'no_to_employed'   => ['required', 'integer'],
            'description'      => ['required', 'string'],
            'job_opening_date' => ['date', 'required', 'after_or_equal:today'],
            'job_closing_date' => ['date', 'required', 'after_or_equal:job_opening_date'],
        ], [
            'job_sector_id.required' => 'Please select job sector',
            'job_sector_id.exists'   => 'Please select valid job sector',
            'job_type_id.required'   => 'Please select job type',
            'job_type_id.exists'     => 'Please select a valid job type',
            'no_to_employed.required'=> 'Please enter number of people to be employed',
            'no_to_employed.integer' => 'People to be employed must be a number',
        ]);

        $job->job_sector_id    = $validated['job_sector_id'];
        $job->job_type_id      = $validated['job_type_id'];
        $job->city_id          = $validated['city_id'];
        $job->title            = $validated['title'];
        $job->no_to_employed   = $validated['no_to_employed'];
        $job->slug             = Str::slug($validated['title']);
        $job->description      = $validated['description'];
        $job->job_opening_date = $validated['job_opening_date'];
        $job->job_closing_date = $validated['job_closing_date'];
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(PostJob $job)
    {
        if (! $this->isAdmin() && $job->user_id !== auth()->id()) {
            abort(403);
        }

        $job->delete();

        return redirect()->back()->with('success', 'Job deleted successfully.');
    }
}
