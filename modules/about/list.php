<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => getOption('about_title'),
    'breadcrumbTitle' => getOption('about_breadcrumb_title'),
    'breadcrumbBackground' => getOption('about_breadcrumb_bg')
];
addLayout('header', 'client', $dataHeader);
addLayout('breadcrumb', 'client', $dataHeader);

require_once _DIR_PATH_ROOT . '/modules/home/sections/about.php';

$aboutLeader = json_decode(getOption('about_leader'), true);
if (!empty($aboutLeader['general'])) {
    $leaderGeneralOpts = json_decode($aboutLeader['general'], true);
}
?>
    <!-- Start Team -->
    <section id="team" class="team section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <span class="title-bg"><?php echo (!empty($leaderGeneralOpts['bg_title']))
                                ? $leaderGeneralOpts['bg_title'] : null; ?></span>
                        <?php echo (!empty($leaderGeneralOpts['main_title']))
                            ? html_entity_decode($leaderGeneralOpts['main_title']) : null; ?>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($aboutLeader['leader'])):
                $leaders = json_decode($aboutLeader['leader'], true);
                if (!empty($leaders) && is_array($leaders)) :
                    ?>
                    <div class="row justify-content-center">
                        <?php foreach ($leaders as $leader) : ?>
                            <div class="col-lg-3 col-md-6 col-12">
                                <!-- Single Team -->
                                <div class="single-team">
                                    <div class="t-head">
                                        <img src="<?php echo $leader['leader_avt']; ?>" alt="#"/>
                                    </div>
                                    <div class="t-bottom">
                                        <p><?php echo $leader['leader_role']; ?></p>
                                        <h2><?php echo $leader['leader_name']; ?></h2>
                                        <ul class="t-social">
                                            <li>
                                                <a href="<?php echo $leader['leader_fb']; ?>"
                                                ><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $leader['leader_twitter']; ?>"
                                                ><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $leader['leader_linked']; ?>"
                                                ><i class="fa fa-linkedin"></i></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $leader['leader_behance']; ?>"
                                                ><i class="fa fa-behance"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Single Team -->
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php
                endif;
            endif;
            ?>
        </div>
    </section>
    <!--/ End Team -->
<?php

require_once _DIR_PATH_ROOT . '/modules/home/sections/partner.php';

// Add Footer
addLayout('footer', 'client');
