<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>
    page
  </title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="permissions-policy" content="fullscreen=(), geolocation=()">
  <!-- Favicons -->
<!--   <link href="" rel="icon">
  <link href="" rel="apple-touch-icon" -->

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/Impact/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/Impact/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/Impact/assets/css/main.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet"> 
  <link href="{{ asset('assets/css/wheel.css') }}" rel="stylesheet"> 
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->

</head>

<body>

  <main id="main">
    <!-- ======= Call To Action Section ======= -->

    <section id="call-to-action" class="call-to-action">
    <div class="banner-img">
      <div class="container text-center" data-aos="zoom-out">
      
      @if($advertisement_video->media_type == "Video" || $advertisement_video->media_type == "video") 
      <video id="video-player" width="100%" height="100%" controls>
        <source src="{{ Storage::url($advertisement_video->media) }}" type="video/mp4">
        Your browser does not support the video tag.
      </video>
      @elseif($advertisement_video->media_type == "Youtube" || $advertisement_video->media_type == "youtube") 
      <div id="player"></div>
      <!-- <iframe id="youtube-player" width="100%" height="100%" src="{{ $advertisement_video->media }}" frameborder="0" allowfullscreen></iframe> -->
      @elseif($advertisement_video->media_type == "Vimeo" || $advertisement_video->media_type == "vimeo") 
      <iframe id="vimeo-player" src="{{ $advertisement_video->media }}" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
      @endif
      </div>
       </div>
    </section>
 
    <!-- End Call To Action Section -->

   
<section id="second-section" class="second-section">
  <div class="container" data-aos="zoom-out">
   <div class="section-header">
          <h4>{{$advertisement_detail->heading}}</h4>
        </div>

        <div class="row gx-lg-0 gy-4">

          <div class="col-lg-12 ">
          <div class="vacation-banner">
            <div class="itinerary-tag">
              <div class="itinerary-box">
                <ul>
                <?php $free_services_str = $primary_image->free_services;
                  $primary_free_services = explode(",", $free_services_str);
                  if(in_array('Flight',$primary_free_services)){
                  ?>
                  <li><img src="{{ asset('assets/img/airplane.svg') }}"></li>
                  <?php } 
                  if(in_array('Visa',$primary_free_services)){
                  ?>
                  <li><img src="{{ asset('assets/img/bed.svg') }}"></li>
                  <?php } 
                   if(in_array('Documentation',$primary_free_services)){
                  ?>
                  <li><img src="{{ asset('assets/img/doc.svg') }}"></li>
                  <?php } ?>
        
                </ul>
              </div>
            </div>
            <div class="bottom-shadow"></div>
            <img class="vacation-img" src="{{ url('/storage').'/'.$primary_image->image }}">
            <h5>{{$primary_image->title}}</h5>
          </div>
          </div>
        </div>
  </div>
</section>


<section id="crousel">
    <div class="container">
    <div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-indicators">
        @foreach($secondary_images as $key => $secondary_image)
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($secondary_images as $key => $secondary_image)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="itinerary-tag">
                  <div class="itinerary-box">
                    <ul>
                    <?php $free_services_str = $secondary_image->free_services;
                          $secondary_free_services = explode(",", $free_services_str);
                    ?>
                    @if(in_array('Flight',$secondary_free_services)) <li><img src="{{ asset('assets/img/airplane.svg') }}"></li>@endif
                    @if(in_array('Visa',$secondary_free_services))  <li><img src="{{ asset('assets/img/bed.svg') }}"></li>@endif
                    @if(in_array('Documentation',$secondary_free_services))  <li><img src="{{ asset('assets/img/doc.svg') }}"></li>@endif
                    </ul>
                  </div>
                </div> 
                <img src="{{ Storage::url($secondary_image->image) }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-md-block">
            
                    <!-- Add your dynamic content here if needed -->
                    <h5>{{ $secondary_image->title }}</h5>
                </div>
            </div>
        @endforeach
    </div>
  </div>
  </div>
  </section>

    <!-- ======= prizes Section ======= -->
    <section id="prizes" class="prizes">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h4>{{$advertisement_detail->other_coupon_prize_heading}}</h4>
        </div>

        <div class="row gx-lg-0 gy-4">
          @foreach($other_images as $other_image)
          <div class="col-4">
            <!-- <div class="prizes-box"> -->
              <div>
              <img src="{{ url('/storage').'/'.$other_image->media }}">
          </div>
           <h6>{{$other_image->title}}</h6>
          </div>
          @endforeach
              
      </div>
    </div>
    </section><!-- End Contact Section -->

    <section id="prizes" class="prizes">
    <div id="wheel">
            <div id="inner-wheel">
                <div class="sec"><span class="fa fa-bell-o"></span></div>
                <div class="sec"><span class="fa fa-comment-o"></span></div>
                <div class="sec"><span class="fa fa-smile-o"></span></div>
                <div class="sec"><span class="fa fa-heart-o"></span></div>
                <div class="sec"><span class="fa fa-star-o"></span></div>
                <div class="sec"><span class="fa fa-lightbulb-o"></span></div>
            </div>       
           
            <div id="spin">
                <div id="inner-spin"></div>
            </div>
            
            <div id="shine"></div>
            <div id="spinner-overlay"> <div id="locked-text"><i class="bi bi-lock custom-lock-icon"></i></div></div> 
        </div>
        
        
        <!-- <div id="txt"></div> -->
    </section><!-- End spin wheel Section -->

    <section class="spinner">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <!-- <div class="spinner-box">
              <img src="{{ asset('assets/Impact/assets/img/spin-wheel-2.svg') }}">
            </div> -->
            <!-- <button type="button" class="btn btn-primary spin-btn mt-4 butn butn__new" data-toggle="modal" data-target="#loginModal">
              SPIN!
            </button> -->
            <a href="#"  class='butn butn__new mt-4'><span>SPIN!</span></a>
          </div>
          <div class="col-12 mt-2">
            <p class="review-text">Please view the video above to spin the wheel.</p>
            <!-- <div id="watched-time" class="container text-center" style="margin-top: 20px;">Watched Time: 0 seconds</div> -->
          </div>
        </div>
      </div>
    </section>
    
          <section class="better-luck" style="display:none;">
            <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="better-luck-img text-center">
              <img src="{{ asset('assets/Impact/assets/img/better-luck.svg') }}">
            </div>
            <h4 class="mt-4 text-center">Better luck next time!</h4>
          </div>
        </div>

        <div class="row countdown-row">
          <div class="col-12">
            <div id="betterluckcountdown" class="betterluckcountdown"></div>
          </div>
          <div class="col-12">
          <p>Worry not, you can try again after 24 hours.</p>
          <a href="#" class='butn butn__new mt-4'><span>Back To Homepage</span></a>
        </div>
          </div>
        </div>
      </section>

    
      <section class="better-luck" style="display:none;">
            <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="better-luck-img text-center">
              <img src="{{ asset('assets/Impact/assets/img/win-badge.svg') }} ">
            </div>
            <h2 class="mt-4 text-center">Congratulations!</h2>
            <p class="text-center"> You have won a 50% discount coupon.
            Enter your details below to avail it.</p>
          </div>
        </div>
        <div class="row countdown-row">
            <div class="col-12">
              <div id="betterluckcountdown" class="betterluckcountdown"></div>
            </div>
              <div class="col-12">
                <div class="claim-input">
                <input type="text" name="Name" placeholder="Name">
                </div>
                <div class="claim-input">
                <textarea placeholder="Address"></textarea>
                </div>
                <a href="#" class='butn butn__new mt-4'><span>Claim Coupon</span></a>
              </div>
          </div>
     
        </div>
      </section>

      <section class="better-luck" style="display:none;">
            <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="better-luck-img text-center">
              <img src="{{ asset('assets/Impact/assets/img/win-badge.svg') }} ">
            </div>
            <br>
            <!-- <h2 class="mt-4 text-center">Congratulations!</h2> -->
            <p class="text-center">{{$coupons[0]->code}} <i class="far fa-copy"></i></p>

            <br>
            <p class="text-center">{{$coupons[0]->description}}</p>
          </div>
        </div>
        <div class="row countdown-row">
        <div class="col-12">
  
            <h2 class="mt-4 text-center">Terms and Conditions</h2>

            <br>
            <p class="text-center">{{$coupons[0]->terms_and_condition}}</p>
          </div>
     
        </div>
      </section>

  </main><!-- End #main -->


<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog loginModal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="close-btn text-center">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="text-center loginModal-header">
          <img src="{{ asset('assets/Impact/assets/img/login-lock.svg') }}">
          <h4>Enter your email & phone number to unlock results!</h4>
        </div>
        <div class="">
        <div class="login-input">
            <input type="hidden" name="store_id" value="{{$advertisement_detail->store_id}}">
            <input type="hidden" name="campaign_id" value="{{$campaignId}}">
            <input type="hidden" name="advertisement_id" value="{{$advertisement_detail->id}}">
            <input type="text" placeholder="First Name" name="first_name">
            <div id="first_name_error" style="color:red"></div>
          </div>
          <div class="login-input">
            <input type="text" placeholder="Last Name" name="last_name">
            <div id="last_name_error" style="color:red"></div>
          </div>
          <div class="login-input">
            <input type="email" placeholder="Email" name="email">
            <div id="email_error" style="color:red"></div>
          </div>
          <div class="login-input">
            <input type="number" placeholder="Phone Number" name="phone_number">
            <div id="phone_number_error"style="color:red" ></div>
          </div>
        </div>
        
        <a href="#" id="create_user" class='butn butn__new mt-4 unlock-results-btn'><span>Unlock Result</span></a>
         <p class="mt-3 term-co text-center">By submitting you agree to our <a href="#">terms
          and conditions</a> and <a href="#">privacy policy</a></p>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog loginModal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="close-btn text-center">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="text-center loginModal-header">
          <img src="{{ asset('assets/Impact/assets/img/login-lock.svg') }}">
          <h4>Enter OTP received on your
email & phone number to verify!</h4>
        </div>
        <div class="">
          <div class="login-input">
            <input type="hidden" name="store_id_otp">
            <input type="hidden" name="campaign_id_otp">
            <input type="hidden" name="advertisement_id_otp">
            <input type="hidden" name="user_id_otp">
            <input type="text" placeholder="Email OTP" name="email_otp">
            <div id="email_otp_error"style="color:red" ></div>
          </div>
          <div class="login-input">
            <input type="text" placeholder="Phone Number OTP" name="phone_number_otp">
            <div id="phone_number_otp_error"style="color:red" ></div>
          </div>
        </div>
        <div class="otp-resend">
        <span class="receive-top">Didn’t receive OTP?</span> <span class="resend-otp">Resend OTP</span>
        </div>
        <a href="#" id="otp_verification" class='butn butn__new mt-4 unlock-results-btn'><span>Unlock Result</span></a>
        <div id="incorrect_error"style="color:red" ></div>
        <div id="otp_email"></div>
        <div id="otp_mobile"></div>
         
      </div>
    </div>
  </div>
</div>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>


  <script>
// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2030 15:37:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("betterluckcountdown").innerHTML = hours + "h : "
  +  minutes + "m : " + seconds + "s";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("betterluckcountdown").innerHTML = "EXPIRED";
  }
}, 1000);
</script>


  <!-- Vendor JS Files -->
  <script src="https://player.vimeo.com/api/player.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{ asset('assets/Impact/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/Impact/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10.3.1/swiper.min.js"></script>
  <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/Impact/assets/js/main.js') }}"></script>
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script type="text/javascript">
   //set default degree (360*5)
var degree = 1800;
//number of clicks = 0
var clicks = 0;

$(document).ready(function(){
	
	/*WHEEL SPIN FUNCTION*/
	$('#spin').click(function(){
		
		//add 1 every click
		clicks ++;
		
		/*multiply the degree by number of clicks
	  generate random number between 1 - 360, 
    then add to the new degree*/
		var newDegree = degree*clicks;
		var extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
		totalDegree = newDegree+extraDegree;
		
		/*let's make the spin btn to tilt every
		time the edge of the section hits 
		the indicator*/
     // Wait for the transition to end before showing the modal
    //  $('#inner-wheel').one('transitionend', function() {
    //         $('#loginModal').modal('show');
    //     });

    setTimeout(function() {
            $('#loginModal').modal('show');
        }, 2000); 

		$('#wheel .sec').each(function(){
			var t = $(this);
			var noY = 0;
			
			var c = 0;
			var n = 700;	
			var interval = setInterval(function () {
				c++;				
				if (c === n) { 
					clearInterval(interval);				
				}	
					
				var aoY = t.offset().top;
				$("#txt").html(aoY);
				console.log(aoY);
				
				/*23.7 is the minumum offset number that 
				each section can get, in a 30 angle degree.
				So, if the offset reaches 23.7, then we know
				that it has a 30 degree angle and therefore, 
				exactly aligned with the spin btn*/
				if(aoY < 23.89){
					console.log('<<<<<<<<');
					$('#spin').addClass('spin');
					setTimeout(function () { 
						$('#spin').removeClass('spin');
					}, 100);	
				}
			}, 10);
			
			$('#inner-wheel').css({
				'transform' : 'rotate(' + totalDegree + 'deg)'			
			});
		 
			noY = t.offset().top;
			
		});
	});
	
	
	
});//DOCUMENT READY


  </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      function enableSpinner() {
            document.getElementById("spinner-overlay").style.display = "none"; // Hide the overlay
        }
        // Get the video element
        var video = document.getElementById("video-player");

        if(video){
          // Get the video container
          var videoContainer = document.getElementById("video-container");

          // Function to handle scroll event
          function handleScroll() {
            var position = video.getBoundingClientRect();
              // Pause the video if it's in the viewport
              if (position.top <= -250 && position.bottom <= window.innerHeight) {
                video.pause();
              }
          }

          // Listen for scroll event
          window.addEventListener("scroll", handleScroll);

          // Listen for video timeupdate event to get watched time
          video.addEventListener("timeupdate", function() {
              // Get the current time in seconds
              var watchedTime = Math.floor(video.currentTime);
              var timetext = "Watched time: " + watchedTime + " seconds";
              //document.getElementById("watched-time").textContent = timetext

          });
          video.addEventListener("play", function() {
              console.log("Video started playing.");
              // enableSpinner();
              //document.getElementById("text_to_spin").style.display = "none";
              // You can add additional actions here when the video starts playing
          });

          video.addEventListener("ended", function() {
            console.log("Video ended.");
            enableSpinner();

            var watchedTime = Math.floor(video.currentTime);
            var timetext = "Watched time: " + watchedTime + " seconds";
            //document.getElementById("watched-time").textContent = timetext
            // Perform actions when the video ends, like tracking or displaying a message
            // For example, you can send an analytics event to track that the user has watched the entire video.
            // You can also display a message or trigger another action.
          });
        }
        var vimeo = document.getElementById('vimeo-player');
        if (vimeo) {
            var player = new Vimeo.Player(vimeo);

            // Listen for the 'play' event
            player.on('play', function() {
                console.log('The video started playing');
            });

            // Listen for the 'ended' event
            player.on('ended', function() {
                console.log('The video has ended');
                enableSpinner();
                var watchedTime = Math.floor(video.currentTime);
                var timetext = "Watched time: " + watchedTime + " seconds";
            });

            function handleScroll() {
            var position = vimeo.getBoundingClientRect();
              // Pause the video if it's in the viewport
              if (position.top <= -150 && position.bottom <= window.innerHeight) {
                player.pause();
              }
          }

          // Listen for scroll event
          window.addEventListener("scroll", handleScroll);
        } 
      });
    
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
  $(document).ready(function(){
    $('#create_user').click(function(e){
      e.preventDefault(); 
    

      if($('input[name="first_name"]').val() == ''){
         $('#first_name_error').text('Please enter first name.');
            // $('html, body').animate({
            //    scrollTop: $('#first_name').offset().top - 150 // Adjust the value as needed
            // }, 1000);
            setTimeout(function() {
                $('#first_name_error').empty();
            }, 3000);

      }else if($('input[name="last_name"]').val() == ''){
         $('#last_name_error').text('Please enter last name.');
            // $('html, body').animate({
            //    scrollTop: $('#adv_video').offset().top - 150 // Adjust the value as needed
            // }, 1000);
            setTimeout(function() {
                $('#last_name_error').empty();
            }, 3000);

      }else if($('input[name="email"]').val() == ''){
         $('#email_error').text('Please enter email.');
            // $('html, body').animate({
            //    scrollTop: $('#adv_video').offset().top - 150 // Adjust the value as needed
            // }, 1000);
            setTimeout(function() {
                $('#email_error').empty();
            }, 3000);
      }else if($('input[name="phone_number"]').val() == ''){
         $('#phone_number_error').text('Please enter phone number.');
            // $('html, body').animate({
            //    scrollTop: $('#adv_video').offset().top - 150 // Adjust the value as needed
            // }, 1000);
            setTimeout(function() {
                $('#phone_number_error').empty();
            }, 3000);

      }else{
         var customData = {
            store_id: $('input[name="store_id"]').val(),
            campaign_id: $('input[name="campaign_id"]').val(),
            advertisement_id: $('input[name="advertisement_id"]').val(),
            first_name: $('input[name="first_name"]').val(),
            last_name: $('input[name="last_name"]').val(),
            email: $('input[name="email"]').val(),
            mobile: $('input[name="phone_number"]').val(),
            _token: '{{csrf_token()}}'
         };
        
         var jsonData = JSON.stringify(customData);
         $.ajax({
            type: 'POST',
            url: '{{ route("frontend.create_user") }}', // URL to submit form data
            data: jsonData,
            contentType : "application/json",
            success: function(response){
                // Handle success response
                console.log(response);
                if(response.response_type == 'success'){
                  $('#loginModal').modal('hide');
                  $('#otpModal').modal('show');

                  document.querySelector('input[name="store_id_otp"]').value = response.storeId;
                  document.querySelector('input[name="campaign_id_otp"]').value = response.campaign_id;
                  document.querySelector('input[name="advertisement_id_otp"]').value = response.adverisement_id;
                  document.querySelector('input[name="user_id_otp"]').value = response.user_id;

                  document.getElementById("otp_email").textContent = 'Dummy OTP For Email: '+response.email_otp;
                  document.getElementById("otp_mobile").textContent = 'Dummy OTP For Mobile: '+response.mobile_otp;
                }else{
                  
                }
            },
            error: function(xhr, status, error){
                // Handle error
                if (xhr.status === 422) {
                  console.log(xhr.responseJSON);
                            var errors = xhr.responseJSON.errors;
                            let firstErrorKey = Object.keys(errors)[0]; // Get the first key
                            if(firstErrorKey == 'first_name'){
                              $('#first_name_error').text(errors[firstErrorKey][0]);
                              setTimeout(function() {
                                  $('#first_name_error').empty();
                              }, 2000);
                            }
                            if(firstErrorKey == 'last_name'){
                              $('#last_name_error').text(errors[firstErrorKey][0]);
                              setTimeout(function() {
                                  $('#last_name_error').empty();
                              }, 2000);
                            }
                            if(firstErrorKey == 'email'){
                              $('#email_error').text(errors[firstErrorKey][0]);
                              setTimeout(function() {
                                  $('#email_error').empty();
                              }, 2000);
                            }
                            if(firstErrorKey == 'mobile'){
                              $('#phone_number_error').text(errors[firstErrorKey][0]);
                              setTimeout(function() {
                                  $('#phone_number_error').empty();
                              }, 2000);
                            }
                        
                          //  displayErrors(errors);
                        } else {
                            // Handle other errors
                            console.error('An error occurred');
                        }
                console.error(error);
            }
         });
      }
   });


   ////////////////////////OTP Verfication//////////////////////////////
   $('#otp_verification').click(function(e){
      e.preventDefault(); 
    

      if($('input[name="email_otp"]').val() == ''){
         $('#email_otp_error').text('Please enter email OTP.');
            // $('html, body').animate({
            //    scrollTop: $('#first_name').offset().top - 150 // Adjust the value as needed
            // }, 1000);
            setTimeout(function() {
                $('#email_otp_error').empty();
            }, 3000);

      }else if($('input[name="phone_number_otp"]').val() == ''){
         $('#phone_number_otp_error').text('Please enter phone number OTP.');
            // $('html, body').animate({
            //    scrollTop: $('#adv_video').offset().top - 150 // Adjust the value as needed
            // }, 1000);
            setTimeout(function() {
                $('#phone_number_otp_error').empty();
            }, 3000);

      }else{
         var customData = {
            store_id: $('input[name="store_id_otp"]').val(),
            campaign_id: $('input[name="campaign_id_otp"]').val(),
            advertisement_id: $('input[name="advertisement_id_otp"]').val(),
            user_id: $('input[name="user_id_otp"]').val(),
            email_otp: $('input[name="email_otp"]').val(),
            mobile_otp: $('input[name="phone_number_otp"]').val(),
            _token: '{{csrf_token()}}'
         };
        
         var jsonData = JSON.stringify(customData);
         $.ajax({
            type: 'POST',
            url: '{{ route("frontend.otp_verify") }}', // URL to submit form data
            data: jsonData,
            contentType : "application/json",
            success: function(response){
                // Handle success response
                console.log(response);
                
                if(response.response_type == 'success'){
                  if(response.result == true){
                    $('#otpModal').modal('hide');
                   
                    var APP_URL = {!! json_encode(url('/')) !!}
                    var url = APP_URL+'/win/'+response.storeId+'/campaign/'+response.campaign_id;
                    window.location.href = url;
                   // window.open(url);
                  }else{
                    $('#otpModal').modal('hide');
                    var APP_URL = {!! json_encode(url('/')) !!}
                    var url = APP_URL+'/better_luck/'+response.store_id+'/campaign/'+response.campaign_id;
                    window.location.href = url;
                    //window.open(url);
                  }
                }else{
                  $('#incorrect_error').text('Please enter correct OTP.');
                }
            },
            error: function(xhr, status, error){
                // Handle error
                console.error(error);
            }
         });
      }
   });
});

</script>
<script>
     var advertisementVideo = {
        media_type: "<?php echo addslashes($advertisement_video->media_type); ?>"
    };
  if(advertisementVideo.media_type == "Youtube" || advertisementVideo.media_type == "youtube"){ 
      function getYouTubeVideoId(url) {
              const regex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
              const matches = url.match(regex);
              return matches ? matches[1] : null;
      }

      var videoUrl = "{{ $advertisement_video->media }}"; // Static video URL for testing
      var videoId = getYouTubeVideoId(videoUrl);
      console.log("Extracted Video ID:", videoId);
      if(videoId){
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        function onYouTubeIframeAPIReady() {
          player = new YT.Player('player', {
            height: '100%',
            width: '100%',
            videoId: videoId,
            events: {
              'onReady': onPlayerReady,
              'onStateChange': onPlayerStateChange
            }
          });
        }

        function onPlayerReady(event) {
          console.log('ready')
          event.target.playVideo();
        }

        function onPlayerStateChange(event) {
                  console.log('Player state changed:', event.data); // Log the state change
                if (event.data == YT.PlayerState.PLAYING) {
                    console.log('Video is playing');
                } else if (event.data == YT.PlayerState.ENDED) {
                    console.log('Video has ended');
                    document.getElementById("spinner-overlay").style.display = "none";
                }
        }
       
        function pauseVideo() {
          if (player) {
            player.pauseVideo();
          }
        }

        function NotPlayerInViewport() {
          const rect = document.getElementById('player').getBoundingClientRect();
          console.log(rect.top);
          return (
            rect.top <= -150 && rect.bottom <= window.innerHeight
          );
        }

        window.addEventListener('scroll', function() {
          if (NotPlayerInViewport()) {
            pauseVideo();
          }
        });
      }
    }
  </script>
</body>

</html>