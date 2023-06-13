<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

$body = getBody();

if (!empty($body['id'])) {
    $departmentId = $body['id'];
    $sql = "SELECT * FROM departments WHERE id=:id";
    $data = ['id' => $departmentId];
    $departmentDetails = getFirstRow($sql, $data);
    if (empty($departmentDetails)) {
        redirect('admin/?module=departments');
    }
} else {
    redirect('admin/?module=departments');
}

if (isPost()) {
    $errors = [];

    // Department name: Required, >=4 characters
    $departmentName = trim($body['name']);
    if (empty($departmentName)) {
        $errors['name']['required'] = 'Required field';
    } elseif (strlen($departmentName) < 4) {
        $errors['name']['min'] = 'Department name must be at least 4 characters';
    }

    if (empty($errors)) {
        // Validation successful

        // Update department in table 'departments'
        $dataUpdate = [
            'name' => $departmentName,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id=:id";
        $dataCondition = ['id' => $departmentId];
        $isDataUpdated = update('departments', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('form_msg', 'Department has been updated successfully.');
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

    redirect('admin/?module=departments&view=edit&id=' . $departmentId);
}

$formMsg = getFlashData('form_msg');
$formMsgType = getFlashData('form_msg_type');
$errors = getFlashData('errors');
if (empty($errors)) {
    $formValues = $departmentDetails;
} else {
    $formValues = getFlashData('old_values');
}
?>

<div class="card card-warning" style="min-height: 235px">
    <div class="card-header">
        <h3 class="card-title">Edit Department</h3>
    </div> <!-- /.card-header -->

    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $departmentId; ?>">

        <div class="card-body">
            <?php echo getMessage($formMsg, $formMsgType); ?>
            <div class="form-group">
                <label for="department-name">Department Name</label>
                <input type="text" name="name" class="form-control"
                       id="department-name" placeholder="Department Name..."
                       value="<?php echo getOldFormValue('name', $formValues); ?>">
                <?php echo getFormErrorMsg('name', $errors); ?>
            </div>
        </div> <!-- /.card-body -->

        <div class="card-footer clearfix">
            <button type="submit" class="btn btn-warning px-4 float-left">Update</button>
            <a href="<?php echo getAbsUrlAdmin('departments'); ?>"
               class="btn btn-outline-secondary px-4 float-right">
                Back
            </a>
            <a href="<?php echo getAbsUrlAdmin('departments', '', ['view' => 'edit', 'id' => $departmentId]); ?>"
               class="btn btn-outline-success px-4 mr-2 float-right">
                Reset
            </a>
        </div> <!-- /.card-footer -->
    </form>
</div> <!-- /.card -->
