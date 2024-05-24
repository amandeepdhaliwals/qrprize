<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Win</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/Impact/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/Impact/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/Impact/assets/css/main.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet"> 
  <link href="{{ asset('assets/css/wheel.css') }}" rel="stylesheet"> 
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
        <div class="row">
          <div class="col-12">
            <div class="better-luck-img text-center">
              <img src="{{ asset('assets/Impact/assets/img/win-badge.svg') }}" alt="Win Badge">
            </div>
            <h2 class="mt-4 text-center">Congratulations!</h2>
            <p class="text-center"> You have won a coupon.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="coupon-details text-center">
              <h3>{{ $coupon->title }}</h3>
              <p><strong>Coupon Code:</strong> {{ $coupon->code }} <button id="copyCoupon" class="btn btn-primary"><i style="font-size:12px" class="fa">&#xf0c5;</i></button></p>
              <div class="description">
                <p><strong>Description:</strong></p>
                <p>{!! nl2br(e($coupon->description)) !!}</p>
              </div>
              <p id="termsHeading" data-bs-toggle="collapse" data-bs-target="#termsCollapse" aria-expanded="false" aria-controls="termsCollapse" class="text-primary"> Terms and Conditions</p>
              <div class="collapse" id="termsCollapse">
                <p><strong>Terms and Conditions:</strong></p>
                <p>{!! nl2br(e($coupon->terms_and_condition)) !!}</p>
              </div>
            </div>
          </div>
        </div>
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
                <button type="submit" class="btn btn-primary mt-4">Claim Coupon</button>
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
              window.location.href = "{{ config('app.url') }}/store/{{ $storeId }}/campaign/{{ $campaignId }}"; // Redirect after 10 seconds
            }, 10000);
        </script>
        @endif
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
