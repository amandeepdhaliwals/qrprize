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
    .note {
    color: #777; /* Adjust color as needed */
    font-size: 14px; /* Adjust font size as needed */
    margin-top: 5px; /* Adjust margin as needed */
    .step-container {
    background-color: #f0f0f0;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
  }
  h5 {
    margin: 0;
    color: #333;
  }
  .note-line {
    color: #007bff; /* Blue color for the note */
    margin-top: 10px;
    margin-bottom: 10px;
  }
  .step-container {
    display: flex;
    align-items: center;
    margin-bottom: 10px; /* Adjust margin as needed */
    background-color: #f0f0f0;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
  }
}

  .theme-selection {
    display: flex;
    /* justify-content: center; */
    gap: 20px;
    /* margin-top: 20px; */
}

.theme-box {
    width: 150px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    cursor: pointer;
    transition: transform 0.3s;
    color: #fff;
    font-weight: bold;
}

.theme-box:hover {
    transform: scale(1.1);
}

.green-theme {
    background-color: #28a745;
}

.red-theme {
    background-color: #dc3545;
}

.selected {
    border: 5px solid #000; /* Add a border to indicate selection */
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

        <div class="step-container">
        <h5>{{$store->store_name}}</h5>
        </div>
        <div class="note-line">Note: Add advertisement here for the store and then assign it to ad campaigns.</div>
        <hr>

        <hr>
        @php
        $stepCompleted = $store->step_completed;
        @endphp

        @if($stepCompleted >= 1)
            <div class="step-container">
                <div class="step-icon">
                    <i class="fas fa-check-circle completed"></i>
                </div>
                <span>Step 1 - Basic details</span>
            </div>
        @endif

        @if($stepCompleted >= 2)
            <div class="step-container">
                <div class="step-icon">
                    <i class="fas fa-check-circle completed"></i>
                </div>
                <span>Step 2 - Profile details</span>
            </div>
        @endif

        @if($stepCompleted == 2)
            <div class="step-container active">
                <div class="step-icon">
                    <i class="fas fa-check-circle" style="color: orange;"></i>
                </div>
                <div>
                    <span style="color: orange;font-weight: bold;" >Step 3 - Add Advertisements</span>
                    <span class="ml-2 text-muted">Note: You can add advertisements here by selecting video and entering the details.</span>
                </div>
            </div>
            <div class="mt-2"> 
                <div class="mt-2"> 
                <a href="{{ route('backend.stores.advertisement_create', ['storeId' => $storeId]) }}" class="btn btn-primary">Add Advertisement</a>
                </div> 
            </div> 
            <br> 
        @endif

        @if($stepCompleted >= 3)
            <div class="step-container active">
                <div class="step-icon">
                    <i class="fas fa-check-circle completed" ></i>
                </div>
                <div>
                    <span style="font-weight: bold;" >Step 3 - Add Advertisements</span>
                    <span class="ml-2 text-muted">Note: You can add more advertisements here by selecting video and entering the details.</span>
                </div>
            </div>
            <div class="mt-2"> 
                <div class="mt-2"> 
                <a href="{{ route('backend.stores.advertisement_create', ['storeId' => $storeId]) }}" class="btn btn-primary">Add More Advertisement</a>
                </div> 
            </div> 
            <br> 
        @endif

        @if($stepCompleted == 3)
            <div class="step-container">
                <div class="step-icon">
                <i class="fas fa-check-circle" style="color: orange;"></i>
                </div>
                <span style="color: orange;font-weight: bold;" >Step 4 - Add Campaign</span>

            </div>
        @elseif($stepCompleted == 2)
            <div class="step-container disabled">
                <div class="step-icon">
                    <i class="fas fa-circle"></i>
                </div>
                <span>Step 4 - Add Campaign</span>
            </div>
        @endif

        @if($stepCompleted == 4)
            <div class="step-container">
                <div class="step-icon">
                <i class="fas fa-check-circle completed"></i>
                </div>
                <span style="font-weight: bold;" >Step 4 - Add Campaign - </span>
                <span class="ml-2 text-muted">Note: You can add more campaign by selecting advertisements</span>
            </div>
        @endif

         <hr>
         @if($stepCompleted >= 3)
         {{ html()->form('POST', route('backend.stores.storeCampaign'))->class('form-horizontal')->open() }}
        {{ csrf_field() }}
        
        <div class="row">    
                <div class="columns medium-12 small-centered">
                    <h4 class="float-left"><a href="#" style="color:#000;">Select Advertisement</a>
                    <div class="note">Select multiple advertisement from list that you already creted in 3rd Step.</div>
                </div>
                </div>
        <div class="row mt-4">
            <div class="col">
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Advertisement Video</label>
                    <div class="col-sm-10">
  
                        <select class="form-control" name="advertisement_ids[]" multiple required>
                        <option value="">--Select--</option>
                            @foreach($advertisements as $advertisement)
                            <option value="{{ $advertisement->id }}">{{ $advertisement->advertisement_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
               <label class="col-sm-2 form-control-label required-label">Campaign Name</label>
               <div class="col-sm-10">
                  <div class="input-group">
                     <!-- Static read-only text -->
                     <div class="input-group-prepend">
                        <span class="input-group-text">{{$store->store_name}}{{$campaign_count_for_name}}_campaign-</span>
                     </div>
                     <!-- Input text field -->
                    <input type="text" class="form-control" name="campaign_name" placeholder="Enter campaign name" required>
                     <input type="hidden" class="form-control" name="campaign_name_hid" value="{{$store->store_name}}{{$campaign_count_for_name}}_campaign-">
                     <input type="hidden" class="form-control" name="store_id" value="{{ $store->user_id }}">
                  </div>
                  <!-- Note -->
                  <div class="note">This is used for internal use only.</div>
                  <div id="adv_name_error" style="color: red;"></div>
               </div>
               
             </div>
            <div class="form-group row mb-3">
               <label class="col-sm-2 form-control-label required-label">Lock Time</label>
           
               <div class="col-sm-10">
               <select class="form-control" name="lock_time" id="lock_time" required>
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
                  </select>
               <div class="note">Lock campaign for specific time in hours</div>
                </div>
            </div>
            </div>

            <div class="form-group row mb-3">
             <label class="col-sm-2 form-control-label required-label">Select Theme</label>
               <div class="col-sm-10">
            <div class="theme-selection">
                <div class="theme-box green-theme selected" data-theme="green">
                    <span>Green</span>
                </div>
                <div class="theme-box red-theme" data-theme="red">
                    <span>Red</span>
                </div>
            </div>
            </div>
            </div>
            <input type="hidden" id="selectedTheme" name="selectedTheme" value="green">


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
        @endif
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
    <div class="card-body table-responsive">
        <h5 class="card-title">Campaigns</h5>
        <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Campaign Name</th>
                    <th>Advertisement Name</th>
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
        ajax: '{{ route("backend.$module_name.campaign_index", ['storeId' => ':storeId']) }}'.replace(':storeId', '{{ $store->user_id }}'),
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'campaign_name',
                name: 'campaign_name'
            },
            {
                data: 'advertisement_names',
                name: 'advertisement_names'
            },
            {
                data: 'qr_code_image', 
                name: 'qr_code_image',
            },
            {
                data: 'download',
                name: 'download'
            },
        ]
    });

    $(document).ready(function () {
    $('.theme-box').on('click', function () {
        $('.theme-box').removeClass('selected');
        $(this).addClass('selected');
        
        const selectedTheme = $(this).data('theme');
        $('#selectedTheme').val(selectedTheme);
        
        // Do something with the selected theme if needed
        console.log('Selected theme:', selectedTheme);
    });
    });


</script>
@endpush
