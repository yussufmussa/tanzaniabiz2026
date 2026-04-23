@extends('backend.layouts.base')
@section('title', 'New Job')



@section('contents')

<div class="row">
    <div class="d-flex justify-content-end">
        <a class="btn btn-primary btn-sm mb-1 mt-0" href="{{ route('events.index') }}">
            <i class="bx bx-list-ul me-1"></i> Events
        </a>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">New Event</h4>

                <div class="row">
                    <div class="col-lg-12">

                        <form action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            {{-- Title --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="e.g. Business Networking Night"
                                    value="{{ old('title') }}">
                                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Slug <small class="text-muted">(optional)</small></label>
                                <input type="text" name="slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    placeholder="e.g. business-networking-night"
                                    value="{{ old('slug') }}">
                                @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
                                <small class="text-muted">Leave blank to auto-generate from the title.</small>
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Event Description <span class="text-danger">*</span></label>
                                <textarea name="event_description" rows="6"
                                    class="form-control @error('event_description') is-invalid @enderror"
                                    placeholder="Write full details about your event...">{{ old('event_description') }}</textarea>
                                @error('event_description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Location --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Event Location <span class="text-danger">*</span></label>
                                <input type="text" name="event_loction"
                                    class="form-control @error('event_loction') is-invalid @enderror"
                                    placeholder="e.g. Mlimani City, Dar es Salaam (Hall B)"
                                    value="{{ old('event_loction') }}">
                                @error('event_loction') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            {{-- Banner preview --}}
                            <img src="{{ asset('uploads/general/event_placeholder.png') }}"
                                 alt="event banner"
                                 class="img-thumbnail mb-3"
                                 width="200" height="200"
                                 id="eventBanner">

                            {{-- Banner upload --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Event Banner <span class="text-danger">*</span></label>
                                <input type="file" name="thumbnail"
                                    class="form-control @error('thumbnail') is-invalid @enderror"
                                    accept="image/*">
                                @error('thumbnail') <div class="text-danger">{{ $message }}</div> @enderror
                                <small class="text-muted">Recommended: JPG/PNG/WebP, max 2MB.</small>
                            </div>

                            {{-- Dates --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Starting Date <span class="text-danger">*</span></label>
                                    <input type="date" name="starting_date"
                                        class="form-control @error('starting_date') is-invalid @enderror"
                                        value="{{ old('starting_date') }}">
                                    @error('starting_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Closing Date <span class="text-danger">*</span></label>
                                    <input type="date" name="closing_date"
                                        class="form-control @error('closing_date') is-invalid @enderror"
                                        value="{{ old('closing_date') }}">
                                    @error('closing_date') <div class="text-danger">{{ $message }}</div> @enderror
                                    <small class="text-muted">
                                        Event stops accepting attendees / visible until this date.
                                    </small>
                                </div>
                            </div>

                            {{-- Times --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Starting Time <span class="text-danger">*</span></label>
                                    <input type="time" name="starting_time"
                                        class="form-control @error('starting_time') is-invalid @enderror"
                                        value="{{ old('starting_time') }}">
                                    @error('starting_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ending Time <span class="text-danger">*</span></label>
                                    <input type="time" name="ending_time"
                                        class="form-control @error('ending_time') is-invalid @enderror"
                                        value="{{ old('ending_time') }}">
                                    @error('ending_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- External link --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">External Link <small class="text-muted">(optional)</small></label>
                                <input type="url" name="link"
                                    class="form-control @error('link') is-invalid @enderror"
                                    placeholder="https://example.com/register"
                                    value="{{ old('link') }}">
                                @error('link') <div class="text-danger">{{ $message }}</div> @enderror
                                <small class="text-muted">If you have a registration page, add it here.</small>
                            </div>

                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                <i class="mdi mdi-content-save me-1"></i> Create Event
                            </button>

                        </form>

                    </div>
                </div><!-- end row -->

            </div>
        </div>
    </div>
</div>

@endsection
@push('extra_script')
    <script src="{{ asset('frontend/js/select2.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/iiqixl8hthzdil6o27bqjiw41edk308z15qnayzyqbbd6vff/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            });
    </script>
        <script>
            $(document).ready(function() {
                $('#city_id').select2();
                $('#sector_id').select2();
                $('#city_id').select2();
                $('#job_type_id').select2();

            });
        </script>
@endpush