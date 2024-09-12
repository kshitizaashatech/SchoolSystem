<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME') }} Login </title>
    <link rel="stylesheet" href="{{ asset('adminassets/assets/bootstrap/dist/css/bootstrap.min.css') }}" />
    <!-- <link rel="stylesheet" href="wwwroot/css/site.css" asp-append-version="true" />
    <link rel="stylesheet" href="~/LifeInsuranceCore.styles.css" asp-append-version="true" />*@ -->

    <!-- ===============================================-->
    <!--    assets from dashboard-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('adminassets/assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('adminassets/assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('adminassets/assets/img/favicons/favicon-32x32.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('adminassets/assets/img/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('adminassets/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('adminassets/assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('adminassets/assets/js/config.js') }}"></script>
    <script src="{{ asset('adminassets/vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>

    <!-- ===============================================-->
    <!--    Stylesheets from dashboard-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('adminassets/vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminassets/assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('adminassets/assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">


    <link rel="stylesheet" href="{{ asset('adminassets/css/custom.css') }}" asp-append-version="true" />


    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>



            <main class="main" id="top">
                <div class="container-fluid">
                    <div class="row min-vh-100 flex-center g-0">
                        <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape"
                                src="{{ asset('adminassets/assets/img/icons/spot-illustrations/bg-shape.png') }}"
                                alt="" width="250"><img class="bg-auth-circle-shape-2"
                                src="{{ asset('adminassets/assets/img/icons/spot-illustrations/shape-1.png') }}"
                                alt="" width="150">
                            <div class="card overflow-hidden z-index-1">
                                <div class="card-body p-0">
                                    <div class="row g-0 h-100">
                                        <div class="col-md-5 text-center bg-card-gradient">
                                            <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                                <div class="bg-holder bg-auth-card-shape"
                                                    style="background-image:url(adminassets/assets/img/icons/spot-illustrations/half-circle.png);">
                                                </div>
                                                <!--/.bg-holder-->
                                                <div class="z-index-1 position-relative"><a
                                                        class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder"
                                                        href="#">{{ env('APP_NAME') }}</a>
                                                    <img height="200" width="200"
                                                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/Emblem_of_Nepal.svg/800px-Emblem_of_Nepal.svg.png">
                                                    {{-- <p class="opacity-75 text-white">With the power of Falcon, you can now focus only on functionaries for your digital products, while leaving the UI design on us!</p> --}}
                                                </div>
                                            </div>
                                          
                                        </div>
                                        <div class="col-md-7 d-flex flex-center">
                                            <div class="p-4 p-md-5 flex-grow-1">
                                                <div class="row flex-between-center">
                                                    <div class="col-auto">
                                                        <h3>{{ __('Account Login') }}</h3>
                                                    </div>
                                                </div>
                                                <form method="POST" action="{{ route('login') }}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label" for="card-email">{{ __('Email Address') }}</label>
                                                        <input class="form-control @error('email') is-invalid @enderror" id="card-email" type="email"
                                                            name="email" value="{{ old('email') }}">

                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                        <br>
                                                        {{-- <span style="color:red">{{ $message }}</span> --}}
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="form-label"
                                                                for="card-password">{{ __('Password') }}</label>
                                                        </div>
                                                        <input class="form-control @error('password') is-invalid @enderror" id="card-password"
                                                            type="password" name="password"
                                                            value="{{ old('password') }}" required autocomplete="current-password">
                                                            
                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <br>
                                                        {{-- <span>{{ $message }}</span> --}}
                                                    </div>
                                                    <div class="row flex-between-center">
                                                        <div class="col-auto">
                                                            <div class="form-check mb-0"><input
                                                                    class="form-check-input" type="checkbox"
                                                                    id="card-checkbox" checked="checked"
                                                                    name="remember">
                                                                <label class="form-check-label mb-0"
                                                                    for="card-checkbox">{{__('Remember Me')}}</label>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-auto"><a class="fs--1" href="../../../pages/authentication/card/forgot-password.html">Forgot Password?</a></div> --}}
                                                    </div>
                                                    <div class="mb-3"><button
                                                            class="btn btn-primary d-block w-100 mt-3" type="submit"
                                                            name="submit">{{ __('Login') }}</button></div>
                                                </form>
                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- ===============================================-->
            <!--    End of Main Content-->
            <!-- ===============================================-->




            <!-- ===============================================-->
            <!--    End of Main Content-->
            <!-- ===============================================-->



            <!-- ===============================================-->
            <!--    JavaScripts from dashboard-->
            <!-- ===============================================-->


            <script type="text/javascript">
                InitializeUnicodeNepali();
            </script>

            <script>
                $(function() {
                    var current = location.pathname;
                    $('.navbar .nav-item .nav-link ').each(function() {
                        var $this = $(this);
                        // if the current path is like this link, make it active
                        if ($this.attr('href').indexOf(current) !== -1) {
                            $this.closest("nav-link.dropdown-indicator.collapsed").removeClass('collapsed');
                            $this.closest(".nav.false.collapse").addClass('show');
                            $this.addClass('active');
                        }
                    })
                })
            </script>
</body>

</html>
