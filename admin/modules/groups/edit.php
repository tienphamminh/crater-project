<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => 'Edit Group'
];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);
?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            ?module=groups&action=edit
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
