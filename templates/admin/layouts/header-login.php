<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Auto remove 'login_token' after 30 minutes since the last activity of user
autoRemoveLoginTokens(1800);

if (isLoggedIn()) {
    redirect('admin/');
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Dynamic Title -->
    <title>Admin | <?php echo (!empty($dataHeader['pageTitle'])) ? $dataHeader['pageTitle'] : 'Auth'; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo _WEB_HOST_CORE_TEMPLATE; ?>/assets/images/crater-favicon.png"/>
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet"
          href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">

<div class="login-box">

    <div class="login-logo">
        <img src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/img/crater-logo.png" alt="logo"/>
    </div>
    <!-- /.login-logo -->

    <div class="card" style="padding: 0.25em; border-radius: 0.25em;">
        <div class="card-body login-card-body">
