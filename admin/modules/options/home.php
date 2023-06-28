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

    if ($formName == 'hero-area') {
        if (!empty($body['home_hero'])) {
            // Convert all slides data to Json
            $homeHero = $body['home_hero'];
            $totalSlides = count($homeHero['slide_title']);
            $slides = [];

            for ($index = 0; $index < $totalSlides; $index++) {
                $slideData = [
                    'slide_layout' => $homeHero['slide_layout'][$index],
                    'slide_text_align' => $homeHero['slide_text_align'][$index],
                    'slide_title' => $homeHero['slide_title'][$index],
                    'slide_desc' => $homeHero['slide_desc'][$index],
                    'slide_btn_text' => $homeHero['slide_btn_text'][$index],
                    'slide_btn_link' => $homeHero['slide_btn_link'][$index],
                    'slide_play_text' => $homeHero['slide_play_text'][$index],
                    'slide_play_link' => $homeHero['slide_play_link'][$index],
                    'slide_background' => $homeHero['slide_background'][$index],
                    'slide_image_1' => $homeHero['slide_image_1'][$index],
                    'slide_image_2' => $homeHero['slide_image_2'][$index],
                ];

                if ($slideData['slide_layout'] == 'center') {
                    $slideData['slide_image_1'] = '';
                    $slideData['slide_image_2'] = '';
                }

                $slides[] = $slideData;
            }

            $body['home_hero'] = json_encode($slides);
        } else {
            // If delete all slides, set to empty
            $body['home_hero'] = '';
        }
    }


    if (empty($errors)) {
        unset($body['form_name']);
        updateOptions($body);

    } else {
        // Errors occurred
        setFlashData('msg', 'Please check the input form data.');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_values', $body);
    }

    setFlashData('form_name', $formName);
    redirect('admin/?module=options&action=home' . '#' . $formName);

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
                    <div class="card-body py-4">
                        <?php echo ($formName == 'hero-area') ? getMessage($msg, $msgType) : null; ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <?php echo getOption('home_hero_opacity', true); ?>:
                                        <h5 class="d-inline pl-2"><span class="badge badge-info range-value"></span>
                                        </h5>
                                    </label>
                                    <input type="range" name="home_hero_opacity"
                                           class="custom-range" min="0" max="100"
                                           value="<?php echo getOption('home_hero_opacity'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="slide-gallery">
                            <?php
                            $slidesJson = getOption('home_hero');
                            if (!empty($slidesJson)):
                                $slides = json_decode($slidesJson, true);
                                if (!empty($slides) && is_array($slides)) :
                                    foreach ($slides as $slide) :
                                        ?>
                                        <!-- Slide Item -->
                                        <div class="slide-item movable">
                                            <!-- Child Card -->
                                            <div class="card card-primary bg-light mb-4 shadow border">
                                                <div style="position: absolute; top: 0px; right: 0px;">
                                                    <div class="btn-group">
                                                        <!-- Move UP -->
                                                        <span class="btn btn-warning px-2 py-0 move-up"
                                                              style="font-size: 24px;">
                                                            <i class="fas fa-caret-up"></i>
                                                        </span>
                                                        <!-- Move DOWN -->
                                                        <span class="btn btn-warning px-2 py-0 move-down"
                                                              style="font-size: 24px;">
                                                            <i class="fas fa-caret-down"></i>
                                                        </span>
                                                    </div>
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-danger px-4 remove-slide-item">
                                                        <span class="d-block d-md-none">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                        <span class="d-none d-md-inline">Delete</span>
                                                    </button>
                                                </div>
                                                <div class="card-body pt-5">
                                                    <div class="row">
                                                        <!-- Col Left -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Slide Layout</label>
                                                                        <select name="home_hero[slide_layout][]"
                                                                                class="form-control">
                                                                            <option value="left"
                                                                                <?php echo ($slide['slide_layout'] == 'left')
                                                                                    ? 'selected'
                                                                                    : null; ?>>
                                                                                Left (Default)
                                                                            </option>
                                                                            <option value="right"
                                                                                <?php echo ($slide['slide_layout'] == 'right')
                                                                                    ? 'selected'
                                                                                    : null; ?>>
                                                                                Right
                                                                            </option>
                                                                            <option value="center"
                                                                                <?php echo ($slide['slide_layout'] == 'center')
                                                                                    ? 'selected'
                                                                                    : null; ?>>
                                                                                Center (No images)
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Slide Text Align</label>
                                                                        <select name="home_hero[slide_text_align][]"
                                                                                class="form-control">
                                                                            <option value="left"
                                                                                <?php echo ($slide['slide_text_align'] == 'left')
                                                                                    ? 'selected'
                                                                                    : null; ?>>
                                                                                Left (Default)
                                                                            </option>
                                                                            <option value="right"
                                                                                <?php echo ($slide['slide_text_align'] == 'right')
                                                                                    ? 'selected'
                                                                                    : null; ?>>
                                                                                Right
                                                                            </option>
                                                                            <option value="center"
                                                                                <?php echo ($slide['slide_text_align'] == 'center')
                                                                                    ? 'selected'
                                                                                    : null; ?>>
                                                                                Center
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Slide Title</label>
                                                                <input type="text" name="home_hero[slide_title][]"
                                                                       class="form-control"
                                                                       placeholder="Slide Title..."
                                                                       value="<?php echo $slide['slide_title']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Slide Description</label>
                                                                <textarea name="home_hero[slide_desc][]"
                                                                          class="form-control"
                                                                          placeholder="Slide Description..."
                                                                          style="height: 210px"
                                                                ><?php echo $slide['slide_desc']; ?></textarea>
                                                            </div>
                                                        </div> <!-- /.col (left) -->
                                                        <!-- Col Right -->
                                                        <div class="col-md-6">
                                                            <!-- View More Button -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>[View More] Button | Text</label>
                                                                        <input type="text"
                                                                               name="home_hero[slide_btn_text][]"
                                                                               class="form-control"
                                                                               placeholder="Text of Button..."
                                                                               value="<?php echo $slide['slide_btn_text']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>[View More] Button | Link</label>
                                                                        <input type="text"
                                                                               name="home_hero[slide_btn_link][]"
                                                                               class="form-control"
                                                                               placeholder="Link of Button..."
                                                                               value="<?php echo $slide['slide_btn_link']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div> <!-- End View More Button -->
                                                            <!-- Play Button -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>[Play] Button | Text</label>
                                                                        <input type="text"
                                                                               name="home_hero[slide_play_text][]"
                                                                               class="form-control"
                                                                               placeholder="Text of Button..."
                                                                               value="<?php echo $slide['slide_play_text']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>[Play] Button | Link (YouTube)</label>
                                                                        <input type="text"
                                                                               name="home_hero[slide_play_link][]"
                                                                               class="form-control"
                                                                               placeholder="Link of Button..."
                                                                               value="<?php echo $slide['slide_play_link']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div> <!-- End Play Button -->
                                                            <!-- Slide Background -->
                                                            <div class="form-group ckfinder-group">
                                                                <label>Background Image</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text"
                                                                           name="home_hero[slide_background][]"
                                                                           class="form-control ckfinder-render-img"
                                                                           placeholder="Choose image..."
                                                                           value="<?php echo $slide['slide_background']; ?>">
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
                                                                    <input type="text" name="home_hero[slide_image_1][]"
                                                                           class="form-control ckfinder-render-img"
                                                                           placeholder="Choose image..."
                                                                           value="<?php echo $slide['slide_image_1']; ?>">
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
                                                                    <input type="text" name="home_hero[slide_image_2][]"
                                                                           class="form-control ckfinder-render-img"
                                                                           placeholder="Choose image..."
                                                                           value="<?php echo $slide['slide_image_2']; ?>">
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
                                                        </div> <!-- /.col (right) -->
                                                    </div> <!-- /.row -->
                                                </div> <!-- /.card-body (child) -->
                                            </div> <!-- /.card (child) -->
                                        </div>
                                        <!-- /.slide-item -->
                                    <?php
                                    endforeach;
                                endif;
                            endif;
                            ?>
                        </div> <!-- /.slide-gallery -->

                        <!-- Add Slide Button -->
                        <button type="button" class="btn btn-warning px-3 add-slide-item">
                            <i class="fas fa-plus mr-1"></i> Add Slide
                        </button>

                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'home'); ?>"
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
