<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Add Page'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];

    // Page title: Required
    $pageTitle = trim($body['title']);
    if (empty($pageTitle)) {
        $errors['title']['required'] = 'Required field';
    }

    // Page slug: Required, valid format
    $pageSlug = trim($body['slug']);
    if (empty($pageSlug)) {
        $errors['slug']['required'] = 'Required field';
    } elseif (!isSlug($pageSlug)) {
        $errors['slug']['isSlug'] = 'Invalid slug format';
    }

    // Page content: Required
    $pageContent = trim($body['content']);
    if (empty($pageContent)) {
        $errors['content']['required'] = 'Required field';
    }

    if (empty($errors)) {
        // Validation successful

        // Insert into table 'pages'
        $dataInsert = [
            'title' => $pageTitle,
            'slug' => $pageSlug,
            'content' => $pageContent,
            'user_id' => getSession('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $isDataInserted = insert('pages', $dataInsert);

        if ($isDataInserted) {
            setFlashData('msg', 'Page has been added successfully.');
            setFlashData('msg_type', 'success');
            redirect('admin/?module=pages');
        } else {
            setFlashData('msg', 'Something went wrong, please try again.');
            setFlashData('msg_type', 'danger');
        }
    } else {
        // Errors occurred
        setFlashData('msg', 'Please check the input form data.');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_values', $body);
    }

    redirect('admin/?module=pages&action=add');
}


$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$oldValues = getFlashData('old_values');
?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <!-- form start -->
                <form action="" method="post">
                    <div class="card-body">
                        <?php echo getMessage($msg, $msgType); ?>
                        <div class="form-group">
                            <label for="page-title">Page Title</label>
                            <input type="text" name="title" class="form-control source-title"
                                   id="page-title" placeholder="Page Title..."
                                   value="<?php echo getOldFormValue('title', $oldValues); ?>">
                            <?php echo getFormErrorMsg('title', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="page-slug">Page Slug</label>
                            <input type="text" name="slug" class="form-control render-slug"
                                   id="page-slug" placeholder="Page Slug..."
                                   value="<?php echo getOldFormValue('slug', $oldValues); ?>">
                            <?php echo getFormErrorMsg('slug', $errors); ?>
                        </div>

                        <div class="form-group">
                            <p class="render-link"><b>Page URL: </b> <span></span></p>
                        </div>

                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" class="form-control editor"
                            ><?php echo getOldFormValue('content', $oldValues); ?></textarea>
                            <?php echo getFormErrorMsg('content', $errors); ?>
                        </div>
                    </div> <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Add</button>
                        <a href="<?php echo getAbsUrlAdmin('pages'); ?>"
                           class="btn btn-outline-secondary px-4 float-right">
                            Back
                        </a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
