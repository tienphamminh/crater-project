<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

?>

<!-- Footer -->
<footer id="footer" class="footer wow fadeIn">
    <!-- Top Arrow -->
    <div class="top-arrow">
        <a href="#header" class="btn"><i class="fa fa-angle-up"></i></a>
    </div>
    <!--/ End Top Arrow -->
    <!-- Footer Top -->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <?php
                    $footerWidget1 = json_decode(getOption('footer_widget1'), true);
                    if (!empty($footerWidget1['general'])) {
                        $widget1GeneralOpts = json_decode($footerWidget1['general'], true);
                    }
                    ?>
                    <!-- About Widget -->
                    <div class="single-widget about">
                        <h2><?php echo (!empty($widget1GeneralOpts['title']))
                                ? $widget1GeneralOpts['title'] : null; ?></h2>
                        <?php echo (!empty($widget1GeneralOpts['description']))
                            ? html_entity_decode($widget1GeneralOpts['description']) : null; ?>
                        <ul class="list">
                            <li>
                                <i class="fa fa-map-marker"></i><?php echo getOption('general_address'); ?>
                            </li>
                            <li>
                                <i class="fa fa-headphones"></i><?php echo getOption('general_hotline'); ?>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <a href="mailto:<?php echo getOption('general_email'); ?>">
                                    <?php echo getOption('general_email'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--/ End About Widget -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <?php
                    $footerWidget2 = json_decode(getOption('footer_widget2'), true);
                    if (!empty($footerWidget2['general'])) {
                        $widget2GeneralOpts = json_decode($footerWidget2['general'], true);
                    }
                    ?>
                    <!-- Links Widget -->
                    <div class="single-widget links">
                        <h2><?php echo (!empty($widget2GeneralOpts['title']))
                                ? $widget2GeneralOpts['title'] : null; ?></h2>
                        <ul class="list">
                            <?php echo (!empty($widget2GeneralOpts['description']))
                                ? html_entity_decode($widget2GeneralOpts['description']) : null; ?>
                        </ul>
                    </div>
                    <!--/ End Links Widget -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <?php
                    $footerWidget3 = json_decode(getOption('footer_widget3'), true);
                    if (!empty($footerWidget3['general'])) {
                        $widget3GeneralOpts = json_decode($footerWidget3['general'], true);
                    }
                    ?>
                    <!-- Facebook Widget -->
                    <div class="single-widget facebook">
                        <h2><?php echo (!empty($widget3GeneralOpts['title']))
                                ? $widget3GeneralOpts['title'] : null; ?></h2>
                        <div class="fb-page" data-href="<?php echo (!empty($widget3GeneralOpts['fb_page']))
                            ? $widget3GeneralOpts['fb_page'] : null; ?>"
                             data-tabs="timeline"
                             data-width="" data-height="240"
                             data-small-header="true"
                             data-hide-cover="true"
                             data-adapt-container-width="true"
                             data-show-facepile="true">
                        </div>
                    </div>
                    <!--/ End Facebook Widget -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <?php
                    $footerWidget4 = json_decode(getOption('footer_widget4'), true);
                    if (!empty($footerWidget4['general'])) {
                        $widget4GeneralOpts = json_decode($footerWidget4['general'], true);
                    }
                    ?>
                    <!-- Newsletter Widget -->
                    <div class="single-widget newsletter">
                        <h2><?php echo (!empty($widget4GeneralOpts['title']))
                                ? $widget4GeneralOpts['title'] : null; ?></h2>
                        <?php echo (!empty($widget4GeneralOpts['description']))
                            ? html_entity_decode($widget4GeneralOpts['description']) : null; ?>
                        <form action="" method="">
                            <input type="text" name=""
                                   placeholder="<?php echo (!empty($widget4GeneralOpts['input1_placeholder']))
                                       ? $widget4GeneralOpts['input1_placeholder'] : null; ?>"/>
                            <input type="email" name=""
                                   placeholder="<?php echo (!empty($widget4GeneralOpts['input2_placeholder']))
                                       ? $widget4GeneralOpts['input2_placeholder'] : null; ?>"/>
                            <button type="submit" class="button primary">
                                <?php echo (!empty($widget4GeneralOpts['btn_text']))
                                    ? $widget4GeneralOpts['btn_text'] : 'Submit'; ?>
                            </button>
                        </form>
                    </div>
                    <!--/ End Newsletter Widget -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Footer Top -->
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bottom-top">
                        <!-- Social -->
                        <ul class="social">
                            <li>
                                <a href="<?php echo getOption('general_twitter'); ?>" target="_blank">
                                    <i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="<?php echo getOption('general_facebook'); ?>" target="_blank">
                                    <i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="<?php echo getOption('general_linkedin'); ?>" target="_blank">
                                    <i class="fa fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="<?php echo getOption('general_behance'); ?>" target="_blank">
                                    <i class="fa fa-behance"></i></a>
                            </li>
                            <li>
                                <a href="<?php echo getOption('general_youtube'); ?>" target="_blank">
                                    <i class="fa fa-youtube"></i></a>
                            </li>
                        </ul>
                        <!--/ End Social -->
                        <!-- Copyright -->
                        <div class="copyright">
                            <p>
                                &copy; 2020 All Right Reserved. Design & Development By
                                <a target="_blank" href="http://themelamp.com"
                                >ThemeLamp.com</a
                                >, Theme Provided By
                                <a target="_blank" href="https://codeglim.com"
                                >CodeGlim.com</a
                                >
                            </p>
                        </div>
                        <!--/ End Copyright -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Footer Bottom -->
</footer>
<!--/ End footer -->

<!-- Jquery -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/jquery-migrate.min.js"></script>
<!-- Popper JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/bootstrap.min.js"></script>
<!-- Modernizer JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/modernizr.min.js"></script>
<!-- Nice select JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/niceselect.js"></script>
<!-- Tilt Jquery JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/tilt.jquery.min.js"></script>
<!-- Fancybox  -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/jquery.fancybox.min.js"></script>
<!-- Jquery Nav -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/jquery.nav.js"></script>
<!-- Owl Carousel JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/owl.carousel.min.js"></script>
<!-- Slick Slider JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/slickslider.min.js"></script>
<!-- Cube Portfolio JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/cubeportfolio.min.js"></script>
<!-- Slicknav JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/jquery.slicknav.min.js"></script>
<!-- Jquery Steller JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/jquery.stellar.min.js"></script>
<!-- Magnific Popup JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/magnific-popup.min.js"></script>
<!-- Wow JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/wow.min.js"></script>
<!-- CounterUp JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/jquery.counterup.min.js"></script>
<!-- Waypoint JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/waypoints.min.js"></script>
<!-- Jquery Easing JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/easing.min.js"></script>
<!-- Main JS -->
<script src="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/js/custom.js"></script>
</body>
</html>
