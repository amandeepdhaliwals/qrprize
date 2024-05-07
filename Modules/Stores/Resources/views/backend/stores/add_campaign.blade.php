@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
    <!-- Breadcrumbs code -->
@endsection

@section('content')
<style>
    .step-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px; /* Adjust margin as needed */
    }

    .step-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #fff; /* Change to your background color */
        border: 2px solid #ccc; /* Change to your border color */
        text-align: center;
        line-height: 30px;
        margin-right: 10px; /* Adjust margin as needed */
    }

    .completed {
        color: green; /* Change to your tick color */
    }
</style>
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
            </x-slot>
        </x-backend.section-header>

        <hr>

        @if($store->step_completed >= 1)
            <div class="step-container">
                <div class="step-icon">
                    <i class="fas fa-check-circle completed"></i>
                </div>
                <span>Step 1 - Basic details</span>
            </div>
        @endif

        @if($store->step_completed >= 2)
            <div class="step-container">
                <div class="step-icon">
                    <i class="fas fa-check-circle completed"></i>
                </div>
                <span>Step 2 - Profile details</span>
            </div>
        @endif

        {{ html()->form('POST', route('backend.stores.storeCampaign'))->class('form-horizontal')->open() }}
        {{ csrf_field() }}
        <h2>Step 3 - Add Campaign</h2>
        <div class="row mt-4">
            <div class="col">
            <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Campaign Name</label>
                    <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="store_id" value="{{ $store->id }}">
                        <!-- Input for QR code URL -->
                        <input type="text" class="form-control" name="campaign_name" placeholder="Enter campaign name" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Advertisement Video</label>
                    <div class="col-sm-10">
                        <!-- Dropdown for coupon -->
                        <!-- Replace the placeholder with your dropdown options -->
                        <select class="form-control" name="video_id" required>
                        <option value="">--Select--</option>
                            @foreach($adv_videos as $adv_video)
                            <option value="{{ $adv_video->id }}">{{ $adv_video->title }}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Primary Image</label>
                    <div class="col-sm-10">
                        <!-- Dropdown for coupon -->
                        <!-- Replace the placeholder with your dropdown options -->
                        <select class="form-control" name="primary_image_id" required>
                            <option value="">--Select--</option>
                            @foreach($adv_images as $adv_image)
                            <option value="{{ $adv_image->id }}">{{ $adv_image->title }}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Secondary Images(carousel)</label>
                    <div class="col-sm-10">
                        <!-- Dropdown for coupon -->
                        <!-- Replace the placeholder with your dropdown options -->
                        <select class="form-control" name="secondary_images_id[]"  multiple required>
                            @foreach($adv_images as $adv_image)
                            <option value="{{ $adv_image->id }}">{{ $adv_image->title }}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Coupon</label>
                    <div class="col-sm-10">
                        <!-- Dropdown for coupon -->
                        <!-- Replace the placeholder with your dropdown options -->
                        <select class="form-control" name="coupons_id[]" multiple required>
                            @foreach($coupons as $coupon)
                            <option value="{{ $coupon->id }}">{{ $coupon->title }}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Lock Time</label>
                    <div class="col-sm-10">
                        <!-- Dropdown for coupon -->
                        <!-- Replace the placeholder with your dropdown options -->
                        <select class="form-control" name="lock_time" required>
                        <option value="">--Select--</option>
                        <option value="1">1 hour</option>
                        <option value="6">6 hours</option>
                        <option value="12">12 hours</option>
                        <option value="18">18 hours</option>
                        <option value="24">24 hours</option>
                        <option value="30">30 hours</option>
                        <option value="36">36 hours</option>
                        <option value="42">42 hours</option>
                        <option value="48">48 hours</option>
                        <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Winning Ratio</label>
                    <div class="col-sm-10">
                    <span>1</span>
                    <label for="denominator">out of : </label>
                    <input type="number" name="winning_ratio" class="ratio-input" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="form-group">
                    <!-- Buttons for submitting and canceling the form -->
                    <x-buttons.create title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}">
                        {{__('Create')}}
                    </x-buttons.create>
                    <div class="float-end">
                        <div class="form-group">
                            <x-buttons.cancel />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>

    <div class="card-footer">
        <div class="row  mb-3">
            <div class="col">
                <small class="float-end text-muted"></small>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Campaigns</h5>
        <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Campaign Name</th>
                    <th>QR Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
</div>
@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="module" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="module">
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.$module_name.campaign_index", ['storeId' => ':storeId']) }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'campaign_name',
                name: 'campaign_name'
            },
            {
                data: 'qr_code_image', 
                name: 'qr_code_image',
                render: function(data, type, full, meta){
                    return '<img src="data:image/png;base64,' + data + '" alt="QR Code" />';
                }
            },
            {
                data: 'edit_compaign',
                name: 'edit_compaign'
            },
        ]
    });
</script>
@endpush
