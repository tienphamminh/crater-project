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
