@extends('backend.layouts.base')
@section('title', 'Jobs')

@section('contents')
    <div class="row">
    
        @livewire('backend.admin.job-post-list')
    </div>
@endsection
