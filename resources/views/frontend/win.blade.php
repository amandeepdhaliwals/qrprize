<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>QrPrize Win - {{ config('app.name', 'Laravel') }}</title>

  <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="{{ setting('meta_description') }}">
  <meta name="keyword" content="{{ setting('meta_keyword') }}">
  <!-- Analytics -->
  <x-google-analytics config="{{ setting('google_analytics') }}" />


  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/Impact/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/Impact/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  @if($campaign->theme == 0)
  <link href="{{ asset('assets/greentheme/css/main.css') }}" rel="stylesheet">
  @else
  <link href="{{ asset('assets/redtheme/css/main.css') }}" rel="stylesheet">
  @endif
  <!-- <link href="{{ asset('assets/Impact/assets/css/main.css')}}" rel="stylesheet"> -->
  <!-- <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">  -->
  <!-- <link href="{{ asset('assets/css/wheel.css') }}" rel="stylesheet">  -->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">

  <style>
    /* Custom CSS for Description Section */
    .description {
      margin-bottom: 20px;
    }

    .description p {
      font-size: 16px;
      line-height: 1.6;
    }

    /* Custom CSS for Terms and Conditions */
    #termsCollapse {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
    }

    #termsHeading {
      cursor: pointer;
    }
  </style>
</head>

<body>

  <main id="main">
    <section class="better-luck">
      <div class="container">
      <div class="signinModal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <!-- <div class="close-btn">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> -->
            @if($campaign->theme == 0)
          
            <div class="text-center coupon-modal-header">
              <h2 class="mt-3 mb-0">HAI</h2>
              <h1 class=" mb-3">VINTO!</h1>
              <img src="{{ asset('assets/greentheme/img/coupon-green.png')}}" alt="Coupon Image">
            </div>
            <div class="coupon-modal-body">
              <p class="">CONTENUTO: <span>{{ $coupon->title }}</span></p>
              <p>CODICE: {{ $coupon->code }} <button id="copyCoupon" class="btn btn-secondary btn-sm"><i style="font-size:12px" class="fa">&#xf0c5;</i></button></p>
              <p class="">DESCRIZIONE: <span>{!! nl2br(e($coupon->description)) !!}</span></p>
            </div>
            <div class="coupon-modal-body mt-4">
              <p>Per riscattare il premio inserisci
                nome e indirizzo</p>
            </div>
            <div class="coupon-modal-footer mt-4">
              <p id="termsHeading" data-bs-toggle="collapse" data-bs-target="#termsCollapse" aria-expanded="false" aria-controls="termsCollapse" class=""> Condizioni d’uso</p>
              <div class="collapse" id="termsCollapse">
                <p><strong>Condizioni d’uso:</strong></p>
                <p>{!! nl2br(e($coupon->terms_and_condition)) !!}</p>
              </div>
            </div>
         
            @else
            <div class="text-center coupon-modal-header">
              <h2 class="mt-3 mb-0">HAI</h2>
              <h1 class=" mb-3">VINTO!</h1>
              <img src="{{ asset('assets/redtheme/img/coupon-black.png')}}" alt="Coupon Image">
            </div>
            <div class="coupon-modal-body">
              <p class="">CONTENUTO: <span>{{ $coupon->title }}</span></p>
              <p>CODICE: {{ $coupon->code }} <button id="copyCoupon" class="btn btn-secondary btn-sm"><i style="font-size:12px" class="fa">&#xf0c5;</i></button></p>
              <p class="">DESCRIZIONE: <span>{!! nl2br(e($coupon->description)) !!}</span></p>
            </div>
            <div class="coupon-modal-body mt-4">
              <p>Per riscattare il premio inserisci
                nome e indirizzo</p>
            </div>
            <div class="coupon-modal-footer mt-4">
              <p id="termsHeading" data-bs-toggle="collapse" data-bs-target="#termsCollapse" aria-expanded="false" aria-controls="termsCollapse" class=""> Condizioni d’uso</p>
              <div class="collapse" id="termsCollapse">
                <p><strong>Condizioni d’uso:</strong></p>
                <p>{!! nl2br(e($coupon->terms_and_condition)) !!}</p>
              </div>
            </div>
            @endif

          <div class="row countdown-row">
          <div class="col-12">
            <div id="betterluckcountdown" class="betterluckcountdown"></div>
          </div>
           @if (!$claim_request_claim)

          <div class="col-12">
            <form action='{{ route("frontend.claim.coupon") }}' method="POST" class="claim-form">
              @csrf
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
              </div>
              <div class="form-group">
                <textarea name="address" class="form-control" placeholder="Address" required></textarea>
              </div>
              <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
              <input type="hidden" name="advertisement_id" value="{{ $advertisement_id }}">
              <input type="hidden" name="customer_id" value="{{ $customer_id }}">
              <div class="text-center">
                <button type="submit" class="btn btn-secondary mt-4">Claim Coupon</button>  
              </div>
              <br>
              <div class="text-center">
              <a href="{{$campaign->qr_code_url }}" style="color:#6c757d;">Back to Homepage</a>
              </div>

            </form>
          </div>
          @else
          <div  class="text-center" style="color: green;"><h1>Claimed</h1></div>
          <div  class="text-center" id="countdown">Redirecting in <span id="countdown-number">10</span> seconds...</div>
          <script>
              // Countdown timer
              var countdownNumberEl = document.getElementById('countdown-number');
              var countdown = 10;

              function countdownFunc() {
                  countdown = countdown - 1;
                  countdownNumberEl.textContent = countdown;
              }

              setInterval(countdownFunc, 1000);

              setTimeout(function () {
                window.location.href = "{{$campaign->qr_code_url }}"; // Redirect after 10 seconds
              }, 10000);
          </script>
          @endif
        </div>



          </div>
        </div>
      </div>

        



      </div>
    </section>
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
  <script src="{{ asset('assets/Impact/assets/js/main.js') }}"></script>
  <script src="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    // JavaScript for Copy Coupon Code Button
    document.getElementById('copyCoupon').addEventListener('click', function() {
      var couponCode = "{{ $coupon->code }}";
      navigator.clipboard.writeText(couponCode).then(function() {
        alert('Coupon code copied to clipboard!');
      }, function(err) {
        console.error('Failed to copy coupon code: ', err);
      });
    });
  </script>
</body>

</html>
