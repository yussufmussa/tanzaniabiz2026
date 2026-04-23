<?php

namespace App\Http\Controllers\Backend\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BusinessEventController extends Controller
{
    private function isAdmin(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    private function viewPath(string $view): string
    {
        return $this->isAdmin()
            ? "backend.business_events.$view"
            : "frontend.business_owner.events.$view";
    }

    public function index()
    {
        $query = BusinessEvent::query()->latest();

        // Non-admin sees only own events
        if (! $this->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $events = $query->paginate();

        return view($this->viewPath('index'), compact('events'));
    }

    public function create()
    {
        return view($this->viewPath('create'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => ['required', 'string', 'max:255', 'unique:business_events,title'],
            'slug'              => ['nullable', 'string', 'max:255'],
            'event_description' => ['required', 'string'],
            'event_loction'     => ['required', 'string'],
            'thumbnail'         => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'starting_date'     => ['required', 'date', 'after_or_equal:today'],
            'starting_time'     => ['required', 'date_format:H:i'],
            'ending_time'       => ['required', 'date_format:H:i', 'after_or_equal:starting_time'],
            'closing_date'      => ['required', 'date', 'after_or_equal:starting_date'],
            'link'              => ['nullable', 'url', 'max:2048'],
        ]);

        // slug: use manual if provided, else from title
        $validated['slug'] = $request->filled('slug')
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $manager = new ImageManager(new Driver());

        $thumbnailRename = Str::uuid();
        $thumbnailWebp   = $thumbnailRename . '.webp';

        $image = $manager->read($request->file('thumbnail'));
        $image->toWebp(85)->save(public_path('uploads/businessEvents/thumbnails/' . $thumbnailWebp));

        $validated['thumbnail'] = $thumbnailWebp;
        $validated['user_id']   = Auth::id();

        BusinessEvent::create($validated);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(BusinessEvent $event)
    {
        // Non-admin can only edit own event
        if (! $this->isAdmin() && $event->user_id !== Auth::id()) {
            abort(403);
        }

        return view($this->viewPath('edit'), compact('event'));
    }

    public function update(Request $request, BusinessEvent $event)
    {
        if (! $this->isAdmin() && $event->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'             => ['required', 'string', 'max:255', 'unique:business_events,title,' . $event->id],
            'slug'              => ['nullable', 'string', 'max:255'],
            'event_description' => ['required', 'string'],
            'event_loction'     => ['required', 'string'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'starting_date'     => ['required', 'date', 'after_or_equal:today'],
            'starting_time'     => ['required', 'date_format:H:i'],
            'ending_time'       => ['required', 'date_format:H:i','after_or_equal:starting_time'],
            'closing_date'      => ['required', 'date', 'after_or_equal:starting_date'],
            'link'              => ['nullable', 'url', 'max:2048'],
        ]);

        $validated['slug'] = $request->filled('slug')
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $oldPath = public_path('uploads/businessEvents/thumbnails/' . $event->thumbnail);
            if ($event->thumbnail && file_exists($oldPath)) {
                @unlink($oldPath);
            }

            $manager = new ImageManager(new Driver());

            $thumbnailRename = Str::uuid();
            $thumbnailWebp   = $thumbnailRename . '.webp';

            $image = $manager->read($request->file('thumbnail'));
            $image->toWebp(85)->save(public_path('uploads/businessEvents/thumbnails/' . $thumbnailWebp));

            $validated['thumbnail'] = $thumbnailWebp;
        }

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(BusinessEvent $event)
    {
        if (! $this->isAdmin() && $event->user_id !== Auth::id()) {
            abort(403);
        }

        $oldPath = public_path('uploads/businessEvents/thumbnails/' . $event->thumbnail);
        if ($event->thumbnail && file_exists($oldPath)) {
            @unlink($oldPath);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

}
