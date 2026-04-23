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
                                    <form action="{{ route('jobs.update', $job->id) }}" method="post">@csrf
                                        @method('PUT')
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="mb-1">Title <span class="text-danger">*</span></label>
                                                <input type="text" name="title" class="form-control rounded"
                                                    placeholder="Junior Backend Developer"
                                                    value="{{ old('title', $job->title) }}" required>
                                                @error('title')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="mb-1">Industry <span class="text-danger">*</span></label>
                                                <select name="job_sector_id"
                                                    class="form-control @error('job_sector_id') is-invalid @enderror"
                                                    id="job_sector_id" required>
                                                    @foreach ($jobsectors as $jobsector)
                                                        <option value="{{ $jobsector->id }}"
                                                            {{ old('job_sector_id', $job->job_sector_id) == $jobsector->id ? 'selected' : '' }}>
                                                            {{ $jobsector->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('job_sector_id')
                                                    <div class="text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="mb-1">Job Type<span class="text-danger">*</span></label>
                                                <select name="job_type_id"
                                                    class="form-control @error('job_type_id') is-invalid @enderror"
                                                    id="job_type_id" required>
                                                    @foreach ($jobtypes as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ old('job_type_id', $job->job_type_id) == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('job_type_id')
                                                    <div class="text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="mb-1">Location <span class="text-danger">*</span></label>
                                                <select name="city_id"
                                                    class="form-control @error('city_id') is-invalid @enderror"
                                                    id="city_id" required>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ old('city_id', $job->city_id) == $city->id ? 'selected' : '' }}>
                                                            {{ $city->city_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('city_id')
                                                    <div class="text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="mb-1">Job Descriptions <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="description" class="form-control rounded ht-150"
                                                    placeholder="Short description about the advertising position" required>{{ old('description', $job->description) }}</textarea>
                                                @error('description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="mb-1">No. To Be Employed <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="no_to_employed" class="form-control rounded"
                                                    placeholder="5"
                                                    value="{{ old('no_to_employed', $job->no_to_employed) }}" required>
                                                @error('no_to_employed')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="mb-1">Job Opening Date</label>
                                                    <input type="date" name="job_opening_date"
                                                        class="form-control rounded" placeholder="2026-02-02"
                                                        value="{{ old('job_opening_date', $job->job_opening_date->format('Y-m-d')) }}">
                                                    @error('job_opening_date')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="mb-1">Job Closing Date</label>
                                                    <input type="date" name="job_closing_date"
                                                        class="form-control rounded" placeholder="2026-02-28"
                                                        value="{{ old('job_closing_date', $job->job_closing_date->format('Y-m-d')) }}">
                                                    @error('job_closing_date')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                </div> <!-- end row -->
                            </div>
                        </div>
                        <!-- Image & Gallery Option -->
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <button class="btn theme-bg rounded text-light" type="submit">Update Job</button>
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
            $('#job_sector_id').select2();
            $('#city_id').select2();
            $('#job_type_id').select2();

        });
    </script>
@endpush
