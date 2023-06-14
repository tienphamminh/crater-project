<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (!isLoggedIn()) {
    redirect('admin/?module=auth&action=login');
}

// Automatic logout after 50 minutes of inactivity on the current device
autoLogoutAfterInactive(3000);

// Save the last time the user accessed the admin page.
$userId = getSession('user_id');
saveLastActivity($userId);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin | <?php echo (!empty($dataHeader['pageTitle'])) ? $dataHeader['pageTitle'] : 'Dashboard'; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo _WEB_HOST_CORE_TEMPLATE; ?>/assets/images/crater-favicon.png"/>
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
          href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet"
          href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
          href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet"
          href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- CKEditor -->
    <script type="text/javascript" src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/ckeditor/ckeditor.js"></script>
    <!-- CKFinder -->
    <script type="text/javascript" src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/ckfinder/ckfinder.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user mr-1"></i>
                    Hi, <?php echo getSession('fullname'); ?>
                </a>
                <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                    <a href="<?php echo getAbsUrlAdmin('users', 'profile'); ?>" class="dropdown-item">
                        <i class="fas fa-user-edit mr-2"></i>
                        Edit Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo getAbsUrlAdmin('users', 'change-password'); ?>" class="dropdown-item">
                        <i class="fas fa-key mr-2"></i>
                        Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo getAbsUrlAdmin('auth', 'logout'); ?>" class="dropdown-item">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Sign out
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
