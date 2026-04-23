@extends('backend.layouts.base')
@section('title', 'Invoices')

@section('contents')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <h4 class="mb-0">Invoice {{ $invoice->invoice_number }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-primary btn-sm">
                    <i class="bx bx-edit"></i> Edit
                </a>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back"></i> Back to List
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- Invoice Header -->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h5>From:</h5>
                        <div class="text-muted">
                            {!! nl2br(e($invoice->from)) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h5>Billed To:</h5>
                        <div class="text-muted">
                            {!! nl2br(e($invoice->billed_to)) !!}
                        </div>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="row mb-4">
                    <div class="col-sm-3">
                        <h6>Invoice Date:</h6>
                        <p class="text-muted">{{ $invoice->invoice_date->format('F d, Y') }}</p>
                    </div>
                    <div class="col-sm-3">
                        <h6>Due Date:</h6>
                        <p class="text-muted">
                            @if($invoice->due_date)
                                {{ $invoice->due_date->format('F d, Y') }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div class="col-sm-3">
                        <h6>Status:</h6>
                        <p>{!! $invoice->status_badge !!}</p>
                    </div>
                    <div class="col-sm-3">
                        <h6>Assigned User:</h6>
                        <p class="text-muted">
                            {{ $invoice->user ? $invoice->user->name : 'Not assigned' }}
                        </p>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Description</th>
                                <th width="15%">Quantity</th>
                                <th width="15%">Rate</th>
                                <th width="15%">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td>{!! nl2br(e($item->description)) !!}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->rate, 2) }}</td>
                                    <td>${{ number_format($item->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Invoice Summary -->
                <div class="row">
                    <div class="col-sm-6">
                        @if($invoice->notes)
                            <div class="mb-3">
                                <h6>Notes:</h6>
                                <div class="text-muted">
                                    {!! nl2br(e($invoice->notes)) !!}
                                </div>
                            </div>
                        @endif

                        @if($invoice->terms)
                            <div class="mb-3">
                                <h6>Terms & Conditions:</h6>
                                <div class="text-muted">
                                    {!! nl2br(e($invoice->terms)) !!}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td>Subtotal:</td>
                                        <td class="text-end">${{ number_format($invoice->subtotal, 2) }}</td>
                                    </tr>
                                    @if($invoice->discount_rate > 0)
                                        <tr>
                                            <td>Discount ({{ $invoice->discount_rate }}%):</td>
                                            <td class="text-end text-danger">-${{ number_format($invoice->discount_amount, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($invoice->tax_rate > 0)
                                        <tr>
                                            <td>Tax ({{ $invoice->tax_rate }}%):</td>
                                            <td class="text-end text-success">+${{ number_format($invoice->tax_amount, 2) }}</td>
                                        </tr>
                                    @endif
                                    <tr class="border-top">
                                        <td><strong>Total:</strong></td>
                                        <td class="text-end"><strong class="text-primary">${{ number_format($invoice->total, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Amount Paid:</td>
                                        <td class="text-end">${{ number_format($invoice->amount_paid, 2) }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td><strong>Balance Due:</strong></td>
                                        <td class="text-end">
                                            <strong class="{{ $invoice->balance_due > 0 ? 'text-danger' : 'text-success' }}">
                                                ${{ number_format($invoice->balance_due, 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection