@extends('frontend.business_owner.account.base')
@section('title', 'Edit Job')

@push('extra_style')
<link href="{{ asset('frontend/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('contents')
<div class="goodup-dashboard-content">

<div class="dashboard-widg-bar d-block">
<div class="row">
<div class="col-xl-12 col-lg-2 col-md-12 col-sm-12">
    <div class="submit-form">
        <!-- Listing Info -->
        <div class="dashboard-list-wraps bg-white rounded mb-4">
            <div class="dashboard-list-wraps-head br-bottom py-3 px-3">
                <div class="dashboard-list-wraps-flx">
                    <h4 class="mb-0 ft-medium fs-md"><i class="fa fa-file me-2 theme-cl fs-sm"></i>Post a
                        Job</h4>
                </div>
            </div>

            <div class="dashboard-list-wraps-body py-3 px-3">
                <div class="row">
                    <form action="{{ route('events.update', $event->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="mb-1">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control rounded"
                                    placeholder="e.g. Business Networking Night"
                                    value="{{ old('title', $event->title) }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="mb-1">Slug <small
                                        class="text-muted">(optional)</small></label>
                                <input type="text" name="slug" class="form-control rounded"
                                    placeholder="e.g. business-networking-night"
                                    value="{{ old('slug', $event->slug) }}">
                                @error('slug')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave blank to auto-generate from the
                                    title.</small>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="mb-1">Event Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="event_description" class="form-control rounded ht-150"
                                    placeholder="Write full details about your event..." required>{{ old('event_description', $event->event_description) }}</textarea>
                                @error('event_description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="mb-1">Event Location <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="event_loction" class="form-control rounded"
                                    placeholder="e.g. Mlimani City, Dar es Salaam (Hall B)" value="{{ old('event_loction', $event->event_loction) }}" required>
                                @error('event_loction')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <img src="{{ asset('uploads/businessEvents/' . $event->thumbnail) }}" alt="event banner" class="img-thumbnail mb-3"
                                    width="200" height="200" id="eventBanner">
                            <div class="form-group">
                                <label class="mb-1">Thumbnail <small
                                        class="text-muted">(optional)</small></label>
                                <input type="file" name="thumbnail" class="form-control rounded"
                                    accept="image/*">
                                @error('thumbnail')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                @if ($event->thumbnail)
                                    <small class="text-muted d-block mt-2">
                                        Current: <a href="{{ asset('storage/' . $event->thumbnail) }}"
                                            target="_blank">View thumbnail</a>
                                    </small>
                                @endif

                                <small class="text-muted">Upload a new image only if you want to replace the
                                    current one.</small>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="mb-1">Starting Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="starting_date" class="form-control rounded"
                                        value="{{ old('starting_date', optional($event->starting_date)->format('Y-m-d')) }}"
                                        required>
                                    @error('starting_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="mb-1">Closing Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="closing_date" class="form-control rounded"
                                        value="{{ old('closing_date', optional($event->closing_date)->format('Y-m-d')) }}"
                                        required>
                                    @error('closing_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Event stops accepting attendees / visible
                                        until this date.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="mb-1">Starting Time <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="starting_time" class="form-control rounded"
                                        value="{{ old('starting_time', optional($event->starting_time)->format('H:i')) }}"
                                        required>
                                    @error('starting_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="mb-1">Ending Time <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="ending_time" class="form-control rounded"
                                        value="{{ old('ending_time', optional($event->ending_time)->format('H:i')) }}"
                                        required>
                                    @error('ending_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="mb-1">External Link <small
                                        class="text-muted">(optional)</small></label>
                                <input type="url" name="link" class="form-control rounded"
                                    placeholder="https://example.com/register"
                                    value="{{ old('link', $event->link) }}">
                                @error('link')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">If you have a registration page, add it
                                    here.</small>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <button class="btn theme-bg rounded text-light" type="submit">Update
                                    Event</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('extra_script')
<script>
$('#banner').change(function () {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#eventBanner').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
});
</script>
<script src="https://cdn.tiny.cloud/1/iiqixl8hthzdil6o27bqjiw41edk308z15qnayzyqbbd6vff/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>
@endpush
