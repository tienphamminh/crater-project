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
    $formName = trim($body['form_name']);

    // Theme Validate
    if ($formName == 'theme') {
        // Theme Color: Required, valid format
        $themeColor = trim($body['general_theme_color']);
        if (empty($themeColor)) {
            $errors['general_theme_color']['required'] = 'Required field';
        } elseif (!isHexColor($themeColor)) {
            $errors['general_theme_color']['isHexColor'] = 'Invalid HEX color code format';
        }
    }

    // Contact Info Validate
    if ($formName == 'contact-info') {
        // Site Name: Required
        $siteName = trim($body['general_sitename']);
        if (empty($siteName)) {
            $errors['general_sitename']['required'] = 'Required field';
        }
        // Site Description: Required
        $siteDesc = trim($body['general_sitedesc']);
        if (empty($siteDesc)) {
            $errors['general_sitedesc']['required'] = 'Required field';
        }
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
    }

    // Logo Validate
    if ($formName == 'logo') {
        $logo = trim($body['general_logo']);
        if (empty($logo)) {
            $errors['general_logo']['required'] = 'Required field';
        }

        $favicon = trim($body['general_favicon']);
        if (empty($favicon)) {
            $errors['general_favicon']['required'] = 'Required field';
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
    redirect('admin/?module=options&action=general' . '#' . $formName);

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
                <div class="col-md-6">
                    <!-- Contact Information -->
                    <div class="card card-primary mb-5" id="contact-info">
                        <div class="card-header">
                            <h3 class="card-title">Contact Information</h3>
                        </div> <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <input type="hidden" name="form_name" value="contact-info">
                            <div class="card-body">
                                <?php echo ($formName == 'contact-info') ? getMessage($msg, $msgType) : null; ?>
                                <div class="form-group">
                                    <label><?php echo getOption('general_sitename', true); ?></label>
                                    <input type="text" name="general_sitename" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'contact-info')
                                               ? getOldFormValue('general_sitename', $oldValues)
                                               : getOption('general_sitename'); ?>">
                                    <?php echo getFormErrorMsg('general_sitename', $errors); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_sitedesc', true); ?></label>
                                    <input type="text" name="general_sitedesc" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'contact-info')
                                               ? getOldFormValue('general_sitedesc', $oldValues)
                                               : getOption('general_sitedesc'); ?>">
                                    <?php echo getFormErrorMsg('general_sitedesc', $errors); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_hotline', true); ?></label>
                                    <input type="text" name="general_hotline" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'contact-info')
                                               ? getOldFormValue('general_hotline', $oldValues)
                                               : getOption('general_hotline'); ?>">
                                    <?php echo getFormErrorMsg('general_hotline', $errors); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_email', true); ?></label>
                                    <input type="email" name="general_email" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'contact-info')
                                               ? getOldFormValue('general_email', $oldValues)
                                               : getOption('general_email'); ?>">
                                    <?php echo getFormErrorMsg('general_email', $errors); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_opening', true); ?></label>
                                    <input type="text" name="general_opening" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'contact-info')
                                               ? getOldFormValue('general_opening', $oldValues)
                                               : getOption('general_opening'); ?>">
                                    <?php echo getFormErrorMsg('general_opening', $errors); ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_address', true); ?></label>
                                    <input type="text" name="general_address" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'contact-info')
                                               ? getOldFormValue('general_address', $oldValues)
                                               : getOption('general_address'); ?>">
                                    <?php echo getFormErrorMsg('general_address', $errors); ?>
                                </div>
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
                    <!-- End Contact Information -->

                    <!-- Social Link -->
                    <div class="card card-primary mb-5" id="social">
                        <div class="card-header">
                            <h3 class="card-title">Social Link</h3>
                        </div> <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <input type="hidden" name="form_name" value="social">
                            <div class="card-body">
                                <?php echo ($formName == 'social') ? getMessage($msg, $msgType) : null; ?>
                                <div class="form-group">
                                    <label><?php echo getOption('general_twitter', true); ?></label>
                                    <input type="text" name="general_twitter" class="form-control"
                                           value="<?php echo getOption('general_twitter'); ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_facebook', true); ?></label>
                                    <input type="text" name="general_facebook" class="form-control"
                                           value="<?php echo getOption('general_facebook'); ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_linkedin', true); ?></label>
                                    <input type="text" name="general_linkedin" class="form-control"
                                           value="<?php echo getOption('general_linkedin'); ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_behance', true); ?></label>
                                    <input type="text" name="general_behance" class="form-control"
                                           value="<?php echo getOption('general_behance'); ?>">
                                </div>
                                <div class="form-group">
                                    <label><?php echo getOption('general_youtube', true); ?></label>
                                    <input type="text" name="general_youtube" class="form-control"
                                           value="<?php echo getOption('general_youtube'); ?>">
                                </div>
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
                    <!-- End Social Link -->
                </div>  <!-- /.col (left) -->

                <!-- right column -->
                <div class="col-md-6">
                    <!-- Theme -->
                    <div class="card card-primary mb-5" id="theme">
                        <div class="card-header">
                            <h3 class="card-title">Theme</h3>
                        </div> <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <input type="hidden" name="form_name" value="theme">
                            <div class="card-body">
                                <?php echo ($formName == 'theme') ? getMessage($msg, $msgType) : null; ?>
                                <div class="form-group">
                                    <label><?php echo getOption('general_theme_color', true); ?></label>
                                    <input type="text" name="general_theme_color" class="form-control"
                                           value="<?php echo (!empty($oldValues) && $formName == 'theme')
                                               ? getOldFormValue('general_theme_color', $oldValues)
                                               : getOption('general_theme_color'); ?>">
                                    <?php echo getFormErrorMsg('general_theme_color', $errors); ?>
                                </div>
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
                    <!-- End Theme -->

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
                                    <label><?php echo getOption('general_logo', true); ?></label>
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" name="general_logo"
                                                   class="form-control ckfinder-render-img"
                                                   placeholder="Choose logo (height: 45)"
                                                   value="<?php echo (!empty($oldValues) && $formName == 'logo')
                                                       ? getOldFormValue('general_logo', $oldValues)
                                                       : getOption('general_logo'); ?>">
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
                                    <?php echo getFormErrorMsg('general_logo', $errors); ?>
                                </div>

                                <div class="form-group ckfinder-group">
                                    <label><?php echo getOption('general_favicon', true); ?></label>
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" name="general_favicon"
                                                   class="form-control ckfinder-render-img"
                                                   placeholder="Choose favicon (32x32)"
                                                   value="<?php echo (!empty($oldValues) && $formName == 'logo')
                                                       ? getOldFormValue('general_favicon', $oldValues)
                                                       : getOption('general_favicon'); ?>">
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
                                    <?php echo getFormErrorMsg('general_favicon', $errors); ?>
                                </div>
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
                    <!-- End Logo & Favicon -->
                </div>  <!-- /.col (right) -->
            </div>
        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
