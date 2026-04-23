@extends('backend.layouts.base')
@section('title', 'Create Post Tag')


@section('contents')
<div class="row">
    <div class="d-flex justify-content-end">
        <a type="submit" class="btn  btn-primary mb-1 mt-0" href="{{route('admin.tags.index')}}">Tag's List</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">New Post Tag</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{route('admin.tags.store')}}" method="post">@csrf
                            <div class="mb-3">
                                <label for="forCategory" class="form-label">Post Tag Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name">
                                @error('name')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>

                    </form>
                </div> <!-- end row -->
            </div>
        </div>
    </div>
</div>

@endsection
