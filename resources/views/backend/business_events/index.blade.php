@extends('backend.layouts.base')
@section('title', 'Events')

@section('contents')
    <div class="row">
    
        @livewire('backend.admin.event-list')
    </div>
@endsection
