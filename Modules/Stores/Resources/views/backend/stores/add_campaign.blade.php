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

        <div class="step-container">
            <div class="step-icon">
                @if($store->status === 1)
                    <i class="fas fa-check-circle completed"></i>
                @else
                    <i class="fas fa-circle"></i>
                @endif
            </div>
            <span>Step 1 - Basic details</span>
        </div>

        <div class="step-container">
            <div class="step-icon">
                @if($store->status === 1)
                    <i class="fas fa-check-circle completed"></i>
                @else
                    <i class="fas fa-circle"></i>
                @endif
            </div>
            <span>Step 2 - Profile details</span>
        </div>

        {{ html()->form('POST', route('backend.stores.storeCampaign'))->class('form-horizontal')->open() }}
        {{ csrf_field() }}
        <h2>Step 3 - Generate Qr Code</h2>
        <div class="row mt-4">
            <div class="col">
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Coupon</label>
                    <div class="col-sm-10">
                        <!-- Dropdown for coupon -->
                        <!-- Replace the placeholder with your dropdown options -->
                        <select class="form-control" name="coupon_id">
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">QR Code URL</label>
                    <div class="col-sm-10">
                        <!-- Input for QR code URL -->
                        <input type="text" class="form-control" name="qr_code_url" placeholder="Enter QR Code URL">
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
                    <th>User Id</th>
                
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
                data: 'user_id',
                name: 'user_id'
            }
        ]
    });
</script>
@endpush
