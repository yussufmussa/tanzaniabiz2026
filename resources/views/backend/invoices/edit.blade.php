@extends('backend.layouts.base')
@section('title', 'Edit Invoice '.$invoice->invoice_number)

@section('contents')
<livewire:backend.admin.invoice-form :invoiceId="$invoice->id" />
@endsection
