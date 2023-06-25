<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Homepage Options'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];
    $formName = trim($body['form_name']);

    echo '<pre>';
    print_r($body);
    echo '</pre>';

//    // Validate
//    if ($formName == '') {
//
//    }
//
//    if (empty($errors)) {
//        unset($body['form_name']);
//        updateOptions($body);
//
//    } else {
//        // Errors occurred
//        setFlashData('msg', 'Please check the input form data.');
//        setFlashData('msg_type', 'danger');
//        setFlashData('errors', $errors);
//        setFlashData('old_values', $body);
//    }
//
//    setFlashData('form_name', $formName);
//    redirect('admin/?module=options&action=home' . '#' . $formName);

}

$formName = getFlashData('form_name');
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$oldValues = getFlashData('old_values');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary mb-5" id="hero-area">
                <div class="card-header">
                    <h3 class="card-title">Hero Area (Slider)</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="hero-area">
                    <div class="card-body pt-0 pb-4">
                        <?php echo ($formName == 'hero-area') ? getMessage($msg, $msgType) : null; ?>

                        <div class="slide-gallery">
                            <!-- Slide Item -->
                            <div class="slide-item movable">
                                <!-- Child Card -->
                                <div class="card card-primary bg-light mt-5 shadow border">
                                    <div style="position: absolute; top: 0px; right: 0px;">
                                        <div class="btn-group">
                                            <!-- Move UP -->
                                            <span class="btn btn-warning px-2 py-0 move-up" style="font-size: 24px;">
                                                <i class="fas fa-caret-up"></i>
                                            </span>
                                            <!-- Move DOWN -->
                                            <span class="btn btn-warning px-2 py-0 move-down" style="font-size: 24px;">
                                                <i class="fas fa-caret-down"></i>
                                            </span>
                                        </div>
                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger px-4 remove-slide-item">
                                            <span class="d-block d-md-none"><i class="fas fa-times"></i></span>
                                            <span class="d-none d-md-inline">Delete</span>
                                        </button>
                                    </div>
                                    <div class="card-body pt-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Slide Title</label>
                                                    <input type="text" name="slide_title[]" class="form-control"
                                                           placeholder="Slide Title..." value="Tieu De 1">
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>[View More] Button | Text</label>
                                                            <input type="text" name="slide_btn_text[]"
                                                                   class="form-control"
                                                                   placeholder="Text of Button...">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>[View More] Button | Link</label>
                                                            <input type="text" name="slide_btn_link[]"
                                                                   class="form-control"
                                                                   placeholder="Link of Button...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- /.row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>YouTube Video URL</label>
                                                    <input type="url" name="slide_video[]" class="form-control"
                                                           placeholder="YouTube Video URL...">
                                                </div>
                                                <div class="form-group">
                                                    <label>Slide Description</label>
                                                    <textarea name="slide_desc[]" class="form-control"
                                                              placeholder="Slide Description..."
                                                              style="height: 210px"
                                                    ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Slide Background -->
                                                <div class="form-group ckfinder-group">
                                                    <label>Background Image</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="slide_background[]"
                                                               class="form-control ckfinder-render-img"
                                                               placeholder="Choose image...">
                                                        <div class="input-group-append">
                                                            <span class="btn input-group-text view-img">
                                                                <i class="fas fa-search-plus"></i>
                                                            </span>
                                                            <button type="button"
                                                                    class="btn btn-success ckfinder-choose-img">
                                                                <i class="fas fa-upload"></i>
                                                                <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Slide Image 1 -->
                                                <div class="form-group ckfinder-group">
                                                    <label>Image 1</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="slide_image_1[]"
                                                               class="form-control ckfinder-render-img"
                                                               placeholder="Choose image...">
                                                        <div class="input-group-append">
                                                            <span class="btn input-group-text view-img">
                                                                <i class="fas fa-search-plus"></i>
                                                            </span>
                                                            <button type="button"
                                                                    class="btn btn-success ckfinder-choose-img">
                                                                <i class="fas fa-upload"></i>
                                                                <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Slide Image 2 -->
                                                <div class="form-group ckfinder-group">
                                                    <label>Image 2</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="slide_image_2[]"
                                                               class="form-control ckfinder-render-img"
                                                               placeholder="Choose image...">
                                                        <div class="input-group-append">
                                                            <span class="btn input-group-text view-img">
                                                                <i class="fas fa-search-plus"></i>
                                                            </span>
                                                            <button type="button"
                                                                    class="btn btn-success ckfinder-choose-img">
                                                                <i class="fas fa-upload"></i>
                                                                <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Position of Image 1, 2</label>
                                                    <select name="slide_images_position" class="form-control">
                                                        <option value="left">
                                                            Left
                                                        </option>
                                                        <option value="right">
                                                            Right
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> <!-- /.row -->
                                    </div> <!-- /.card-body (child) -->
                                </div> <!-- /.card (child) -->
                            </div> <!-- /.slide-item -->
                        </div> <!-- /.slide-gallery -->

                        <!-- Add Slide Button -->
                        <button type="button" class="btn btn-warning px-3 mt-3 add-slide-item">
                            <i class="fas fa-plus mr-1"></i> Add Slide
                        </button>

                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'general'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div> <!-- /.card -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
