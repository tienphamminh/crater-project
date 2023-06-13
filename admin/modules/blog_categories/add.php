<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    $body = getBody();
    $errors = [];

    // Category name: Required, >=4 characters
    $categoryName = trim($body['name']);
    if (empty($categoryName)) {
        $errors['name']['required'] = 'Required field';
    } elseif (strlen($categoryName) < 4) {
        $errors['name']['min'] = 'Category name must be at least 4 characters';
    }

    // Category slug: Required, valid format
    $blogSlug = trim($body['slug']);
    if (empty($blogSlug)) {
        $errors['slug']['required'] = 'Required field';
    } elseif (!isSlug($blogSlug)) {
        $errors['slug']['isSlug'] = 'Invalid slug format';
    }

    if (empty($errors)) {
        // Validation successful

        // Insert into table 'blog_categories'
        $dataInsert = [
            'name' => $categoryName,
            'slug' => $blogSlug,
            'user_id' => getSession('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $isDataInserted = insert('blog_categories', $dataInsert);

        if ($isDataInserted) {
            setFlashData('form_msg', 'Blog category has been added successfully.');
            setFlashData('form_msg_type', 'success');
        } else {
            setFlashData('form_msg', 'Something went wrong, please try again.');
            setFlashData('form_msg_type', 'danger');
        }
    } else {
        // Errors occurred
        setFlashData('form_msg', 'Please check the input form data.');
        setFlashData('form_msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_values', $body);
    }

    redirect('admin/?module=blog_categories');
}

$formMsg = getFlashData('form_msg');
$formMsgType = getFlashData('form_msg_type');
$errors = getFlashData('errors');
$oldValues = getFlashData('old_values');
?>

<div class="card card-success" style="min-height: 235px">
    <div class="card-header">
        <h3 class="card-title">Add Blog Category</h3>
    </div> <!-- /.card-header -->

    <form action="" method="post">
        <div class="card-body">
            <?php echo getMessage($formMsg, $formMsgType); ?>
            <div class="form-group">
                <label for="category-name">Category Name</label>
                <input type="text" name="name" class="form-control source-title"
                       id="category-name" placeholder="Category Name..."
                       value="<?php echo getOldFormValue('name', $oldValues); ?>">
                <?php echo getFormErrorMsg('name', $errors); ?>
            </div>
            <div class="form-group">
                <label for="category-slug">Category Slug</label>
                <input type="text" name="slug" class="form-control render-slug"
                       id="category-slug" placeholder="Category Slug..."
                       value="<?php echo getOldFormValue('slug', $oldValues); ?>">
                <?php echo getFormErrorMsg('slug', $errors); ?>
            </div>

            <div class="form-group">
                <p class="render-link"><b>URL: </b> <span></span></p>
            </div>
        </div> <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-success px-4">Add</button>
        </div> <!-- /.card-footer -->
    </form>
</div> <!-- /.card -->
