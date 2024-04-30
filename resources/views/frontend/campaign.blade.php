@extends('frontend.layouts.app')

@section('title') Campaign - {{ config('app.name') }} @endsection


@section('content')
<main id="main">
    <!-- ======= Call To Action Section ======= -->
    <div class="banner-img">
    <section id="call-to-action" class="call-to-action">
  <div class="container text-center" data-aos="zoom-out">
    <!-- <iframe id="youtubeLink" width="100%" height="130" src="https://www.youtube.com/embed/LXb3EKWsInQ?enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
      <video id="video-player" width="100%" height="130px" controls>
        <source src="{{ Storage::url($advertisement_video->media) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
  </div>
</section>
  </div>
    <!-- End Call To Action Section -->

   
<section id="second-section" class="second-section">
  <div class="container" data-aos="zoom-out">
   <div class="section-header">
          <h4>Stand a chance to win a fully
          paid vacation in Saudi Arabia!</h4>
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
            <!-- <img class="vacation-img" src="{{ asset('assets/img/section-2-bg.png') }}"> -->
            <img class="vacation-img" src="{{ Storage::url($primary_image->media) }}">
            <h5> 7-day trip in Riyadh, Jeddah, & Al Ula</h5>
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
                <img src="{{ Storage::url($secondary_image->media) }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-md-block">
            
                    <!-- Add your dynamic content here if needed -->
                    <h5>{{ $secondary_image->title }}</h5>
                </div>
            </div>
        @endforeach
    <!-- <div class="carousel-item">
      <img src="{{ asset('assets/img/slider/slider-2.png') }}" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
                     <div class="itinerary-tag">
              <div class="itinerary-box">
                <ul>
                  <li><img src="assets/img/airplane.svg"></li>
                  <li><img src="assets/img/bed.svg"></li>
                  <li><img src="assets/img/doc.svg"></li>
                </ul>
              </div>
            </div> 
        <h5>First slide label</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/img/slider/slider-3.png') }}" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
                    <div class="itinerary-tag">
              <div class="itinerary-box">
                <ul>
                  <li><img src="assets/img/airplane.svg"></li>
                  <li><img src="assets/img/bed.svg"></li>
                  <li><img src="assets/img/doc.svg"></li>
                </ul>
              </div>
            </div> 
        <h5>First slide label</h5>
      </div>
    </div> -->
  </div>
</div>
</div>

  </section>

    <!-- ======= prizes Section ======= -->
    <section id="prizes" class="prizes">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h4>Other prizes you could win</h4>
        </div>

        <div class="row gx-lg-0 gy-4">

          <div class="col-4">
            <div class="prizes-box">
              <img src="{{ asset('assets/img/prizes/t-shirt.svg') }}">
          </div>
          <h6>1 T-shirt</h6>
        </div>
                  <div class="col-4">
            <div class="prizes-box">
              <img src="{{ asset('assets/img/prizes/cap.svg') }}">
          </div>
          <h6>1 Hat</h6>
        </div>
                  <div class="col-4">
            <div class="prizes-box">
              <img src="{{ asset('assets/img/prizes/hand-bag.svg') }}">
          </div>
          <h6>3 Tote Bag</h6>
        </div>
                  <div class="col-4">
            <div class="prizes-box">
              <img src="{{ asset('assets/img/prizes/dates.svg') }}">
          </div>
          <h6>1 Pack Dates</h6>
        </div>
                  <div class="col-4">
            <div class="prizes-box">
              <img src="{{ asset('assets/img/prizes/bottle.svg') }}">
          </div>
          <h6>1 Aluminium Water Bottle</h6>
        </div>
                  <div class="col-4">
            <div class="prizes-box">
              <img src="{{ asset('assets/img/prizes/pen.svg') }}">
          </div>
          <h6>5 Pens</h6>
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

  </main><!-- End #main -->
  <div id="text_to_spin" class="container text-center" style="margin-top: 20px;"><b>Please View the video above to spin the wheel</b></div>
  <div id="watched-time" class="container text-center" style="margin-top: 20px;">Watched Time: 0 seconds</div>


  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- <div id="preloader"></div> -->

@endsection
  <!-- Vendor JS Files -->
  <script src="https://www.youtube.com/iframe_api"></script>
  <!-- <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->
  <!-- <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10.3.1/swiper.min.js"></script>
  <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
  <!--<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script> -->

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
 <!-- Add your JavaScript -->
 <!-- <script>
  // function handleVideoPlaying() {
  //   console.log('Video is playing.');
  // }
    document.addEventListener("DOMContentLoaded", function() {
      // var video = document.getElementById("youtubeLink");
      // video.addEventListener("playing", function() {
      //     console.log("Video is playing.");
      //     // Add your code here to handle CSS changes or other actions
      // });
        // Function to enable the spinner
        function enableSpinner() {
            document.getElementById("spinner-overlay").style.display = "none"; // Hide the overlay
        }

        // Function to check if YouTube video has been watched
        function checkVideoWatched() {
            // Here, you can implement your logic to check if the video has been watched.
            // For simplicity, let's assume the video is watched after 10 seconds.
            setTimeout(function() {
                enableSpinner(); // Enable the spinner after 10 seconds
            }, 10000); // 10 seconds delay (adjust as needed)
        }

        // Call checkVideoWatched() function to check if the video has been watched
        document.getElementById("youtubeLink").addEventListener("click", function() {
          console.log('jhk');
            checkVideoWatched();
        });
    });
</script> -->
<!-- <script>
window.addEventListener('scroll', function() {
  var video = document.getElementById('youtubeLink');
  var position = video.getBoundingClientRect();

  // Pause the video if it's in the viewport
  if (position.top <= -250 && position.bottom <= window.innerHeight) {
    console.log('g');
    console.log(position.top)
    video.contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
  }
});

</script> -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
      function enableSpinner() {
            document.getElementById("spinner-overlay").style.display = "none"; // Hide the overlay
        }
        // Get the video element
        var video = document.getElementById("video-player");

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
            document.getElementById("watched-time").textContent = timetext

        });
        video.addEventListener("play", function() {
            console.log("Video started playing.");
            enableSpinner();
            document.getElementById("text_to_spin").style.display = "none";
            // You can add additional actions here when the video starts playing
        });
    });
</script>