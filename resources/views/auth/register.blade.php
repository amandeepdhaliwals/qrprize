<x-auth-layout>
    <x-slot name="title">
        @lang('Register')
    </x-slot>

    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" id="register-form">
            @csrf

            <!-- First Name -->
            <div class="mt-4">
                <x-label for="first_name" :value="__('First Name')" />
                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
            </div>

            <!-- Last Name -->
            <div class="mt-4">
                <x-label for="last_name" :value="__('Last Name')" />
                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Mobile Number -->
            <div class="mt-4">
                <x-label for="mobile" :value="__('Mobile Number')" />
                <x-input id="mobile" class="block mt-1 w-full" type="text" name="mobile" :value="old('mobile')" required />
            </div>

            <div id="message" class="hidden"></div>

            <!-- OTP Verification -->
            <div id="otp-verification" class="hidden mt-4">
                <x-label for="otp" :value="__('OTP')" />
                <x-input id="otp" class="block mt-1 w-full" type="text" name="otp" />
                <x-button id="resend-otp" class="ml-4 mt-2">
                    {{ __('Resend OTP') }}
                </x-button>
                <span id="timer" class="ml-4 mt-2 text-gray-600"></span>
                <x-button id="verify-otp-button" class="ml-4 mt-2 hidden">
                    {{ __('Verify OTP') }}
                </x-button>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button id="register-button" class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>

        </form>

        <x-slot name="extra">
            <p class="text-center text-gray-600 mt-4">
                Already have an account? <a href="{{ route('login') }}" class="underline hover:text-gray-900">Login</a>.
            </p>
        </x-slot>
    </x-auth-card>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.getElementById('register-form');
            const otpVerification = document.getElementById('otp-verification');
            const resendOtpButton = document.getElementById('resend-otp');
            const verifyOtpButton = document.getElementById('verify-otp-button');
            const registerButton = document.getElementById('register-button');
            const timerElement = document.getElementById('timer');
            const messageDiv = document.getElementById('message');
            let timer;

            registerForm.addEventListener('submit', function(event) {
                event.preventDefault();
                sendOtp();
            });

            resendOtpButton.addEventListener('click', function(event) {
                event.preventDefault();
                sendOtp();
                startTimer();
            });

            function sendOtp() {
                // Gather form data
                const firstName = document.getElementById('first_name').value;
                const lastName = document.getElementById('last_name').value;
                const email = document.getElementById('email').value;
                const mobile = document.getElementById('mobile').value;

                // Prepare the data to send
                const formData = {
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    mobile: mobile,
                    _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
                };

                // Send data to the server via AJAX
                $.ajax({
                    type: 'POST',
                    url: '{{ route("register") }}', // The route to your controller method
                    data: formData,
                    success: function(response) {
                        if (response.response_type === 'success') {
                            showMessage('OTP sent successfully!', 'success');
                            otpVerification.classList.remove('hidden');
                            verifyOtpButton.classList.remove('hidden');
                            registerButton.classList.add('hidden');
                            startTimer();
                        } else {
                            showMessage('Failed to send OTP: ' + response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred. Please try again later.';

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            // Get the first error message from the response
                            if (errors) {
                                const firstErrorKey = Object.keys(errors)[0];
                                if (firstErrorKey) {
                                    errorMessage = errors[firstErrorKey][0];
                                }
                            }
                        }

                        showMessage(errorMessage, 'error');
                    }
                });
            }

            function showMessage(message, type) {
                messageDiv.textContent = message;
                messageDiv.classList.remove('hidden');
                if (type === 'success') {
                    messageDiv.classList.add('bg-green-500');
                    messageDiv.classList.remove('bg-red-500');
                } else if (type === 'error') {
                    messageDiv.classList.add('bg-red-500');
                    messageDiv.classList.remove('bg-green-500');
                }
            }

            function startTimer() {
                let time = 120; // 2 minutes
                timerElement.textContent = formatTime(time);
                clearInterval(timer);
                timer = setInterval(function() {
                    time--;
                    timerElement.textContent = formatTime(time);
                    if (time <= 0) {
                        clearInterval(timer);
                        resendOtpButton.disabled = false;
                    }
                }, 1000);
                resendOtpButton.disabled = true;
            }

            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const secondsRemaining = seconds % 60;
                return `${minutes}:${secondsRemaining < 10 ? '0' : ''}${secondsRemaining}`;
            }
        });
    </script>
</x-auth-layout>
