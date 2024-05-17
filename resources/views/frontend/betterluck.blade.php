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

    
    <section class="better-luck" id="bad_luck">
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
<!-- <script>
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
            phone_number: $('input[name="phone_number"]').val(),
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

                }else{
                  
                }
            },
            error: function(xhr, status, error){
                // Handle error
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
            phone_number_otp: $('input[name="phone_number_otp"]').val(),
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
            url: '{{ route("frontend.otp_verify") }}', // URL to submit form data
            data: jsonData,
            contentType : "application/json",
            success: function(response){
                // Handle success response
                console.log(response);
                if(response.response_type == 'success'){
                  if(response.result == true){
                    $('#otpModal').modal('hide');
                    $('#good_luck').modal('show');
                  }else{
                    $('#otpModal').modal('hide');
                    $('#bad_luck').modal('show');
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

</script> -->
</body>

</html>