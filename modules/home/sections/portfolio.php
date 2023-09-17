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
