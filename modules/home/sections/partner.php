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