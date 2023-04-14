<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => 'Forgot Password'
];
addLayout('header-login', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();

    if (!empty($body['email'])) {
        $email = $body['email'];

        // Check if email address exists in table 'users'
        $sql = "SELECT id, fullname FROM users WHERE email=:email AND status=:status";
        $data = [
            'email' => $email,
            'status' => 1
        ];
        $result = getFirstRow($sql, $data);

        if (!empty($result)) {
            // Create reset token
            $resetToken = sha1(uniqid() . time());

            // Update field: 'reset_token' in table 'users'
            $userId = $result['id'];
            $dataUpdate = ['reset_token' => $resetToken];
            $condition = "id=:id";
            $dataCondition = ['id' => $userId];
            $isDataUpdated = update('users', $dataUpdate, $condition, $dataCondition);

            if ($isDataUpdated) {
                // Create reset link
                $resetLink = _WEB_HOST_ROOT_ADMIN . '?module=auth&action=reset&token=' . $resetToken;
                // Send mail
                $subject = 'Reset your password';
                $content = 'Hi ' . $result['fullname'] . '!<br>';
                $content .= 'We received a request to reset the password for your account. <br>';
                $content .= 'To reset your password, click the link below: <br>' . $resetLink . '<br>';
                $content .= 'Regards.';
                $sendStatus = sendMail($email, $subject, $content);

                if ($sendStatus) {
                    $resendForm =
                        '<form method="post" action="">
                            <input type="hidden" name="email" value="' . $email . '">
                            <button type="submit" class="btn btn-success btn-block" style="margin-top: 10px">Resend message</button>
                         </form>';
                    $message = 'A password reset message was sent to your email address.' . '<br>';
                    $message .= 'You still have not received the message?';
                    $message .= $resendForm;
                    setFlashData('msg', $message);
                    setFlashData('msg_type', 'success');
                } else {
                    setFlashData('msg', 'Something went wrong, please try again.');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Something went wrong, please try again.');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Incorrect (or not activated) email address.');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Please enter your email.');
        setFlashData('msg_type', 'danger');
    }

    redirect('admin/?module=auth&action=forgot');
}


$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

    <?php echo getMessage($msg, $msgType); ?>

    <form action="" method="post">
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Request new password</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <hr>
    <p class="mt-3 mb-1">
        <a href="?module=auth&action=login">Login</a>
    </p>

<?php
// Add Footer
addLayout('footer-login', 'admin');
