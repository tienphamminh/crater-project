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
                       class="nav-link <?php echo (isActiveModule('dashboard') || isActiveModule(''))
                           ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <!-- /.dashboard -->

                <!-- Groups -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('groups')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('groups')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Groups
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <!-- Child-->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('groups'); ?>"
                               class="nav-link <?php echo (isActiveAction('groups', 'list')
                                   || isActiveAction('groups', ''))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Groups</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('groups', 'add'); ?>"
                               class="nav-link <?php echo (isActiveAction('groups', 'add')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Group</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.groups -->

                <!-- Users -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('users')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('users')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-user-friends"></i>
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
                            <a href="<?php echo getAbsUrlAdmin('users', 'add'); ?>"
                               class="nav-link <?php echo (isActiveAction('users', 'add')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.users -->

                <!-- Services -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('services')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('services')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-toolbox"></i>
                        <p>
                            Services
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <!-- Child-->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('services'); ?>"
                               class="nav-link <?php echo (isActiveAction('services', 'list')
                                   || isActiveAction('services', ''))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Services</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('services', 'add'); ?>"
                               class="nav-link <?php echo (isActiveAction('services', 'add')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Service</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.services -->

                <!-- Pages -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('pages')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('pages')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Pages
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <!-- Child-->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('pages'); ?>"
                               class="nav-link <?php echo (isActiveAction('pages', 'list')
                                   || isActiveAction('pages', ''))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Pages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('pages', 'add'); ?>"
                               class="nav-link <?php echo (isActiveAction('pages', 'add')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Page</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.pages -->

                <!-- Portfolios -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('portfolios')
                    || isActiveModule('portfolio_categories')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('portfolios')
                           || isActiveModule('portfolio_categories')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Portfolios
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <!-- Child-->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('portfolios'); ?>"
                               class="nav-link <?php echo (isActiveAction('portfolios', 'list')
                                   || isActiveAction('portfolios', ''))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List of Portfolios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('portfolios', 'add'); ?>"
                               class="nav-link <?php echo (isActiveAction('portfolios', 'add')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Portfolio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('portfolio_categories'); ?>"
                               class="nav-link <?php echo (isActiveModule('portfolio_categories'))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Portfolio Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.portfolios -->

                <!-- Blogs -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('blogs')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('blogs')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-blog"></i>
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

            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- /.main-sidebar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
