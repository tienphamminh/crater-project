<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Add User'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];

    // Full name: Required, >=5 characters
    $fullname = trim($body['fullname']);
    if (empty($fullname)) {
        $errors['fullname']['required'] = 'Required field';
    } elseif (strlen($fullname) < 5) {
        $errors['fullname']['min'] = 'Full name must be at least 5 characters';
    }

    // Group: Required
    $groupId = trim($body['group_id']);
    if (empty($groupId)) {
        $errors['group_id']['required'] = 'Required field';
    }


    // Phone number: Required, valid format
    $phone = trim($body['phone']);
    if (empty($phone)) {
        $errors['phone']['required'] = 'Required field';
    } elseif (!isPhone($phone)) {
        $errors['phone']['isPhone'] = 'Invalid phone number format';
    }

    // Email: Required, valid format, unique
    $email = trim($body['email']);
    if (empty($email)) {
        $errors['email']['required'] = 'Required field';
    } elseif (!isEmail($email)) {
        $errors['email']['isEmail'] = 'Invalid email address';
    } else {
        $sql = "SELECT id FROM users WHERE email=:email";
        $data = ['email' => $email];
        if (getNumberOfRows($sql, $data) > 0) {
            $errors['email']['unique'] = 'An account with this email address already exists';
        }
    }

    // Password: Required, >=8 characters
    $password = $body['password'];
    if (empty($password)) {
        $errors['password']['required'] = 'Required field';
    } elseif (strlen($password) < 8) {
        $errors['password']['min'] = 'Password must be at least 8 characters';
    }

    // Confirm password: Required, match
    $confirmPassword = $body['confirm_password'];
    if (empty($confirmPassword)) {
        $errors['confirm_password']['required'] = 'Required field';
    } elseif ($confirmPassword != $password) {
        $errors['confirm_password']['match'] = 'Confirm password does not match new password';
    }


    if (empty($errors)) {
        // Validation successful

        if (trim($body['status']) == 1) {
            $status = 1;
        } else {
            $status = 0;
        }

        // Insert into table 'users'
        $dataInsert = [
            'fullname' => $fullname,
            'group_id' => $groupId,
            'status' => $status,
            'phone' => $phone,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $isDataInserted = insert('users', $dataInsert);

        if ($isDataInserted) {
            setFlashData('msg', 'User has been added successfully.');
            setFlashData('msg_type', 'success');
            redirect('admin/?module=users');
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
    redirect('admin/?module=users&action=add');
}

// Retrieve group data for  <select name="group_id">
$groups = getAllRows("SELECT id, name FROM `groups` ORDER BY name");

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$oldValues = getFlashData('old_values');

?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <!-- form start -->
                <form action="" method="post">
                    <div class="card-body">
                        <?php echo getMessage($msg, $msgType); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" name="fullname" class="form-control" id="fullname"
                                           placeholder="Fullname..."
                                           value="<?php echo getOldFormValue('fullname', $oldValues); ?>">
                                    <?php echo getFormErrorMsg('fullname', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-6 col-sm-8">
                                        <div class="form-group">
                                            <label>Group:</label>
                                            <select name="group_id" class="form-control">
                                                <option value="">
                                                    Choose Group
                                                </option>
                                                <?php
                                                if (!empty($groups)):
                                                    foreach ($groups as $group):
                                                        ?>
                                                        <option value="<?php echo $group['id']; ?>"
                                                            <?php
                                                            echo (getOldFormValue('group_id', $oldValues)
                                                                == $group['id'])
                                                                ? 'selected'
                                                                : null; ?>
                                                        >
                                                            <?php echo $group['name']; ?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            <?php echo getFormErrorMsg('group_id', $errors); ?>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="form-group">
                                            <label>Status:</label>
                                            <select name="status" class="form-control">
                                                <option value="0">
                                                    Not Active (Default)
                                                </option>
                                                <option value="1"
                                                    <?php echo (getOldFormValue('status', $oldValues) == 1)
                                                        ? 'selected'
                                                        : null; ?>
                                                >
                                                    Active
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                           placeholder="Phone Number..."
                                           value="<?php echo getOldFormValue('phone', $oldValues); ?>">
                                    <?php echo getFormErrorMsg('phone', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           placeholder="Email Address..."
                                           value="<?php echo getOldFormValue('email', $oldValues); ?>">
                                    <?php echo getFormErrorMsg('email', $errors); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="Password...">
                                    <?php echo getFormErrorMsg('password', $errors); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cf-password">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" id="cf-password"
                                           placeholder="Confirm Password...">
                                    <?php echo getFormErrorMsg('confirm_password', $errors); ?>
                                </div>
                            </div>
                        </div> <!-- /.row -->
                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Add</button>
                        <a href="<?php echo getAbsUrlAdmin('users'); ?>"
                           class="btn btn-outline-secondary px-4 float-right">
                            Back
                        </a>
                    </div>
                </form> <!-- form end -->
            </div> <!-- /.card -->
        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');