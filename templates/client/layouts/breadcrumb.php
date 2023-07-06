<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

?>

<!-- Breadcrumbs -->
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    <i class="fa fa-pencil"></i>
                    <?php echo (!empty($dataHeader['breadcrumbTitle']))
                        ? $dataHeader['breadcrumbTitle'] : null; ?>
                </h2>
                <ul>
                    <li>
                        <a href="<?php echo getAbsUrlFront(); ?>">
                            <i class="fa fa-home"></i><?php echo getOption('home_title'); ?>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#">
                            <i class="fa fa-clone"></i>
                            <?php echo (!empty($dataHeader['pageTitle']))
                                ? $dataHeader['pageTitle']
                                : null; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--/ End Breadcrumbs -->

