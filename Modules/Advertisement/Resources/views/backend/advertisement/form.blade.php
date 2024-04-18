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
        </div>
    </div>
    <!-- <div class="col-12 col-sm-6">
        <div class="form-group">
            <?php
            // $field_name = 'code';
            // $field_lable = label_case($field_name);
            // $field_placeholder = $field_lable;
            // $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div> -->
</div>
<div class="row mb-3">
    <div class="col-8">
        <div class="form-group">
            <?php
            $field_name = 'media';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = $data ? '' : 'required';
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->input("file", $field_name)->class('form-control')->attributes(["$required", "accept" => "image/png, image/jpeg, image/jpg, video/mp4, video/MOV, video/WMV"]) }}
        </div>
    </div>
  
    @if($data)
    <div class="col-4">
        <div class="float-end">
            <figure class="figure">
                @if($data->media_type == "Image")
                <a href="{{ Storage::url($data->media) }}" data-lightbox="image-set" data-title="Path: {{ Storage::url($data->media) }}">
                    <img src="{{ Storage::url($data->media) }}" class="figure-img img-fluid rounded img-thumbnail" alt="">
                </a>
                @else
                <video width="380" height="240" controls><source src="{{ Storage::url($data->media) }}" type="video/mp4"></video>
                @endif
                <!-- <figcaption class="figure-caption">Path: </figcaption> -->
            </figure>
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
        </div>
    </div>
</div>
<hr>

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
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-sm-4">
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