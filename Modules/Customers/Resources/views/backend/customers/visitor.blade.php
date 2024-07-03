@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active"
        icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

<style>
    .advertisement {
        margin-bottom: 5px;
    }

    .advertisement-name {
        font-weight: bold;
    }

    .views,
    .unviews {
        margin-left: 10px;
        color: #888;
    }

    .card {
        margin-top: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .body-stat {
        font-family: Arial, sans-serif;
    }

    .stat {
        font-size: 1.2rem;
        margin: 10px 0;
    }
</style>
@section('content')
<div class="container">
    <div class="card card-stat">
        <div class="card-body body-stat">
            <h4 class="card-title">Total</h4>
            <p class="stat">Total Visitors: <strong>{{$distinctUserCount}}</strong></p>
            <p class="stat">Total Views: <strong>{{$totalViews}}</strong></p>
            <p class="stat">Total Unviews: <strong>{{$totalUnviews}}</strong></p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small
                class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name' => Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col table-responsive">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                User
                            </th>
                            <th>
                                Details
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">

                </div>
            </div>
            <div class="col-5">
                <div class="float-end">

                </div>
            </div>
        </div>
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
            ajax: '{{ route("backend.$module_name.visitor_data") }}',
            columns: [
                {
                    data: null,
                    name: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Row index starts from 0, so add 1 to start from 1
                    }
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'details',
                    name: 'details'
                }
            ]
        });
    </script>
@endpush