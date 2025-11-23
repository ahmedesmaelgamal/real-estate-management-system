<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ trns('terms_and_conditions') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {

            font-family: "IBM Plex Sans Arabic", sans-serif !important;
            background-color:white;
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
            padding: 20px;

        }
        h4 {
            font-family: "IBM Plex Sans Arabic", sans-serif !important;
            margin-top: 1.5rem;
            font-weight: bold;
            color: #2A3A65;
        }

        p {
            font-family: "IBM Plex Sans Arabic", sans-serif !important;
            font-size: 1rem;
            line-height: 1.7;
            color: #555;
        }
         .btn-one{
    background-color: #00193a;
    color: #00F3CA;
    border: none;
    /* margin-left: 10px; */
    font-weight: bold;
    width: 300px;
    }
    .btn-one:hover{
        background-color: #00F3CA;
        color: #00193a;
    }

    </style>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-1 col-12"></div>
            <div class="col-lg-10 col-12" style="border-radius: 10px; border: 1px solid gainsboro; padding:0;">
                <div style="background-color: #00193a; border-radius: 10px 10px 0 0;">
    <div class="container d-flex justify-content-center">
            <a href="{{ route('admin.login') }}">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="max-width: 200px;">
            </a>
    </div>
</div>
<div class="card-header">
            <h4 class="text-center">{{ trns('terms_and_conditions') }}</h4>
        </div>
        <div class="card-body p-5">
            {!! $terms !!}

        </div>
            </div>
            <div class="col-lg-1 col-12"></div>
        </div>

        <!-- <div class="mt-5 d-flex justify-content-center">
              <a href="{{ route('admin.login') }}" class="btn btn-one">
                            استكمال التسجيل
        </a>
        </div> -->

    </div>

</body>
</html>
