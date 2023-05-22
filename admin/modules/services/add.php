<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Add Service'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];

    // Service name: Required
    $serviceName = trim($body['name']);
    if (empty($serviceName)) {
        $errors['name']['required'] = 'Required field';
    }

    // Service slug: Required, valid format
    $serviceSlug = trim($body['slug']);
    if (empty($serviceSlug)) {
        $errors['slug']['required'] = 'Required field';
    } elseif (!isSlug($serviceSlug)) {
        $errors['slug']['isSlug'] = 'Invalid slug format';
    }

    // Service icon: Required
    $serviceIcon = trim($body['icon']);
    if (empty($serviceIcon)) {
        $errors['icon']['required'] = 'Required field';
    }

    // Service content: Required
    $serviceContent = trim($body['content']);
    if (empty($serviceContent)) {
        $errors['content']['required'] = 'Required field';
    }

    if (empty($errors)) {
        // Validation successful

        // Insert into table 'services'
        $dataInsert = [
            'name' => $serviceName,
            'slug' => $serviceSlug,
            'icon' => $serviceIcon,
            'description' => trim($body['description']),
            'content' => $serviceContent,
            'user_id' => getSession('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $isDataInserted = insert('services', $dataInsert);

        if ($isDataInserted) {
            setFlashData('msg', 'Service has been added successfully.');
            setFlashData('msg_type', 'success');
            redirect('admin/?module=services');
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

    redirect('admin/?module=services&action=add');
}


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
                        <div class="form-group">
                            <label for="service-name">Service Name</label>
                            <input type="text" name="name" class="form-control source-title"
                                   id="service-name" placeholder="Service Name..."
                                   value="<?php echo getOldFormValue('name', $oldValues); ?>">
                            <?php echo getFormErrorMsg('name', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="service-slug">URL-friendly Slug</label>
                            <input type="text" name="slug" class="form-control render-slug"
                                   id="service-slug" placeholder="URL-friendly Slug..."
                                   value="<?php echo getOldFormValue('slug', $oldValues); ?>">
                            <?php echo getFormErrorMsg('slug', $errors); ?>
                        </div>

                        <div class="form-group">
                            <p class="render-link"><b>Service URL:</b> <span></span></p>
                        </div>


                        <div class="form-group ckfinder-group">
                            <label for="">Icon or Image</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" name="icon" class="form-control ckfinder-render-img"
                                           placeholder="Insert icon tag or choose image..."
                                           value="<?php echo getOldFormValue('icon', $oldValues); ?>">
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-success btn-block ckfinder-choose-img">
                                        <i class="fas fa-upload"></i>
                                        <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="ckfinder-show-image image-popup" style="cursor: pointer">
                                </span>
                            </div>
                            <?php echo getFormErrorMsg('icon', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="service-description">Description</label>
                            <textarea name="description" class="form-control"
                                      id="service-description" placeholder="Description..."
                            ><?php echo getOldFormValue('description', $oldValues); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" class="form-control editor"
                            ><?php echo getOldFormValue('content', $oldValues); ?></textarea>
                            <?php echo getFormErrorMsg('content', $errors); ?>
                        </div>
                    </div> <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Add</button>
                        <a href="<?php echo getAbsUrlAdmin('services'); ?>"
                           class="btn btn-outline-secondary px-4 float-right">
                            Back
                        </a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
