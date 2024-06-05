@extends('backend.layouts.app')
@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection
@section('breadcrumbs')
<!-- Breadcrumbs code -->
@endsection
@section('content')
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/6.2.3/foundation.min.css"> -->
<style>
 .required-label::after {
            content: ' *';
            color: red;
            display: contents;
            margin-left: 5px;
        }
   .note {
   color: #777; /* Adjust color as needed */
   font-size: 14px; /* Adjust font size as needed */
   margin-top: 5px; /* Adjust margin as needed */
   }
   .step-container {
   display: flex;
   align-items: center;
   margin-bottom: 10px; /* Adjust margin as needed */
   }
   .step-icon {
   width: 30px;
   height: 30px;
   border-radius: 50%;
   background-color: #fff; /* Change to your background color */
   border: 2px solid #ccc; /* Change to your border color */
   text-align: center;
   line-height: 30px;
   margin-right: 10px; /* Adjust margin as needed */
   }
   .completed {
   color: green; /* Change to your tick color */
   }
   .step-container {
   background-color: #f0f0f0;
   padding: 10px;
   border-radius: 5px;
   text-align: center;
   }
   h5 {
   margin: 0;
   color: #333;
   }
   .note-line {
   color: #007bff; /* Blue color for the note */
   margin-top: 10px;
   margin-bottom: 10px;
   }
   hr {
   border: none;
   border-top: 1px solid #ccc;
   margin: 20px 0;
   }
   .video-gallery
   {
   padding:20px 0;
   }
   .column {
   margin-bottom:40;
   padding-right: 15px;
   display: inline-table;
   }
   .large-up-3>.column, .large-up-3>.columns {
   width: 20%;
   float: left;
   }
   .large-up-3>.column:nth-of-type(3n+1), .large-up-3>.columns:nth-of-type(3n+1) {
   clear: both;
   }
   .large-up-3>.columns a img {
   max-width: 100%;
   height: auto;
   -ms-interpolation-mode: bicubic;
   display: inline-block;
   vertical-align: middle;
   }
   .large-up-3>.column a {
   color: #2199e8;
   text-decoration: none;
   line-height: inherit;
   cursor: pointer;
   }
   .medium-3 {
   width: 25%;
   }
   .medium-9 {
   width: 75%;
   }
   .search-video{
   display: block;
   box-sizing: border-box;
   width: 100%;
   height: 2.4375rem;
   padding: .5rem;
   border: 1px solid #cacaca;
   margin: 0 0 1rem;
   font-family: inherit;
   font-size: 1rem;
   color: #0a0a0a;
   background-color: #fefefe;
   box-shadow: inset 0 1px 2px hsla(0, 0%, 4%, .1);
   border-radius: 0;
   -webkit-transition: -webkit-box-shadow .5s, border-color .25s ease-in-out;
   transition: box-shadow .5s, border-color .25s ease-in-out;
   -webkit-appearance: none;
   -moz-appearance: none;
   }
   .video-list{
   max-height: 500px;
   overflow-y: auto;
   overflow-x: hidden;
   }

   .select-video {
   height: 2.4375rem;
   padding: .5rem;
   border: 1px solid #cacaca;
   margin: 0 0 1rem;
   font-size: 1rem;
   font-family: inherit;
   line-height: normal;
   color: #0a0a0a;
   background-color: #fefefe;
   border-radius: 0;
   -webkit-appearance: none;
   -moz-appearance: none;
   /* background-image: url("data:image/svg+xml;utf8,
   <svg xmlns='http://www.w3.org/2000/svg' version='1.1' width='32' height='24' viewBox='0 0 32 24'>
      <polygon points='0,0 32,0 16,24' style='fill: rgb%28138, 138, 138%29'></polygon>
   </svg>
   "); */
   background-size: 9px 6px;
   background-position: right -1rem center;
   background-origin: content-box;
   background-repeat: no-repeat;
   padding-right: 1.5rem;
   }
</style>
<div class="card">
   <div class="card-body">
      <x-backend.section-header>
         <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>
         <x-slot name="subtitle">
            @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
         </x-slot>
         <x-slot name="toolbar">
            <x-backend.buttons.return-back />
         </x-slot>
      </x-backend.section-header>
      <div class="step-container">
         <h5>{{$store->store_name}}</h5>
      </div>
      <div class="note-line">Note: Add advertisement here for the store and then assign it to ad campaigns.</div>
      <hr>
      {{ html()->form('POST', route('backend.stores.storeAdvertisement'))->class('form-horizontal')->id('myForm')->open() }}
      {{ csrf_field() }}
      <div class="row mt-4">
         <div class="col">
            <div class="form-group row mb-3" id="adv_name">
               <label class="col-sm-2 form-control-label required-label">Advertisement Name</label>
               <div class="col-sm-10">
                  <div class="input-group">
                     <!-- Static read-only text -->
                     <div class="input-group-prepend">
                        <span class="input-group-text">{{$store->store_name}}{{$advertisement_count_for_name}}_adv-</span>
                     </div>
                     <!-- Input text field -->
                     <input type="text" class="form-control" name="advertisement_name" placeholder="Enter advertisement name" required>
                     <input type="hidden" class="form-control" name="advertisement_name_hid" value="{{$store->store_name}}{{$advertisement_count_for_name}}_adv-">
                  </div>
                  <!-- Note -->
                  <div class="note">This is used for internal use only.</div>
                  <div id="adv_name_error" style="color: red;"></div>
               </div>
            </div>
            <hr>
            <!-- ////video gallery start -->
            <div class="row">
               <div class="col-lg-12" id="adv_video" >
                  <div class="row">
                     <div class="columns medium-12 small-centered">
                        <!-- <h4 class="float-left"> -->
                        <label class="required-label">Select Video
                        </label>
                        <div class="note">Select any one video from list.</div>
                     </div>
                  </div>
                  <div id="videoGallery" class="video-gallery">
                     <!-- Video -->
                     <div class="row" data-video-container style="display:none;">
                        <div class="columns medium-12">
                           <div class="flex-video widescreen">
                              <iframe data-video width="1600" height="900" src="" frameborder="0" allowfullscreen></iframe>
                           </div>
                        </div>
                     </div>
                     <!-- Search / Filter -->
                     <div class="row">
                        <div class="columns medium-3">
                           <select name="category" class="select-video" id="filter">
                              <option selected="selected" value="">View All Videos</option>
                              <option value="Uploaded Video">Upload Video</option>
                              <option value="Youtube Link">Youtube Link</option>
                              <option value="Vimeo Link">Vimeo Link</option>
                           </select>
                        </div>
                        <div class="columns medium-9">
                           <input id="search" class="search search-video" type="text" placeholder="search">
                        </div>
                     </div>
                     <div class="video-list">
                        <!-- Thumbnails -->
                        <div id="thumbnails" class="list row small-up-1 medium-up-2 large-up-3">
                           @foreach($adv_videos as $key => $adv_video)
                           <div class="column">
                              <a href="#">
                                 @if($adv_video->media_type == "Video" || $adv_video->media_type == "video") 
                                 <video width="200" height="120" controls>
                                    <source src="{{ Storage::url($adv_video->media) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                 </video>
                                 @elseif($adv_video->media_type == "Youtube" || $adv_video->media_type == "youtube") 
                                 <iframe width="200" height="120" src="{{ $adv_video->media }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                 @elseif($adv_video->media_type == "Vimeo" || $adv_video->media_type == "vimeo") 
                                 <iframe src="{{ $adv_video->media }}" width="200" height="120" frameborder="0" allowfullscreen></iframe>
                                 @endif
                                
                                 
                                 @if($adv_video->media_type == "Video" || $adv_video->media_type == "video") 
                                 <span class="category" style="display: none;">Uploaded Video</span>
                                 @elseif($adv_video->media_type == "Youtube" || $adv_video->media_type == "youtube")
                                 <span class="category" style="display: none;">Youtube Link</span>
                                 @elseif($adv_video->media_type == "Vimeo" || $adv_video->media_type == "vimeo") 
                                 <span class="category" style="display: none;">Vimeo Link</span>
                                 @endif
                              </a>
                              <div style="display:flex; align-items: baseline;"> <input style="margin-right:6px;" type="radio" id="html" name="video_id" value="{{$adv_video->id}}"><br/><span style="font-size: 14px;" class="name"><strong>{{$adv_video->title}}</strong></span><br /></div>
                           </div>
                           @endforeach   
                        </div>
                        <div id="adv_video_error" style="color: red;"></div>
                        <!-- End Row -->
                     </div>
                  </div>
                  <!-- End search-results -->
               </div>
            </div>
            <hr>
            <div class="form-group row mb-3" id="adv_heading">
               <label class="col-sm-2 form-control-label required-label">Heading</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" name="heading" placeholder="Enter heading for frontend" required>
                  <div class="note">This heading is used for frontend.</div>
                  <div id="adv_heading_error" style="color: red;"></div>
               </div>
            </div>
            <hr>
            <!-- ////image gallery start -->
            <div class="row">
               <div class="col-lg-12" id="adv_primary" >
                  <div class="row">
                     <div class="columns medium-12 small-centered">
                        <!-- <h4 class="float-left"> -->
                        <lable class="required-label">Select Primary Image</lable>
                        <div class="note">Select multiple images from list for carousel.</div>
                     </div>
                  </div>
                  <div id="imageGallery" class="video-gallery">
                     <!-- Video -->
                     <div class="row" data-video-container style="display:none;">
                        <div class="columns medium-12">
                           <div class="flex-video widescreen">
                              <iframe data-video width="1600" height="900" src="" frameborder="0" allowfullscreen></iframe>
                           </div>
                        </div>
                     </div>
                     <!-- Search / Filter -->
                     <div class="row">
                        <div class="columns medium-12">
                           <input id="search-image" class="search search-video" type="text" placeholder="search">
                        </div>
                     </div>
                     <div class="video-list">
                        <!-- Thumbnails -->
                        <div id="thumbnails1" class="list row small-up-1 medium-up-2 large-up-3">
                           @php $firstIteration = true; @endphp
                           @foreach($adv_images as $key => $adv_image)
                           @if($adv_image->image_type == 'primary')
                           <div class="column">
                              <a href="#">
                              <img src="{{ Storage::url($adv_image->image) }}" class="figure-img img-fluid rounded img-thumbnail" alt="" width="200">
                              
                              </a>
                              <div style="display:flex; align-items: baseline;">
                              <input style="margin-right:6px" type="checkbox" id="html{{ $key }}" name="primary_image_id[]" value="{{ $adv_image->id }}"><br/>
                              <span class="name"><strong>{{$adv_image->title}}</strong></span>
                              </div>
                           </div>
                           @php $firstIteration = false; @endphp <!-- Update flag after the first iteration -->
                           @endif 
                           @endforeach   
                        </div>
                        <div id="adv_primary_error" style="color: red;"></div>
                        <!-- End Row -->
                     </div>
                  </div>
                  <!-- End search-results -->
               </div>
            </div>
            <!-- ////image gallery end --> 
            <hr>
            <!-- ////image secondary gallery start -->
            <div class="row">
               <div class="col-lg-12" id="adv_secondary" >
                  <div class="row">
                     <div class="columns medium-12 small-centered">
                        <lable class="">Select Secondary Image</lable>
                        <div class="note">Select multiple images from list for carousel.</div>
                     </div>
                  </div>
                  <div id="imageGallerySecondary" class="video-gallery">
                     <!-- Video -->
                     <div class="row" data-video-container style="display:none;">
                        <div class="columns medium-12">
                           <div class="flex-video widescreen">
                              <iframe data-video width="1600" height="900" src="" frameborder="0" allowfullscreen></iframe>
                           </div>
                        </div>
                     </div>
                     <!-- Search / Filter -->
                     <div class="row">
                        <div class="columns medium-12">
                           <input id="search-image-secondary" class="search search-video" type="text" placeholder="search">
                        </div>
                     </div>
                     <div class="video-list">
                        <!-- Thumbnails -->
                        <div id="thumbnails" class="list row small-up-1 medium-up-2 large-up-3">
                           @php $firstIteration = true; @endphp
                           @foreach($adv_images as $key => $adv_image)
                           @if($adv_image->image_type == 'secondary')
                           <div class="column">
                              <a href="#">
                              <img src="{{ Storage::url($adv_image->image) }}" class="figure-img img-fluid rounded img-thumbnail" alt="" width="200">
                              
                              </a>
                              <div style="display:flex; align-items: baseline;">
                              <input style="margin-right:6px" type="checkbox"  name="secondary_image_id[]" value="{{$adv_image->id}}"><br />
                              <span class="name"><strong>{{$adv_image->title}}</strong></span>
                              </div>
                           </div>
                           @php $firstIteration = false; @endphp
                           @endif 
                           @endforeach   
                        </div>
                        <div id="secondary_error" style="color: red;"></div>
                        <!-- End Row -->
                     </div>
                  </div>
                  <!-- End search-results -->
               </div>
            </div>
            <!-- ////image secondary gallery end --> 
            <hr>
            <div class="form-group row mb-3" id="adv_other">
               <label class="col-sm-2 form-control-label required-label">Other Prizes Heading</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" name="heading_other_prize" placeholder="Enter other prize heading for frontend" required>
                  <div class="note">This heading is used for other prized - on frontend.</div>
                  <div id="adv_other_heading_error" style="color: red;"></div>
               </div>
            </div>
            <hr>
            <!-- ////image other coupons start -->
            <div class="row">
               <div class="col-lg-12" id="adv_other_coupon">
                  <div class="row">
                     <div class="columns medium-12 small-centered">
                        <!-- <h4 class="float-left"> -->
                        <label class="required-label">Select Other Coupons Images</label>
                        <div class="note">Select multiple images from list to show other coupons.</div>
                     </div>
                  </div>
                  <div id="imageGalleryOtherCoupon" class="video-gallery">
                     <!-- Video -->
                     <div class="row" data-video-container style="display:none;">
                        <div class="columns medium-12">
                           <div class="flex-video widescreen">
                              <iframe data-video width="1600" height="900" src="" frameborder="0" allowfullscreen></iframe>
                           </div>
                        </div>
                     </div>
                     <!-- Search / Filter -->
                     <div class="row">
                        <div class="columns medium-12">
                           <input id="search-image-other-coupon" class="search search-video" type="text" placeholder="search">
                        </div>
                     </div>
                     <div class="video-list">
                        <!-- Thumbnails -->
                        <div id="thumbnails" class="list row small-up-1 medium-up-2 large-up-3">
                           @php $firstIteration = true; @endphp
                           @foreach($other_images as $key => $other_image)
                           <div class="column">
                              <a href="#">
                              <img src="{{ Storage::url($other_image->media) }}" class="figure-img img-fluid rounded img-thumbnail" alt="" width="200">
                              
                              </a>
                              <div style="display:flex; align-items: baseline;">
                              <input style="margin-right:6px" type="checkbox"  name="other_coupon_image_ids[]" value="{{$other_image->id}}"><br />
                              <span class="name"><strong>{{$other_image->title}}</strong></span>
                              </div>
                           </div>
                           @php $firstIteration = false; @endphp
                           @endforeach   
                        </div>
                        <div id="adv_other_coupon_error" style="color: red;"></div>
                        <!-- End Row -->
                     </div>
                  </div>
                  <!-- End search-results -->
               </div>
            </div>
            <!-- ////image secondary gallery end --> 
            <hr>
            <!-- ////coupon select -->
            <div class="row">
               <div class="col-lg-12" id="adv_winning">
                  <div class="row">
                     <div class="columns medium-12 small-centered">
                        <label class="required-label">Select Winning Prizes</label>
                        <div class="note">Select multiple coupons and add no. of coupons to win</div>
                     </div>
                  </div>
                  <div id="imageGalleryCoupon" class="video-gallery">
                     <!-- Video -->
                     <div class="row" data-video-container style="display:none;">
                        <div class="columns medium-12">
                           <div class="flex-video widescreen">
                              <iframe data-video width="1600" height="900" src="" frameborder="0" allowfullscreen></iframe>
                           </div>
                        </div>
                     </div>
                     <!-- Search / Filter -->
                     <div class="row">
                        <div class="columns medium-3">
                           <select name="category_coupon" id="category_coupon" class="select-video" id="filter_coupon">
                              <option selected="selected" value="">View All Coupons</option>
                              <option value="Physical Coupon Prize">Physical Coupon Prize</option>
                              <option value="Service Coupon Prize">Service Coupon Prize</option>
                           </select>
                        </div>
                        <div class="columns medium-9">
                           <input id="search-image-coupon" class="search search-video" type="text" placeholder="search">
                        </div>
                     </div>
                     <div class="video-list" id="videoGalleryCoupon">
                        <!-- Thumbnails -->
                        <div id="thumbnails" class="list row small-up-1 medium-up-2 large-up-3">
                        @php $firstIteration_c = true; @endphp

                        @foreach($coupons as $key => $coupon)
                            <div class="column category_coupon mb-4" data-category="{{ $coupon->category }}">
                                <a href="#">
                                    <!-- <img src="{{ Storage::url($coupon->image) }}" class="" alt="" height="100" width="200"> -->
                                    <!-- <span class="category_coupon" style="display: none;"></span> -->
                                    @if($coupon->category == "physical" || $coupon->category == "Physical") 
                                        <span class="category_coupon" style="display: none;">Physical Coupon Prize</span>
                                    @elseif($coupon->category == "service" || $coupon->category == "Service")
                                        <span class="category_coupon" style="display: none;">Service Coupon Prize</span>
                                    @endif
                                </a>
                                @if($coupon->total_coupons > 0)
                                <input type="checkbox" name="coupon_id[]" value="{{$coupon->id}}" class="mr-2">
                                    <span class="name"><strong>
                                        @if(strlen($coupon->title) > 12)
                                            {{ substr($coupon->title, 0, 12) }}...
                                        @else
                                            {{ $coupon->title }}
                                        @endif
                                    </strong>
                                    @php
                                    $color = '';
                                    if ($coupon->total_coupons >= 10) {
                                        $color = 'green';
                                    } elseif ($coupon->total_coupons >= 5) {
                                        $color = 'orange';
                                    } else {
                                        $color = 'red';
                                    }
                                @endphp
                                <!-- color: {{ $color }} -->
                                <span style="color:gray;">available-<span style="">{{ $coupon->total_coupons }}</span></span>
                         
                                 </span><br />
                                 <input type="number" name="no_of_coupon[]" placeholder="Enter no. of coupons" class="coupon-input mt-2" data-max="{{ $coupon->total_coupons }}" required><br/>
                                    <!-- <div class="note">e.g- if you enter 100, it means that the prize will be awarded after the 99th customer.</div> -->
                                 <div class="col-sm-12 mt-2">
                                    <span>1</span>
                                    <label for="denominator">out of : </label>
                                    <input type="number" name="winning_ratio[]" placeholder="Enter Ratio" class="ratio-input" required>
                           
                                 </div>
                                @else
                                <input type="checkbox" name="" value="{{$coupon->id}}" disabled >
                                    <span class="name" style="color:grey;"><strong>
                                        @if(strlen($coupon->title) > 12)
                                            {{ substr($coupon->title, 0, 12) }}...
                                        @else
                                            {{ $coupon->title }}
                                        @endif
                                    </strong></span><br />
                                    <input type="text" name=""                                  placeholder="Enter no. of coupons" value="" disabled><br/>
                                @endif
                                 </div>
                            @if($coupon->total_coupons > 0)
                            @php $firstIteration_c = false; @endphp
                            @endif  
                        @endforeach
 
                        </div>
                        <div id="adv_winning_error" style="color: red;"></div>
                        <div id="adv_winning_error_ratio" style="color: red;"></div>
                        <input type="hidden" name="user_id" value="{{$store->user_id}}" >
                        <!-- End Row -->
                     </div>
                  </div>
                  <!-- End search-results -->
               </div>
            </div>
            <!-- ////coupon end --> 
            <!-- <div class="form-group row mb-3" id="adv_lock">
               <label class="form-control-label required-label">Lock Time</label>
               <div class="note">Lock advertisement for specific time in hours</div>
               <div class="col-sm-3">
                  <select class="form-control" name="lock_time" id="lock_time" required>
                     <option value="">--Select--</option>
                     <option value="1">1 hour</option>
                     <option value="6">6 hours</option>
                     <option value="12">12 hours</option>
                     <option value="18">18 hours</option>
                     <option value="24">24 hours</option>
                     <option value="30">30 hours</option>
                     <option value="36">36 hours</option>
                     <option value="42">42 hours</option>
                     <option value="48">48 hours</option>
                  </select>
               </div>
               <div id="adv_lock_error" style="color: red;"></div>
             
            </div> -->
            <!-- <div class="form-group row mb-3">
               <label class="col-sm-2 form-control-label">Winning Ratio</label>
               <div class="note">e.g- if you enter 100, it means that the prize will be awarded after the 99th customer.</div>
               <div class="col-sm-10">
                  <span>1</span>
                  <label for="denominator">out of : </label>
                  <input type="number" name="winning_ratio" class="ratio-input" required>
              
               </div>
            </div> -->
         </div>
      </div>
      <div class="row mt-4">
         <div class="col">
            <div class="form-group">
               <!-- Buttons for submitting and canceling the form -->
               <button type="submit" id="preview_winning" name="action" value="preview_winning" class="adv_btn btn btn-warning">
                    Preview Winning
                </button>
                <button type="submit" id="preview_lose" name="action" value="preview_lose" class="adv_btn btn btn-warning">
                    Preview Lose
                </button>
               <x-buttons.create title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}" class="adv_btn">
                  {{__('Create')}}
               </x-buttons.create>
               <div class="float-end">
                  <div class="form-group">
                     <x-buttons.cancel />
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{ html()->form()->close() }}
   </div>
   <div class="card-footer">
      <div class="row  mb-3">
         <div class="col">
            <small class="float-end text-muted"></small>
         </div>
      </div>
   </div>
</div>
<div class="card mt-4">
   <div class="card-body table-responsive">
      <h5 class="card-title">Advertisement List</h5>
      <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
         <thead>
            <tr>
               <th>ID</th>
               <th>Advertisement Name</th>
               <th>Video</th>
               <!-- <th>Action</th> -->
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
   $('.coupon-input').on('input', function() {
    var enteredValue = parseInt($(this).val());
    var maxAllowed = parseInt($(this).data('max'));
    if (enteredValue > maxAllowed) {
        $(this).val(maxAllowed);
    }
});

   $('#datatable').DataTable({
       processing: true,
       serverSide: true,
       autoWidth: true,
       responsive: true,
       ajax: '{{ route("backend.$module_name.advertisement_index", ['storeId' => ':storeId']) }}'.replace(':storeId', '{{ $store->user_id }}'),
       columns: [{
               data: 'id',
               name: 'id'
           },
           {
               data: 'advertisement_name',
               name: 'advertisement_name'
           },
           {
               data: 'media', 
               name: 'media',
           },
         //   {
         //       data: 'edit_advertisement',
         //       name: 'edit_advertisement'
         //   },
       ]
   });
   
   $(function() {
   
       // Search
       var options = {
           valueNames: ['name', 'category' ]
       };
       var videoList = new List('videoGallery', options);
       
       $("#search").change(function() {
           // smooth scroll to thumbnails
           $('html, body').animate({
               scrollTop: $("#thumbnails").offset().top-60
           }, 1000);  
       });
       
       // Filter
       $('#filter').change(function () {
           var selection = this.value;
           if (selection) {
           videoList.filter(function(item) {
               return (item.values().category == selection);
           });
           } else {
           videoList.filter();
           }
         });
        });
   
        var options_coupons = {
           valueNames: ['name', 'category_coupon']
           };
       var videoListCoupon = new List('videoGalleryCoupon', options_coupons);
   
       $('#category_coupon').change(function () {
           var selection = $(this).val();
           videoListCoupon.filter(function(item) {
               return !selection || item.values().category_coupon === selection;
           });
       });
   
   
        ////image search
        var options_image = {
           valueNames: ['name', 'category' ]
       };
        var imageList = new List('imageGallery', options_image);
        $("#search-image").change(function() {
           // smooth scroll to thumbnails
           $('html, body').animate({
               scrollTop: $("#thumbnails").offset().top-60
           }, 1000);  
       });
   
         ////image secondary search
         var options_image_secondary = {
           valueNames: ['name', 'category' ]
       };
        var imageListSecondary = new List('imageGallerySecondary', options_image_secondary);
        $("#search-image-secondary").change(function() {
           // smooth scroll to thumbnails
           $('html, body').animate({
               scrollTop: $("#thumbnails").offset().top-60
           }, 1000);  
       });
   
   
       ////coupon search
       var options_image_secondary = {
           valueNames: ['name', 'category' ]
       };
        var imageListSecondary = new List('imageGalleryCoupon', options_image_secondary);
        $("#search-image-coupon").change(function() {
           // smooth scroll to thumbnails
           $('html, body').animate({
               scrollTop: $("#thumbnails").offset().top-60
           }, 1000);  
       });
   
        ////coupon other search
         var options_image_secondary = {
           valueNames: ['name', 'category_coupon']
       };
        var imageListSecondary = new List('imageGalleryOtherCoupon', options_image_secondary);
        $("#search-image-coupon-other").change(function() {
           // smooth scroll to thumbnails
           $('html, body').animate({
               scrollTop: $("#thumbnails").offset().top-60
           }, 1000);  
       });
   
           //Get URL query string
           function getQueryVariable(variable) {
               var query = window.location.search.substring(1);
               var vars = query.split("&");
               for (var i = 0; i < vars.length; i++) {
               var pair = vars[i].split("=");
               if (pair[0] == variable) { return pair[1]; }
               }
               return (false);
           }
           // Get URL query string variables
           var id = getQueryVariable("id");
           var title = getQueryVariable("title");
   
           if(id) {
           $("[data-video-container]").show(); 
               $("[data-video]").attr("src", "https://www.youtube.com/embed/" + id);
           }
   
           if(title) {
           var videoTitle = title.replace(/\+/g, " ");
           $("[data-title]").html(videoTitle);
           }

     @if(session()->has('new_tab_route'))
        window.open("{{ route(session('new_tab_route.route'), session('new_tab_route.parameters')) }}", "_blank");
        // Remove the session data after opening the new tab
        {{ session()->forget('new_tab_route') }}
    @endif

</script>

<script>
$(document).ready(function() {
    $('.adv_btn').click(function(e) {
        e.preventDefault();
        var clickedButtonValue = this.value;

        var hasError = false;
        // Function to show error messages to the respective field
        function showError(errorField, errorMessage) {
            $(errorField).text(errorMessage);
            hasError = true;
        }
        function removeError(errorField) {
            $(errorField).text('');
        }

         // Validate advertisement_name
         if ($('input[name="advertisement_name"]').val() === '') {
            showError('#adv_name_error', 'Please enter advertisement name.', '#adv_name');
         } else {
            removeError('#adv_name_error', '#adv_name');
         }

         // Validate video_id
         if ($('input[name="video_id"]:checked').length === 0) {
            showError('#adv_video_error', 'Please select advertisement video.', '#adv_video');
         } else {
            removeError('#adv_video_error', '#adv_video');
         }

         // Validate heading
         if ($('input[name="heading"]').val() === '') {
            showError('#adv_heading_error', 'Please enter heading.', '#adv_heading');
         } else {
            removeError('#adv_heading_error', '#adv_heading');
         }

         // Validate heading_other_prize
         if ($('input[name="heading_other_prize"]').val() === '') {
            showError('#adv_other_heading_error', 'Please enter other prize heading.', '#adv_other');
         } else {
            removeError('#adv_other_heading_error', '#adv_other');
         }

        var primary_image_id_checkedValues = $('input[name="primary_image_id[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        var secondary_image_id_checkedValues = $('input[name="secondary_image_id[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        var other_coupon_image_ids_checkedValues = $('input[name="other_coupon_image_ids[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        var coupon_id_checkedValues = $('input[name="coupon_id[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        var no_of_coupon_checkedValues = $('input[name="no_of_coupon[]"]').map(function() {
            return $(this).val();
        }).get();

        var no_of_winning_ration_checkedValues = $('input[name="winning_ratio[]"]').map(function() {
            return $(this).val();
        }).get();

        if (primary_image_id_checkedValues.length === 0) {
            showError('#adv_primary_error', 'Please select at least one primary image.');
        }
        else{
            removeError('#adv_primary_error');
        }

      //   if (secondary_image_id_checkedValues.length === 0) {
      //       showError('#secondary_error', 'Please select at least one secondary image.', '#imageGallerySecondary');
      
      //   }
      //   else{
      //       removeError('#secondary_error');
      // 
      //   }

        if (other_coupon_image_ids_checkedValues.length === 0) {
            showError('#adv_other_coupon_error', 'Please select at least one other coupon image.', '#adv_other_coupon');
        }
        else{
            removeError('#adv_other_coupon_error');
        }

        if (coupon_id_checkedValues.length === 0) {
            showError('#adv_winning_error', 'Please select at least one winning prize.', '#adv_winning');
        }
        else{
            removeError('#adv_winning_error');
        }

        var couponCheckboxes = $('input[name="coupon_id[]"]');
        var numberOfCouponsInputs = $('input[name="no_of_coupon[]"]');
        var winningRatioInputs = $('input[name="winning_ratio[]"]');

         for (var i = 0; i < couponCheckboxes.length; i++) {
            if (couponCheckboxes[i].checked) {
               if (!numberOfCouponsInputs[i].value) {
                     // Show error message or perform validation here
                     showError('#adv_winning_error', 'Please enter no of coupons.', '#adv_winning');
                     // For example, you can show an error message or perform other validation logic
               }
               else{
                  removeError('#adv_winning_error');
         
               }
               if (!winningRatioInputs[i].value) {
                     // Show error message or perform validation for missing winning ratio
                     showError('#adv_winning_error_ratio', 'Please enter ratio.', '#adv_winning');
                     // For example, you can show an error message or perform other validation logic
               }
               else{
                  removeError('#adv_winning_error_ratio');
         
               }
            }
            else {
               // If the coupon is not checked, but its associated inputs have values, show an error
               if (numberOfCouponsInputs[i].value || winningRatioInputs[i].value) {
                     showError('#adv_winning_error', 'Please select the winning prize first.', '#adv_winning');
                     // You may show an error message or perform other actions as needed
               }
            }
         }

     
        if (hasError) {
            return;
        }

      
        var customData = {
            advertisement_name: $('input[name="advertisement_name"]').val(),
            advertisement_name_hid: $('input[name="advertisement_name_hid"]').val(),
            video_id: $('input[name="video_id"]:checked').val(),
            heading: $('input[name="heading"]').val(),
           // primary_image_id: $('input[name="primary_image_id"]:checked').val(),
            primary_image_id: primary_image_id_checkedValues,
            secondary_image_id: secondary_image_id_checkedValues,
            heading_other_prize: $('input[name="heading_other_prize"]').val(),
            other_coupon_image_ids: other_coupon_image_ids_checkedValues,
            category_coupon: $('select[name="category_coupon"]').val(),
            coupon_id: coupon_id_checkedValues,
            no_of_coupon: no_of_coupon_checkedValues,
           // lock_time: $('select[name="lock_time"]').val(),
            winning_ratio: no_of_winning_ration_checkedValues,
            user_id: $('input[name="user_id"]').val(),
            action: clickedButtonValue,
            _token: '{{csrf_token()}}'
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var jsonData = JSON.stringify(customData);
        $.ajax({
            type: 'POST',
            url: '{{ route("backend.stores.storeAdvertisement") }}', // URL to submit form data
            data: jsonData,
            contentType: "application/json",
            success: function(response) {
                //console.log(response);
                   if(response.response_type == 'store'){
                  window.scrollTo(0, 0);
                  setTimeout(function() {
                     location.reload();
                  }, 1000); 
                }else{
                  var APP_URL = {!! json_encode(url('/')) !!}
                  var url = APP_URL+'/admin/stores/'+response.storeId+'/'+response.request_action+'/preview_advertisement';
                  window.open(url, '_blank');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Remove error message when input is changed
    $('input, select').on('input change', function() {
        var errorField = $(this).data('error-field');
        if (errorField) {
            $(errorField).empty();
        }
    });

    // Initialize checkbox and related input fields
    $('input[name="coupon_id[]"]').each(function() {
        var $this = $(this);
        var $input = $this.closest('div').find('input[name="no_of_coupon[]"]');
        $input.prop('required', $this.is(':checked'));
    }).change(function() {
        var $this = $(this);
        var $input = $this.closest('div').find('input[name="no_of_coupon[]"]');
        $input.prop('required', $this.is(':checked'));
    });
});
   </script>
@endpush