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
              @if($advertisement_video->media_type == "Video" || $advertisement_video->media_type == "video")
              <video id="video-player" style=" position: absolute;top: 0;left: 0; width: 100%; height: 100%;" controls>
                  <source src="{{ Storage::url($advertisement_video->media) }}" type="video/mp4">
                  Your browser does not support the video tag.
              </video>
              @elseif($advertisement_video->media_type == "Youtube" || $advertisement_video->media_type == "youtube")
              <div id="player"></div>
              @elseif($advertisement_video->media_type == "Vimeo" || $advertisement_video->media_type == "vimeo")
              <iframe id="vimeo-player" src="{{ $advertisement_video->media }}" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
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
                    $heading = $advertisement_detail->heading;

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
          <h4 class="mb-0" id="fifth-dynamic-heading">  {{$advertisement_detail->other_coupon_prize_heading}}</h4>
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
                        <p>Non disperare!</p>
                        <p>Puoi tornare a provare la fortuna tra:</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="spinner">
				<div class="container">
					<div class="row countdown-row" id="div-id-countdown-row">
						<div class="col-12">
							<div id="betterluckcountdown" class="betterluckcountdown"></div>
						</div>
						<div class="col-12">
							<p id="p-better-luck"></p>
						</div>
					</div>
				<div id="scroll-down-div"></div>
		</section>

    <section id="footer">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <p class="mb-0">@2024 QR Code. All rights reserved.</p>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <div class="modal fade" id="signinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog signinModal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="close-btn">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="text-center signinModal-header">
              <img src="{{ asset('assets/greentheme/img/login-lock.svg') }}">
              <h4 class="mt-3 mb-3">PER FAVORE INSERISCI I TUOL <br>
                    CONTATTI PER SBLOCCARE I PREMI:</h4>
            </div>
            <form id="modalForm">
            <div class="">
              <div class="signin-input">
                <label>NOME:</label>
                <input type="text" name="first_name">
                <div id="first_name_error" style="color:red"></div>
              </div>
              <div class="signin-input">
                  <label>COGNOME:</label>
                <input type="text" name="last_name">
                <div id="last_name_error" style="color:red"></div>
              </div>

                <div class="signin-input">
                <label>INDIRIZZO E-MAIL:</label>
                <input type="email" name="email">
                <div id="email_error" style="color:red"></div>
              </div>
              <div class="signin-input">
                  <label>N° DI CELLULARE:</label>
                <input type="number" name="phone_number">
                <div id="phone_number_error" style="color:red"></div>
              </div>
              <div id="user_data_error" style="color:red"></div>
			  <input type="hidden" name="token_user_data" value="{{$encryptedValue}}">
            </div>
            <form id="modalForm">
            <button class="INVIA-btn" id="create_user">INVIA</button>
            <p class="mt-3 term-co text-center">Cliccando INVIA accetti le <a href="#">Condizioni d’uso</a> e <a href="#">privacy</a> del sito web.</p>
          </div>
        </div>
      </div>
     </div>

     <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog signinModal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <div class="close-btn">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="text-center signinModal-header">
                <img src="{{ asset('assets/greentheme/img/login-lock.svg') }}">
                <h4 class="mt-3 mb-3">INSERISCI IL TUO CODICE OTP <br>
                    RICEVUTO PER E-EMAIL:</h4>
            </div>
            <form id="otpForm">
            <div class="">
                <div class="signin-input">
                <label>CODICE OTP:</label>
                <input type="hidden" name="user_id_otp">
                <input type="text" name="email_otp">
                <div id="email_otp_error" style="color:red"></div>
                </div>  
                <p class="otp-timer" id="resend-info">Non hai ricevuto il codice OTP?
                puoi richiederne un altro in <span id="timer">120</span> secondi.</p>
               	<button id="resend-button" disabled>Resend OTP</button>
            </div>
            </form>
            <button id="otp_verification" class="INVIA-btn">INVIA</button>
			<div id="incorrect_error" style="color:red"></div>
            
            </div>
        </div>
        </div>
     </div>

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

        <script>
          function enableSpinner() {
                var image = document.getElementById("spinning-image");
                var button = document.querySelector(".spin-button");
                image.classList.remove("fade-out");
                button.removeAttribute("disabled");
                button.innerHTML = "&#x27A4;"; // Change the button icon if needed
                button.addEventListener("click", function() {
                    console.log("Spin button clicked.");
                    spinImage(); 
                    // Call your spinImage() function or perform spin logic here
                });
            }

            function disableSpinner() {
                var image = document.getElementById("spinning-image");
                var button = document.querySelector(".spin-button");
                image.classList.add("fade-out");
                button.setAttribute("disabled", "true");
                button.innerHTML = "&#x1F512;"; // Change the button icon if needed
            }
            //////// VIDEO - UPLOAD, VIMEO, YOUTUBE
			document.addEventListener("DOMContentLoaded", function() {
         /// Uploaded Video
				// Get the video element
				var video = document.getElementById("video-player");

				if (video) {
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
						// console.log("Video started playing.");
					});

                    video.addEventListener("pause", function() {
                        // console.log("Video paused.");
                        //disableSpinner();
                    });

					video.addEventListener("ended", function() {
						// console.log("Video ended.");
						var visitorId = {{$visitor_id}};
						updateView(visitorId);
						enableSpinner();
						// $('#spin-button').hide();
						// $('#spin-button-a').hide();
						// $('#rvw-text').hide();

						var watchedTime = Math.floor(video.currentTime);
						var timetext = "Watched time: " + watchedTime + " seconds";
						//document.getElementById("watched-time").textContent = timetext
						// Perform actions when the video ends, like tracking or displaying a message
						// For example, you can send an analytics event to track that the user has watched the entire video.
						// You can also display a message or trigger another action.
					});
				}

                //// vimeo
				var vimeo = document.getElementById('vimeo-player');
				if (vimeo) {
					var player = new Vimeo.Player(vimeo);

					// Listen for the 'play' event
					player.on('play', function() {
						console.log('The video started playing');
					});

                    player.on('pause', function() {
                      //  disableSpinner();
					});

					// Listen for the 'ended' event
					player.on('ended', function() {
						console.log('The video has ended');
						var visitorId = {{$visitor_id}};
						updateView(visitorId);
						enableSpinner();
						$('#spin-button').hide();
						$('#spin-button-a').hide();
						$('#rvw-text').hide();
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
		
            ////// youtube
			var advertisementVideo = {
				media_type: "<?php echo addslashes($advertisement_video->media_type); ?>"
			};
			if (advertisementVideo.media_type == "Youtube" || advertisementVideo.media_type == "youtube") {
				function getYouTubeVideoId(url) {
					const regex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
					const matches = url.match(regex);
					return matches ? matches[1] : null;
				}

				var videoUrl = "{{ $advertisement_video->media }}"; // Static video URL for testing
				var videoId = getYouTubeVideoId(videoUrl);
				// console.log("Extracted Video ID:", videoId);
				if (videoId) {
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
						event.target.playVideo();
					}

					function onPlayerStateChange(event) {
						if (event.data == YT.PlayerState.PLAYING) {
						} else if (event.data == YT.PlayerState.ENDED) {
							var visitorId = {{$visitor_id}};
							updateView(visitorId);
                            enableSpinner();
						}
					}

					function pauseVideo() {
						if (player) {
							player.pauseVideo();
                //disableSpinner();
						}
					}

					function NotPlayerInViewport() {
						const rect = document.getElementById('player').getBoundingClientRect();
						// console.log(rect.top);
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

            // document.addEventListener('DOMContentLoaded', function () {
            //     const carousel1 = document.querySelector('#carouselExampleCaptions1');
            //     const fifthDynamicHeading = document.querySelector('#fifth-dynamic-heading');

            //     carousel1.addEventListener('slid.bs.carousel', function (event) {
            //         const activeItem = carousel1.querySelector('.carousel-item.active');
            //         const newHeading = activeItem.getAttribute('data-title');
            //         fifthDynamicHeading.textContent = newHeading;
            //     });
            // });
         </script>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script>
         ////// Update Visitor 
         function updateView(visitorId) {
            // Make an AJAX request to update the view
            var customData = {
                visitorId: visitorId,
                _token: '{{csrf_token()}}'
            };
            var jsonData = JSON.stringify(customData);
            $.ajax({
                type: 'POST',
                url: '{{ route("frontend.updateVisitor") }}', // URL to submit form data
                data: jsonData,
                contentType: "application/json",
                success: function(response) {
                    // Handle success response            
                    console.log("View updated successfully.");
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
		 }
         ////// Spin Image
         function spinImage() {
            const image = document.getElementById('spinning-image');
            image.style.animation = 'spin 1s linear 2';
            image.addEventListener('animationend', () => {
                image.style.animation = '';
            });

            $('input[name="first_name"]').val('');
            $('input[name="last_name"]').val('');
            $('input[name="email"]').val('');
            $('input[name="phone_number"]').val('');

            setTimeout(function() {
                $('#signinModal').modal('show');
            }, 2000);
         }
         $(document).ready(function() {
            $('#signinModal').on('hidden.bs.modal', function () {
                $('#modalForm')[0].reset(); // Clear all input fields
            });
         });
        </script>

		<script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$(document).ready(function() {
				$('#create_user').click(function(e) {
					e.preventDefault();
					if ($('input[name="first_name"]').val() == '') {
						$('#first_name_error').text('Please enter first name.');
						setTimeout(function() {
							$('#first_name_error').empty();
						}, 3000);

					} else if ($('input[name="last_name"]').val() == '') {
						$('#last_name_error').text('Please enter last name.');
						setTimeout(function() {
							$('#last_name_error').empty();
						}, 3000);

					} else if ($('input[name="email"]').val() == '') {
						$('#email_error').text('Please enter email.');
						setTimeout(function() {
							$('#email_error').empty();
						}, 3000);
					}
					else if ($('input[name="phone_number"]').val() == '') {
						$('#phone_number_error').text('Please enter phone number.');
	
						setTimeout(function() {
							$('#phone_number_error').empty();
						}, 3000);
					 } 
					else {
						var customData = {
							token_user_data: $('input[name="token_user_data"]').val(),
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
							contentType: "application/json",
							success: function(response) {
								// Handle success response
								if (response.response_type == 'success') {

									if (response.status == 'otp_send_customerVerify' ||
										response.status == 'otp_send') {
										$('#signinModal').modal('hide');
										$('#otpModal').modal('show');
										startTimer(); //otp timer
										disableResendButton();
										document.querySelector('input[name="user_id_otp"]').value = response.user_id;

									}

									if (response.status == 'customer_result') {
										$('#otpModal').modal('hide');
										window.location.href = response.redirect_url;
	
									}
								} 
								else{
									if (response.status == 'locked') {
										$('#signinModal').modal('hide');
										countdownLocked(response.lockDateTime);
									}
									if(response.status == 'user_token')
									{
										$('#user_data_error').text(response.message);
									}
								}
							},
							error: function(xhr, status, error) {
								// Handle error
								if (xhr.status === 422) {
									var errors = xhr.responseJSON.errors;
									let firstErrorKey = Object.keys(errors)[0]; // Get the first key
									if (firstErrorKey == 'first_name') {
										$('#first_name_error').text(errors[firstErrorKey][0]);
										setTimeout(function() {
											$('#first_name_error').empty();
										}, 2000);
									}
									if (firstErrorKey == 'last_name') {
										$('#last_name_error').text(errors[firstErrorKey][0]);
										setTimeout(function() {
											$('#last_name_error').empty();
										}, 2000);
									}
									if (firstErrorKey == 'email') {
										$('#email_error').text(errors[firstErrorKey][0]);
										setTimeout(function() {
											$('#email_error').empty();
										}, 2000);
									}
									if (firstErrorKey == 'mobile') {
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
							}
						});
					}
				});

                $('#otpModal').on('hidden.bs.modal', function () {
                    // Reset the form
                    $('#otpForm')[0].reset();
                    // Clear the countdown timer
                    clearInterval(countdown);
                    // Reset the timer display and visibility
                    document.getElementById('timer').textContent = otpExpiryTime;
                    document.getElementById('resend-info').classList.add('hidden');
                    document.getElementById('resend-button').classList.remove('hidden');
                });

                let countdown;
				const otpExpiryTime = 120; // 120 seconds
				const resendDisabledTime = 120; // 120 seconds (2 minutes)

				function startTimer() {
					let timeLeft = otpExpiryTime;
					document.getElementById('timer').textContent = timeLeft;
					document.getElementById('resend-info').classList.remove('hidden');
					document.getElementById('resend-button').classList.add('hidden');

					countdown = setInterval(() => {
						timeLeft--;
						document.getElementById('timer').textContent = timeLeft;

						if (timeLeft <= 0) {
							clearInterval(countdown);
							document.getElementById('resend-info').classList.add('hidden');
							document.getElementById('resend-button').classList.remove('hidden');
						}
					}, 1000);
				}

				function countdownLocked(lockDateTime) {
					$('#div-id-countdown-row').css('display', 'block');
					// Set the date we're counting down to
					var countDownDate = new Date(lockDateTime).getTime();
					// Update the count down every 1 second
					var x = setInterval(function() {

						// Get today's date and time
						var now = new Date().getTime();
						console.log(countDownDate, now);

						// Find the distance between now and the count down date
						var distance = countDownDate - now;

						// Time calculations for days, hours, minutes and seconds
						var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
						var seconds = Math.floor((distance % (1000 * 60)) / 1000);

						// Output the result in an element with id="demo"
						document.getElementById("betterluckcountdown").innerHTML = hours + "h : " +
							minutes + "m : " + seconds + "s";

						document.getElementById("p-better-luck").innerHTML = "Worry not, you can try again after " + hours + " hours " + minutes + " minutes ";


						// If the count down is over, write some text 
						if (distance < 0) {
							clearInterval(x);
							//document.getElementById("betterluckcountdown").innerHTML = "Unlocked";
							$('#betterluckcountdown').hide();
						}
					}, 1000);

					var targetDiv = document.getElementById('scroll-down-div');
					targetDiv.scrollIntoView({
						behavior: 'smooth'
					});
				}

				$('#resend-button').click(function(e) {

					e.preventDefault(); // Prevent default form submission behavior

					var user_id = $('#user_id_otp').val(); 
					var _token = '{{ csrf_token() }}';
					var customData = {
						user_id: $('input[name="user_id_otp"]').val(),
						_token: '{{csrf_token()}}'
					};
					var jsonData = JSON.stringify(customData);

					$.ajax({
						type: 'POST',
						url: '{{ route("frontend.resend_otp") }}',
						data: jsonData,
						contentType: "application/json",
						success: function(response) {
							startTimer();
							disableResendButton();
							if (response.response_type == 'failed') {
								$('#incorrect_error').text(response.message);
							}
						},
						error: function(xhr, status, error) {
							console.error(error);
						}
					});
				});

				function disableResendButton() {
					document.getElementById('resend-button').disabled = true;
					setTimeout(() => {
						document.getElementById('resend-button').disabled = false;
					}, resendDisabledTime * 1000); // Convert seconds to milliseconds
				}

				////////////////////////OTP Verfication//////////////////////////////
				$('#otp_verification').click(function(e) {
					e.preventDefault();

					if ($('input[name="email_otp"]').val() == '') {
						$('#email_otp_error').text('Please enter email OTP.');
						setTimeout(function() {
							$('#email_otp_error').empty();
						}, 3000);

					}
					else {
						var customData = {
							token_user_data: $('input[name="token_user_data"]').val(),
							user_id: $('input[name="user_id_otp"]').val(),
							email_otp: $('input[name="email_otp"]').val(),
							_token: '{{csrf_token()}}'
						};

						var jsonData = JSON.stringify(customData);
						$.ajax({
							type: 'POST',
							url: '{{ route("frontend.otp_verify") }}', // URL to submit form data
							data: jsonData,
							contentType: "application/json",
							success: function(response) {
								// Handle success response            
								if (response.response_type == 'success') {
									$('#otpModal').modal('hide');
									window.location.href = response.redirect_url;
								} else {
									$('#incorrect_error').text(response.message);
								}
							},
							error: function(xhr, status, error) {
								// Handle error
								console.error(error);
							}
						});
					}
				});
			});
		</script>
   </body>
</html>