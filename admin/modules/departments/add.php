<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    $body = getBody();
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

        // Insert into table 'departments'
        $dataInsert = [
            'name' => $departmentName,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $isDataInserted = insert('departments', $dataInsert);

        if ($isDataInserted) {
            setFlashData('form_msg', 'Department has been added successfully.');
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

    redirect('admin/?module=departments');
}

$formMsg = getFlashData('form_msg');
$formMsgType = getFlashData('form_msg_type');
$errors = getFlashData('errors');
$oldValues = getFlashData('old_values');
?>

<div class="card card-success" style="min-height: 235px">
    <div class="card-header">
        <h3 class="card-title">Add Department</h3>
    </div> <!-- /.card-header -->

    <form action="" method="post">
        <div class="card-body">
            <?php echo getMessage($formMsg, $formMsgType); ?>
            <div class="form-group">
                <label for="department-name">Department Name</label>
                <input type="text" name="name" class="form-control"
                       id="department-name" placeholder="Department Name..."
                       value="<?php echo getOldFormValue('name', $oldValues); ?>">
                <?php echo getFormErrorMsg('name', $errors); ?>
            </div>
        </div> <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-success px-4">Add</button>
        </div> <!-- /.card-footer -->
    </form>
</div> <!-- /.card -->
