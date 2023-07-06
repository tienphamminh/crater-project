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