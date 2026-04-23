@extends('backend.layouts.base')
@section('title', 'New City')

@section('contents')
    <div class="row">
        <div class="d-flex justify-content-end">
        @canany(['create.cities', 'manage.cities'])
            <a type="submit" class="btn  btn-primary btn-sm mb-1 mt-0"
                href="{{ route('cities.index') }}">
                <i class="bx bx-list-ul me-1"></i> Cities</a>
        @endcanany
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="bx bx-plus"></i>
                        Add New City
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('cities.store') }}" method="post"
                                enctype="multipart/form-data">@csrf
                                <div class="mb-3">
                                    <label for="forCity" class="form-label fw-bold">City Name</label>
                                    <input class="form-control @error('city_name') is-invalid @enderror" type="text"
                                        name="city_name">
                                    @error('city_name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Save</button>
                        </div>

                        </form>
                    </div> <!-- end row -->
                </div>
            </div>
        </div>
    </div>

@endsection
@push('extra_script')
@endpush
