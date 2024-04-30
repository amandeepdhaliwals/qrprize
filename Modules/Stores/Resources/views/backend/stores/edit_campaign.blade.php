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

        {{ html()->form('POST', route('backend.stores.updateCampaign'))->class('form-horizontal')->open() }}
        {{ csrf_field() }}
        <h2>Step 3 - Update Campaign</h2>
        <div class="row mt-4">
            <div class="col">
            <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Campaign Name</label>
                    <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="store_id" value="{{ $store->id }}">
                    <input type="hidden" class="form-control" name="campaign_id" value="{{ $campaign->id }}">
                        <!-- Input for QR code URL -->
                        <input type="text" class="form-control" name="campaign_name" placeholder="Enter campaign name" value="{{ $campaign->campaign_name }}" required>
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
                                @if($adv_video->id == $campaign->adv_video_id)
                                    <option value="{{ $adv_video->id }}" selected>{{ $adv_video->title }}</option>
                                @else
                                    <option value="{{ $adv_video->id }}">{{ $adv_video->title }}</option>
                                @endif
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
                                @if($adv_image->id == $campaign->primary_image_id)
                                <option value="{{ $adv_image->id }}" selected>{{ $adv_image->title }}</option>
                                @else
                                <option value="{{ $adv_image->id }}">{{ $adv_image->title }}</option>
                                @endif
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
                                @if(in_array($adv_image->id, $campaign->secondary_images_id))
                                <option value="{{ $adv_image->id }}" selected>{{ $adv_image->title }}</option>
                                @else
                                <option value="{{ $adv_image->id }}">{{ $adv_image->title }}</option>
                                @endif
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
                                @if(in_array($coupon->id, $campaign->coupons_id))
                                <option value="{{ $coupon->id }}" selected>{{ $coupon->title }}</option>
                                @else
                                <option value="{{ $coupon->id }}">{{ $coupon->title }}</option>
                                @endif
                           
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
                        <option <?php if($campaign->lock_time == 1){  ?>selected<?php } ?> value="1">1 hour</option>
                        <option <?php if($campaign->lock_time == 6){  ?>selected<?php } ?> value="6">6 hours</option>
                        <option <?php if($campaign->lock_time == 12){  ?>selected<?php } ?> value="12">12 hours</option>
                        <option <?php if($campaign->lock_time == 18){  ?>selected<?php } ?> value="18">18 hours</option>
                        <option <?php if($campaign->lock_time == 24){  ?>selected<?php } ?> value="24">24 hours</option>
                        <option <?php if($campaign->lock_time == 30){  ?>selected<?php } ?> value="30">30 hours</option>
                        <option <?php if($campaign->lock_time == 36){  ?>selected<?php } ?> value="36">36 hours</option>
                        <option <?php if($campaign->lock_time == 42){  ?>selected<?php } ?> alue="42">42 hours</option>
                        <option <?php if($campaign->lock_time == 48){  ?>selected<?php } ?> value="48">48 hours</option>
                        <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 form-control-label">Winning Ratio</label>
                    <div class="col-sm-10">
                    <span>1</span>
                    <label for="denominator">out of : </label>
                    <input type="number" name="winning_ratio" class="ratio-input" value="{{ $campaign->winning_ratio }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="form-group">
                    <!-- Buttons for submitting and canceling the form -->
                    <x-buttons.edit title="{{__('Update')}} {{ ucwords(Str::singular($module_name)) }}">
                        {{__('Update')}}
                    </x-buttons.edit>
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

@endsection
