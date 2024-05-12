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
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
      
      @if($adv_videos->media_type == "Video" || $adv_videos->media_type == "video") 
      <video width="100%" height="100%" controls>
        <source src="{{ Storage::url($adv_videos->media) }}" type="video/mp4">
        Your browser does not support the video tag.
      </video>
      @elseif($adv_videos->media_type == "Youtube" || $adv_videos->media_type == "youtube") 
      <iframe width="100%" height="100%" src="{{ $adv_videos->media }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      @elseif($adv_videos->media_type == "Vimeo" || $adv_videos->media_type == "vimeo") 
      <iframe src="{{ $adv_videos->media }}" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
      @endif
        <!-- <a href="{{ Storage::url($adv_videos->media) }}" class="glightbox play-btn"></a> -->
      </div>
       </div>
    </section>
 
    <!-- End Call To Action Section -->

   
<section id="second-section" class="second-section">
  <div class="container" data-aos="zoom-out">
   <div class="section-header">
          <h4>{{$preview_advertisements->heading}}</h4>
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
          <h4>{{$preview_advertisements->other_coupon_prize_heading}}</h4>
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

    <section class="spinner">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div class="spinner-box">
              <img src="{{ asset('assets/Impact/assets/img/spin-wheel-2.svg') }}">
            </div>
            <!-- <button type="button" class="btn btn-primary spin-btn mt-4 butn butn__new" data-toggle="modal" data-target="#loginModal">
              SPIN!
            </button> -->
            <a href="#" data-toggle="modal" data-target="#otpModal" class='butn butn__new mt-4'><span>SPIN!</span></a>
          </div>
          <div class="col-12 mt-2">
            <p class="review-text">Please view the video above to spin the wheel.</p>
          </div>
        </div>
      </div>
    </section>
    @if($request_action == '2')
          <section class="better-luck">
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

    @else
      <section class="better-luck">
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

      <section class="better-luck">
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
      @endif
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
          <img src="assets/img/login-lock.svg">
          <h4>Enter your email & phone number to unlock results!</h4>
        </div>
        <div class="">
          <div class="login-input">
            <input type="text" placeholder="Username" name="username">
          </div>
          <div class="login-input">
            <input type="password" placeholder="Password" name="password">
          </div>
        </div>
        
        <a href="#" class='butn butn__new mt-4 unlock-results-btn'><span>Unlock Result</span></a>
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
          <img src="assets/img/login-lock.svg">
          <h4>Enter OTP received on your
email & phone number to verify!</h4>
        </div>
        <div class="">
          <div class="login-input">
            <input type="text" placeholder="Username" name="username">
          </div>
          <div class="login-input">
            <input type="password" placeholder="Password" name="password">
          </div>
        </div>
        <div class="otp-resend">
        <span class="receive-top">Didn’t receive OTP?</span> <span class="resend-otp">Resend OTP</span>
        </div>
        <a href="#" class='butn butn__new mt-4 unlock-results-btn'><span>Unlock Result</span></a>
         
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

  <script src="https://www.youtube.com/iframe_api"></script>
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

  <script type="text/javascript">
    
  </script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>