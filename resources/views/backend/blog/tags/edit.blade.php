@extends('backend.layouts.base')
@section('title', $posttag->name)

@section('contents')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{route('admin.tags.update', $posttag->id)}}" method="post">@csrf
                            @method('patch')
                            <div class="mb-3">
                                <label for="forCategory" class="form-label">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{$posttag->name}}">
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