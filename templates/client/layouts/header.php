<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

$themeColor = getOption('general_theme_color');
if (empty($themeColor)) {
    // Default theme color
    $themeColor = '#26bdef';
}
$faviconUrl = getOption('general_favicon');
if (empty($faviconUrl)) {
    // Default favicon
    $faviconUrl = _WEB_HOST_CORE_TEMPLATE . '/assets/images/crater-favicon.png';
}
$logoUrl = getOption('general_logo');
if (empty($logoUrl)) {
    // Default logo
    $logoUrl = _WEB_HOST_CLIENT_TEMPLATE . '/assets/images/crater-logo.png';
}

$homeHero = json_decode(getOption('home_hero'), true);
if (!empty($homeHero['general'])) {
    $heroGeneralOpts = json_decode($homeHero['general'], true);
}
if (!empty($heroGeneralOpts['bg_opacity'])) {
    $bgOpacity = $heroGeneralOpts['bg_opacity'];
} else {
    // Default opacity
    $bgOpacity = 0.94;
}

$homeCta = json_decode(getOption('home_cta'), true);
if (!empty($homeCta['general'])) {
    $ctaGeneralOpts = json_decode($homeCta['general'], true);
}
if (!empty($ctaGeneralOpts['bg_image'])) {
    $bgImage = $ctaGeneralOpts['bg_image'];
} else {
    // Default Call to Action background image
    $bgImage = _WEB_HOST_CLIENT_TEMPLATE . '/assets/images/call-to-action.jpg';
}

?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
    <!-- Meta tag -->
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Title Tag -->
    <title><?php echo getOption('general_sitename'); ?> | <?php echo (!empty($dataHeader['pageTitle']))
            ? $dataHeader['pageTitle']
            : 'Get creative - Get Coding'; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $faviconUrl; ?>"/>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700,800"
          rel="stylesheet"/>

    <style>
        :root {
            --theme-color: <?php echo $themeColor; ?>;
            --home-hero-opacity: <?php echo $bgOpacity; ?>;
            --home-cta-bg-img: url("<?php echo $bgImage; ?>");
        }
    </style>

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
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"
        nonce="6H0CH2B6"></script>

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
                        <li><i class="fa fa-headphones"></i><?php echo getOption('general_hotline'); ?></li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:<?php echo getOption('general_email'); ?>"><?php echo getOption('general_email'); ?></a>
                        </li>
                        <li><i class="fa fa-clock-o"></i><?php echo getOption('general_opening'); ?></li>
                    </ul>
                    <!--/ End Contact -->
                </div>
                <div class="col-lg-6 col-12">
                    <div class="topbar-right">
                        <!-- Search Form -->
                        <div class="search-form active">
                            <a class="icon" href="#"><i class="fa fa-search"></i></a>
                            <form class="form" action="#">
                                <input placeholder="<?php echo getOption('header_search_placeholder'); ?>"
                                       type="search"/>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                        <!-- Social -->
                        <ul class="social">
                            <li>
                                <a target="_blank" href="<?php echo getOption('general_twitter'); ?>">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php echo getOption('general_facebook'); ?>">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php echo getOption('general_linkedin'); ?>">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php echo getOption('general_behance'); ?>">
                                    <i class="fa fa-behance"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php echo getOption('general_youtube'); ?>">
                                    <i class="fa fa-youtube"></i>
                                </a>
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
                        <a href="<?php echo getAbsUrlFront(); ?>">
                            <img src="<?php echo $logoUrl; ?>"
                                 alt="logo"/>
                        </a>
                    </div>
                    <div class="link">
                        <a href="<?php echo getAbsUrlFront(); ?>">
                            <img src="<?php echo $logoUrl; ?>"
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
                            <a href="<?php echo getOption('header_quote_link'); ?>"
                               class="btn"><?php echo getOption('header_quote_text'); ?></a>
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
