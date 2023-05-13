<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Change Password'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);


if (isPost()) {
    $body = getBody();
    $errors = [];

    $userId = getSession('user_id');
    $userDetails = getUserDetails($userId, 'email, password');
    if (empty($userDetails)) {
        setFlashData('msg', 'Something went wrong, please try again.');
        setFlashData('msg_type', 'danger');
        redirect('admin/?module=users&action=change-password');
    }

    // Current Password: Required, match hashed password
    $currentPassword = $body['current_password'];
    if (empty($currentPassword)) {
        $errors['current_password']['required'] = 'Required field';
    } else {
        $hashedPassword = $userDetails['password'];
        $isPasswordMatch = password_verify($currentPassword, $hashedPassword);
        if (!$isPasswordMatch) {
            $errors['current_password']['match'] = 'Current password does not match the hash';
        }
    }

    // New Password: Required, >=8 characters
    $newPassword = $body['new_password'];
    if (empty($newPassword)) {
        $errors['new_password']['required'] = 'Required field';
    } elseif (strlen($newPassword) < 8) {
        $errors['new_password']['min'] = 'Password must be at least 8 characters';
    }

    // Confirm New Password: Required, match new password
    $confirmNewPassword = $body['confirm_new_password'];
    if (empty($confirmNewPassword)) {
        $errors['confirm_new_password']['required'] = 'Required field';
    } elseif ($confirmNewPassword != $newPassword) {
        $errors['confirm_new_password']['match'] = 'Confirm password does not match new password';
    }

    if (empty($errors)) {
        // Validation successful

        // Update 'password' in table 'users'
        $dataUpdate = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id=:id";
        $dataCondition = ['id' => $userId];
        $isDataUpdated = update('users', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('msg', 'Your password has been changed successfully.');
            setFlashData('msg_type', 'success');

            // Send mail
            $subject = 'Your password has been changed';
            $content = 'You have successfully changed your account password at ' . date('Y-m-d H:i:s') . '.';
            sendMail($userDetails['email'], $subject, $content);

            // 'Log out of all devices' option
            if (!empty($body['logout_all']) && $body['logout_all'] == 1) {
                logoutOfAllDevices($userId);
            }
        } else {
            setFlashData('msg', 'Something went wrong, please try again.');
            setFlashData('msg_type', 'danger');
        }
    } else {
        // Errors occurred
        setFlashData('msg', 'Please check the input form data.');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
    }

    redirect('admin/?module=users&action=change-password');
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');

?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <div class="card-body">
                                <?php echo getMessage($msg, $msgType); ?>
                                <div class="form-group">
                                    <label for="current-password">Current Password</label>
                                    <input type="password" name="current_password" class="form-control"
                                           id="current-password"
                                           placeholder="Current Password">
                                    <?php echo getFormErrorMsg('current_password', $errors); ?>
                                </div>

                                <div class="form-group">
                                    <label for="new-password">New Password</label>
                                    <input type="password" name="new_password" class="form-control" id="new-password"
                                           placeholder="New Password">
                                    <?php echo getFormErrorMsg('new_password', $errors); ?>
                                </div>

                                <div class="form-group">
                                    <label for="cf-password">Confirm New Password</label>
                                    <input type="password" name="confirm_new_password" class="form-control"
                                           id="cf-password" placeholder="Confirm New Password">
                                    <?php echo getFormErrorMsg('confirm_new_password', $errors); ?>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" name="logout_all" class="form-check-input"
                                           id="logout-all" value="1">
                                    <label class="form-check-label" for="logout-all">Sign out of all devices?</label>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary px-3">Change</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');