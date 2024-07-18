<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Better Luck
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

  @if($campaign->theme == 0)
  <link href="{{ asset('assets/greentheme/css/main.css') }}" rel="stylesheet">
  @else
  <link href="{{ asset('assets/redtheme/css/main.css') }}" rel="stylesheet">
  @endif
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
  <!------ Include the above in your HEAD tag ---------->

</head>

<style>
  .theme-green{
    color: #eb6169; 
    font-family: system-ui;
    text-align:center;
  }
  .gt-bold{
    font-weight: bold;
  }
  .theme-red{
    text-align:center;
  }
  </style>
  


<body>

  <main id="main">
      <div class="signinModal-dialog" role="document">
       <div class="modal-content">
        <div class="modal-body">
          <div class="close-btn">
           <!-- <button type="button" onclick="window.location.href='{{$campaign->qr_code_url}}'" class="close" aria-label="Close"> -->
          </div>

          <div class="text-center vinto-timer-header">
            <h2 class="mt-3 mb-0">QUESTA VOLTA<br> NON HAI</h2>
            <h1 class=" mb-3">VINTO!</h1>
            @if($campaign->theme == 0)
            <img src="{{ asset('assets/redtheme/img/finger-top-red.jpg') }}" alt="Finger Top Image">
            @else
            <img src="{{ asset('assets/redtheme/img/finger-top.jpg') }}" alt="Finger Top Image">
            @endif
          </div>
          <div class="vinto-timer-body">
            <p class="mb-0" style="text-align:center;">Non disperare!</p>
            <p class="mb-0" style="text-align:center;">Puoi tornare a provare la fortuna tra:</p>
          </div>
          <h2 id="betterluckcountdown" class="{{ $campaign->theme == 0 ? 'theme-green gt-bold' : 'theme-red' }}" ></h2>
          <p class="Condizioni {{ $campaign->theme == 0 ? 'theme-green' : 'theme-red' }}">Condizioni d’uso</p>


        </div>
      </div>
    </div>
    </main><!-- End #main -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>


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

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    countdownLocked('{{$lockDateTime}}')
  	function countdownLocked(lockDateTime) {
          if(lockDateTime == ''){
            $('#betterluckcountdown').hide();
          }
          else{

				  	// Set the date we're counting down to
				  	var countDownDate = new Date(lockDateTime).getTime();
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
						document.getElementById("betterluckcountdown").innerHTML = hours + "h : " +
							minutes + "m : " + seconds + "s";

						// If the count down is over, write some text 
						if (distance < 0) {
							clearInterval(x);
							$('#betterluckcountdown').hide();
						}
					}, 1000);
				}
       } 
      });

      setTimeout(function () {
              window.location.href = "{{$campaign->qr_code_url }}"; // Redirect after 10 seconds
            }, 10000);
  </script>   
</body>

</html>