<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => 'Add Group'
];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];

    // Full name: Required, >=5 characters
    $groupName = trim($body['group_name']);
    if (empty($groupName)) {
        $errors['group_name']['required'] = 'Required field';
    } elseif (strlen($groupName) < 4) {
        $errors['group_name']['min'] = 'Group name must be at least 4 characters';
    }


    if (empty($errors)) {
        // Validation successful

        // Insert into table 'user'
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
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <div class="card-body">
                                <?php echo getMessage($msg, $msgType); ?>
                                <div class="form-group">
                                    <label for="group-name">Group Name</label>
                                    <input type="text" name="group_name" class="form-control"
                                           id="group-name" placeholder="Group Name"
                                           value="<?php echo getOldFormValue('group_name', $oldValues); ?>">
                                    <?php echo getFormError('group_name', $errors); ?>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary px-4 float-left">Add</button>
                                <a href="<?php echo getAbsUrlAdmin('groups'); ?>"
                                   class="btn btn-outline-secondary px-4 float-right">
                                    Back
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
