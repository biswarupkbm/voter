<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Responsive Multipurpose Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Home')</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/logos/favicon.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-5.14.0.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Custom CSS -->
    <style>
        body { font-family: 'Inter', sans-serif; background: #f9f9f9; }
        .navigation li { display: inline-block; margin: 0 10px; }
        .navigation li a { color: #333; font-weight: 500; }
        .navigation li a:hover { color: #ff6600; }
        .theme-btn { background-color: #ff6600; color: #fff; padding: 10px 18px; border-radius: 5px; }
        .theme-btn:hover { background-color: #e95500; }
        .light-btn { background: transparent; border: 1px solid #ff6600; color: #ff6600; padding: 10px 18px; border-radius: 5px; }
        .light-btn:hover { background-color: #ff6600; color: #fff; }
        .footer-title { font-weight: 600; margin-bottom: 10px; }
        .footer-widget ul { list-style: none; padding: 0; }
        .footer-widget ul li a { color: #ccc; transition: 0.3s; }
        .footer-widget ul li a:hover { color: #fff; }
        .scroll-top { position: fixed; right: 15px; bottom: 15px; background: #ff6600; color: #fff; border: none; border-radius: 50%; padding: 10px 12px; cursor: pointer; display: none; }
        .scroll-top:hover { background: #e95500; }
    </style>
</head>
<body class="home-three">
<div class="page-wrapper">

    <!-- HEADER -->
    <header class="main-header menu-absolute">
        <div class="header-upper">
            <div class="container container-1520 clearfix">
                <div class="header-inner py-20 rpy-10 rel d-flex align-items-center">
                    <!-- Logo -->
                    <div class="logo-outer">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/images/logos/logo3.png') }}" alt="Logo" title="Logo">
                            </a>
                        </div>
                    </div>
                    <!-- Navigation -->
                    <div class="nav-outer ms-lg-auto clearfix">
                        <nav class="main-menu navbar-expand-lg">
                            <div class="navbar-header py-10">
                                <div class="mobile-logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset('assets/images/logos/logo3.png') }}" alt="Logo" title="Logo">
                                    </a>
                                </div>
                                <button type="button" class="navbar-toggle" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="navbar-collapse collapse clearfix">
                                <ul class="navigation clearfix">
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Buttons -->
                    <div class="menu-btns ms-lg-auto">
                        <a href="{{ url('/login') }}" class="light-btn">Log in</a>
                        <a href="{{ url('/register') }}" class="theme-btn style-two">Sign Up <i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="main-footer footer-three pt-100 rel z-1 bgc-navyblue">
        <div class="container">
            <div class="for-middle-border pb-50">
                <div class="row justify-content-between">
                    <div class="col-xl-6 col-lg-7">
                        <div class="footer-widget widget-about">
                            <div class="section-title text-white">
                                <h2>We’re Now Available On Store Download Our Apps</h2>
                                <p>No credit card requirement — it’s free for all</p>
                            </div>
                            <div class="footer-btns">
                                <a href="https://play.google.com/store/apps" class="theme-btn">Play Store <i class="fab fa-google-play"></i></a>
                                <a href="https://www.apple.com/app-store/" class="theme-btn style-three">Apple Store <i class="fab fa-apple"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 ms-lg-auto">
                        <div class="footer-widget widget-links">
                            <h6 class="footer-title">Resources</h6>
                            <ul>
                                <li><a href="#">Product</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Benefits</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <div class="footer-widget widget-links">
                            <h6 class="footer-title">Quick Links</h6>
                            <ul>
                                <li><a href="#">Features</a></li>
                                <li><a href="#">Pricing Plan</a></li>
                                <li><a href="#">Best Program</a></li>
                                <li><a href="#">Press Kit</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom py-15">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-6">
                        <div class="copyright-text">
                            <p>Copyright @{{ date('Y') }}, <a href="#">Akpager</a> All Rights Reserved</p>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-6 text-end">
                        <a href="#"><img src="{{ asset('assets/images/logos/logo-white3.png') }}" alt="Logo"></a>
                    </div>
                </div>
                <button class="scroll-top scroll-to-target" data-target="html"><span class="far fa-angle-double-up"></span></button>
            </div>
        </div>
    </footer>

</div>

<!-- JS -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/aos.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

<script>
    // Scroll Top Button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scroll-top').fadeIn();
        } else {
            $('.scroll-top').fadeOut();
        }
    });
    $('.scroll-top').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
</script>

</body>
</html>
