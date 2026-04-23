@extends('backend.layouts.base')
@section('title', 'Edit Job')


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
                <h4 class="card-title">Edit Event</h4>

                <div class="row">
                    <div class="col-lg-12">

                        {{-- EDIT FORM --}}
                        <form action="{{ route('events.update', $event) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $event->title) }}">
                                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Slug <small class="text-muted">(optional)</small></label>
                                <input type="text" name="slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $event->slug) }}">
                                @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
                                <small class="text-muted">Leave blank to auto-generate from the title.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Event Description <span class="text-danger">*</span></label>
                                <textarea name="event_description" rows="6"
                                    class="form-control @error('event_description') is-invalid @enderror">{{ old('event_description', $event->event_description) }}</textarea>
                                @error('event_description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Event Location <span class="text-danger">*</span></label>
                                <input type="text" name="event_loction"
                                    class="form-control @error('event_loction') is-invalid @enderror"
                                    value="{{ old('event_loction', $event->event_loction) }}">
                                @error('event_loction') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            @php
                                $bannerSrc = $event->thumbnail
                                    ? asset('uploads/businessEvents/thumbnails/' . $event->thumbnail)
                                    : asset('uploads/general/event_placeholder.png');
                            @endphp

                            <img src="{{ $bannerSrc }}" class="img-thumbnail mb-3" width="200" height="200" id="eventBanner" alt="event banner">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Event Banner <small class="text-muted">(optional)</small></label>
                                <input type="file" name="thumbnail" accept="image/*"
                                    class="form-control @error('thumbnail') is-invalid @enderror">
                                @error('thumbnail') <div class="text-danger">{{ $message }}</div> @enderror
                                <small class="text-muted">Leave blank to keep current banner. Recommended: JPG/PNG/WebP, max 2MB.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Starting Date <span class="text-danger">*</span></label>
                                    <input type="date" name="starting_date"
                                        class="form-control @error('starting_date') is-invalid @enderror"
                                        value="{{ old('starting_date', $event->starting_date->format('Y-m-d')) }}">
                                    @error('starting_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Closing Date <span class="text-danger">*</span></label>
                                    <input type="date" name="closing_date"
                                        class="form-control @error('closing_date') is-invalid @enderror"
                                        value="{{ old('closing_date', $event->closing_date->format('Y-m-d')) }}">
                                    @error('closing_date') <div class="text-danger">{{ $message }}</div> @enderror
                                    <small class="text-muted">Event stops accepting attendees / visible until this date.</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Starting Time <span class="text-danger">*</span></label>
                                    <input type="time" name="starting_time"
                                        class="form-control @error('starting_time') is-invalid @enderror"
                                        value="{{ old('starting_time', $event->starting_time->format('H:m')) }}">
                                    @error('starting_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ending Time <span class="text-danger">*</span></label>
                                    <input type="time" name="ending_time"
                                        class="form-control @error('ending_time') is-invalid @enderror"
                                        value="{{ old('ending_time', $event->ending_time->format('H:m')) }}">
                                    @error('ending_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">External Link <small class="text-muted">(optional)</small></label>
                                <input type="url" name="link"
                                    class="form-control @error('link') is-invalid @enderror"
                                    value="{{ old('link', $event->link) }}">
                                @error('link') <div class="text-danger">{{ $message }}</div> @enderror
                                <small class="text-muted">If you have a registration page, add it here.</small>
                            </div>

                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                <i class="mdi mdi-content-save me-1"></i> Update
                            </button>
                        </form>
                        {{-- /EDIT FORM --}}

                    </div>
                </div>

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
