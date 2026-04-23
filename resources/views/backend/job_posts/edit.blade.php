@extends('backend.layouts.base')
@section('title', 'Edit Job')


@section('contents')

    <div class="row">
        <div class="d-flex justify-content-end">
            <a class="btn btn-primary btn-sm mb-1 mt-0" href="{{ route('jobs.index') }}">
                <i class="bx bx-left-arrow-alt me-1"></i> Back
            </a>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Job Post</h4>

                    <div class="row">
                        <div class="col-lg-12">

                            <form action="{{ route('jobs.update', $job) }}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                    <input class="form-control @error('title') is-invalid @enderror" type="text"
                                        name="title" value="{{ old('title', $job->title) }}"
                                        placeholder="Junior Backend Developer" required>
                                    @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Industry <span class="text-danger">*</span></label>
                                    <select name="job_sector_id"
                                        class="form-control @error('job_sector_id') is-invalid @enderror" required>
                                        <option value="">Select industry</option>
                                        @foreach ($jobsectors as $jobsector)
                                            <option value="{{ $jobsector->id }}"
                                                {{ old('job_sector_id', $job->job_sector_id) == $jobsector->id ? 'selected' : '' }}>
                                                {{ $jobsector->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('job_sector_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Job Type <span class="text-danger">*</span></label>
                                    <select name="job_type_id"
                                        class="form-control @error('job_type_id') is-invalid @enderror" required>
                                        <option value="">Select job type</option>
                                        @foreach ($jobtypes as $type)
                                            <option value="{{ $type->id }}"
                                                {{ old('job_type_id', $job->job_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('job_type_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Location <span class="text-danger">*</span></label>
                                    <select name="city_id" class="form-control @error('city_id') is-invalid @enderror"
                                        required>
                                        <option value="">Select location</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id', $job->city_id) == $city->id ? 'selected' : '' }}>
                                                {{ $city->city_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Job Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6"
                                        placeholder="Short description about the position" required>{{ old('description', $job->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">No. To Be Employed <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('no_to_employed') is-invalid @enderror" type="number"
                                        name="no_to_employed" value="{{ old('no_to_employed', $job->no_to_employed) }}"
                                        placeholder="5" required>
                                    @error('no_to_employed')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Job Opening Date <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('job_opening_date') is-invalid @enderror"
                                            type="date" name="job_opening_date"
                                            value="{{ old('job_opening_date', $job->job_opening_date->format('Y-m-d')) }}" required>
                                        @error('job_opening_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Job Closing Date <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('job_closing_date') is-invalid @enderror"
                                            type="date" name="job_closing_date"
                                            value="{{ old('job_closing_date', $job->job_closing_date->format('Y-m-d')) }}" required>
                                        @error('job_closing_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Update
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
