<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Get creative - Get Coding'];
addLayout('header', 'client', $dataHeader);
?>


<?php
$homeHero = json_decode(getOption('home_hero'), true);
if (!empty($homeHero['slider'])):
    $slides = json_decode($homeHero['slider'], true);
    if (!empty($slides) && is_array($slides)) :
        ?>
        <!-- Hero Area -->
        <section id="hero-area" class="hero-area">
            <!-- Slider -->
            <div class="<?php echo (count($slides) > 1) ? 'slider-area' : null; ?>">
                <?php
                foreach ($slides as $slide) :
                    if ($slide['slide_text_align'] == 'right') {
                        $textAlignClass = 'text-right';
                    } elseif ($slide['slide_text_align'] == 'center') {
                        $textAlignClass = 'text-center';
                    } else {
                        $textAlignClass = '';
                    }
                    $slideImages = '<!-- Image Gallery -->
                                    <div class="image-gallery">
                                        <div class="single-image">
                                            <img src="' . $slide['slide_image_1'] . '"/>
                                        </div>
                                        <div class="single-image two">
                                            <img src="' . $slide['slide_image_2'] . '"/>
                                        </div>
                                    </div>
                                    <!--/ End Image Gallery -->';
                    if (!empty($slide['slide_btn_text'])) {
                        $slideViewMoreBtn = '<a href="' . $slide['slide_btn_link'] . '" class="btn">' . $slide['slide_btn_text'] . '</a>';
                    } else {
                        $slideViewMoreBtn = '';
                    }
                    if (!empty($slide['slide_play_text'])) {
                        $slidePlayBtn = '<a href="' . $slide['slide_play_link'] . '"
                                            class="btn video video-popup mfp-fade"
                                         ><i class="fa fa-play"></i>' . $slide['slide_play_text'] . '</a>';
                    } else {
                        $slidePlayBtn = '';
                    }
                    $slideText = '<!-- Slider Text -->
                                    <div class="slider-text ' . $textAlignClass . '">
                                        <h1>' . html_entity_decode($slide['slide_title']) . '</h1>
                                        <p>' . $slide['slide_desc'] . '</p>
                                        <div class="button">' . $slideViewMoreBtn . $slidePlayBtn . '</div>
                                    </div>
                                    <!--/ End Slider Text -->';

                    if ($slide['slide_layout'] == 'right') {
                        $slideLayoutClass = 'slider-right';
                        $colLeft = '<div class="col-lg-5 col-md-6 col-12">' . $slideImages . '</div>';
                        $colRight = '<div class="col-lg-7 col-md-6 col-12">' . $slideText . '</div>';
                    } elseif ($slide['slide_layout'] == 'center') {
                        $slideLayoutClass = 'slider-center';
                        $colLeft = '<div class="col-lg-10 offset-lg-1 col-12">' . $slideText . '</div>';
                        $colRight = '';
                    } else {
                        $slideLayoutClass = '';
                        $colLeft = '<div class="col-lg-7 col-md-6 col-12">' . $slideText . '</div>';
                        $colRight = '<div class="col-lg-5 col-md-6 col-12">' . $slideImages . '</div>';
                    }
                    ?>

                    <!-- Single Slider -->
                    <div class="single-slider <?php echo $slideLayoutClass; ?>"
                         style="background-image: url('<?php echo $slide['slide_background']; ?>')"
                    >
                        <div class="container">
                            <div class="row">
                                <?php echo $colLeft . $colRight; ?>
                            </div>
                        </div>
                    </div>
                    <!--/ End Single Slider -->
                <?php
                endforeach;
                ?>
            </div>
            <!--/ End Slider -->
        </section>
        <!--/ End Hero Area -->
    <?php
    endif;
endif;
?>


    <!-- About Us -->
<?php
$homeAbout = json_decode(getOption('home_about'), true);
if (!empty($homeAbout['general'])) {
    $aboutGeneralOpts = json_decode($homeAbout['general'], true);
}
?>
    <section class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title wow fadeInUp">
                        <span class="title-bg"
                        ><?php echo (!empty($aboutGeneralOpts['bg_title']))
                                ? $aboutGeneralOpts['bg_title'] : null; ?></span>

                        <?php echo (!empty($aboutGeneralOpts['main_title']))
                            ? html_entity_decode($aboutGeneralOpts['main_title']) : null; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12 wow fadeInLeft" data-wow-delay="0.6s">
                    <!-- Video -->
                    <div class="about-video">
                        <div class="single-video overlay">
                            <?php
                            if (!empty($aboutGeneralOpts['intro_video']) && !empty($aboutGeneralOpts['intro_image'])) :
                                ?>
                                <a href="<?php echo $aboutGeneralOpts['intro_video']; ?>"
                                   class="video-popup mfp-fade"
                                ><i class="fa fa-play"></i></a>
                            <?php endif; ?>
                            <?php
                            if (!empty($aboutGeneralOpts['intro_image'])) :
                                ?>
                                <img src="<?php echo $aboutGeneralOpts['intro_image']; ?>" alt="#"/>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!--/ End Video -->
                </div>
                <div class="col-lg-6 col-12 wow fadeInRight" data-wow-delay="0.8s">
                    <!-- About Content -->
                    <div class="about-content">
                        <?php echo (!empty($aboutGeneralOpts['intro_content']))
                            ? html_entity_decode($aboutGeneralOpts['intro_content']) : null; ?>
                    </div>
                    <!--/ End About Content -->
                </div>
            </div>
            <?php
            if (!empty($homeAbout['skill'])):
                $skills = json_decode($homeAbout['skill'], true);
                if (!empty($skills) && is_array($skills)) :
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="progress-main">
                                <div class="row">
                                    <?php
                                    $delay = 0.4;
                                    foreach ($skills as $skill) :
                                        ?>
                                        <div class="col-lg-6 col-md-6 col-12 wow fadeInUp"
                                             data-wow-delay="<?php echo $delay; ?>s">
                                            <!-- Single Skill -->
                                            <div class="single-progress">
                                                <h4><?php echo $skill['skill_name']; ?></h4>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                         role="progressbar"
                                                         style="width: <?php echo $skill['skill_percent']; ?>%"
                                                         aria-valuenow="25"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100"
                                                    >
                                                        <span class="percent"><?php echo $skill['skill_percent']; ?>%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/ End Single Skill -->
                                        </div>
                                        <?php
                                        $delay += 0.2;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
            endif;
            ?>
        </div>
    </section>
    <!--/ End About Us -->

    <!-- Services -->
<?php
$homeService = json_decode(getOption('home_service'), true);
if (!empty($homeService['general'])) {
    $serviceGeneralOpts = json_decode($homeService['general'], true);
}
?>
    <section id="services" class="services section">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="section-title">
                        <span class="title-bg"><?php echo (!empty($serviceGeneralOpts['bg_title']))
                                ? $serviceGeneralOpts['bg_title'] : null; ?></span>

                        <?php echo (!empty($serviceGeneralOpts['main_title']))
                            ? html_entity_decode($serviceGeneralOpts['main_title']) : null; ?>
                    </div>
                </div>
            </div>
            <?php
            $result = getAllRows("SELECT * FROM services ORDER BY name");
            $services = $result;
            if (!empty($services)) :
                while (count($services) <= 4) {
                    $services = array_merge($services, $result);
                }
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="service-slider">
                            <?php foreach ($services as $service) : ?>
                                <!-- Single Service -->
                                <div class="single-service">
                                    <?php echo html_entity_decode($service['icon']); ?>
                                    <h2><a href="#"><?php echo $service['name']; ?></a></h2>
                                    <p>
                                        <?php echo $service['description']; ?>
                                    </p>
                                </div>
                                <!-- End Single Service -->
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!--/ End Services -->

    <!-- Fun Facts -->
    <section id="fun-facts" class="fun-facts section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12 wow fadeInLeft" data-wow-delay="0.5s">
                    <div class="text-content">
                        <div class="section-title">
                            <h1>
                                <span>Our achievements</span>With smooth animation numbering
                            </h1>
                            <p>
                                Pellentesque vitae gravida nulla. Maecenas molestie ligula
                                quis urna viverra venenatis. Donec at ex metus. Suspendisse ac
                                est et magna viverra eleifend. Etiam varius auctor est eu
                                eleifend.
                            </p>
                            <a href="contact.html" class="btn primary">Contact Us</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 wow fadeIn"
                             data-wow-delay="0.6s">
                            <!-- Single Fact -->
                            <div class="single-fact">
                                <div class="icon"><i class="fa fa-clock-o"></i></div>
                                <div class="counter">
                                    <p><span class="count">35</span></p>
                                    <h4>years of success</h4>
                                </div>
                            </div>
                            <!--/ End Single Fact -->
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 wow fadeIn"
                             data-wow-delay="0.8s">
                            <!-- Single Fact -->
                            <div class="single-fact">
                                <div class="icon"><i class="fa fa-bullseye"></i></div>
                                <div class="counter">
                                    <p><span class="count">88</span>K</p>
                                    <h4>Project Complete</h4>
                                </div>
                            </div>
                            <!--/ End Single Fact -->
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 wow fadeIn"
                             data-wow-delay="1s">
                            <!-- Single Fact -->
                            <div class="single-fact">
                                <div class="icon"><i class="fa fa-dollar"></i></div>
                                <div class="counter">
                                    <p><span class="count">10</span>M</p>
                                    <h4>Total Earnings</h4>
                                </div>
                            </div>
                            <!--/ End Single Fact -->
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 wow fadeIn"
                             data-wow-delay="1.2s">
                            <!-- Single Fact -->
                            <div class="single-fact">
                                <div class="icon"><i class="fa fa-trophy"></i></div>
                                <div class="counter">
                                    <p><span class="count">32</span></p>
                                    <h4>Winning Awards</h4>
                                </div>
                            </div>
                            <!--/ End Single Fact -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Fun Facts -->

    <!-- Portfolio -->
    <section id="portfolio" class="portfolio section">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="section-title">
                        <span class="title-bg">Projects</span>
                        <h1>Our Portfolio</h1>
                        <p>
                            Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor.
                            Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus
                            magna, a vehicula turpis Proin
                        </p>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- portfolio Nav -->
                    <div class="portfolio-nav">
                        <ul class="tr-list list-inline" id="portfolio-menu">
                            <li data-filter="*" class="cbp-filter-item active">
                                All Works
                                <div class="cbp-filter-counter"></div>
                            </li>
                            <li data-filter=".animation" class="cbp-filter-item">
                                Animation
                                <div class="cbp-filter-counter"></div>
                            </li>
                            <li data-filter=".website" class="cbp-filter-item">
                                Website
                                <div class="cbp-filter-counter"></div>
                            </li>
                            <li data-filter=".package" class="cbp-filter-item">
                                Package
                                <div class="cbp-filter-counter"></div>
                            </li>
                            <li data-filter=".development" class="cbp-filter-item">
                                Development
                                <div class="cbp-filter-counter"></div>
                            </li>
                            <li data-filter=".printing" class="cbp-filter-item">
                                Printing
                                <div class="cbp-filter-counter"></div>
                            </li>
                        </ul>
                    </div>
                    <!--/ End portfolio Nav -->
                </div>
            </div>
            <div class="portfolio-inner">
                <div class="row">
                    <div class="col-12">
                        <div id="portfolio-item">
                            <!-- Single portfolio -->
                            <div class="cbp-item website animation printing">
                                <div class="portfolio-single">
                                    <div class="portfolio-head">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p1.jpg"
                                             alt="#"/>
                                    </div>
                                    <div class="portfolio-hover">
                                        <h4><a href="portfolio-single.html">Creative Work</a></h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac enim
                                        </p>
                                        <div class="button">
                                            <a class="primary"
                                               data-fancybox="gallery01"
                                               href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p1.jpg"
                                            ><i class="fa fa-search"></i></a>
                                            <div style="display: none">
                                                <a data-fancybox="gallery01"
                                                   href="https://lipsum.app/id/61/1600x1200"
                                                ><img src="https://lipsum.app/id/61/120x80"/></a>
                                                <a data-fancybox="gallery01"
                                                   href="https://lipsum.app/id/62/1600x1200"
                                                ><img src="https://lipsum.app/id/62/120x80"/></a>
                                                <a data-fancybox="gallery01"
                                                   href="https://lipsum.app/id/63/1600x1200"
                                                ><img src="https://lipsum.app/id/63/120x80"/></a>
                                            </div>
                                            <a href="portfolio-single.html"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End portfolio -->
                            <!-- Single portfolio -->
                            <div class="cbp-item website package development">
                                <div class="portfolio-single">
                                    <div class="portfolio-head">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p2.jpg"
                                             alt="#"/>
                                    </div>
                                    <div class="portfolio-hover">
                                        <h4>
                                            <a href="portfolio-single.html">Responsive Design</a>
                                        </h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac enim
                                        </p>
                                        <div class="button">
                                            <a href="https://www.youtube.com/watch?v=E-2ocmhF6TA"
                                               class="primary cbp-lightbox"
                                            ><i class="fa fa-play"></i></a>
                                            <a href="portfolio-single.html"
                                            ><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End portfolio -->
                            <!-- Single portfolio -->
                            <div class="cbp-item website animation">
                                <div class="portfolio-single">
                                    <div class="portfolio-head">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p3.jpg"
                                             alt="#"/>
                                    </div>
                                    <div class="portfolio-hover">
                                        <h4>
                                            <a href="portfolio-single.html">Bootstrap Based</a>
                                        </h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac enim
                                        </p>
                                        <div class="button">
                                            <a class="primary"
                                               data-fancybox="gallery"
                                               href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p3.jpg"
                                            ><i class="fa fa-search"></i></a>
                                            <a href="portfolio-single.html"
                                            ><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End portfolio -->
                            <!-- Single portfolio -->
                            <div class="cbp-item development printing">
                                <div class="portfolio-single">
                                    <div class="portfolio-head">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p4.jpg"
                                             alt="#"/>
                                    </div>
                                    <div class="portfolio-hover">
                                        <h4><a href="portfolio-single.html">Clean Design</a></h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac enim
                                        </p>
                                        <div class="button">
                                            <a href="https://www.youtube.com/watch?v=E-2ocmhF6TA"
                                               class="primary cbp-lightbox"
                                            ><i class="fa fa-play"></i></a>
                                            <a href="portfolio-single.html"
                                            ><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End portfolio -->
                            <!-- Single portfolio -->
                            <div class="cbp-item development package">
                                <div class="portfolio-single">
                                    <div class="portfolio-head">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p5.jpg"
                                             alt="#"/>
                                    </div>
                                    <div class="portfolio-hover">
                                        <h4><a href="portfolio-single.html">Animation</a></h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac enim
                                        </p>
                                        <div class="button">
                                            <a class="primary"
                                               data-fancybox="gallery"
                                               href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p5.jpg"
                                            ><i class="fa fa-search"></i></a>
                                            <a href="portfolio-single.html"
                                            ><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End portfolio -->
                            <!-- Single portfolio -->
                            <div class="cbp-item website animation printing">
                                <div class="portfolio-single">
                                    <div class="portfolio-head">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/portfolio/p6.jpg"
                                             alt="#"/>
                                    </div>
                                    <div class="portfolio-hover">
                                        <h4><a href="portfolio-single.html">Parallax</a></h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac enim
                                        </p>
                                        <div class="button">
                                            <a href="https://www.youtube.com/watch?v=E-2ocmhF6TA"
                                               class="primary cbp-lightbox"
                                            ><i class="fa fa-play"></i></a>
                                            <a href="portfolio-single.html"
                                            ><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End portfolio -->
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="button">
                            <a class="btn primary" href="portfolio-3-column.html"
                            >More Portfolio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End portfolio -->

    <!-- Call To Action -->
    <section class="call-to-action section" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 wow fadeInUp">
                    <div class="call-to-main">
                        <h2>
                            We have 35+ Years of experiences for creating creative website
                            project.
                        </h2>
                        <p>
                            Maecenas sapien erat, porta non porttitor non, dignissim et
                            enim. Aenean ac enim feugiat, facilisis arcu vehicula, consequat
                            sem. Cras et vulputate nisi, ac dignissim mi. Etiam laoreet
                        </p>
                        <a href="contact.html" class="btn">Buy This Theme</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Call To Action -->

    <!-- Blogs Area -->
    <section class="blogs-main section">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="section-title">
                        <span class="title-bg">News</span>
                        <h1>Latest Blogs</h1>
                        <p>
                            Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor.
                            Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus
                            magna, a vehicula turpis Proin
                        </p>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row blog-slider">
                        <div class="col-lg-4 col-12">
                            <!-- Single Blog -->
                            <div class="single-blog">
                                <div class="blog-head">
                                    <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/blogs/blog1.jpg"
                                         alt="#"/>
                                </div>
                                <div class="blog-bottom">
                                    <div class="blog-inner">
                                        <h4>
                                            <a href="blog-single.html"
                                            >Recognizing the need is the primary</a>
                                        </h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac tincidunt tortor sedelon bond
                                        </p>
                                        <div class="meta">
                                            <span><i class="fa fa-folder"></i><a href="#">Marketing</a></span>
                                            <span><i class="fa fa-calendar"></i>03 May, 2018</span>
                                            <span><i class="fa fa-eye"></i><a href="#">333k</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Blog -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single Blog -->
                            <div class="single-blog">
                                <div class="blog-head">
                                    <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/blogs/blog2.jpg"
                                         alt="#"/>
                                </div>
                                <div class="blog-bottom">
                                    <div class="blog-inner">
                                        <h4>
                                            <a href="blog-single.html"
                                            >How to grow your business with blank table!</a>
                                        </h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac tincidunt tortor sedelon bond
                                        </p>
                                        <div class="meta">
                                            <span><i class="fa fa-folder"></i><a href="#">Business</a></span>
                                            <span><i class="fa fa-calendar"></i>28 April, 2018</span>
                                            <span><i class="fa fa-eye"></i><a href="#">5m</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Blog -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single Blog -->
                            <div class="single-blog">
                                <div class="blog-head">
                                    <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/blogs/blog3.jpg"
                                         alt="#"/>
                                </div>
                                <div class="blog-bottom">
                                    <div class="blog-inner">
                                        <h4>
                                            <a href="blog-single.html"
                                            >10 ways to improve your startup Business</a>
                                        </h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac tincidunt tortor sedelon bond
                                        </p>
                                        <div class="meta">
                                            <span><i class="fa fa-folder"></i><a href="#">Brand</a></span>
                                            <span><i class="fa fa-calendar"></i>15 April, 2018</span>
                                            <span><i class="fa fa-eye"></i><a href="#">10m</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Blog -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single Blog -->
                            <div class="single-blog">
                                <div class="blog-head">
                                    <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/blogs/blog4.jpg"
                                         alt="#"/>
                                </div>
                                <div class="blog-bottom">
                                    <div class="blog-inner">
                                        <h4>
                                            <a href="blog-single.html"
                                            >Recognizing the need is the primary</a>
                                        </h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac tincidunt tortor sedelon bond
                                        </p>
                                        <div class="meta">
                                            <span><i class="fa fa-folder"></i><a href="#">Online</a></span>
                                            <span><i class="fa fa-calendar"></i>25 March, 2018</span>
                                            <span><i class="fa fa-eye"></i><a href="#">38k</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Blog -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single Blog -->
                            <div class="single-blog">
                                <div class="blog-head">
                                    <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/blogs/blog5.jpg"
                                         alt="#"/>
                                </div>
                                <div class="blog-bottom">
                                    <div class="blog-inner">
                                        <h4>
                                            <a href="blog-single.html"
                                            >How to grow your business with blank table!</a>
                                        </h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac tincidunt tortor sedelon bond
                                        </p>
                                        <div class="meta">
                                            <span><i class="fa fa-folder"></i><a href="#">Marketing</a></span>
                                            <span><i class="fa fa-calendar"></i>10 March, 2018</span>
                                            <span><i class="fa fa-eye"></i><a href="#">100k</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Blog -->
                        </div>
                        <div class="col-lg-4 col-12">
                            <!-- Single Blog -->
                            <div class="single-blog">
                                <div class="blog-head">
                                    <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/blogs/blog6.jpg"
                                         alt="#"/>
                                </div>
                                <div class="blog-bottom">
                                    <div class="blog-inner">
                                        <h4>
                                            <a href="blog-single.html"
                                            >10 ways to improve your startup Business</a>
                                        </h4>
                                        <p>
                                            Maecenas sapien erat, porta non porttitor non, dignissim
                                            et enim. Aenean ac tincidunt tortor sedelon bond
                                        </p>
                                        <div class="meta">
                                            <span><i class="fa fa-folder"></i><a href="#">Website</a></span>
                                            <span><i class="fa fa-calendar"></i>21 February, 2018</span>
                                            <span><i class="fa fa-eye"></i><a href="#">320k</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Blog -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blogs Area -->

    <!-- Partners -->
    <section id="partners" class="partners section">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="section-title">
                        <span class="title-bg">Clients</span>
                        <h1>Our Partners</h1>
                        <p>
                            Sed lorem enim, faucibus at erat eget, laoreet tincidunt tortor.
                            Ut sed mi nec ligula bibendum aliquam. Sed scelerisque maximus
                            magna, a vehicula turpis Proin
                        </p>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="partners-inner">
                        <div class="row no-gutters">
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-1.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-2.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-3.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-4.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-5.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-6.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-7.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-8.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-5.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-6.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-7.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                            <!-- Single Partner -->
                            <div class="col-lg-2 col-md-3 col-12">
                                <div class="single-partner">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/images/partner-3.png"
                                             alt="#"/>
                                    </a>
                                </div>
                            </div>
                            <!--/ End Single Partner -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Partners -->
<?php
// Add Footer
addLayout('footer', 'client');
