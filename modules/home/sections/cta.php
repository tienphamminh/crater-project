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