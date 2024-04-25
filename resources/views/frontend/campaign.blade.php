@extends('frontend.layouts.app')

@section('title') Campaign - {{ config('app.name') }} @endsection


@section('content')
<main id="main">
    <!-- ======= Call To Action Section ======= -->
    <div class="banner-img">
    <section id="call-to-action" class="call-to-action">

      <div class="container text-center" data-aos="zoom-out">
        <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
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
                  <li><img src="{{ asset('assets/img/airplane.svg') }}"></li>
                  <li><img src="{{ asset('assets/img/bed.svg') }}"></li>
                  <li><img src="{{ asset('assets/img/doc.svg') }}"></li>
                </ul>
              </div>
            </div>
            <div class="bottom-shadow"></div>
            <img class="vacation-img" src="{{ asset('assets/img/section-2-bg.png') }}">
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
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('assets/img/slider/slider-1.png') }}" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
                    <!-- <div class="itinerary-tag">
              <div class="itinerary-box">
                <ul>
                  <li><img src="assets/img/airplane.svg"></li>
                  <li><img src="assets/img/bed.svg"></li>
                  <li><img src="assets/img/doc.svg"></li>
                </ul>
              </div>
            </div> -->
        <h5>First slide label</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/img/slider/slider-2.png') }}" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
                    <!-- <div class="itinerary-tag">
              <div class="itinerary-box">
                <ul>
                  <li><img src="assets/img/airplane.svg"></li>
                  <li><img src="assets/img/bed.svg"></li>
                  <li><img src="assets/img/doc.svg"></li>
                </ul>
              </div>
            </div> -->
        <h5>First slide label</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/img/slider/slider-3.png') }}" class="d-block w-100" alt="...">
      <div class="carousel-caption  d-md-block">
                    <!-- <div class="itinerary-tag">
              <div class="itinerary-box">
                <ul>
                  <li><img src="assets/img/airplane.svg"></li>
                  <li><img src="assets/img/bed.svg"></li>
                  <li><img src="assets/img/doc.svg"></li>
                </ul>
              </div>
            </div> -->
        <h5>First slide label</h5>
      </div>
    </div>
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
        </div>
        
        
        <!-- <div id="txt"></div> -->
    </section><!-- End spin wheel Section -->

  </main><!-- End #main -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- <div id="preloader"></div> -->

@endsection
  <!-- Vendor JS Files -->

  <!-- <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->
  <!-- <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10.3.1/swiper.min.js"></script>
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