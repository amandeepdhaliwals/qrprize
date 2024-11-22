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
             
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col table-responsive">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Coins per Category</th>
                            <!-- <th>Created At</th>
                            <th>Updated At</th> -->
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($coins as $coin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $coin->category }}</td>
                            <td>{{ $coin->coins_per_category }}</td>
                            <!-- <td>{{ $coin->created_at }}</td>
                            <td>{{ $coin->updated_at }}</td> -->
                            <td class="text-end">
                                <a href="{{ route('backend.mobilesettings.coins.edit', $coin->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                               
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
                    Total {{ $coins->count() }} Coins
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $coins->links() !!} <!-- Pagination links -->
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
        serverSide: false,
        autoWidth: true,
        responsive: true,
    });
</script>
@endpush
