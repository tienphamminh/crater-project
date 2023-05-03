<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Edit Group'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

$body = getBody();

if (!empty($body['id'])) {
    $groupId = $body['id'];
    $sql = "SELECT * FROM `groups` WHERE id=:id";
    $data = ['id' => $groupId];
    $groupDetails = getFirstRow($sql, $data);
    if (empty($groupDetails)) {
        setFlashData('msg', 'Something went wrong, please try again.');
        setFlashData('msg_type', 'danger');
        redirect('admin/?module=groups');
    }
} else {
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
    redirect('admin/?module=groups');
}

if (isPost()) {
    $errors = [];

    // Group name: Required, >=4 characters
    $groupName = trim($body['name']);
    if (empty($groupName)) {
        $errors['name']['required'] = 'Required field';
    } elseif (strlen($groupName) < 4) {
        $errors['name']['min'] = 'Group name must be at least 4 characters';
    }

    if (empty($errors)) {
        // Validation successful

        // Update group in table 'groups'
        $dataUpdate = [
            'name' => $groupName,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id=:id";
        $dataCondition = ['id' => $groupId];
        $isDataUpdated = update('groups', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('msg', 'Group has been updated successfully.');
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

    redirect('admin/?module=groups&action=edit&id=' . $groupId);
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
if (empty($errors)) {
    $formValues = $groupDetails;
} else {
    $formValues = getFlashData('old_values');
}

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $groupId; ?>">
                            <div class="card-body">
                                <?php echo getMessage($msg, $msgType); ?>
                                <div class="form-group">
                                    <label for="group-name">Group Name</label>
                                    <input type="text" name="name" class="form-control"
                                           id="group-name" placeholder="Group Name"
                                           value="<?php echo getOldFormValue('name', $formValues); ?>">
                                    <?php echo getFormError('name', $errors); ?>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                                <a href="<?php echo getAbsUrlAdmin('groups'); ?>"
                                   class="btn btn-outline-secondary px-4 float-right">
                                    Back
                                </a>
                                <a href="<?php echo getAbsUrlAdmin('groups', 'edit') . '&id=' . $groupId; ?>"
                                   class="btn btn-outline-success px-4 mr-2 float-right">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
