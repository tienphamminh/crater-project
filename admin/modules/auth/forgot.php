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

?>

    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

    <?php //echo getMessage($msg, $msgType); ?>

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
