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
                    if (!empty($slide['slide_btn_text']) && !empty($slide['slide_btn_link'])) {
                        $slideViewMoreBtn = '<a href="' . $slide['slide_btn_link'] . '" class="btn">' . $slide['slide_btn_text'] . '</a>';
                    } else {
                        $slideViewMoreBtn = '';
                    }
                    if (!empty($slide['slide_play_text']) && !empty($slide['slide_play_link'])) {
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
$services = getAllRows("SELECT * FROM services ORDER BY name");
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
            if (!empty($services)) :
                $temp = $services;
                while (count($services) <= 4) {
                    $services = array_merge($services, $temp);
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
<?php
$homeFact = json_decode(getOption('home_fact'), true);
if (!empty($homeFact['general'])) {
    $factGeneralOpts = json_decode($homeFact['general'], true);
}
?>
    <section id="fun-facts" class="fun-facts section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12 wow fadeInLeft" data-wow-delay="0.5s">
                    <div class="text-content">
                        <div class="section-title">
                            <!-- Title -->
                            <h1>
                                <span><?php echo (!empty($factGeneralOpts['small_title']))
                                        ? $factGeneralOpts['small_title'] : null; ?></span>
                                <?php echo (!empty($factGeneralOpts['main_title']))
                                    ? $factGeneralOpts['main_title'] : null; ?>
                            </h1>
                            <!-- Content -->
                            <?php echo (!empty($factGeneralOpts['content']))
                                ? html_entity_decode($factGeneralOpts['content']) : null; ?>
                            <!-- Button -->
                            <?php
                            if (!empty($factGeneralOpts['btn_text']) && !empty($factGeneralOpts['btn_link'])) :
                                ?>
                                <a href="<?php echo $factGeneralOpts['btn_link']; ?>"
                                   class="btn primary"><?php echo $factGeneralOpts['btn_text']; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
                if (!empty($homeFact['fact'])):
                    $facts = json_decode($homeFact['fact'], true);
                    if (!empty($facts) && is_array($facts)) :
                        ?>
                        <div class="col-lg-7 col-12">
                            <div class="row">
                                <?php
                                $delay = 0.6;
                                foreach ($facts as $fact) :
                                    ?>
                                    <div class="col-lg-6 col-md-6 col-12 wow fadeIn"
                                         data-wow-delay="<?php echo $delay; ?>s">
                                        <!-- Single Fact -->
                                        <div class="single-fact">
                                            <div class="icon"><?php echo html_entity_decode($fact['fact_icon']); ?></div>
                                            <div class="counter">
                                                <p>
                                                    <span class="count"><?php echo $fact['fact_figure']; ?></span
                                                    ><?php echo $fact['fact_unit']; ?>
                                                </p>
                                                <h4><?php echo $fact['fact_name']; ?></h4>
                                            </div>
                                        </div>
                                        <!--/ End Single Fact -->
                                    </div>
                                    <?php
                                    $delay += 0.2;
                                endforeach;
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                endif;
                ?>
            </div>
        </div>
    </section>
    <!--/ End Fun Facts -->

<?php
$portfolioCategories = getAllRows("SELECT * FROM portfolio_categories ORDER BY name");
$portfolios = getAllRows("SELECT * FROM portfolios ORDER BY name");
$homePortfolio = json_decode(getOption('home_portfolio'), true);
if (!empty($homePortfolio['general'])) {
    $portfolioGeneralOpts = json_decode($homePortfolio['general'], true);
}
?>
    <!-- Portfolio -->
    <section id="portfolio" class="portfolio section">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="section-title">
                        <span class="title-bg"><?php echo (!empty($portfolioGeneralOpts['bg_title']))
                                ? $portfolioGeneralOpts['bg_title'] : null; ?></span>
                        <?php echo (!empty($portfolioGeneralOpts['main_title']))
                            ? html_entity_decode($portfolioGeneralOpts['main_title']) : null; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- portfolio Nav -->
                    <div class="portfolio-nav">
                        <ul class="tr-list list-inline" id="portfolio-menu">
                            <li data-filter="*" class="cbp-filter-item active">
                                All Portfolios
                                <div class="cbp-filter-counter"></div>
                            </li>
                            <?php
                            if (!empty($portfolioCategories)):
                                foreach ($portfolioCategories as $category):
                                    ?>
                                    <li data-filter=".portfolio-cate-<?php echo $category['id']; ?>"
                                        class="cbp-filter-item">
                                        <?php echo $category['name']; ?>
                                        <div class="cbp-filter-counter"></div>
                                    </li>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    <!--/ End portfolio Nav -->
                </div>
            </div>
            <div class="portfolio-inner">
                <div class="row">
                    <div class="col-12">
                        <div id="portfolio-item">
                            <?php
                            if (!empty($portfolios)):
                                foreach ($portfolios as $portfolio) :
                                    ?>
                                    <!-- Single portfolio -->
                                    <div class="cbp-item portfolio-cate-<?php echo $portfolio['portfolio_category_id']; ?>">
                                        <div class="portfolio-single">
                                            <div class="portfolio-head">
                                                <img src="<?php echo $portfolio['thumbnail']; ?>"
                                                     alt="#"/>
                                            </div>
                                            <div class="portfolio-hover">
                                                <h4><a href="#"><?php echo $portfolio['name']; ?></a></h4>
                                                <p>
                                                    <?php echo $portfolio['description']; ?>
                                                </p>
                                                <div class="button">
                                                    <a class="primary"
                                                       data-fancybox="portfolio-gallery-<?php echo $portfolio['id']; ?>"
                                                       href="<?php echo $portfolio['thumbnail']; ?>"
                                                    ><i class="fa fa-search"></i></a>
                                                    <div style="display: none">
                                                        <?php
                                                        // Retrieve portfolio images data
                                                        $sql = "SELECT * FROM portfolio_images WHERE portfolio_id=:portfolio_id";
                                                        $data = ['portfolio_id' => $portfolio['id']];
                                                        $gallery = getAllRows($sql, $data);
                                                        if (!empty($gallery)):
                                                            foreach ($gallery as $image):
                                                                ?>
                                                                <a data-fancybox="portfolio-gallery-<?php echo $portfolio['id']; ?>"
                                                                   href="<?php echo $image['image']; ?>"
                                                                ></a>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </div>
                                                    <a href="<?php echo $portfolio['video']; ?>"
                                                       class="primary video-popup mfp-fade"
                                                    ><i class="fa fa-play"></i></a>
                                                    <a href="#"><i class="fa fa-link"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End portfolio -->
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                    <!-- Button -->
                    <?php
                    if (!empty($portfolioGeneralOpts['btn_text']) && !empty($portfolioGeneralOpts['btn_link'])) :
                        ?>
                        <div class="col-12">
                            <div class="button">
                                <a class="btn primary" href="<?php echo $portfolioGeneralOpts['btn_link']; ?>"
                                ><?php echo $portfolioGeneralOpts['btn_text']; ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!--/ End portfolio -->

<?php
$homeCta = json_decode(getOption('home_cta'), true);
if (!empty($homeCta['general'])) {
    $ctaGeneralOpts = json_decode($homeCta['general'], true);
}
?>
    <!-- Call To Action -->
    <section class="call-to-action section" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 wow fadeInUp">
                    <div class="call-to-main">
                        <!-- Content -->
                        <?php echo (!empty($ctaGeneralOpts['content']))
                            ? html_entity_decode($ctaGeneralOpts['content']) : null; ?>
                        <!-- Button -->
                        <?php
                        if (!empty($ctaGeneralOpts['btn_text']) && !empty($ctaGeneralOpts['btn_link'])) :
                            ?>
                            <a href="<?php echo $ctaGeneralOpts['btn_link']; ?>"
                               class="btn"><?php echo $ctaGeneralOpts['btn_text']; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Call To Action -->

<?php
// Retrieve data
$columnNames = "blogs.id, blogs.blog_category_id, blogs.title, blogs.description, blogs.thumbnail, blogs.views_count, blogs.created_at, blog_categories.name AS category_name";
$sql = "SELECT $columnNames FROM blogs INNER JOIN blog_categories ON blogs.blog_category_id=blog_categories.id ORDER BY blogs.created_at DESC";
$blogs = getAllRows($sql);
$homeBlog = json_decode(getOption('home_blog'), true);
if (!empty($homeBlog['general'])) {
    $blogGeneralOpts = json_decode($homeBlog['general'], true);
}
?>
    <!-- Blogs Area -->
    <section class="blogs-main section">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="section-title">
                        <span class="title-bg"><?php echo (!empty($blogGeneralOpts['bg_title']))
                                ? $blogGeneralOpts['bg_title'] : null; ?></span>
                        <?php echo (!empty($blogGeneralOpts['main_title']))
                            ? html_entity_decode($blogGeneralOpts['main_title']) : null; ?>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($blogs)) :
                $temp = $blogs;
                while (count($blogs) <= 4) {
                    $blogs = array_merge($blogs, $temp);
                }
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="row blog-slider">
                            <?php foreach ($blogs as $blog): ?>
                                <div class="col-lg-4 col-12">
                                    <!-- Single Blog -->
                                    <div class="single-blog">
                                        <div class="blog-head">
                                            <img src="<?php echo $blog['thumbnail']; ?>"
                                                 alt="#"/>
                                        </div>
                                        <div class="blog-bottom">
                                            <div class="blog-inner">
                                                <h4>
                                                    <a href="#"><?php echo $blog['title']; ?></a>
                                                </h4>
                                                <p>
                                                    <?php echo $blog['description']; ?>
                                                </p>
                                                <div class="meta">
                                                    <span><i class="fa fa-folder"></i><a
                                                                href="#"><?php echo $blog['category_name']; ?></a></span>
                                                    <span><i class="fa fa-calendar"></i><?php
                                                        echo getFormattedDate($blog['created_at'], 'd-m-Y');
                                                        ?></span>
                                                    <span><i class="fa fa-eye"></i><?php echo $blog['views_count']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Blog -->
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!--/ End Blogs Area -->

<?php
$homePartner = json_decode(getOption('home_partner'), true);
if (!empty($homePartner['general'])) {
    $partnerGeneralOpts = json_decode($homePartner['general'], true);
}
?>
    <!-- Partners -->
    <section id="partners" class="partners section">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="section-title">
                        <span class="title-bg"><?php echo (!empty($partnerGeneralOpts['bg_title']))
                                ? $partnerGeneralOpts['bg_title'] : null; ?></span>
                        <?php echo (!empty($partnerGeneralOpts['main_title']))
                            ? html_entity_decode($partnerGeneralOpts['main_title']) : null; ?>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($homePartner['partner'])):
                $partners = json_decode($homePartner['partner'], true);
                if (!empty($partners) && is_array($partners)) :
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="partners-inner">
                                <div class="row no-gutters justify-content-center">
                                    <?php
                                    foreach ($partners as $partner):
                                        if (!empty($partner['partner_logo']) && !empty($partner['partner_link'])):
                                            ?>
                                            <!-- Single Partner -->
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="single-partner">
                                                    <a href="<?php echo $partner['partner_link']; ?>"
                                                       target="_blank">
                                                        <img src="<?php echo $partner['partner_logo']; ?>"
                                                             alt="#"/>
                                                    </a>
                                                </div>
                                            </div>
                                            <!--/ End Single Partner -->
                                        <?php
                                        endif;
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
    <!--/ End Partners -->
<?php
// Add Footer
addLayout('footer', 'client');
