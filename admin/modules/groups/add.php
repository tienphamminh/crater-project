<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Add Group'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
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

        // Insert into table 'groups'
        $dataInsert = [
            'name' => $groupName,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $isDataInserted = insert('groups', $dataInsert);

        if ($isDataInserted) {
            setFlashData('msg', 'Group has been added successfully.');
            setFlashData('msg_type', 'success');
            redirect('admin/?module=groups');
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

    redirect('admin/?module=groups&action=add');
}


$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$oldValues = getFlashData('old_values');
?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="" method="post">
                            <div class="card-body">
                                <?php echo getMessage($msg, $msgType); ?>
                                <div class="form-group">
                                    <label for="group-name">Group Name</label>
                                    <input type="text" name="name" class="form-control"
                                           id="group-name" placeholder="Group Name..."
                                           value="<?php echo getOldFormValue('name', $oldValues); ?>">
                                    <?php echo getFormErrorMsg('name', $errors); ?>
                                </div>
                            </div> <!-- /.card-body -->

                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary px-4 float-left">Add</button>
                                <a href="<?php echo getAbsUrlAdmin('groups'); ?>"
                                   class="btn btn-outline-secondary px-4 float-right">
                                    Back
                                </a>
                            </div> <!-- /.card-footer -->
                        </form>
                    </div> <!-- /.card -->
                </div> <!-- /.col (left) -->
            </div>
        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
