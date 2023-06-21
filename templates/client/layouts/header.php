<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
    <!-- Meta tag -->
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="Crater" content="Responsive Multipurpose Business Template"/>
    <meta name="copyright" content="Crater"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Title Tag -->
    <title>Crater &#8739; Creative Business & Consulting HTML5 Template</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo _WEB_HOST_CORE_TEMPLATE; ?>/assets/images/crater-favicon.png"/>

    <!-- Google Font -->
    <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700,800"
            rel="stylesheet"
    />

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/bootstrap.min.css"/>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/font-awesome.min.css"/>
    <!-- Slick Nav CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/slicknav.min.css"/>
    <!-- Cube Portfolio CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/cubeportfolio.min.css"/>
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/magnific-popup.min.css"/>
    <!-- Fancy Box CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/jquery.fancybox.min.css"/>
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/niceselect.css"/>
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/owl.theme.default.css"/>
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/owl.carousel.min.css"/>
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/slickslider.min.css"/>
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/animate.min.css"/>

    <!-- Crater StyleShet CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/reset.css"/>
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/style.css"/>
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/responsive.css"/>

    <!-- Crater Color CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/color.css"/>
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="preloader-inner">
        <div class="single-loader one"></div>
        <div class="single-loader two"></div>
        <div class="single-loader three"></div>
        <div class="single-loader four"></div>
        <div class="single-loader five"></div>
        <div class="single-loader six"></div>
        <div class="single-loader seven"></div>
        <div class="single-loader eight"></div>
        <div class="single-loader nine"></div>
    </div>
</div>
<!-- End Preloader -->

<!-- Start Header -->
<header id="header" class="header">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <!-- Contact -->
                    <ul class="contact">
                        <li><i class="fa fa-headphones"></i> +(123) 45678910</li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:info@yourmail.com">info@yourmail.com</a>
                        </li>
                        <li><i class="fa fa-clock-o"></i>Opening: 09am-5pm</li>
                    </ul>
                    <!--/ End Contact -->
                </div>
                <div class="col-lg-6 col-12">
                    <div class="topbar-right">
                        <!-- Search Form -->
                        <div class="search-form active">
                            <a class="icon" href="#"><i class="fa fa-search"></i></a>
                            <form class="form" action="#">
                                <input placeholder="Search & Enter" type="search"/>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                        <!-- Social -->
                        <ul class="social">
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-behance"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                            </li>
                        </ul>
                        <!--/ End Social -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Topbar -->
    <!-- Middle Bar -->
    <div class="middle-bar">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.html">
                            <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/crater-logo.png"
                                 alt="logo"/>
                        </a>
                    </div>
                    <div class="link">
                        <a href="index.html">
                            <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/crater-logo.png"
                                 alt="logo"/>
                        </a>
                    </div>
                    <!--/ End Logo -->
                    <button class="mobile-arrow"><i class="fa fa-bars"></i></button>
                    <div class="mobile-menu"></div>
                </div>
                <div class="col-lg-10 col-12">
                    <!-- Main Menu -->
                    <div class="mainmenu">
                        <nav class="navigation">
                            <ul class="nav menu">
                                <li class="active"><a href="index.html">Home</a></li>
                                <li class="has-dropdown">
                                    <a href="#">Pages</a>
                                    <ul>
                                        <li><a href="about-us.html">About Us</a></li>
                                        <li><a href="team.html">Our Team</a></li>
                                        <li><a href="pricing.html">Pricing</a></li>
                                    </ul>
                                </li>
                                <li><a href="services.html">Services</a></li>
                                <li><a href="portfolio.html">Portfolio</a></li>
                                <li class="has-dropdown">
                                    <a href="#">Blogs</a>
                                    <ul>
                                        <li><a href="blog.html">Blog layout</a></li>
                                        <li class="has-dropdown">
                                            <a href="blog-single.html">Blog Single</a>
                                            <ul>
                                                <li><a href="#">Sample 1</a></li>
                                                <li class="has-dropdown">
                                                    <a href="#">Sample 2</a>
                                                    <ul>
                                                        <li><a href="#">Sample 2.1</a></li>
                                                        <li><a href="#">Sample 2.2</a></li>
                                                        <li><a href="#">Sample 2.3</a></li>
                                                        <li><a href="#">Sample 2.4</a></li>
                                                        <li><a href="#">Sample 2.5</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#">Sample 3</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                        <!-- Button -->
                        <div class="button">
                            <a href="contact.html" class="btn">Get a quote</a>
                        </div>
                        <!--/ End Button -->
                    </div>
                    <!--/ End Main Menu -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Middle Bar -->
</header>
<!--/ End Header -->
