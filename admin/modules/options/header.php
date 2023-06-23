<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Header Options'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];
    $formName = trim($body['form_name']);

    // Others Validate
    if ($formName == 'others') {
        $btnText = trim($body['header_quote_text']);
        if (empty($btnText)) {
            $errors['header_quote_text']['required'] = 'Required field';
        }
    }

    // Logo Validate
    if ($formName == 'logo') {
        $logo = trim($body['header_logo']);
        if (empty($logo)) {
            $errors['header_logo']['required'] = 'Required field';
        }

        $favicon = trim($body['header_favicon']);
        if (empty($favicon)) {
            $errors['header_favicon']['required'] = 'Required field';
        }
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
    redirect('admin/?module=options&action=header' . '#' . $formName);

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
            <div class="row">

                <!-- left column -->
                <div class="col-md-7">

                </div>  <!-- /.col (left) -->

                <!-- right column -->
                <div class="col-md-5">
                    <!-- Others -->
                    <div class="card card-primary mb-5" id="others">
                        <div class="card-header">
                            <h3 class="card-title">Others</h3>
                        </div> <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <input type="hidden" name="form_name" value="others">
                            <div class="card-body">
                                <?php echo ($formName == 'others') ? getMessage($msg, $msgType) : null; ?>
                                <div class="form-group">
                                    <label><?php echo getOption('header_search_placeholder', true); ?></label>
                                    <input type="text" name="header_search_placeholder" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'others')
                                               ? getOldFormValue('header_search_placeholder', $oldValues)
                                               : getOption('header_search_placeholder'); ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('header_quote_text', true); ?></label>
                                    <input type="text" name="header_quote_text" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'others')
                                               ? getOldFormValue('header_quote_text', $oldValues)
                                               : getOption('header_quote_text'); ?>">
                                    <?php echo getFormErrorMsg('header_quote_text', $errors); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('header_quote_link', true); ?></label>
                                    <input type="text" name="header_quote_link" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'others')
                                               ? getOldFormValue('header_quote_link', $oldValues)
                                               : getOption('header_quote_link'); ?>">
                                </div>
                            </div> <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                                <a href="<?php echo getAbsUrlAdmin('options', 'header'); ?>"
                                   class="btn btn-outline-success px-4 mr-2 float-right">
                                    Reset
                                </a>
                            </div> <!-- /.card-footer -->
                        </form>
                    </div> <!-- /.card -->

                    <!-- Logo & Favicon -->
                    <div class="card card-primary mb-5" id="logo">
                        <div class="card-header">
                            <h3 class="card-title">Logo & Favicon</h3>
                        </div> <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <input type="hidden" name="form_name" value="logo">
                            <div class="card-body">
                                <?php echo ($formName == 'logo') ? getMessage($msg, $msgType) : null; ?>
                                <div class="form-group ckfinder-group">
                                    <label><?php echo getOption('header_logo', true); ?></label>
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" name="header_logo"
                                                   class="form-control ckfinder-render-img"
                                                   placeholder="Choose logo (height: 45)"
                                                   value="<?php echo (!empty($oldValues) && $formName == 'logo')
                                                       ? getOldFormValue('header_logo', $oldValues)
                                                       : getOption('header_logo'); ?>">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-success btn-block ckfinder-choose-img">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- '.ckfinder-show-img' must be inside '.ckfinder-group' -->
                                    <div class="mt-2 ckfinder-show-img image-popup"
                                         style="width: 200px; cursor: pointer;">
                                    </div>
                                    <?php echo getFormErrorMsg('header_logo', $errors); ?>
                                </div>

                                <div class="form-group ckfinder-group">
                                    <label><?php echo getOption('header_favicon', true); ?></label>
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" name="header_favicon"
                                                   class="form-control ckfinder-render-img"
                                                   placeholder="Choose favicon (32x32)"
                                                   value="<?php echo (!empty($oldValues) && $formName == 'logo')
                                                       ? getOldFormValue('header_favicon', $oldValues)
                                                       : getOption('header_favicon'); ?>">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-success btn-block ckfinder-choose-img">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- '.ckfinder-show-img' must be inside '.ckfinder-group' -->
                                    <div class="mt-2 ckfinder-show-img image-popup"
                                         style="width: 100px; cursor: pointer;">
                                    </div>
                                    <?php echo getFormErrorMsg('header_favicon', $errors); ?>
                                </div>
                            </div> <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                                <a href="<?php echo getAbsUrlAdmin('options', 'header'); ?>"
                                   class="btn btn-outline-success px-4 mr-2 float-right">
                                    Reset
                                </a>
                            </div> <!-- /.card-footer -->
                        </form>
                    </div> <!-- /.card -->
                </div>  <!-- /.col (right) -->
            </div>
        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
