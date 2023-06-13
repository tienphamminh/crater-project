<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Edit Profile'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

$userId = getSession('user_id');

if (!empty(getUserDetails($userId))) {
    $userDetails = getUserDetails($userId);
} else {
    $userDetails = [];
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

$body = getBody();
if (isPost()) {
    $errors = [];

    // Full name: Required, >=5 characters
    $fullname = trim($body['fullname']);
    if (empty($fullname)) {
        $errors['fullname']['required'] = 'Required field';
    } elseif (strlen($fullname) < 5) {
        $errors['fullname']['min'] = 'Full name must be at least 5 characters';
    }

    // Phone number: Required, valid format
    $phone = trim($body['phone']);
    if (empty($phone)) {
        $errors['phone']['required'] = 'Required field';
    } elseif (!isPhone($phone)) {
        $errors['phone']['isPhone'] = 'Invalid phone number format';
    }

    if (empty($errors)) {
        // Validation successful

        // Update user in table 'users'
        $dataUpdate = [
            'fullname' => $fullname,
            'phone' => $phone,
            'introduction' => trim($body['introduction']),
            'contact_facebook' => trim($body['contact_facebook']),
            'contact_twitter' => trim($body['contact_twitter']),
            'contact_linkedin' => trim($body['contact_linkedin']),
            'contact_pinterest' => trim($body['contact_pinterest']),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $condition = "id=:id";
        $dataCondition = ['id' => $userId];
        $isDataUpdated = update('users', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            // Update the greeting in the navbar
            setSession('fullname', $fullname);
            setFlashData('msg', 'Your profile has been updated successfully.');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Something went wrong, please try again.');
            setFlashData('msg_type', 'danger');
        }
    } else {
        // Errors occurred
        setFlashData('msg', 'Please check the input form data.');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_values', $body);
    }

    redirect('admin/?module=users&action=profile');
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');

if (empty($errors)) {
    $formValues = $userDetails;
} else {
    $formValues = getFlashData('old_values');
}

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <!-- form start -->
                <form action="" method="post">
                    <div class="card-body">
                        <?php echo getMessage($msg, $msgType); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" name="fullname" class="form-control" id="fullname"
                                           value="<?php echo getOldFormValue('fullname', $formValues); ?>">
                                    <?php echo getFormErrorMsg('fullname', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                           value="<?php echo getOldFormValue('phone', $formValues); ?>">
                                    <?php echo getFormErrorMsg('phone', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" name="contact_facebook" class="form-control" id="facebook"
                                           value="<?php echo getOldFormValue('contact_facebook', $formValues); ?>">
                                    <?php echo getFormErrorMsg('contact_facebook', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" name="contact_twitter" class="form-control" id="twitter"
                                           value="<?php echo getOldFormValue('contact_twitter', $formValues); ?>">
                                    <?php echo getFormErrorMsg('contact_twitter', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn</label>
                                    <input type="text" name="contact_linkedin" class="form-control" id="linkedin"
                                           value="<?php echo getOldFormValue('contact_linkedin', $formValues); ?>">
                                    <?php echo getFormErrorMsg('contact_linkedin', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pinterest">Pinterest</label>
                                    <input type="text" name="contact_pinterest" class="form-control" id="pinterest"
                                           value="<?php echo getOldFormValue('contact_pinterest', $formValues); ?>">
                                    <?php echo getFormErrorMsg('contact_pinterest', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="introduction">Introduction</label>
                                    <textarea name="introduction" class="form-control"
                                              id="introduction"><?php
                                        echo getOldFormValue('introduction', $formValues);
                                        ?></textarea>
                                    <?php echo getFormErrorMsg('introduction', $errors); ?>
                                </div>
                            </div>
                        </div> <!-- /.row -->
                    </div> <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary px-3 clearfix">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('users', 'profile'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div> <!-- /.card -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
