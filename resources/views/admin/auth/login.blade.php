<!doctype html>
<html lang="en">

<head>
    <title> {{ trns('login') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fustat:wght@200..800&family=Jost:ital,wght@0,100..900;1,100..900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('assets/auth') }}/css/style.css">
    <link rel="stylesheet" href="sweetalert2.min.css">

    <style>
        .tabs-list {
            list-style: none;
            margin: 0;
            padding: 0;
            border-bottom: 1px solid #EEEEEE;
        }

        .tabs-list li {
            padding: 5px 15px;
            display: inline-block;
            cursor: pointer;
            font-weight: 500;
            position: relative;
            top: 1px;
        }

        @media (max-width: 466px) {
            .tabs-list li {
                display: flex;
                flex-direction: column;
                text-align: center;
            }
        }

        .tabs-list li:hover {
            color: #2A3A65;
        }

        .tabs-list .show {
            color: #2A3A65;
            border-bottom: 2px solid #2A3A65;
            font-weight: bold;
        }

        .content-list>form:not(:first-child) {
            display: none;
        }

        label {
            color: #2A3A65 !important;
            font-weight: bold !important;
        }
    </style>

</head>

<body style="background-color: white;">


    <section class="ftco-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="image-login" style="height: 99vh; padding: 10px 0;">
                        <img src="{{ asset('assets/admin/assets/images/login.jpg') }}" alt="login"
                            style="width: 100%; object-fit: cover; border-radius: 10px; height: 100%; ">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div style="padding: 0 50px;">
                        <div class="wrap">
                            <div class="login-wrap">


                                <div class="d-flex">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-end mt-4 mb-4">
                                            <img src="{{ asset('assets/admin/assets/images/logo.png') }}" alt="login"
                                                style="height: 60px;">
                                        </div>
                                        <h3 class="mb-2 mt-2" style="font-weight: bold; text-align: right;">مرحباً بك في
                                            إدارات</h3>
                                        <p style="text-align: right;">سجل الدخول إلي حسابك للمتابعة </p>
                                        <div class="d-flex justify-content-center">

                                        </div>
                                    </div>
                                </div>
                                <div class="tabs">
                                    <ul class="tabs-list"
                                        style="direction: rtl; display: flex; justify-content: flex-start;">
                                        <li class="show" data-content=".content-one">ادخل البريد الالكترونى</li>
                                        <li data-content=".content-two">ادخل رقم الجوال</li>
                                    </ul>
                                    <div class="content-list mt-2">
                                        <form action="{{ route('admin.login') }}" id="LoginForm"
                                            class="signin-form content-one" method="post">
                                            @csrf
                                            <div class="form-group mt-3">
                                                <label for="input" class="form-label d-flex justify-content-end">
                                                    <span class="text-danger">*</span>
                                                    {{ trns('email') }}
                                                </label>
                                                <input type="text" class="form-control" name="input" required>
                                            </div>
                                            <div class="form-group" style="margin-bottom: 20px !important;">
                                                <label for="password" class="form-label d-flex justify-content-end">
                                                    <span class="text-danger">*</span>
                                                    {{ trns('password') }}
                                                </label>
                                                <input id="password-field" type="password" name="password"
                                                    class="form-control" required>
                                                <span toggle="#password-field" style="top: 70%; right: 15px;"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                            <div class="forget-password mb-2 "><a style="cursor: pointer;"
                                                    data-toggle="modal" data-target="#ForgotPasswordModal"> نسيت كلمة
                                                    المرور؟ </a>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="LoginBtn"
                                                    style="color: #00f3ca !important; font-weight: bold; font-size: 18px;"
                                                    class="form-control btn btn-primary rounded submit px-3">{{ trns('login') }}
                                                </button>
                                            </div>

                                            <div class="form-group d-md-flex justify-content-end">
                                                <a href="{{ route('terms') }}">
                                                    <p data-v-46b35b01="" class="text-right constrains mb-4"> بالمتابعة
                                                        أنت
                                                        توافق
                                                        على <b data-v-46b35b01=""
                                                            style="color: rgb(0, 0, 0); font-weight: 700 !important; cursor: pointer;">الشروط
                                                            و الأحكام </b>الخاصة بنا
                                                    </p>
                                                </a>
                                                {{-- <input type="checkbox" name="remember" id="rememberLoginBtn"
                                                    style="margin-bottom:27px; margin-left: 10px;"> --}}

                                            </div>
                                        </form>
                                        <form class="row signin-form content-two"
                                            action="{{ route('admin.loginWithPhone') }}" id="loginWithPhoneForm"
                                            method="post">
                                            @csrf
                                            <div class="col-12">
                                                <label for="phone" class="form-label d-flex justify-content-end">
                                                    <span class="text-danger">*</span>
                                                    رقم الجوال
                                                </label>
                                                <div class="input-group mb-5">
                                                    <span class="input-group-text"
                                                        style="background-color: transparent; font-weight: bold; border-radius: 0.25rem 0 0 0.25rem;"
                                                        id="inputGroupPrepend2">+966</span>
                                                    <input type="number" class="form-control" name="phone"
                                                        aria-describedby="inputGroupPrepend2" required>
                                                </div>
                                                <input type="hidden" value="+966">

                                                <div class="form-group">
                                                    <button type="button" id="loginWithPhoneBtn"
                                                        style="color: #00f3ca !important; font-weight: bold; font-size: 18px;"
                                                        class="form-control btn btn-primary rounded submit px-3">{{ trns('login') }}</button>
                                                </div>

                                                <div class="form-group d-md-flex justify-content-end">





                                                    <a href="{{ route('terms') }}">
                                                        <p data-v-46b35b01="" class="text-right constrains mb-4">
                                                            بالمتابعة
                                                            أنت
                                                            توافق
                                                            على <b data-v-46b35b01=""
                                                                style="color: rgb(0, 0, 0); font-weight: 700 !important; cursor: pointer;">الشروط
                                                                و الأحكام </b>الخاصة بنا
                                                        </p>
                                                    </a>
                                                    {{-- <input type="checkbox" name="remember"
                                                        style="margin-bottom:27px; margin-left: 10px;"
                                                        id="rememberLoginWithPhoneBtn"> --}}
                                                </div>
                                            </div>
                                        </form>





                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Modal -->
    <div class="modal fade" id="ForgotPasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px;">
                <div class="">
                    <button type="button"
                        style="background-color: transparent; border-radius: 50px; margin: 10px 50px; border: 2px solid gainsboro; padding: 0 15px;"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 25px;">&#x2039;</span>
                        العودة
                    </button>
                </div>

                <!-- Email Form -->
                <form id="ForgotPasswordForm" action="{{ route('admin.forgetPassword') }}">
                    @csrf
                    <div class="modal-body" style="padding: 0 50px;">
                        <div class="d-flex justify-content-center mt-4 mb-4">
                            <img src="{{ asset('assets/admin/assets/images/logo.png') }}" alt="login"
                                style="height: 60px;">
                        </div>
                        <h4 style="font-weight: bold; text-align: center;">إعادة تعين كلمة المرور</h4>
                        <p style="color: black; text-align: center;">أدخل عنوان بريدك الإلكتروني أدناه لتلقي بريد
                            إلكتروني لإعادة تعيين كلمة المرور الخاصة بك.</p>

                        <div class="form-group mt-5">
                            <label for="email-input" class="form-label d-flex justify-content-end">
                                <span class="text-danger">*</span>
                                {{ trns('email') }}
                            </label>
                            <input type="email" class="form-control" name="input" id="email-input" required>
                        </div>

                        <div id="alert-container"></div>
                    </div>
                    <div style="padding: 0 50px 50px 50px; margin-top: 30px; ">
                        <button type="submit" style="background-color: #2A3A65; color: #00F3CA;" class="btn w-100"
                            id="ForgotPasswordBtn">ارسال</button>
                    </div>
                </form>

                <!-- OTP and New Password Form -->
                <form id="check-otp-new-password" class="d-none">
                    @csrf
                    <div class="modal-body" style="padding: 0 50px;">
                        <div class="d-flex justify-content-center mt-4 mb-4">
                            <img src="{{ asset('assets/admin/assets/images/logo.png') }}" alt="login"
                                style="height: 60px;">
                        </div>
                        <h4 style="font-weight: bold; text-align: center;">إعادة تعين رمز الدخول</h4>
                        <p style="color: black; text-align: center;">الرجاء ادخل كلمة المرور الجديدة</p>

                        <div class="form-group">
                            <label for="otp-input" class="form-label d-flex justify-content-end">
                                الرمز
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" placeholder="الرمز" class="form-control" name="otp"
                                id="otp-input" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="password-input" class="form-label d-flex justify-content-end">
                                كلمة المرور الجديدة
                                <span class="text-danger">*</span>
                            </label>
                            <input type="password" placeholder="كلمة المرور الجديدة" class="form-control"
                                name="password" id="password-input" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirmation-input" class="form-label d-flex justify-content-end">
                                تأكيد كلمة المرور الجديدة
                                <span class="text-danger">*</span>
                            </label>
                            <input type="password" placeholder="تأكيد كلمة المرور الجديدة" class="form-control"
                                name="password_confirmation" id="password-confirmation-input" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div id="alert-container-otp"></div>
                    </div>
                    <div style="padding: 0 50px 50px 50px; margin-top: 30px;">
                        <button type="submit" class="btn w-100" id="submit-btn-otp"
                            style="background-color: #2A3A65; color: #00F3CA;">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.auth.js')

    <script src="{{ asset('assets/auth') }}/js/jquery.min.js"></script>
    <script src="{{ asset('assets/auth') }}/js/popper.js"></script>
    <script src="{{ asset('assets/auth') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/auth') }}/js/main.js"></script>
    <script src="sweetalert2.min.js"></script>
    <script>
        $(function() {

            'use strict';

            $('.tabs-list li').on('click', function() {

                $(this).addClass('show').siblings().removeClass('show');

                $('.content-list > form').hide();

                $($(this).data('content')).fadeIn();
            });

        });
    </script>




    <script>
        $(document).ready(function() {
            $("form#ForgotPasswordForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var url = $('#ForgotPasswordForm').attr('action');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#ForgotPasswordBtn').html(' <i class="fa fa-spinner fa-spin"></i>')
                            .attr(
                                'disabled',
                                true);

                    },

                    success: function(data) {
                        if (data.status == 200) {
                            $(document).ready(function() {
                                Swal.fire({
                                    title: '<span style="margin-bottom: 50px; display: block;">{{ trns('otp_successfully') }}</span>',
                                    imageUrl: '{{ asset('true.png') }}',
                                    imageWidth: 80,
                                    imageHeight: 80,
                                    imageAlt: 'Success',
                                    showConfirmButton: false,
                                    html: '<small style="font-size:24px;">{{ trns('you_will_be_redirected_to_otp_now') }}</small>',
                                    timer: 1500,
                                    customClass: {
                                        image: 'swal2-image-mt30'
                                    }
                                });
                            });
                            $('#ForgotPasswordBtn').html(
                                `<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> {{ trns('login') }}`
                            ).attr('disabled', true);

                            $('#ForgotPasswordForm')[0].reset();

                            setTimeout(function() {
                                var params = $.param({
                                    type: data.type,
                                    email: data.email
                                });
                                window.location.href =
                                    "{{ route('admin.checkOtpForm') }}?" + params;
                            }, 1500);

                        } else {

                            $('#ForgotPasswordBtn').html(
                                `<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> {{ trns('login') }}`
                            ).attr('disabled', false);
                            Swal.fire({

                                icon: 'error',
                                confirmButtonText: '{{ trns('OK') }}',
                                customClass: {
                                    confirmButton: 'my-confirm-btn'
                                },
                                buttonsStyling: false,
                                title: '{{ trns('something_went_wrong') }}'
                            });

                        }

                    },
                    error: function(xhr) {
                        $('#ForgotPasswordBtn').html(
                                '{{ trns('login') }}')
                            .attr('disabled', false);

                        if (xhr.status === 500) {
                            Swal.fire({

                                icon: 'error',
                                confirmButtonText: '{{ trns('OK') }}',
                                customClass: {
                                    confirmButton: 'my-confirm-btn'
                                },
                                buttonsStyling: false,
                                title: '{{ trns('server_error') }}',
                                text: '{{ trns('internal_server_error') }}'
                            });
                        } else if (xhr.status === 422) {


                            Swal.fire({

                                icon: 'error',
                                confirmButtonText: '{{ trns('OK') }}',
                                customClass: {
                                    confirmButton: 'my-confirm-btn'
                                },
                                buttonsStyling: false,
                                title: '{{ trns('validation_error') }}',
                                text: '{{ trns('please_check_your_input') }}'
                            });

                        } else if (xhr.status === 401) {


                            Swal.fire({

                                icon: 'error',
                                confirmButtonText: '{{ trns('OK') }}',
                                customClass: {
                                    confirmButton: 'my-confirm-btn'
                                },
                                buttonsStyling: false,
                                title: '{{ trns('invalid_credentials') }}',
                                text: '{{ trns('please_correct_your_password') }}'
                            });

                        } else {
                            Swal.fire({

                                icon: 'error',
                                confirmButtonText: '{{ trns('OK') }}',
                                customClass: {
                                    confirmButton: 'my-confirm-btn'
                                },
                                buttonsStyling: false,
                                title: '{{ trns('error') }}',
                                text: '{{ trns('something_went_wrong') }}'
                            });
                        }
                    },

                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });






        // Handle OTP and new password submission
        $('#check-otp-new-password').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const submitBtn = form.find('#submit-btn-otp');
            const alertContainer = form.find('#alert-container');
            const otpInput = $('#otp-input');
            const passwordInput = $('#password-input');
            const passwordConfirmationInput = $('#password-confirmation-input');
            const email = form.data('email');

            // Clear previous errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            alertContainer.empty();

            // Validate password confirmation
            if (passwordInput.val() !== passwordConfirmationInput.val()) {
                passwordConfirmationInput.addClass('is-invalid');
                passwordConfirmationInput.siblings('.invalid-feedback').text('كلمة المرور غير متطابقة');
                return;
            }

            // Show loading state
            submitBtn.prop('disabled', true).text('جاري الحفظ...');

            $.ajax({
                url: "{{ route('admin.resetPassword') }}", // You'll need to create this route
                type: 'POST',
                data: {
                    'email': email,
                    'otp': otpInput.val(),
                    'password': passwordInput.val(),
                    'password_confirmation': passwordConfirmationInput.val(),
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Hide loading
                    submitBtn.prop('disabled', false).text('جاري التحميل ...');

                    // Show success message
                    alertContainer.html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        ${response.message || 'تم تغيير كلمة المرور بنجاح'}
                    </div>
                `);

                    // Reset form and close modal after success
                    setTimeout(function() {
                        form[0].reset();
                        $('#reset-password-modal').modal('hide');

                        // Reset to first form for next time
                        $('#check-otp-new-password').addClass('d-none');
                        $('#reset-password').removeClass('d-none');

                        // Optionally redirect to login
                        window.location.href = "{{ route('admin.login') }}";
                    }, 2000);
                },
                error: function(xhr) {
                    // Hide loading
                    submitBtn.prop('disabled', false).text('حفظ');

                    if (xhr.status === 400) {
                        // OTP not found
                        submitBtn.prop('disabled', false).text(
                            'الرمز غير صحيح أو منتهي الصلاحية');
                        setTimeout(e => {
                            submitBtn.prop('disabled', false).text('حفظ');
                        }, 2000)
                    }
                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;

                        Object.keys(errors).forEach(function(key) {
                            const input = $(`#${key}-input`);
                            if (input.length) {
                                input.addClass('is-invalid');
                                input.siblings('.invalid-feedback').text(errors[
                                        key]
                                    [0]);
                            }
                        });
                    } else {
                        // General error
                        alertContainer.html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            ${xhr.responseJSON?.message || 'حدث خطأ أثناء حفظ كلمة المرور. يرجى المحاولة مرة أخرى'}
                        </div>
                    `);
                    }
                }
            });
        });

        // Handle back button to return to email form
        $('.modal').on('click', '[data-dismiss="modal"]', function() {
            // Reset to first form when modal is closed
            $('#check-otp-new-password').addClass('d-none');
            $('#reset-password').removeClass('d-none');

            // Clear all forms
            $('#reset-password')[0].reset();
            $('#check-otp-new-password')[0].reset();

            // Clear errors and messages
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#alert-container').empty();
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('#loginWithPhoneBtn').prop('disabled', !$('#rememberLoginWithPhoneBtn').is(':checked'));

            $('#rememberLoginWithPhoneBtn').on('change', function() {
                $('#loginWithPhoneBtn').prop('disabled', !$(this).is(':checked'));
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#loginBtn').prop('disabled', !$('#rememberLoginBtn').is(':checked'));

            $('#rememberLoginBtn').on('change', function() {
                $('#loginBtn').prop('disabled', !$(this).is(':checked'));
            });
        });
        client who order to make admin login  if read policy and terms or not
    </script> --}}


</body>

</html>
