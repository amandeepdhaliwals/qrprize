<div class="row mb-3">
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'title';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            <small class="form-text text-muted">This title is used on frontend image.</small>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'image_type';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select an option --";
            $required = "required";
            $select_options = [
                'primary' => 'Primary',
                'secondary' => 'Secondary'
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'image';
            $field_label = label_case($field_name);
            $field_placeholder = $field_label;
            $required = $data ? '' : 'required';
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->input("file", 'image_file')->class('form-control')->attributes(["accept" => "image/png, image/jpeg, image/jpg"]) }}
        </div>
      </div>
    </div>
  
    @if($data)
    <div class="col-6">
       <div class="form-group">
        <div class="float-end">
            <figure class="figure">
                <a href="{{ Storage::url($data->image) }}" data-lightbox="image-set" data-title="Path: {{ Storage::url($data->image) }}">
                    <img src="{{ Storage::url($data->image) }}" class="figure-img img-fluid rounded img-thumbnail" alt="">
                </a>
            </figure>
        </div>
       </div>
    </div>
    <x-library.lightbox />
    @endif
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'description';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            <small class="form-text text-muted">This field is used for internal use only.</small>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'status';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select an option --";
            $required = "required";
            $select_options = [
                '1' => 'Active',
                '0' => 'Inactive'
            ];
            $selected_option = '1';
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options, $selected_option)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<hr>
<div class="row mb-3">
    <div class="col-12 col-sm-12">
        <div class="form-group">
            <?php
            $field_name = 'free services';
            $field_lable = label_case($field_name);
            $required = "";
            $checkbox_options = [
                'Flight' => 'Flight',
                'Visa' => 'Visa',
                'Documentation' => 'Documentation'
            ];
            if($data){
                $existing_values = explode(',', $data->free_services);
            }else{
                $existing_values = array();
            }
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            <small class="form-text text-muted">(This field is used for frontend image icons if image type not equals to Other Prize)</small>
   
            <div>
                @foreach($checkbox_options as $value => $label)
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="{{ $field_name }}[]" value="{{ $value }}" id="{{ $field_name . '_' . $value }}" {{ is_array($existing_values) && in_array($value, $existing_values) ? 'checked' : '' }}>
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
