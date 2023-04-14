<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => 'Log in'
];
addLayout('header-login', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    if (!empty(trim($body['email'])) && !empty($body['password'])) {
        $email = $body['email'];
        $password = $body['password'];

        // Check if email address exists in table 'users'
        $sql = "SELECT id, fullname, password FROM users WHERE email=:email AND status=:status";
        $data = [
            'email' => $email,
            'status' => 1
        ];
        $result = getFirstRow($sql, $data);

        if (!empty($result)) {
            $userId = $result['id'];
            $fullname = $result['fullname'];

            // Check if password matches a hashed password in table 'users'
            $hashedPassword = $result['password'];
            $isPasswordMatch = password_verify($password, $hashedPassword);
            if ($isPasswordMatch) {
                // Create login token
                $loginToken = sha1(uniqid() . time());
                // Insert into table 'login_tokens'
                $dataInsert = [
                    'user_id' => $userId,
                    'token' => $loginToken,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $isDataInserted = insert('login_tokens', $dataInsert);

                if ($isDataInserted) {
                    saveLastActivity($userId);
                    setSession('login_token', $loginToken);
                    setSession('id', $userId);
                    setSession('fullname', $fullname);
                    redirect('admin/');
                } else {
                    setFlashData('msg', 'Something went wrong, please try again.');
                    setFlashData('msg_type', 'danger');
                    redirect('admin/?module=auth&action=login');
                }
            }
        }
        setFlashData('msg', 'Incorrect email address or password (or not activated).');
    } else {
        setFlashData('msg', 'Please enter your email and password.');
    }

    setFlashData('msg_type', 'danger');
    redirect('admin/?module=auth&action=login');
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

    <p class="login-box-msg">Sign in to start your session</p>

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

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <hr>
    <p class="mb-1">
        <a href="?module=auth&action=forgot">I forgot my password</a>
    </p>

<?php
// Add Footer
addLayout('footer-login', 'admin');
