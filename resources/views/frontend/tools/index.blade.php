@extends('frontend.layouts.base')
@section('title', 'Invoice Generator')

@push('extra_style')
<style>
        .inv-card {
            border: 1px solid #e6e6e6;
        }

        .inv-box {
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            background: #fff;
        }

        .inv-logo {
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9aa0a6;
            cursor: pointer;
        }

        .inv-title {
            font-size: 44px;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .inv-label {
            color: #6c757d;
            font-size: 13px;
        }

        .inv-mini {
            font-size: 13px;
            color: #6c757d;
        }

        .inv-table-head {
            background: #111;
            color: #fff;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 600;
        }

        .inv-line {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .inv-input-clean {
            border: none !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            box-shadow: none !important;
        }

        .inv-money {
            font-weight: 600;
        }

        .inv-right-col {
            width: 120px;
        }

        .inv-right-col-sm {
            width: 100px;
        }

        .inv-right-col-xs {
            width: 90px;
        }
    </style>
@endpush

@section('contents')

@livewire('frontend.tools.invoice-generator')

@endsection
