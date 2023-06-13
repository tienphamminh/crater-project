<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Edit User'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

$body = getBody();

if (!empty($body['id'])) {
    $userId = $body['id'];
    $sql = "SELECT * FROM users WHERE id=:id";
    $data = ['id' => $userId];
    $userDetails = getFirstRow($sql, $data);
    if (empty($userDetails)) {
        setFlashData('msg', 'Something went wrong, please try again.');
        setFlashData('msg_type', 'danger');
        redirect('admin/?module=users');
    }
} else {
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
    redirect('admin/?module=users');
}

if (isPost()) {
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
        $sql = "SELECT id FROM users WHERE email=:email AND id<>:id";
        $data = ['email' => $email, 'id' => $userId];
        if (getNumberOfRows($sql, $data) > 0) {
            $errors['email']['unique'] = 'An account with this email address already exists';
        }
    }

    // Password: >=8 characters (If edit password)
    $password = $body['password'];
    if (!empty($password)) {
        if (strlen($password) < 8) {
            $errors['password']['min'] = 'Password must be at least 8 characters';
        }
        // Confirm password: match
        $confirmPassword = $body['confirm_password'];
        if ($confirmPassword != $password) {
            $errors['confirm_password']['match'] = 'Confirm password does not match new password';
        }
    }


    if (empty($errors)) {
        // Validation successful

        if (trim($body['status']) == 1) {
            $status = 1;
        } else {
            $status = 0;
        }

        // Update group in table 'groups'
        $dataUpdate = [
            'fullname' => $fullname,
            'group_id' => $groupId,
            'status' => $status,
            'phone' => $phone,
            'email' => $email,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if (!empty($password)) {
            $dataUpdate['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $condition = "id=:id";
        $dataCondition = ['id' => $userId];
        $isDataUpdated = update('users', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('msg', 'User has been updated successfully.');
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

    redirect('admin/?module=users&action=edit&id=' . $userId);
}

// Retrieve group data for  <select name="group_id">
$groups = getAllRows("SELECT id, name FROM `groups`");

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
if (empty($errors)) {
    $formValues = $userDetails;
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
                    <input type="hidden" name="id" value="<?php echo $userId; ?>">

                    <div class="card-body">
                        <?php echo getMessage($msg, $msgType); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" name="fullname" class="form-control" id="fullname"
                                           placeholder="Fullname"
                                           value="<?php echo getOldFormValue('fullname', $formValues); ?>">
                                    <?php echo getFormErrorMsg('fullname', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-8">
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
                                                            echo (getOldFormValue('group_id', $formValues)
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Status:</label>
                                            <select name="status" class="form-control">
                                                <option value="0"
                                                    <?php echo (getOldFormValue('status', $formValues) == 0)
                                                        ? 'selected'
                                                        : null; ?>
                                                >
                                                    Not Active
                                                </option>
                                                <option value="1"
                                                    <?php echo (getOldFormValue('status', $formValues) == 1)
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
                                           placeholder="Phone Number"
                                           value="<?php echo getOldFormValue('phone', $formValues); ?>">
                                    <?php echo getFormErrorMsg('phone', $errors); ?>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           placeholder="Email Address"
                                           value="<?php echo getOldFormValue('email', $formValues); ?>">
                                    <?php echo getFormErrorMsg('email', $errors); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="Password (Leave blank if no change)...">
                                    <?php echo getFormErrorMsg('password', $errors); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cf-password">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" id="cf-password"
                                           placeholder="Confirm Password (Leave blank if no change)...">
                                    <?php echo getFormErrorMsg('confirm_password', $errors); ?>
                                </div>
                            </div>
                        </div> <!-- /.row -->
                    </div> <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('users'); ?>"
                           class="btn btn-outline-secondary px-4 float-right">
                            Back
                        </a>
                        <a href="<?php echo getAbsUrlAdmin('users', 'edit') . '&id=' . $userId; ?>"
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
