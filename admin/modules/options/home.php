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

            if (!empty($body['home_hero']['general'])) {
                $general = $body['home_hero']['general'];
                $body['home_hero']['general'] = json_encode($general);
            } else {
                $body['home_hero']['general'] = '';
            }

            if (!empty($body['home_hero']['slider'])) {
                // Convert all slides data to Json
                $slider = $body['home_hero']['slider'];

                $totalSlides = count($slider['slide_title']);
                $slides = [];
                for ($index = 0; $index < $totalSlides; $index++) {
                    $slideData = [
                        'slide_layout' => $slider['slide_layout'][$index],
                        'slide_text_align' => $slider['slide_text_align'][$index],
                        'slide_title' => $slider['slide_title'][$index],
                        'slide_desc' => $slider['slide_desc'][$index],
                        'slide_btn_text' => $slider['slide_btn_text'][$index],
                        'slide_btn_link' => $slider['slide_btn_link'][$index],
                        'slide_play_text' => $slider['slide_play_text'][$index],
                        'slide_play_link' => $slider['slide_play_link'][$index],
                        'slide_background' => $slider['slide_background'][$index],
                        'slide_image_1' => $slider['slide_image_1'][$index],
                        'slide_image_2' => $slider['slide_image_2'][$index],
                    ];

                    if ($slideData['slide_layout'] == 'center') {
                        $slideData['slide_image_1'] = '';
                        $slideData['slide_image_2'] = '';
                    }

                    $slides[] = $slideData;
                }
                $body['home_hero']['slider'] = json_encode($slides);
            } else {
                // If delete all slides, set to empty
                $body['home_hero']['slider'] = '';
            }
        } else {
            $body['home_hero'] = [
                'general' => '',
                'slider' => ''
            ];
        }
        $body['home_hero'] = json_encode($body['home_hero']);
    }

    if ($formName == 'about-comp') {
        if (!empty($body['home_about'])) {

            if (!empty($body['home_about']['general'])) {
                $general = $body['home_about']['general'];
                $body['home_about']['general'] = json_encode($general);
            } else {
                $body['home_about']['general'] = '';
            }

            if (!empty($body['home_about']['skill'])) {
                // Convert all skills data to Json
                $aboutSkill = $body['home_about']['skill'];

                $totalSkills = count($aboutSkill['skill_name']);
                $skills = [];
                for ($index = 0; $index < $totalSkills; $index++) {
                    $skillData = [
                        'skill_name' => $aboutSkill['skill_name'][$index],
                        'skill_percent' => $aboutSkill['skill_percent'][$index],
                    ];

                    $skills[] = $skillData;
                }
                $body['home_about']['skill'] = json_encode($skills);
            } else {
                // If delete all skills, set to empty
                $body['home_about']['skill'] = '';
            }
        } else {
            $body['home_about'] = [
                'general' => '',
                'skill' => ''
            ];
        }
        $body['home_about'] = json_encode($body['home_about']);
    }

    if ($formName == 'service') {
        if (!empty($body['home_service'])) {
            if (!empty($body['home_service']['general'])) {
                $general = $body['home_service']['general'];
                $body['home_service']['general'] = json_encode($general);
            } else {
                $body['home_service']['general'] = '';
            }
        } else {
            $body['home_service'] = [
                'general' => '',
            ];
        }
        $body['home_service'] = json_encode($body['home_service']);
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

            <!-- Hero Area -->
            <div class="card card-primary mb-5" id="hero-area">
                <div class="card-header">
                    <h3 class="card-title">Hero Area (Main Slider)</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="hero-area">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'hero-area') ? getMessage($msg, $msgType) : null;
                        $homeHero = json_decode(getOption('home_hero'), true);
                        if (!empty($homeHero['general'])) {
                            $heroGeneralOpts = json_decode($homeHero['general'], true);
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Background Opacity:</label>
                                    <input type="text" name="home_hero[general][bg_opacity]"
                                           class="form-control opacity-range"
                                           value="<?php echo (!empty($heroGeneralOpts['bg_opacity']))
                                               ? $heroGeneralOpts['bg_opacity'] : null; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 18px;">List of Slides:</label>
                            <div class="slide-gallery">
                                <?php
                                if (!empty($homeHero['slider'])):
                                    $slides = json_decode($homeHero['slider'], true);
                                    if (!empty($slides) && is_array($slides)) :
                                        foreach ($slides as $slide) :
                                            ?>
                                            <!-- Slide Item -->
                                            <div class="slide-item movable">
                                                <!-- Child Card -->
                                                <div class="card bg-light mb-4 shadow border">
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
                                                        <button type="button"
                                                                class="btn btn-danger px-4 remove-slide-item">
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
                                                                            <select name="home_hero[slider][slide_layout][]"
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
                                                                            <select name="home_hero[slider][slide_text_align][]"
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
                                                                    <input type="text"
                                                                           name="home_hero[slider][slide_title][]"
                                                                           class="form-control"
                                                                           placeholder="Slide Title..."
                                                                           value="<?php echo $slide['slide_title']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Slide Description</label>
                                                                    <textarea name="home_hero[slider][slide_desc][]"
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
                                                                                   name="home_hero[slider][slide_btn_text][]"
                                                                                   class="form-control"
                                                                                   placeholder="Text of Button..."
                                                                                   value="<?php echo $slide['slide_btn_text']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>[View More] Button | Link</label>
                                                                            <input type="text"
                                                                                   name="home_hero[slider][slide_btn_link][]"
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
                                                                                   name="home_hero[slider][slide_play_text][]"
                                                                                   class="form-control"
                                                                                   placeholder="Text of Button..."
                                                                                   value="<?php echo $slide['slide_play_text']; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>[Play] Button | Link
                                                                                (YouTube)</label>
                                                                            <input type="text"
                                                                                   name="home_hero[slider][slide_play_link][]"
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
                                                                               name="home_hero[slider][slide_background][]"
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
                                                                        <input type="text"
                                                                               name="home_hero[slider][slide_image_1][]"
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
                                                                        <input type="text"
                                                                               name="home_hero[slider][slide_image_2][]"
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
                        </div>


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
            </div>
            <!-- End Hero Area -->

            <!-- About Company -->
            <div class="card card-primary mb-5" id="about-comp">
                <div class="card-header">
                    <h3 class="card-title">About Company</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="about-comp">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'about-comp') ? getMessage($msg, $msgType) : null;
                        $homeAbout = json_decode(getOption('home_about'), true);
                        if (!empty($homeAbout['general'])) {
                            $aboutGeneralOpts = json_decode($homeAbout['general'], true);
                        }
                        ?>

                        <div class="form-group">
                            <label>Background Title</label>
                            <input type="text" name="home_about[general][bg_title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($aboutGeneralOpts['bg_title']))
                                       ? $aboutGeneralOpts['bg_title'] : null; ?>">
                        </div>
                        <div class="form-group ckfinder-group">
                            <label>Intro Image</label>
                            <div class="input-group mb-3">
                                <input type="text"
                                       name="home_about[general][intro_image]"
                                       class="form-control ckfinder-render-img"
                                       placeholder="Choose image..."
                                       value="<?php echo (!empty($aboutGeneralOpts['intro_image']))
                                           ? $aboutGeneralOpts['intro_image'] : null; ?>">
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
                            <label>[Play] Button | Link (YouTube)</label>
                            <input type="text" name="home_about[general][intro_video]" class="form-control"
                                   placeholder="Link of Button..."
                                   value="<?php echo (!empty($aboutGeneralOpts['intro_video']))
                                       ? $aboutGeneralOpts['intro_video'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Main Title</label>
                            <textarea name="home_about[general][main_title]" class="form-control editor"
                            ><?php echo (!empty($aboutGeneralOpts['main_title']))
                                    ? $aboutGeneralOpts['main_title'] : null; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Company Introduction</label>
                            <textarea name="home_about[general][intro_content]" class="form-control editor"
                            ><?php echo (!empty($aboutGeneralOpts['intro_content']))
                                    ? $aboutGeneralOpts['intro_content'] : null; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 18px;">List of Skills:</label>
                            <div class="skill-gallery">
                                <?php
                                if (!empty($homeAbout['skill'])):
                                    $skills = json_decode($homeAbout['skill'], true);
                                    if (!empty($skills) && is_array($skills)) :
                                        foreach ($skills as $skill) :
                                            ?>
                                            <!-- Skill Item -->
                                            <div class="skill-item movable">
                                                <!-- Child Card -->
                                                <div class="card bg-light mb-4 shadow border">
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
                                                        <button type="button"
                                                                class="btn btn-danger px-4 remove-skill-item">
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
                                                                <div class="form-group">
                                                                    <label>Skill Name</label>
                                                                    <input type="text"
                                                                           name="home_about[skill][skill_name][]"
                                                                           class="form-control"
                                                                           placeholder="Skill Name..."
                                                                           value="<?php echo $skill['skill_name']; ?>">
                                                                </div>
                                                            </div> <!-- /.col (left) -->
                                                            <!-- Col Right -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Percentage</label>
                                                                    <input type="text"
                                                                           name="home_about[skill][skill_percent][]"
                                                                           class="form-control percent-range"
                                                                           value="<?php echo $skill['skill_percent']; ?>">
                                                                </div>
                                                            </div> <!-- /.col (right) -->
                                                        </div> <!-- /.row -->
                                                    </div> <!-- /.card-body (child) -->
                                                </div> <!-- /.card (child) -->
                                            </div>
                                            <!-- /.skill-item -->
                                        <?php
                                        endforeach;
                                    endif;
                                endif;
                                ?>
                            </div> <!-- /.skill-gallery -->
                        </div>

                        <!-- Add Slide Button -->
                        <button type="button" class="btn btn-warning px-3 add-skill-item">
                            <i class="fas fa-plus mr-1"></i> Add Skill
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
            </div>
            <!-- End About Company -->

            <!-- Services -->
            <div class="card card-primary mb-5" id="service">
                <div class="card-header">
                    <h3 class="card-title">Services</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="service">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'service') ? getMessage($msg, $msgType) : null;
                        $homeService = json_decode(getOption('home_service'), true);
                        if (!empty($homeService['general'])) {
                            $serviceGeneralOpts = json_decode($homeService['general'], true);
                        }
                        ?>

                        <div class="form-group">
                            <label>Background Title</label>
                            <input type="text" name="home_service[general][bg_title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($serviceGeneralOpts['bg_title']))
                                       ? $serviceGeneralOpts['bg_title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Main Title</label>
                            <textarea name="home_service[general][main_title]" class="form-control editor"
                            ><?php echo (!empty($serviceGeneralOpts['main_title']))
                                    ? $serviceGeneralOpts['main_title'] : null; ?></textarea>
                        </div>
                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'home'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div>
            <!-- End Services -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
