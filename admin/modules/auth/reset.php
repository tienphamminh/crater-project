<?php

if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Recover Password'];
addLayout('header-login', 'admin', $dataHeader);

if (!empty(getBody()['token'])) {
    // Check if reset token in URL exists in table 'users'
    $resetToken = getBody()['token'];
    $sql = "SELECT id, email FROM users WHERE reset_token=:reset_token";
    $data = ['reset_token' => $resetToken];
    $result = getFirstRow($sql, $data);

    if (!empty($result)) {
        $userId = $result['id'];
        $email = $result['email'];

        if (isPost()) {
            $body = getBody();
            $errors = [];

            // New password: Required, >=8 characters
            $newPassword = $body['new_password'];
            if (empty($newPassword)) {
                $errors['new_password']['required'] = 'Required field';
            } elseif (strlen($newPassword) < 8) {
                $errors['new_password']['min'] = 'Password must be at least 8 characters';
            }


            // Confirm new password: Required, match
            $confirmPassword = $body['confirm_password'];
            if (empty($confirmPassword)) {
                $errors['confirm_password']['required'] = 'Required field';
            } elseif ($newPassword != $confirmPassword) {
                $errors['confirm_password']['match'] = 'Those passwords do not match';
            }

            if (empty($errors)) {
                // Update fields: 'password', 'reset_token' and 'updated_at' in table 'users'
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $dataUpdate = [
                    'password' => $newHashedPassword,
                    'reset_token' => null,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $condition = "id=:id";
                $dataCondition = ['id' => $userId];
                $isDataUpdated = update('users', $dataUpdate, $condition, $dataCondition);

                if ($isDataUpdated) {
                    setFlashData('msg', 'Your password has been changed! Sign in with the new password.');
                    setFlashData('msg_type', 'success');

                    // Send mail
                    $subject = 'Your password has been changed';
                    $content = 'You have successfully changed your account password at ' . date('Y-m-d H:i:s') . '.';
                    sendMail($email, $subject, $content);

                    redirect('admin/?module=auth&action=login');
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

            redirect('admin/?module=auth&action=reset&token=' . $resetToken);
        }

        $msg = getFlashData('msg');
        $msgType = getFlashData('msg_type');
        $errors = getFlashData('errors');

        ?>
        <p class="login-box-msg">Recover your password.</p>

        <?php echo getMessage($msg, $msgType); ?>

        <form action="" method="post">

            <input type="hidden" name="token" value="<?php echo $resetToken; ?>">

            <div class="input-group mb-3">
                <input type="password" name="new_password" class="form-control" placeholder="New Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <div class="input-group">
                    <?php echo getFormErrorMsg('new_password', $errors); ?>
                </div>
            </div>

            <div class="input-group mb-3">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <div class="input-group">
                    <?php echo getFormErrorMsg('confirm_password', $errors); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Change password</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <hr>
        <p class="mt-3 mb-1">
            <a href="<?php echo getAbsUrlAdmin('auth', 'login'); ?>">Login</a>
        </p>
        <?php
    } else {
        $message = getMessage('Invalid or expired active link.', 'danger');
    }
} else {
    $message = getMessage('Invalid or expired active link.', 'danger');
}

echo !empty($message) ? $message : null;
?>


<?php
// Add Footer
addLayout('footer-login', 'admin');
