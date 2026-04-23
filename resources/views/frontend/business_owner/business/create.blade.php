@extends('frontend.business_owner.account.base')
@section('title', 'Add Business Listing')

@push('extra_style')
<link href="{{asset('frontend/css/select2.min.css')}}" rel="stylesheet" />
<style>
    .custom-file-upload {
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        background-color: #dc3545;
        border: 1px solid #dc3545;
        border-radius: 4px;
        color: #fff;
    }

    .custom-file-upload-new {
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        background-color: #198754;
        border: 1px solid #198754;
        border-radius: 4px;
        color: #fff;
    }

    .custom-file-upload:hover {
        background-color: #c82333;
    }

    .custom-file-upload:active {
        background-color: #bd2130;
    }

    /* Tab Styles */
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 20px;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        padding: 12px 24px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .nav-tabs .nav-link:hover {
        color: #495057;
        border-color: transparent;
    }

    .nav-tabs .nav-link.active {
        color: #dc3545;
        background-color: transparent;
        border-bottom: 3px solid #dc3545;
    }

    .nav-tabs .nav-link.completed {
        color: #198754;
    }

    .nav-tabs .nav-link.completed i {
        display: inline-block;
        margin-left: 5px;
    }

    .tab-content {
        padding: 20px 0;
    }

    .tab-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
    }

    .tab-pane {
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .step-indicator {
        display: inline-block;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #6c757d;
        color: white;
        text-align: center;
        line-height: 24px;
        font-size: 12px;
        margin-right: 8px;
    }

    .nav-link.active .step-indicator {
        background-color: #dc3545;
    }

    .nav-link.completed .step-indicator {
        background-color: #198754;
    }
</style>
@endpush

@section('contents')
<div class="goodup-dashboard-content">

    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-2 col-md-12 col-sm-12">
                <div class="submit-form">
                    <!-- Listing Info -->
                    <div class="dashboard-list-wraps bg-white rounded mb-4">
                        {{-- <div class="dashboard-list-wraps-head br-bottom py-3 px-3">
                            <div class="dashboard-list-wraps-flx">
                                <h4 class="mb-0 ft-medium fs-md"><i class="fa fa-file me-2 theme-cl fs-sm"></i>
                                    {{ isset($listing) ? 'Edit Listing' : 'Add New Listing' }}
                                </h4>
                            </div>
                        </div> --}}

                        <div class="dashboard-list-wraps-body py-3 px-3">
                            @livewire('frontend.business.business-listing-form')                            
                        </div> <!-- Close dashboard-list-wraps-body -->

                    </div> <!-- Close dashboard-list-wraps -->
                </div> <!-- Close submit-form -->
            </div> <!-- Close col-xl-12 -->
        </div> <!-- Close row -->
    </div> <!-- Close dashboard-widg-bar -->
</div> <!-- Close goodup-dashboard-content -->
</div>
@endsection


@push('extra_script')
<script src="{{asset('frontend/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function() {
    $('#subcategory_id').select2();
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('StatusUpdated', (data) => {
                console.log(data[0].type);
                if (data[0].type === 'success') {
                    toastr.success(data[0].message);
                } else if (data[0].type === 'error') {
                    toastr.error(data[0].message);
                } else {
                    console.warn('Unexpected type:', data[0].type);
                }
            });
        });
    </script>
@endpush
