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
            <small class="form-text text-muted">This title is used for internal use only.</small>
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
    <div class="col-4">
        <div class="float-end">
            <figure class="figure">
                
                <a href="{{ Storage::url($data->media) }}" data-lightbox="image-set" data-title="Path: {{ Storage::url($data->media) }}">
                    <img src="{{ Storage::url($data->media) }}" class="figure-img img-fluid rounded img-thumbnail" alt="">
                </a>
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
            <small class="form-text text-muted">This field is used for internal use only.</small>
        </div>
    </div>
</div>
