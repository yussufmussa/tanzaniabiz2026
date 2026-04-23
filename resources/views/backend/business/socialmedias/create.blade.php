@extends('backend.layouts.base')
@section('title', 'New Social Media')

@section('contents')
    <div class="row">
        <div class="d-flex justify-content-end">
            @canany(['create.categories', 'manage.categories'])
                <a type="submit" class="btn  btn-primary btn-sm mb-1 mt-0" href="{{ route('socialmedias.index') }}">
                 <i class="fa fa-arrow-left"></i> Back to list</a>
            @endcanany
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">New Social Media</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ route('socialmedias.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="forCategory" class="form-label fw-bold">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name">
                                    @error('name')
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
