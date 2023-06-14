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
             src="<?php echo _WEB_HOST_CORE_TEMPLATE; ?>/assets/images/crater-icon.png" alt="crater-icon">
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
                <li class="nav-item has-treeview <?php echo (isActiveModule('blogs')
                    || isActiveModule('blog_categories')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('blogs')
                           || isActiveModule('blog_categories')) ? 'active' : null; ?>">
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
                            <a href="<?php echo getAbsUrlAdmin('blogs', 'add'); ?>"
                               class="nav-link <?php echo (isActiveAction('blogs', 'add')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Blog</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('blog_categories'); ?>"
                               class="nav-link <?php echo (isActiveModule('blog_categories'))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Blog Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.blogs -->

                <!-- Contacts -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('contacts')
                    || isActiveModule('departments')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link toggle-badge <?php echo (isActiveModule('contacts')
                           || isActiveModule('departments')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-headset"></i>
                        <p>
                            Contacts
                            <i class="fas fa-angle-left right"></i>
                            <?php
                            $unreadContacts = getUnreadContacts();
                            if (!empty($unreadContacts)):
                                ?>
                                <span class="badge badge-danger right" <?php echo (isActiveModule('contacts')
                                    || isActiveModule('departments')) ? 'style="display: none;"' : null; ?>
                                ><?php echo $unreadContacts; ?></span>
                            <?php endif; ?>
                        </p>
                    </a>
                    <!-- Child-->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('contacts'); ?>"
                               class="nav-link <?php echo (isActiveAction('contacts', 'list')
                                   || isActiveAction('contacts', ''))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    List of Contacts
                                    <?php if (!empty($unreadContacts)): ?>
                                        <span class="badge badge-danger right"><?php echo $unreadContacts; ?></span>
                                    <?php endif; ?>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('departments'); ?>"
                               class="nav-link <?php echo (isActiveModule('departments'))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Departments</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /.contacts -->

                <!-- Options -->
                <li class="nav-item has-treeview <?php echo (isActiveModule('options')) ? 'menu-open' : null; ?>">
                    <!-- Parent-->
                    <a href="#"
                       class="nav-link <?php echo (isActiveModule('options')) ? 'active' : null; ?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Options
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <!-- Child-->
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('options', 'general'); ?>"
                               class="nav-link <?php echo (isActiveAction('options', 'general'))
                                   ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>General</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('options', 'header'); ?>"
                               class="nav-link <?php echo (isActiveAction('options', 'header')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Header</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('options', 'footer'); ?>"
                               class="nav-link <?php echo (isActiveAction('options', 'footer')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Footer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo getAbsUrlAdmin('options', 'home'); ?>"
                               class="nav-link <?php echo (isActiveAction('options', 'home')) ? 'active' : null; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Homepage</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- /.options -->

            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- /.main-sidebar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
