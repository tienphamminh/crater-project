<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

$body = getBody();

if (!empty($body['id'])) {
    $categoryId = $body['id'];
    $sql = "SELECT * FROM blog_categories WHERE id=:id";
    $data = ['id' => $categoryId];
    $categoryDetails = getFirstRow($sql, $data);
    if (empty($categoryDetails)) {
        redirect('admin/?module=blog_categories');
    }
} else {
    redirect('admin/?module=blog_categories');
}

if (isPost()) {
    $errors = [];

    // Category name: Required, >=4 characters
    $categoryName = trim($body['name']);
    if (empty($categoryName)) {
        $errors['name']['required'] = 'Required field';
    } elseif (strlen($categoryName) < 4) {
        $errors['name']['min'] = 'Category name must be at least 4 characters';
    }

    // Category slug: Required, valid format
    $categorySlug = trim($body['slug']);
    if (empty($categorySlug)) {
        $errors['slug']['required'] = 'Required field';
    } elseif (!isSlug($categorySlug)) {
        $errors['slug']['isSlug'] = 'Invalid slug format';
    }

    if (empty($errors)) {
        // Validation successful

        // Update category in table 'blog_categories'
        $dataUpdate = [
            'name' => $categoryName,
            'slug' => $categorySlug,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id=:id";
        $dataCondition = ['id' => $categoryId];
        $isDataUpdated = update('blog_categories', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('form_msg', 'Blog category has been updated successfully.');
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

    redirect('admin/?module=blog_categories&view=edit&id=' . $categoryId);
}

$formMsg = getFlashData('form_msg');
$formMsgType = getFlashData('form_msg_type');
$errors = getFlashData('errors');
if (empty($errors)) {
    $formValues = $categoryDetails;
} else {
    $formValues = getFlashData('old_values');
}
?>

<div class="card card-warning" style="min-height: 235px">
    <div class="card-header">
        <h3 class="card-title">Edit Blog Category</h3>
    </div>
    <!-- /.card-header -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $categoryId; ?>">
        <div class="card-body">
            <?php echo getMessage($formMsg, $formMsgType); ?>
            <div class="form-group">
                <label for="category-name">Category Name</label>
                <input type="text" name="name" class="form-control source-title"
                       id="category-name" placeholder="Category Name..."
                       value="<?php echo getOldFormValue('name', $formValues); ?>">
                <?php echo getFormErrorMsg('name', $errors); ?>
            </div>

            <div class="form-group">
                <label for="category-slug">Category Slug</label>
                <input type="text" name="slug" class="form-control render-slug"
                       id="category-slug" placeholder="Category Slug..."
                       value="<?php echo getOldFormValue('slug', $formValues); ?>">
                <?php echo getFormErrorMsg('slug', $errors); ?>
            </div>

            <div class="form-group">
                <p class="render-link"><b>URL: </b> <span></span></p>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <button type="submit" class="btn btn-warning px-4 float-left">Update</button>
            <a href="<?php echo getAbsUrlAdmin('blog_categories'); ?>"
               class="btn btn-outline-secondary px-4 float-right">
                Back
            </a>
            <a href="<?php echo getAbsUrlAdmin('blog_categories', '', ['view' => 'edit', 'id' => $categoryId]); ?>"
               class="btn btn-outline-success px-4 mr-2 float-right">
                Reset
            </a>
        </div>
    </form>
</div>
