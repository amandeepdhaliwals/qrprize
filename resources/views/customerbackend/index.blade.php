@extends('customerbackend.layouts.app')

@section('title') @lang("Dashboard") @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs />
@endsection

@section('content')


@include("customerbackend.includes.dashboard")

@endsection