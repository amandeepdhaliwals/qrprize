@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{ route("backend.$module_name.claimed") }}' icon=''>
        Claim
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="container mt-3">
    <!-- <h2>{{ __($module_action) }} {{ __($module_title) }}</h2> -->
    <div class="mb-3">
        <strong>Customer:</strong> {{ $claim->customer_name }}
    </div>
    <div class="mb-3">
        <strong>Advertisement:</strong> {{ $claim->advertisement_name }}
    </div>
    <div class="mb-3">
        <strong>Coupon:</strong> {{ $claim->title }}
    </div>
    <div class="mb-3">
        <strong>Name:</strong> {{ $claim->name }}
    </div>
    <div class="mb-3">
        <strong>Address:</strong> {{ $claim->address }}
    </div>
    <div class="mb-3">
        <strong>Request for Claim:</strong> {{ $claim->request_claim ? 'Yes' : 'No' }}
    </div>
    <div class="mb-3">
        <strong>Is Claim:</strong> {{ $claim->is_claimed ? 'Completed' : 'Pending' }}
    </div>
    <div class="mb-3">
        <strong>Email Sent:</strong> {{ $claim->email_sent ? 'Sent to admin' : 'Not Sent' }}
    </div>
    <h5> <strong>Current Shipping Status:</strong>
    <?php
        // Define the status text array
        $status_text = [
            '0' => 'Pending',
            '1' => 'Packed',
            '2' => 'In transit',
            '3' => 'Shipped',
            '4' => 'Completed'
        ];

        // Ensure $shipping_status is set and of the correct type
        $shipping_status = isset($shipping_status) ? (string)$shipping_status : null;

        // Check if $shipping_status is a valid key in the $status_text array
        echo isset($status_text[$shipping_status]) ? $status_text[$shipping_status] : 'Unknown';
    ?>
    </h5>
</div>
<br>
<form action='{{ route("backend.customers.update_shipping_status") }}' method="POST">
    @csrf
    <div class="form-group">
        <label for="status">Shipping Status:</label>
        <select class="form-control" id="status" name="status" required>
            <option value="0" {{ $shipping_status == '0' ? 'selected' : '' }}>Pending</option>
            <option value="1" {{ $shipping_status == '1' ? 'selected' : '' }}>Packed</option>
            <option value="2" {{ $shipping_status == '2' ? 'selected' : '' }}>In transit</option>
            <option value="3" {{ $shipping_status == '3' ? 'selected' : '' }}>Shipped</option>
            <option value="4" {{ $shipping_status == '4' ? 'selected' : '' }}>Completed</option>
        </select>
    </div>
    <br>
    <input type="hidden" name="claim_id" value="{{$claim->id}}">
    <button type="submit" class="btn btn-primary">Update Status</button>
</form>
</div>
@endsection