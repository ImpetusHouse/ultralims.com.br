<head>
    <title>{{(isset($title) ? $title . ' - ' . config('app.name') : config('app.name'))}} | Impetus Sistemas</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="{{asset('images/impetus_favicon.ico')}}" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{asset('assets/plugins/custom/leaflet/leaflet.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .overlayer {
            width: 100%;
            height: 100%;
            background: rgba(26, 20, 35, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: -999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
        }
        .overlayer.show {
            z-index: 9999 !important;
            opacity: 1 !important;
            pointer-events: initial !important;
        }
        .overlayer > .body {
            padding: 35px 50px;
            border-radius: 8px;
            background: #FFF;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .overlayer > .body > svg {
            -webkit-animation-name: spin;
            -webkit-animation-duration: 2000ms;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: linear;
            -moz-animation-name: spin;
            -moz-animation-duration: 2000ms;
            -moz-animation-iteration-count: infinite;
            -moz-animation-timing-function: linear;
            -ms-animation-name: spin;
            -ms-animation-duration: 2000ms;
            -ms-animation-iteration-count: infinite;
            -ms-animation-timing-function: linear;
            animation-name: spin;
            animation-duration: 2000ms;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }
        .overlayer > .body > span {
            max-width: 320px;
            display: block;
            margin: 20px auto;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
        }
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes beat {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        .aside .menu>.menu-item>.menu-link.active .menu-icon i{
            color: #03B7FC !important;
            fill: #03B7FC !important;
        }

        svg.animate{
            -webkit-animation-name: beat;
            -webkit-animation-duration: 2000ms;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: linear;
            -moz-animation-name: beat;
            -moz-animation-duration: 2000ms;
            -moz-animation-iteration-count: infinite;
            -moz-animation-timing-function: linear;
            -ms-animation-name: beat;
            -ms-animation-duration: 2000ms;
            -ms-animation-iteration-count: infinite;
            -ms-animation-timing-function: linear;
            animation-name: beat;
            animation-duration: 2000ms;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }
    </style>

    @stack('head')
    @yield('head')

</head>
