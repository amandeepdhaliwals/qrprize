@extends('customerbackend.layouts.app')

@section('title') @lang("Dashboard") @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs />
@endsection

@section('content')

<div class="card mt-4">
   <div class="card-body table-responsive">
      <h5 class="card-title">Campaign List</h5>
      <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
         <thead>
            <tr>
               <th>Campaign Name</th>
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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

   <script type="module">
   

      $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("customerbackend.campaigns") }}',
        columns: [
        {
          data: 'campaign_name',
          name: 'campaign_name'
        },
        {
          data: 'play',
          name: 'play',
        },
        ]
      });
      </script>
      @endpush