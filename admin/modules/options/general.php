<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'General Options'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];

    // Hotline: Required, valid format
    $hotline = trim($body['general_hotline']);
    if (empty($hotline)) {
        $errors['general_hotline']['required'] = 'Required field';
    } elseif (!isPhone($hotline)) {
        $errors['general_hotline']['isPhone'] = 'Invalid phone number format';
    }

    // Email: Required, valid format, unique
    $email = trim($body['general_email']);
    if (empty($email)) {
        $errors['general_email']['required'] = 'Required field';
    } elseif (!isEmail($email)) {
        $errors['general_email']['isEmail'] = 'Invalid email address';
    }

    // Opening: Required
    $opening = trim($body['general_opening']);
    if (empty($opening)) {
        $errors['general_opening']['required'] = 'Required field';
    }

    if (empty($errors)) {
        updateOptions($body);

    } else {
        // Errors occurred
        setFlashData('msg', 'Please check the input form data.');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_values', $body);
    }

    redirect('admin/?module=options&action=general');

}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$oldValues = getFlashData('old_values');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- left column -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Contact Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <div class="card-body">
                                <?php echo getMessage($msg, $msgType); ?>
                                <div class="form-group">
                                    <label><?php echo getOption('general_hotline', true); ?></label>
                                    <input type="text" name="general_hotline" class="form-control"
                                           value="<?php echo (!empty($oldValues))
                                               ? getOldFormValue('general_hotline', $oldValues)
                                               : getOption('general_hotline'); ?>">
                                    <?php echo getFormErrorMsg('general_hotline', $errors); ?>
                                </div>

                                <div class="form-group">
                                    <label><?php echo getOption('general_email', true); ?></label>
                                    <input type="email" name="general_email" class="form-control"
                                           value="<?php echo (!empty($oldValues))
                                               ? getOldFormValue('general_email', $oldValues)
                                               : getOption('general_email'); ?>">
                                    <?php echo getFormErrorMsg('general_email', $errors); ?>
                                </div>

                                <div class="form-group">
                                    <label><?php echo getOption('general_opening', true); ?></label>
                                    <input type="text" name="general_opening" class="form-control"
                                           value="<?php echo (!empty($oldValues))
                                               ? getOldFormValue('general_opening', $oldValues)
                                               : getOption('general_opening'); ?>">
                                    <?php echo getFormErrorMsg('general_opening', $errors); ?>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                                <a href="<?php echo getAbsUrlAdmin('options', 'general'); ?>"
                                   class="btn btn-outline-success px-4 mr-2 float-right">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div> <!-- /.card -->
                </div>  <!-- /.col (left) -->

            </div>
        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
