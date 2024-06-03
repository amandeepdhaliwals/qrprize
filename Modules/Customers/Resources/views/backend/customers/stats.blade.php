@extends('backend.layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

<style>
    .advertisement {
        margin-bottom: 5px;
    }

    .advertisement-name {
        font-weight: bold;
    }

    .views, .unviews {
        margin-left: 10px;
        color: #888;
    }

</style>
@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<form action='{{ route("backend.customers.stats.filter") }}' method="POST">
<div class="row mb-3">
    @csrf
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <?php
            $field_name = 'year'; 
            $field_label = ''; 
            $field_placeholder = "-- Select a year --";
            $required = "";
            $start_year = date('Y');
            $end_year = date('Y') - 10;
            $select_options = [];
            
            for ($year = $start_year; $year >= $end_year; $year--) {
                $select_options[$year] = $year;
            }
            $year_selected = $selectedYear ? $selected_year : '';
            ?>
            
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! $required !!}
            {{ html()->select($field_name, $select_options, $year_selected)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
    @if(auth()->check() && auth()->user()->roles->first()->id === 1)
    <div class="col-12 col-sm-3">
        <div class="form-group">
            <?php
            $field_name = 'store';
            $field_label = '';
            $field_placeholder = "-- Select a store --";
            $required = "";
            $select_options = [];
            
            foreach ($stores as $store) {
                $select_options[$store->id] = $store->name;
            }
            $selected_store = $store_id != null ? $store_id : '';
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

<br><hr>
<div class="row mt-4">
    <div class="col-6">
        <canvas id="visitorChart"></canvas>
    </div>
    <div class="col-6">
        <h4>Total Visitors: {{ $totalVisitors }}</h4>
        <h4>Total Registered: {{ $totalRegistered }}</h4>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('visitorChart').getContext('2d');
        var visitorChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total Visitors', 'Total Registered'],
                datasets: [{
                    data: [{{ $totalVisitors }}, {{ $totalRegistered }}],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
