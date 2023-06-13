<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Edit Contact'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

$body = getBody();

if (!empty($body['id'])) {
    $contactId = $body['id'];
    $sql = "SELECT * FROM contacts WHERE id=:id";
    $data = ['id' => $contactId];
    $contactDetails = getFirstRow($sql, $data);
    if (empty($contactDetails)) {
        setFlashData('msg', 'Something went wrong, please try again.');
        setFlashData('msg_type', 'danger');
        redirect('admin/?module=contacts');
    }
} else {
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
    redirect('admin/?module=contacts');
}

if (isPost()) {
    $errors = [];

    // Department: Required
    $departmentId = trim($body['department_id']);
    if (empty($departmentId)) {
        $errors['department_id']['required'] = 'Required field';
    }

    if (empty($errors)) {
        // Validation successful
        if (trim($body['status']) == 2) {
            $status = 2;
        } elseif (trim($body['status']) == 1) {
            $status = 1;
        } else {
            $status = 0; // Default
        }

        // Update contact in table 'contacts'
        $dataUpdate = [
            'department_id' => $departmentId,
            'status' => $status,
            'note' => trim($body['note']),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id=:id";
        $dataCondition = ['id' => $contactId];
        $isDataUpdated = update('contacts', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('msg', 'Contact has been updated successfully.');
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

    redirect('admin/?module=contacts&action=edit&id=' . $contactId);
}

// Retrieve department data for <select name="department_id">
$departments = getAllRows("SELECT id, name FROM departments ORDER BY name");

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
if (empty($errors)) {
    $formValues = $contactDetails;
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
                    <input type="hidden" name="id" value="<?php echo $contactId; ?>">

                    <div class="card-body">
                        <?php echo getMessage($msg, $msgType); ?>
                        <div class="form-group">
                            <label>Customer Info:</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" name="fullname" class="form-control" readonly
                                               value="<?php echo getOldFormValue('fullname', $contactDetails); ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="text" name="email" class="form-control" readonly
                                               value="<?php echo getOldFormValue('email', $contactDetails); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control" rows="5" readonly
                            ><?php echo getOldFormValue('message', $contactDetails); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select name="department_id" class="form-control">
                                        <option value="">
                                            Choose Department
                                        </option>
                                        <?php
                                        if (!empty($departments)):
                                            foreach ($departments as $department):
                                                ?>
                                                <option value="<?php echo $department['id']; ?>"
                                                    <?php
                                                    echo (getOldFormValue('department_id', $formValues)
                                                        == $department['id'])
                                                        ? 'selected'
                                                        : null; ?>
                                                >
                                                    <?php echo $department['name']; ?>
                                                </option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <?php echo getFormErrorMsg('department_id', $errors); ?>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Processing Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="0"
                                            <?php echo (getOldFormValue('status', $formValues) == 0)
                                                ? 'selected'
                                                : null; ?>
                                        >
                                            Not yet
                                        </option>
                                        <option value="1"
                                            <?php echo (getOldFormValue('status', $formValues) == 1)
                                                ? 'selected'
                                                : null; ?>
                                        >
                                            In progress
                                        </option>
                                        <option value="2"
                                            <?php echo (getOldFormValue('status', $formValues) == 2)
                                                ? 'selected'
                                                : null; ?>
                                        >
                                            Done
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" class="form-control" rows="5"
                            ><?php echo getOldFormValue('note', $formValues); ?></textarea>
                        </div>
                    </div> <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('contacts'); ?>"
                           class="btn btn-outline-secondary px-4 float-right">
                            Back
                        </a>
                        <a href="<?php echo getAbsUrlAdmin('contacts', 'edit') . '&id=' . $contactId; ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div> <!-- /.card -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
