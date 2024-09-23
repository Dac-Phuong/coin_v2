<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
        integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
        integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/headerall.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover.css') }}">
    <link rel="stylesheet" href="{{ asset('js/jquery-3.6.4.min.js') }}">

    <style>
        .skiptranslate iframe {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        .goog-te-combo {
            width: 110px !important;
            height: 38px;
        }

        .skiptranslate span {
            display: none !important;
        }
    </style>
    @livewireStyles
</head>

<body>
    <div class="depo_bg">
        <div class="header_bg header1_bg" style="background:#416382">
            <div class="container">
                <div class="banner_bg">
                    <header>
                        @include('web.layouts.nav')
                    </header>
                </div>
            </div>
            <div class="scroller">
                <a href="#" id="scroll" style="display: none">
                    <img src="{{ asset('/images/staking_logo.png') }}" class="top_but" />
                </a>
            </div>
            <div class="content_bg banner">
                <div class="container">
                    <div class="content_text ml9 head">
                        <h3>Register Success</h3>
                    </div>
                    <div class="content_subtext"></div>
                </div>
            </div>
        </div>
        <div class="admin_bg  about_bg">
            <div class="container items-center">

                <div class="row">
                    <div class=" col-md-12">
                        <div class="m-auto" style="width: 200px;">
                            <img src="{{ asset('images/check.png') }}" class="img1" alt="content_img3" />
                        </div>
                        <div class="rem_text text-center">
                            <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Check your email</h1>
                            <h3 class="text-white">Please check your email to confirm your email address before logging
                                in to the system...</h3>
                            <div class="text_but text-center">
                                <a href="{{ url('login') }}" wire:navigate class="but"> login</a>
                                <a href="{{ url('/') }}" wire:navigate class="but"> Home</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @include('web.layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="{{ asset('js/ion.rangeSlider.js') }}"></script>
    <script src="{{ asset('js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/livewire/index.js') }}"></script>
    @livewireScripts
</body>

</html>
