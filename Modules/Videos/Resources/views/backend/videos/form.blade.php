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
</div>

<div class="row mb-3">
    <div class="col-8">
        <div class="form-group">
            <?php
            $field_name = 'media_type';
            $field_label = label_case($field_name);
            $field_placeholder = $field_label;
            $required = $data ? '' : 'required';
            ?>

            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
   
            <div id="media-type-options">
       
                <label class="media-option">
                    {{ html()->radio('media_type', 'video')->id('video')->value('video') }}
                    Video
                </label>
                <label class="media-option">
                    {{ html()->radio('media_type', 'youtube')->id('youtube')->value('youtube') }}
                    YouTube
                </label>
                <label class="media-option">
                    {{ html()->radio('media_type', 'vimeo')->id('vimeo')->value('vimeo') }}
                    Vimeo
                </label>
            </div>

            <div id="file-inputs">
                <div id="video-input" style="display: none;">
                    {{ html()->input("file", 'video_file')->class('form-control')->attributes(["accept" => "video/mp4, video/MOV, video/WMV"]) }}
                </div>
                <div id="youtube-input" style="display: none;">
                    {{ html()->text("youtube_link")->placeholder('Youtube Link')->class('form-control')->value($data ? $data->media : '' ) }}
                </div>
                <div id="vimeo-input" style="display: none;">
                    {{ html()->text("vimeo_link")->placeholder('Vimeo Link')->class('form-control')->value($data ? $data->media : '' ) }}
                </div>
            </div>
        </div>
    </div>
</div>
  
    @if($data)
    <div class="col-4">
        <div class="float-end">
            <figure class="figure">
                @if($data->media_type == "Video" || $data->media_type == "video") 
                    <video width="380" height="240" controls>
                    <source src="{{ Storage::url($data->media) }}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                @elseif($data->media_type == "Youtube" || $data->media_type == "youtube") 
                    <iframe width="380" height="240" src="{{ $data->media }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @elseif($data->media_type == "Vimeo" || $data->media_type == "vimeo") 
                    <iframe src="{{ $data->media }}" width="380" height="240" frameborder="0" allowfullscreen></iframe>

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


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var isData = <?php  echo json_encode($data); ?>;

        if(isData.media_type == 'video' || isData.media_type == 'Video'){
            showInput('video-input');
            hideInput('youtube-input');
            hideInput('vimeo-input'); 
            document.getElementById('video').checked = true; 
        }
        if(isData.media_type == 'youtube'){
            showInput('youtube-input');
            hideInput('video-input');
            hideInput('vimeo-input');  
            document.getElementById('youtube').checked = true;
        }
        if(isData.media_type == 'vimeo'){
            showInput('vimeo-input');
            hideInput('youtube-input');
            hideInput('video-input');  
            document.getElementById('vimeo').checked = true;
        }
        
    
        const mediaTypeOptions = document.getElementById('media-type-options');
        const fileInputs = document.getElementById('file-inputs');

        mediaTypeOptions.addEventListener('change', function () {
            console.log('Media type change event fired');
            const selectedMediaType = document.querySelector('input[name="media_type"]:checked').id;
            console.log('Selected media type:', selectedMediaType);

            switch (selectedMediaType) {
                case 'video':
                    showInput('video-input');
                    hideInput('youtube-input');
                    hideInput('vimeo-input');
                    if (!isData) {
                        document.getElementById('video_file').setAttribute('required', 'required');
                        document.getElementById('youtube_link').removeAttribute('required');
                        document.getElementById('vimeo_link').removeAttribute('required');
                    }

                    break;
                case 'youtube':
                    showInput('youtube-input');
                    hideInput('video-input');
                    hideInput('vimeo-input');
                    if (!isData) {
                        document.getElementById('video_file').removeAttribute('required');
                        document.getElementById('youtube_link').setAttribute('required', 'required');
                        document.getElementById('vimeo_link').removeAttribute('required');
                    }
                    break;
                case 'vimeo':
                    showInput('vimeo-input');
                    hideInput('video-input');
                    hideInput('youtube-input');
                    if (!isData) {
                        document.getElementById('video_file').removeAttribute('required');
                        document.getElementById('youtube_link').removeAttribute('required');
                        document.getElementById('vimeo_link').setAttribute('required', 'required');
                    }
                    break;
                default:
                    break;
            }
        });

        function hideInput(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.style.display = 'none';
            }
        }

        function showInput(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.style.display = 'block';
            }
        }
        
        // Ensure default state
        if (!isData) {
            showInput('video-input');
            document.getElementById('video').checked = true;
            document.getElementById('video_file').setAttribute('required', 'required');
        }
    });
</script>