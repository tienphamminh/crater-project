<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

$body = getBody();

if (!empty($body['id'])) {
    $categoryId = $body['id'];
    $sql = "SELECT * FROM portfolio_categories WHERE id=:id";
    $data = ['id' => $categoryId];
    $categoryDetails = getFirstRow($sql, $data);
    if (empty($categoryDetails)) {
        redirect('admin/?module=portfolio_categories');
    }
} else {
    redirect('admin/?module=portfolio_categories');
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

    if (empty($errors)) {
        // Validation successful

        // Update category in table 'portfolio_categories'
        $dataUpdate = [
            'name' => $categoryName,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id=:id";
        $dataCondition = ['id' => $categoryId];
        $isDataUpdated = update('portfolio_categories', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('form_msg', 'Category has been updated successfully.');
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

    redirect('admin/?module=portfolio_categories&view=edit&id=' . $categoryId);
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
        <h3 class="card-title">Edit Portfolio Category</h3>
    </div>
    <!-- /.card-header -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $categoryId; ?>">
        <div class="card-body">
            <?php echo getMessage($formMsg, $formMsgType); ?>
            <div class="form-group">
                <label for="category-name">Category Name</label>
                <input type="text" name="name"
                       class="form-control <?php echo isFormError('name', $errors)
                           ? 'is-invalid' : null; ?>"
                       id="category-name" placeholder="Category Name..."
                       value="<?php echo getOldFormValue('name', $formValues); ?>">
                <?php echo getFormErrorMsg('name', $errors); ?>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <button type="submit" class="btn btn-warning px-4 float-left">Update</button>
            <a href="<?php echo getAbsUrlAdmin('portfolio_categories'); ?>"
               class="btn btn-outline-secondary px-4 float-right">
                Back
            </a>
            <a href="<?php echo getAbsUrlAdmin('portfolio_categories', '', ['view' => 'edit', 'id' => $categoryId]); ?>"
               class="btn btn-outline-success px-4 mr-2 float-right">
                Reset
            </a>
        </div>
    </form>
</div>
