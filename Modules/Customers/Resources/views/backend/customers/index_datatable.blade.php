@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection
<style>
.hiddenData {
    display: none;
}

.more, .less {
    cursor: pointer;
    color: blue;
    text-decoration: underline;
}

</style>

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <label for="store_filter" class="form-label">Filter by Store:</label>
                <select id="store_filter" class="form-select">
                    <option value="">All Stores</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-3">
                <label for="campaign_filter" class="form-label">Filter by Campaign:</label>
                <select id="campaign_filter" class="form-select">
                    <option value="">All Campaign</option>
                    @foreach($campaigns as $campaign)
                        <option value="{{ $campaign->id }}">{{ $campaign->campaign_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <label for="adv_filter" class="form-label">Filter by Advertisement:</label>
                <select id="adv_filter" class="form-select">
                    <option value="">All Advertisement</option>
                    @foreach($advertisements as $advertisement)
                        <option value="{{ $advertisement->id }}">{{ $advertisement->advertisement_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <label for="win_filter" class="form-label">Filter by Win:</label>
                <select id="win_filter" class="form-select">
                    <option value="">No Filter</option>
                    <option value="1">Win</option>
                    <option value="0">Lose</option>
                </select>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
    <div class="col"> 
        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                @can('add_'.$module_name)
                <!-- <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}" /> -->
                @endcan 
                <!-- <button id="" class="btn btn-secondary" type="button" data-coreui-toggle="" aria-expanded="">
                <a class="" href='{{ route("backend.$module_name.exportToExcel") }}'>
                Export To Excel
                            </a>
                    </button> -->

                <button id="exportBtn" class="btn btn-secondary" type="button" data-coreui-toggle="" aria-expanded="">
                Export To Excel
                    </button>

                @can('restore_'.$module_name)
                <!-- <div class="btn-group">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href='{{ route("backend.$module_name.trashed") }}'>
                                <i class="fas fa-eye-slash"></i> @lang("View trash")
                            </a>
                        </li>
                    </ul>
                </div> -->
                @endcan
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col table-responsive">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Store Name</th>
                            <th>Campaign</th>
                            <th>Advertisement</th>
                            <th>Win Count</th>
                            <th>Lose Count</th>
                            <th>Updated At</th>
                            <!-- <th>Action</th>  -->
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
    $(document).ready(function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // DataTable initialization
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            responsive: true,
            ajax: {
                url: '{{ route("backend.$module_name.index_data_cust") }}',
                type: 'GET',
                data: function (d) {
                    d._token = csrfToken; // Include CSRF token
                    d.store = $('#store_filter').val(); // Add selected store value to the request data
                    d.campaign = $('#campaign_filter').val();
                    d.adv = $('#adv_filter').val();
                    d.win_lose = $('#win_filter').val();
                    //table.ajax.reload(null, false);
                    //table.ajax.reload();
                }
            },
            columns: [
                { 
                    data: null,
                    name: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Row index starts from 0, so add 1 to start from 1
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                {
                    data: 'store_name',
                    name: 'store_name'
                },
                {
                    data: 'campaign',
                    name: 'campaign'
                },
                {
                    data: 'advertisement',
                    name: 'advertisement'
                },
                {
                    data: 'win_count',
                    name: 'win_count'
                },
                {
                    data: 'lose_count',
                    name: 'lose_count'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
            ]
        });


        table.on('draw', function() {
        $('td div[data-list]').each(function() {
        var dataList = $(this).attr('data-list').split(', ');
        if (dataList.length > 1) {
            var shownData = dataList.slice(0, 1).map(item => '<li>' + item + '</li>').join('');
            var hiddenData = dataList.slice(1).map(item => '<li>' + item + '</li>').join('');
            $(this).html(
                '<ul>' + shownData + '</ul>' +
                '<span class="more">more...</span>' +
                '<ul class="hiddenData">' + hiddenData + '</ul>'
            );
        } else {
            var allData = dataList.map(item => '<li>' + item + '</li>').join('');
            $(this).html('<ul>' + allData + '</ul>');
        }
        });

        // Event to show hidden data on click
        $(document).on('click', '.more', function() {
            var hiddenData = $(this).next('.hiddenData');
            if (hiddenData.is(':visible')) {
                hiddenData.hide();
                $(this).text('more...');
            } else {
                hiddenData.show();
                $(this).text('less...');
            }
        });
        });


        // Handle change event on store filter dropdown
        $('#store_filter').on('change', function () {
            table.ajax.reload(); // Reload DataTable when the store filter changes
        });

        $('#campaign_filter').on('change', function () {
            table.ajax.reload(); // Reload DataTable when the store filter changes
        });

        $('#adv_filter').on('change', function () {
            table.ajax.reload(); // Reload DataTable when the store filter changes
        });

        $('#win_filter').on('change', function () {
            table.ajax.reload(); // Reload DataTable when the store filter changes
        });
        
        // Export to Excel button click event
        $('#exportBtn').click(function() {
            // Get filtered data from all pages
            var filteredData = [];
            table.rows({ search: 'applied' }).every(function() {
                filteredData.push(this.data());
            });

            // Send filtered data to server for export
            $.ajax({
                url: '{{ route("backend.$module_name.exportToExcel") }}',
                type: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                },
                data: JSON.stringify({ filteredData: filteredData }),
                xhrFields: {
                    responseType: 'blob' // Set the response type to blob
                },
                success: function(response) {
                    var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'customers.xlsx';
                    link.click();
                },
                error: function(xhr, status, error) {
                    alert(error)
                }
            });
        });
    });
</script>
@endpush
