<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Edit Page'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

$body = getBody();

if (!empty($body['id'])) {
    $pageId = $body['id'];
    $sql = "SELECT * FROM `pages` WHERE id=:id";
    $data = ['id' => $pageId];
    $pageDetails = getFirstRow($sql, $data);
    if (empty($pageDetails)) {
        setFlashData('msg', 'Something went wrong, please try again.');
        setFlashData('msg_type', 'danger');
        redirect('admin/?module=pages');
    }
} else {
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
    redirect('admin/?module=pages');
}

if (isPost()) {
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

        // Update page in table 'pages'
        $dataUpdate = [
            'title' => $pageTitle,
            'slug' => $pageSlug,
            'content' => $pageContent,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id=:id";
        $dataCondition = ['id' => $pageId];
        $isDataUpdated = update('pages', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('msg', 'Page has been updated successfully.');
            setFlashData('msg_type', 'success');
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

    redirect('admin/?module=pages&action=edit&id=' . $pageId);
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
if (empty($errors)) {
    $formValues = $pageDetails;
} else {
    $formValues = getFlashData('old_values');
}
?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $pageId; ?>">
                    <div class="card-body">
                        <?php echo getMessage($msg, $msgType); ?>
                        <div class="form-group">
                            <label for="page-title">Page Title</label>
                            <input type="text" name="title" class="form-control source-title"
                                   id="page-title" placeholder="Page Title..."
                                   value="<?php echo getOldFormValue('title', $formValues); ?>">
                            <?php echo getFormErrorMsg('title', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="page-slug">URL-friendly Slug</label>
                            <input type="text" name="slug" class="form-control render-slug"
                                   id="page-slug" placeholder="URL-friendly Slug..."
                                   value="<?php echo getOldFormValue('slug', $formValues); ?>">
                            <?php echo getFormErrorMsg('slug', $errors); ?>
                        </div>

                        <div class="form-group">
                            <p class="render-link"><b>Page URL: </b> <span></span></p>
                        </div>

                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" class="form-control editor"
                            ><?php echo getOldFormValue('content', $formValues); ?></textarea>
                            <?php echo getFormErrorMsg('content', $errors); ?>
                        </div>
                    </div> <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('pages'); ?>"
                           class="btn btn-outline-secondary px-4 float-right">
                            Back
                        </a>
                        <a href="<?php echo getAbsUrlAdmin('pages', 'edit') . '&id=' . $pageId; ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
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
