@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                @can('add_'.$module_name)
                <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}" />
                @endcan

                @can('restore_'.$module_name)
                <div class="btn-group">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <!-- <a class="dropdown-item" href='{{ route("backend.$module_name.show",1) }}'>
                                <i class="fas fa-eye-slash"></i> View trash
                            </a> -->
                            <a class="dropdown-item" href='{{ route("backend.$module_name.trashed") }}'>
                                <i class="fas fa-eye-slash"></i> View trash
                            </a>
                        </li>
                    </ul>
                </div>
                @endcan
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col table-responsive">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>media</th> 
                             <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($otherprizes as $otherprize)
                        <tr>
                            <td>{{ $otherprize->id }}</td>
                            <td>{{ $otherprize->title }}</td>
                            <td>{{ $otherprize->description }}</td>
                            <td><img src="{{ $otherprize->media }}" alt="uploaded media" class="img-fluid" style="max-width: 100px;"></td>
                            <td>{{ $otherprize->status }}</td>
                            <td>{{ $otherprize->created_at }}</td>
                            <td>{{ $otherprize->updated_at }}</td>
                            <td class="text-end">
                                <a href="{{ route('backend.otherprizes.edit', $otherprize->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('backend.otherprizes.show', $otherprize->id) }}" class="btn btn-sm btn-success" title="View"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    Total {{ $otherprizes->total() }} Advertisements
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $otherprizes->render() !!} <!-- Pagination links -->
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
        ajax: '{{ route("backend.$module_name.index_data") }}',
        columns: [
            { 
            data: null,
            name: 'id',
            render: function (data, type, row, meta) {
                    return meta.row + 1; // Row index starts from 0, so add 1 to start from 1
                }
            },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'media', name: 'media' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
    });
</script>
@endpush