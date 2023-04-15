<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => 'Blogs'
];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);
?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            ?module=blogs&action=list
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
