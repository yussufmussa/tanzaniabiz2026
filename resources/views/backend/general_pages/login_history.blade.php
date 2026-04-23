@extends('backend.layouts.base')
@section('title', 'Login History')

@push('extra_style')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
}

.device-info {
    min-width: 120px;
}
th a {
    color: inherit;
    text-decoration: none;
}
th a:hover {
    text-decoration: underline;
}

</style>
@endpush
@section('contents')

  <livewire:backend.login-history-list/>

@endsection



