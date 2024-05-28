@extends('backend.layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <!-- <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend-breadcrumb-item> -->
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<!-- <x-backend.layouts.create :module_name="$module_name" :module_path="$module_path" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" /> -->
<form action='{{ route("backend.customers.stats.filter") }}' method="POST">
<div class="row mb-3">
              @csrf
<div class="col-12 col-sm-3">
    <div class="form-group">
        <?php
        $field_name = 'year'; // Assuming the field name is 'year'
        $field_label = ''; // Assuming the label for the field is 'Year'
        $field_placeholder = "-- Select a year --";
        $required = "";
        $start_year = date('Y');
        $end_year = date('Y') - 10;
        $select_options = [];
        
        for ($year = $start_year; $year >= $end_year; $year--) {
            $select_options[$year] = $year;
        }
        if($selectedYear == true){
            $year_selected = $selected_year;
        }else{
            $year_selected = '';
        }
        ?>
        
        {{ html()->label($field_label, $field_name)->class('form-label') }} {!! $required !!}
        {{ html()->select($field_name, $select_options, $year_selected)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
    </div>
    </div>
    @if(auth()->check() && auth()->user()->roles->first()->id === 1)
    <div class="col-12 col-sm-3">
    <div class="form-group">
        <?php
        $field_name = 'store'; // Assuming the field name is 'year'
        $field_label = ''; // Assuming the label for the field is 'Year'
        $field_placeholder = "-- Select a store --";
        $required = "";
        $select_options = [];
        
        foreach ($stores as $store) {
            $select_options[$store->id] = $store->name;
        }
        if($store_id != null){
            $selected_store = $store_id;
        }else{
            $selected_store = '';
        }
        ?>
        
        {{ html()->label($field_label, $field_name)->class('form-label') }} {!! $required !!}
        {{ html()->select($field_name, $select_options, $selected_store)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
    
    </div>
    </div>
    @endif
    <div class="col-12 col-sm-1">
    <div class="form-group">
        <button type="submit" class="btn btn-primary" style="margin-top:10px;">Filter</button>
    </div>
    </div>
    <div class="col-12 col-sm-1">
    <div class="form-group">
        <a href="{{ route('backend.customers.stats') }}"><button type="button" class="btn btn-primary" style="margin-top:10px;">Reset</button></a>
    </div>
    </div>
</div>
</form>
<div class="container">
        {!! $chart->container() !!}
    </div>
    {!! $chart->script() !!}

@endsection