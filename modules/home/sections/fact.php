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