@props(["data"=>"", "module_name", "module_path", "module_title"=>"", "module_icon"=>"", "module_action"=>""])
<div class="card">
    @if ($slot != "")
    <div class="card-body">
        {{ $slot }}
    </div>
    @else
    <div class="card-body">

    <x-backend.section-header :data="$data" :module_name="$module_name" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" />

    <div class="row mt-4">
        <div class="col">
            {{ html()->modelForm($data, 'PATCH', route("backend.$module_name.update", $data))->class('form')->acceptsFiles()->open() }}

            @include ("$module_path.$module_name.form")

            <div class="row">
                <div class="col-4 mt-4">
                    <x-backend.buttons.save />
                </div>

                <div class="col-8 mt-4">
                    <div class="float-end">
                        @can('delete_'.$module_name)
                        <!-- Delete button -->
                        <a href="javascript:void(0);" 
                           class="btn btn-danger" 
                           data-toggle="tooltip" 
                           title="{{ __('Delete') }}" 
                           onclick="confirmDelete({{ $data->id }})">
                           <i class="fas fa-trash-alt"></i>
                        </a>
                        @endcan
                        <x-backend.buttons.cancel />
                    </div>
                </div>
            </div>

            {{ html()->closeModelForm() }}
            <!-- Hidden delete form -->
            <form id="delete-form-{{ $data->id }}" action="{{ route('backend.'.$module_name.'.destroy', $data) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
    @endif

    <div class="card-footer">
        <div class="row">
            <div class="col">
                @if ($data != "")
                <small class="float-end text-muted">
                    @lang('Updated at'): {{$data->updated_at->diffForHumans()}},
                    @lang('Created at'): {{$data->created_at->isoFormat('LLLL')}}
                </small>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        var form = document.getElementById('delete-form-' + id);
        if (!form) {
            console.error('Form not found for ID:', id);
            return;
        }
        if (confirm('Are you sure you want to delete this?')) {
            form.submit();
        }
    }
</script>