<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="<?php echo getAbsUrlAdmin(); ?>" class="brand-link">
        <img class="brand-image"
             src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/img/crater-icon.png" alt="crater-icon">
        <span class="brand-text font-weight-normal" style="color: #26bdef">Admin Page</span>
    </a>
    <!-- /.brand-logo -->

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item ">
                    <a href="<?php echo getAbsUrlAdmin(); ?>"
                       class="nav-link <?php echo (isActiveModule('dashboard') || empty(getBody()['module']))
                           ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <!-- /.dashboard -->

                <!-- Blogs -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('blogs')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('blogs')) ? 'active' : null; ?>">
                        <i class="nav-icon fab fa-blogger"></i>
                        <p>
                            Blogs
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <!-- Child-->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('blogs'); ?>"
                               class="nav-link <?php echo (isActiveAction('blogs', 'list')
                                   || isActiveAction('blogs', ''))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Blogs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('blogs', 'edit'); ?>"
                               class="nav-link <?php echo (isActiveAction('blogs', 'edit')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edit Blog</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.blogs -->

                <!-- Users -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('users')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('users')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <!-- Child-->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('users'); ?>"
                               class="nav-link <?php echo (isActiveAction('users', 'list')
                                   || isActiveAction('users', ''))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('users', 'edit'); ?>"
                               class="nav-link <?php echo (isActiveAction('users', 'edit')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edit User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.users -->
            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- /.main-sidebar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
