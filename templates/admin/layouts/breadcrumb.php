<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <?php echo (!empty($dataHeader['pageTitle'])) ? $dataHeader['pageTitle'] : 'Dashboard'; ?>
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="<?php echo getAbsUrlAdmin(); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <?php echo (!empty($dataHeader['pageTitle'])) ? $dataHeader['pageTitle'] : 'Dashboard'; ?>
                    </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
