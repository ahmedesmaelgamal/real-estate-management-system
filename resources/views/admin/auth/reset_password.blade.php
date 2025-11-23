<!doctype html>
<html lang="en">

<head>
    <title> {{ trns('login') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet"> -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fustat:wght@200..800&family=Jost:ital,wght@0,100..900;1,100..900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('assets/auth') }}/css/style.css">

</head>

<body style="background-color: white;">
    <section class="ftco-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="image-login" style="height: 100vh; padding: 10px 0;">
                        <img src="{{ asset('assets/admin/assets/images/bg-login.jpeg') }}" alt="login"
                            style="width: 100%; object-fit: cover; border-radius: 10px; height: 100%; ">
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="wrap">
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <div class="d-flex justify-content-center mt-5">
                                        <img src="{{ asset('assets/admin/assets/images/logo.png') }}" alt="login"
                                            style="height: 100px;">
                                    </div>
                                    <h3 class="mb-4 text-center mt-3" style="font-weight: bold;">إعادة تعيين كلمة المرور
                                    </h3>
                                    <div class="d-flex justify-content-center">
                                        @session('error')
                                            <small class="text-danger">{{ session('error') }} </small>
                                        @endsession
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('admin.resetPassword', ['email' => $email]) }}" id="resetPassword"
                                class="signin-form content-one" method="post">
                                @csrf

                                <div class="form-group">
                                    <label for="password" class="form-label d-flex justify-content-end">
                                        <span class="text-danger">*</span>
                                        {{ trns('password') }}
                                    </label>
                                    <input id="password-field" type="password" name="password" class="form-control"
                                        required>
                                    <span toggle="#password-field"
                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label d-flex justify-content-end">
                                        <span class="text-danger">*</span>
                                        {{ trns('password_confirmation') }}
                                    </label>
                                    <input id="password-confirmation-field" type="password" name="password_confirmation"
                                        class="form-control" required>
                                    <span toggle="#password-confirmation-field"
                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="resetPasswordBtn"
                                        style="color: #00f3ca !important; font-weight: bold; font-size: 18px;"
                                        class="form-control btn btn-primary rounded submit px-3">{{ trns('login') }}
                                    </button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <p data-v-46b35b01="" class="text-right constrains mb-4"> بالمتابعة أنت توافق
                                        على <b data-v-46b35b01=""
                                            style="color: rgb(0, 0, 0); font-weight: 700 !important; cursor: pointer;">الشروط
                                            و الأحكام </b>الخاصة بنا </p>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/auth') }}/js/jquery.min.js"></script>
    <script src="{{ asset('assets/auth') }}/js/popper.js"></script>
    <script src="{{ asset('assets/auth') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/auth') }}/js/main.js"></script>


    <script>
        $('#resetPasswordBtn').on('click', function(e) {
            $(this).attr('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i>');

            setTimeout(() => {
                $(this).attr('disabled', false);
                $(this).html('{{ trns('reset_password') }}');
                $('#resetPassword').submit();
            }, 3000)
        });
    </script>
</body>

</html>
