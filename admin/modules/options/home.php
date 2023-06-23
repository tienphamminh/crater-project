<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Homepage Options'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];
    $formName = trim($body['form_name']);

    // Validate
    if ($formName == '') {

    }

    if (empty($errors)) {
        unset($body['form_name']);
        updateOptions($body);

    } else {
        // Errors occurred
        setFlashData('msg', 'Please check the input form data.');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_values', $body);
    }

    setFlashData('form_name', $formName);
    redirect('admin/?module=options&action=home' . '#' . $formName);

}

$formName = getFlashData('form_name');
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$oldValues = getFlashData('old_values');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary mb-5" id="hero-area">
                <div class="card-header">
                    <h3 class="card-title">Hero Area (Slider)</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="hero-area">
                    <div class="card-body pt-0 pb-4">
                        <?php echo ($formName == 'hero-area') ? getMessage($msg, $msgType) : null; ?>

                        <div class="slide-gallery" id="sortable">

                        </div> <!-- /.slide-gallery -->

                        <!-- Add Slide Button -->
                        <button type="button" class="btn btn-warning px-3 mt-3 add-slide-item">
                            <i class="fas fa-plus mr-1"></i> Add Slide
                        </button>

                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'general'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div> <!-- /.card -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
