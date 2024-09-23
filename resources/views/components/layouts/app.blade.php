<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Page Title' }}</title>
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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/headerall.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .plan-title {
            width: 50%;
            padding: 10px;
            font-size: 17px;
            font-weight: 500;
            color: #ffb821;
            margin: 0px;
            border-bottom: 1px dashed #ffb8219e;
            background: #2c5168;
        }

        .deposit-modal-col {
            width: 75%;
        }

        .qr-image {
            width: 25%;
        }

        .plan-title1 {
            width: 50%;
            font-size: 17px;
            font-weight: 500;
            color: #fff;
            padding: 10px;
            border-bottom: 1px dashed #ffb8217a;
        }

        .qr-image svg .qr-image div {
            width: 100% !important;
            height: 100% !important;
        }
        input {
            width: 100%;
            font-size: 16px;
            box-sizing: border-box;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        html,
        body {
            overflow: auto;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }
  .withdraw-icon {
            height: 35px;
            width: 35px;
            position: absolute;
            right: 11px;
            top: 8px;
            border-radius: 20px;
            display: flex;
            text-align: center;
            justify-content: center;
            align-items: center;
            background: #fff;
            cursor: pointer;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }
        @media (max-width: 992px) {
            .deposit-modal-col {
                width: 100%;
            }

            .plan-title,
            .plan-title1 {
                font-size: 14px;
            }

            select.w-50 {
                height: 37.8px;
            }

            .qr-image {
                margin-top: 10px;
                width: 100%;
            }
        }
    </style>
    @livewireStyles
</head>

<body>
    <main class="content">
        @yield('content')
    </main>
    @include('web.layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="{{ asset('js/livewire/index.js') }}"></script>
    <script>
        function copyToClipboard() {
            var input = document.getElementById('myInput');
            input.select();
            document.execCommand('copy');
        }
        // Ngăn chặn pinch-to-zoom nhưng vẫn cho phép cuộn
        document.addEventListener('touchstart', function(event) {
            if (event.touches.length > 1) {
                event.preventDefault(); // Prevent zoom
            }
        }, {
            passive: false
        });

        // Ngăn chặn zoom bằng cử chỉ
        document.addEventListener('gesturestart', function(e) {
            e.preventDefault();
        });

        document.addEventListener('gesturechange', function(e) {
            e.preventDefault();
        });

        document.addEventListener('gestureend', function(e) {
            e.preventDefault();
        });
    </script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
