<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>QrPrize</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- <link href="" rel="icon">
  <link href="" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/greentheme/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/greentheme/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  
  <!-- Template Main CSS File -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="{{ asset('assets/greentheme/css/main.css') }}" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">

  <!------ Include the above in your HEAD tag ---------->

</head>

<style>
     .hidden {
				display: none;
			}
		.video-container {
			position: relative;
			padding-bottom: 56.25%;
			/* 16:9 aspect ratio */
			height: 0;
			overflow: hidden;
			max-width: 100%;
			background: #000;
		}

		.video-container iframe {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}

    .spinner {
      width: 100%;
      }

      .spinner-box {
      position: relative;
      display: inline-block;
      }


      #spinning-image {
      max-width: 95%%;
      /* height: auto; */
      transition: opacity 0.5s ease-in-out; /* Smooth fade-out transition */
      }

      .fade-out {
          opacity: 0.5; /* Adjust opacity for fade-out effect */
      }

      .spin-button {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 50px;
      height: 50px;
      border: none;
      border-radius: 50%;
      background-color: white;
      font-size: 24px;
      cursor: pointer;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      display: flex;
      justify-content: center;
      align-items: center;
      }

      .spinner-bottom-text {
      text-align: center;
      }

      .spin-button[disabled] {
      cursor: not-allowed; /* Indicates the button is disabled */
      color: #999; /* Change the text color as needed */
      background-color: transparent; /* Change the background color as needed */
      }

      @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
      }

      i.bi.bi-lock{
          font-size: 150px;
          color: #fff;
      }


      .otp-timer {
            display: inline;
        }
        #resend-button {
          background: none;
          border: none;
          color: #21887c;
          text-decoration: underline;
          cursor: pointer;
          font: inherit;
          padding: 0;
          margin-left: 5px;
          font-weight: 800;
        }
        #resend-button:disabled {
            color: gray;
            text-decoration: none;
            cursor: default;
        }

	</style>

<body>

  <main id="main">
    <!-- ======= Call To Action Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <div class="logo">
              <img src="{{ asset('assets/greentheme/img/Benvenuto-Qrprize-logo.png') }}">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="call-to-action" class="call-to-action">
    <div class="">
          <div class="container text-center video-container" data-aos="zoom-out">
            <!-- <a href="https://youtu.be/u0bVjCTcfLw?si=JNm8GTJxahkjFtky" class=""></a> -->
              @if($adv_videos->media_type == "Video" || $adv_videos->media_type == "video")
              <video id="video-player" style=" position: absolute;top: 0;left: 0; width: 100%; height: 100%;" controls>
                  <source src="{{ Storage::url($adv_videos->media) }}" type="video/mp4">
                  Your browser does not support the video tag.
              </video>
              @elseif($adv_videos->media_type == "Youtube" || $adv_videos->media_type == "youtube")
              <iframe width="100%" height="100%" src="{{ $adv_videos->media }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              @elseif($adv_videos->media_type == "Vimeo" || $adv_videos->media_type == "vimeo")
              <iframe id="vimeo-player" src="{{ $adv_videos->media }}" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
              @endif
          </div>
      </div>
    </section>
    <!-- End Call To Action Section -->

    <section id="second-section" class="second-section">
      <div class="container" data-aos="zoom-out">
      <div class="second-section-body">
                  <p>Guarda gentilmente tutto il Video per sbloccare i premi.</p>
                  @php
                    $heading = $preview_advertisements->heading;

                    if (strpos($heading, '&') !== false) {
                        // Split by '&'
                        list($part1, $part2) = explode('&', $heading, 2);
                    } else {
                        // Split by spaces after 4 words
                        $words = explode(' ', $heading);
                        if (count($words) > 4) {
                            $part1 = implode(' ', array_slice($words, 0, 4));
                            $part2 = implode(' ', array_slice($words, 4));
                        } else {
                            $part1 = $heading;
                            $part2 = '';
                        }
                    }
                @endphp

                <h2>{{ $part1 }}</h2>
                @if(!empty($part2))
                    <h4>{{ $part2 }}</h4>
                @endif

               </div>
      </div>
    </section>

    <section id="crousel">
      <div class="">
        <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
                @foreach($primary_images as $key => $primary_image)
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($primary_images as $key => $primary_image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-title="{{ $primary_image->title }}">
                    <div class="itinerary-tag">
                        <div class="itinerary-box">
                            <ul>
                                <?php
                                    $free_services_str = $primary_image->free_services;
                                    $primary_free_services = explode(",", $free_services_str);
                                    if (in_array("Flight", $primary_free_services)) { ?>
                                        <li><img src="{{ asset('assets/img/airplane.svg') }}"></li>
                                        <?php }
                                    if (in_array("Visa", $primary_free_services)) { ?>
                                        <li><img src="{{ asset('assets/img/bed.svg') }}"></li>
                                        <?php }
                                    if (in_array("Documentation", $primary_free_services)) { ?>
                                    <li><img src="{{ asset('assets/img/doc.svg') }}"></li>
                                <?php }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <img src="{{ Storage::url($primary_image->image) }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-md-block">
                        <!-- Add your dynamic content here if needed -->
                        <!-- <h5>{{ $primary_image->title }}</h5> -->
                    </div>
                </div>
                @endforeach
            </div>
        </div>
      </div>
    </section>

    <section id="forth-section" class="forth-section">
      <div class="container" data-aos="zoom-out">
        <div class="forth-section-body">
          <h4 class="mb-0" id="dynamic-heading">  {{ $primary_images->first()->title }}</h4>
        </div>
      </div>
    </section>

    <section id="crousel">
      <div class="">
        <div id="carouselExampleCaptions1" class="carousel slide">
        <div class="carousel-indicators">
              @foreach($secondary_images as $key => $secondary_image)
              <button type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
              @endforeach
          </div>
          <div class="carousel-inner">
              @foreach($secondary_images as $key => $secondary_image)
              <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-title="{{ $secondary_image->title }}">
                  <div class="itinerary-tag">
                      <div class="itinerary-box">
                          <ul>
                              <?php
                                  $free_services_str = $secondary_image->free_services;
                                  $secondary_free_services = explode(",", $free_services_str);
                              ?>
                              @if(in_array('Flight',$secondary_free_services)) <li><img src="{{ asset('assets/img/airplane.svg') }}"></li>@endif
                              @if(in_array('Visa',$secondary_free_services)) <li><img src="{{ asset('assets/img/bed.svg') }}"></li>@endif
                              @if(in_array('Documentation',$secondary_free_services)) <li><img src="{{ asset('assets/img/doc.svg') }}"></li>@endif
                          </ul>
                      </div>
                  </div>
                  <img src="{{ Storage::url($secondary_image->image) }}" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-md-block">
                      <!-- Add your dynamic content here if needed -->
                  </div>
              </div>
              @endforeach
          </div>
        </div>
      </div>
    </section>

    <section id="fifth-section" class="fifth-section">
      <div class="container" data-aos="zoom-out">
        <div class="fifth-section-body">
          <h4 class="mb-0" id="fifth-dynamic-heading">  {{$preview_advertisements->other_coupon_prize_heading}}</h4>
        </div>
      </div>
    </section>

    <section class="spinner">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="spinner-box">
                            <img 
                                src="{{ asset('assets/greentheme/img/spin-wheel.png') }}" 
                                alt="Spin Wheel" 
                                id="spinning-image" 
                                class="fade-out"
                            >
                         <button class="spin-button" disabled><i class="bi bi-lock"></i></button>
                        </div>
                    </div>
                    <div class="col-12 mt-2 spinner-bottom-text">
                        <p>Guarda gentilmente tutto il video per sbloccare i premi.</p>
                    </div>
                </div>
            </div>
        </section>

    <section id="footer">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <p class="mb-0">@2024 QR Prize. All rights reserved.</p>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

<br/>
@if($request_action == '2')
  <div class="signinModal-dialog" role="document">
       <div class="modal-content">
        <div class="modal-body">
          <div class="close-btn">

          </div>

          <div class="text-center vinto-timer-header">
            <h2 class="mt-3 mb-0">QUESTA VOLTA<br> NON HAI</h2>
            <h1 class=" mb-3">VINTO!</h1>
            
            <img src="{{ asset('assets/redtheme/img/finger-top.jpg') }}" alt="Finger Top Image">
         
          </div>
          <div class="vinto-timer-body">
            <p class="mb-0" style="text-align:center;">Non disperare!</p>
            <p class="mb-0" style="text-align:center;">Puoi tornare a provare la fortuna tra:</p>
          </div>
          <h2 id="betterluckcountdown" style="color: #eb6169; font-family: system-ui; text-align:center; font-weight: bold;" >03h 24m 05s</h2>
          <p class="Condizioni" style="color: #eb6169; text-align:center;">Condizioni d’uso</p>


        </div>
      </div>
    </div>
    @else
    <div class="signinModal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <!-- <div class="close-btn">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> -->
          
            <div class="text-center coupon-modal-header">
              <h2 class="mt-3 mb-0">HAI</h2>
              <h1 class=" mb-3">VINTO!</h1>
              <img src="{{ asset('assets/greentheme/img/coupon-green.png')}}" alt="Coupon Image">
            </div>
            <div class="coupon-modal-body">
              <p class="">CONTENUTO: <span>{{ $coupons[0]->title }}</span></p>
              <p>CODICE: {{ $coupons[0]->code }} <button id="copyCoupon" class="btn btn-secondary btn-sm"><i style="font-size:12px" class="fa">&#xf0c5;</i></button></p>
              <p class="">DESCRIZIONE: <span>{!! nl2br(e($coupons[0]->description)) !!}</span></p>
            </div>
            <div class="coupon-modal-body mt-4">
              <p>Per riscattare il premio inserisci
                nome e indirizzo</p>
            </div>
            <div class="coupon-modal-footer mt-4">
              <p id="termsHeading" data-bs-toggle="collapse" data-bs-target="#termsCollapse" aria-expanded="false" aria-controls="termsCollapse" class=""> Condizioni d’uso</p>
              <div class="collapse" id="termsCollapse">
                <p><strong>Condizioni d’uso:</strong></p>
                <p>{!! nl2br(e($coupons[0]->terms_and_condition)) !!}</p>
              </div>
            </div>
         

          <div class="row countdown-row">
          <div class="col-12">
            <div id="betterluckcountdown" class="betterluckcountdown"></div>
          </div>
      

          <div class="col-12">
            <form action='' method="POST" class="claim-form">
              @csrf
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
              </div>
              <div class="form-group">
                <textarea name="address" class="form-control" placeholder="Address" required></textarea>
              </div>
              <div class="text-center">
                <button type="button" class="btn btn-secondary mt-4">Claim Coupon</button>  
              </div>
              <br>
            

            </form>
          </div>
        
        </div>



          </div>
        </div>
      </div>

    @endif



  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

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

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/greentheme/js/main.js') }}"></script>


        <!-- //// Dynamic Heading carousel -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const carousel = document.querySelector('#carouselExampleCaptions');
                const dynamicHeading = document.querySelector('#dynamic-heading');

                carousel.addEventListener('slid.bs.carousel', function (event) {
                    const activeItem = carousel.querySelector('.carousel-item.active');
                    const newHeading = activeItem.getAttribute('data-title');
                    dynamicHeading.textContent = newHeading;
                });
            });

         </script>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



   </body>
</html>