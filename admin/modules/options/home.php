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
                $slideFields = $body['home_hero']['slider'];

                $totalSlides = count($slideFields['slide_title']);
                $slides = [];
                for ($index = 0; $index < $totalSlides; $index++) {
                    $slideData = [
                        'slide_layout' => $slideFields['slide_layout'][$index],
                        'slide_text_align' => $slideFields['slide_text_align'][$index],
                        'slide_title' => $slideFields['slide_title'][$index],
                        'slide_desc' => $slideFields['slide_desc'][$index],
                        'slide_btn_text' => $slideFields['slide_btn_text'][$index],
                        'slide_btn_link' => $slideFields['slide_btn_link'][$index],
                        'slide_play_text' => $slideFields['slide_play_text'][$index],
                        'slide_play_link' => $slideFields['slide_play_link'][$index],
                        'slide_background' => $slideFields['slide_background'][$index],
                        'slide_image_1' => $slideFields['slide_image_1'][$index],
                        'slide_image_2' => $slideFields['slide_image_2'][$index],
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
            $body['home_hero'] = ['general' => '', 'slider' => ''];
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
                $skillFields = $body['home_about']['skill'];

                $totalSkills = count($skillFields['skill_name']);
                $skills = [];
                for ($index = 0; $index < $totalSkills; $index++) {
                    $skillData = [
                        'skill_name' => $skillFields['skill_name'][$index],
                        'skill_percent' => $skillFields['skill_percent'][$index],
                    ];

                    $skills[] = $skillData;
                }
                $body['home_about']['skill'] = json_encode($skills);
            } else {
                // If delete all skills, set to empty
                $body['home_about']['skill'] = '';
            }
        } else {
            $body['home_about'] = ['general' => '', 'skill' => ''];
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
            $body['home_service'] = ['general' => '',];
        }
        $body['home_service'] = json_encode($body['home_service']);
    }

    if ($formName == 'fact') {
        if (!empty($body['home_fact'])) {

            if (!empty($body['home_fact']['general'])) {
                $general = $body['home_fact']['general'];
                $body['home_fact']['general'] = json_encode($general);
            } else {
                $body['home_fact']['general'] = '';
            }

            if (!empty($body['home_fact']['fact'])) {
                // Convert all facts data to Json
                $factFields = $body['home_fact']['fact'];

                $totalFacts = count($factFields['fact_name']);
                $facts = [];
                for ($index = 0; $index < $totalFacts; $index++) {
                    $factData = [
                        'fact_name' => $factFields['fact_name'][$index],
                        'fact_figure' => $factFields['fact_figure'][$index],
                        'fact_unit' => $factFields['fact_unit'][$index],
                        'fact_icon' => $factFields['fact_icon'][$index],
                    ];

                    $facts[] = $factData;
                }
                $body['home_fact']['fact'] = json_encode($facts);
            } else {
                // If delete all skills, set to empty
                $body['home_fact']['fact'] = '';
            }
        } else {
            $body['home_fact'] = ['general' => '', 'fact' => ''];
        }
        $body['home_fact'] = json_encode($body['home_fact']);
    }

    if ($formName == 'portfolio') {
        if (!empty($body['home_portfolio'])) {
            if (!empty($body['home_portfolio']['general'])) {
                $general = $body['home_portfolio']['general'];
                $body['home_portfolio']['general'] = json_encode($general);
            } else {
                $body['home_portfolio']['general'] = '';
            }
        } else {
            $body['home_portfolio'] = ['general' => '',];
        }
        $body['home_portfolio'] = json_encode($body['home_portfolio']);
    }

    if ($formName == 'cta') {
        if (!empty($body['home_cta'])) {
            if (!empty($body['home_cta']['general'])) {
                $general = $body['home_cta']['general'];
                $body['home_cta']['general'] = json_encode($general);
            } else {
                $body['home_cta']['general'] = '';
            }
        } else {
            $body['home_cta'] = ['general' => '',];
        }
        $body['home_cta'] = json_encode($body['home_cta']);
    }

    if ($formName == 'blog') {
        if (!empty($body['home_blog'])) {
            if (!empty($body['home_blog']['general'])) {
                $general = $body['home_blog']['general'];
                $body['home_blog']['general'] = json_encode($general);
            } else {
                $body['home_blog']['general'] = '';
            }
        } else {
            $body['home_blog'] = ['general' => '',];
        }
        $body['home_blog'] = json_encode($body['home_blog']);
    }

    if ($formName == 'partner') {
        if (!empty($body['home_partner'])) {

            if (!empty($body['home_partner']['general'])) {
                $general = $body['home_partner']['general'];
                $body['home_partner']['general'] = json_encode($general);
            } else {
                $body['home_partner']['general'] = '';
            }

            if (!empty($body['home_partner']['partner'])) {
                // Convert all partners data to Json
                $partnerFields = $body['home_partner']['partner'];
                $totalPartners = count($partnerFields['partner_logo']);
                $partners = [];
                for ($index = 0; $index < $totalPartners; $index++) {
                    $partnerData = [
                        'partner_logo' => $partnerFields['partner_logo'][$index],
                        'partner_link' => $partnerFields['partner_link'][$index],
                    ];

                    $partners[] = $partnerData;
                }
                $body['home_partner']['partner'] = json_encode($partners);
            } else {
                // If delete all partners, set to empty
                $body['home_partner']['partner'] = '';
            }
        } else {
            $body['home_partner'] = ['general' => '', 'partner' => ''];
        }
        $body['home_partner'] = json_encode($body['home_partner']);
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
            <div class="card card-primary mb-5 border border-primary" id="hero-area">
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
            <div class="card card-primary mb-5 border border-primary" id="about-comp">
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
                            <label>Intro Video (YouTube)</label>
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
            <div class="card card-primary mb-5 border border-primary" id="service">
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

            <!-- Facts -->
            <div class="card card-primary mb-5 border border-primary" id="fact">
                <div class="card-header">
                    <h3 class="card-title">Interesting Facts</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="fact">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'fact') ? getMessage($msg, $msgType) : null;
                        $homeFact = json_decode(getOption('home_fact'), true);
                        if (!empty($homeFact['general'])) {
                            $factGeneralOpts = json_decode($homeFact['general'], true);
                        }
                        ?>

                        <div class="form-group">
                            <label>Small Title</label>
                            <input type="text" name="home_fact[general][small_title]" class="form-control"
                                   placeholder="Small Title..."
                                   value="<?php echo (!empty($factGeneralOpts['small_title']))
                                       ? $factGeneralOpts['small_title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="home_fact[general][main_title]" class="form-control"
                                   placeholder="Title..."
                                   value="<?php echo (!empty($factGeneralOpts['main_title']))
                                       ? $factGeneralOpts['main_title'] : null; ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button | Text</label>
                                    <input type="text" class="form-control"
                                           name="home_fact[general][btn_text]"
                                           placeholder="Text of Button..."
                                           value="<?php echo (!empty($factGeneralOpts['btn_text']))
                                               ? $factGeneralOpts['btn_text'] : null; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button | Link</label>
                                    <input type="text" class="form-control"
                                           name="home_fact[general][btn_link]"
                                           placeholder="Link of Button..."
                                           value="<?php echo (!empty($factGeneralOpts['btn_link']))
                                               ? $factGeneralOpts['btn_link'] : null; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="home_fact[general][content]" class="form-control editor"
                            ><?php echo (!empty($factGeneralOpts['content']))
                                    ? $factGeneralOpts['content'] : null; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 18px;">List of Facts:</label>
                            <div class="fact-gallery">
                                <?php
                                if (!empty($homeFact['fact'])):
                                    $facts = json_decode($homeFact['fact'], true);
                                    if (!empty($facts) && is_array($facts)) :
                                        foreach ($facts as $fact) :
                                            ?>
                                            <!-- Fact Item -->
                                            <div class="fact-item movable">
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
                                                                class="btn btn-danger px-4 remove-fact-item">
                                                            <span class="d-block d-md-none">
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                            <span class="d-none d-md-inline">Delete</span>
                                                        </button>
                                                    </div>
                                                    <div class="card-body pt-5">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Fact Name</label>
                                                                    <input type="text" class="form-control"
                                                                           name="home_fact[fact][fact_name][]"
                                                                           placeholder="Fact Name..."
                                                                           value="<?php echo $fact['fact_name']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Fact Figure</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                               name="home_fact[fact][fact_figure][]"
                                                                               placeholder="Fact Figure..."
                                                                               value="<?php echo $fact['fact_figure']; ?>">
                                                                        <input type="text" class="form-control"
                                                                               name="home_fact[fact][fact_unit][]"
                                                                               placeholder="Unit..."
                                                                               value="<?php echo $fact['fact_unit']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Fact Icon</label>
                                                                    <input type="text" class="form-control"
                                                                           name="home_fact[fact][fact_icon][]"
                                                                           placeholder="Fact Icon..."
                                                                           value="<?php echo $fact['fact_icon']; ?>">
                                                                </div>
                                                            </div>
                                                        </div> <!-- /.row -->
                                                    </div> <!-- /.card-body (child) -->
                                                </div> <!-- /.card (child) -->
                                            </div>
                                            <!-- /.fact-item -->
                                        <?php
                                        endforeach;
                                    endif;
                                endif;
                                ?>
                            </div> <!-- /.fact-gallery -->
                        </div>

                        <!-- Add Slide Button -->
                        <button type="button" class="btn btn-warning px-3 add-fact-item">
                            <i class="fas fa-plus mr-1"></i> Add Fact
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
            <!-- End Facts -->

            <!-- Portfolios -->
            <div class="card card-primary mb-5 border border-primary" id="portfolio">
                <div class="card-header">
                    <h3 class="card-title">Portfolios</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="portfolio">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'portfolio') ? getMessage($msg, $msgType) : null;
                        $homePortfolio = json_decode(getOption('home_portfolio'), true);
                        if (!empty($homePortfolio['general'])) {
                            $portfolioGeneralOpts = json_decode($homePortfolio['general'], true);
                        }
                        ?>

                        <div class="form-group">
                            <label>Background Title</label>
                            <input type="text" name="home_portfolio[general][bg_title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($portfolioGeneralOpts['bg_title']))
                                       ? $portfolioGeneralOpts['bg_title'] : null; ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button | Text</label>
                                    <input type="text" class="form-control"
                                           name="home_portfolio[general][btn_text]"
                                           placeholder="Text of Button..."
                                           value="<?php echo (!empty($portfolioGeneralOpts['btn_text']))
                                               ? $portfolioGeneralOpts['btn_text'] : null; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button | Link</label>
                                    <input type="text" class="form-control"
                                           name="home_portfolio[general][btn_link]"
                                           placeholder="Link of Button..."
                                           value="<?php echo (!empty($portfolioGeneralOpts['btn_link']))
                                               ? $portfolioGeneralOpts['btn_link'] : null; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Main Title</label>
                            <textarea name="home_portfolio[general][main_title]" class="form-control editor"
                            ><?php echo (!empty($portfolioGeneralOpts['main_title']))
                                    ? $portfolioGeneralOpts['main_title'] : null; ?></textarea>
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
            <!-- End Portfolios -->

            <!-- Call to Action -->
            <div class="card card-primary mb-5 border border-primary" id="cta">
                <div class="card-header">
                    <h3 class="card-title">Portfolios</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="cta">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'cta') ? getMessage($msg, $msgType) : null;
                        $homeCta = json_decode(getOption('home_cta'), true);
                        if (!empty($homeCta['general'])) {
                            $ctaGeneralOpts = json_decode($homeCta['general'], true);
                        }
                        ?>

                        <div class="form-group ckfinder-group">
                            <label>Background Image</label>
                            <div class="input-group mb-3">
                                <input type="text"
                                       name="home_cta[general][bg_image]"
                                       class="form-control ckfinder-render-img"
                                       placeholder="Choose image..."
                                       value="<?php echo (!empty($ctaGeneralOpts['bg_image']))
                                           ? $ctaGeneralOpts['bg_image'] : null; ?>">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button | Text</label>
                                    <input type="text" class="form-control"
                                           name="home_cta[general][btn_text]"
                                           placeholder="Text of Button..."
                                           value="<?php echo (!empty($ctaGeneralOpts['btn_text']))
                                               ? $ctaGeneralOpts['btn_text'] : null; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Button | Link</label>
                                    <input type="text" class="form-control"
                                           name="home_cta[general][btn_link]"
                                           placeholder="Link of Button..."
                                           value="<?php echo (!empty($ctaGeneralOpts['btn_link']))
                                               ? $ctaGeneralOpts['btn_link'] : null; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="home_cta[general][content]" class="form-control editor"
                            ><?php echo (!empty($ctaGeneralOpts['content']))
                                    ? $ctaGeneralOpts['content'] : null; ?></textarea>
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
            <!-- End Call to Action -->

            <!-- Blogs -->
            <div class="card card-primary mb-5 border border-primary" id="blog">
                <div class="card-header">
                    <h3 class="card-title">Blogs</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="blog">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'blog') ? getMessage($msg, $msgType) : null;
                        $homeBlog = json_decode(getOption('home_blog'), true);
                        if (!empty($homeBlog['general'])) {
                            $blogGeneralOpts = json_decode($homeBlog['general'], true);
                        }
                        ?>

                        <div class="form-group">
                            <label>Background Title</label>
                            <input type="text" name="home_blog[general][bg_title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($blogGeneralOpts['bg_title']))
                                       ? $blogGeneralOpts['bg_title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Main Title</label>
                            <textarea name="home_blog[general][main_title]" class="form-control editor"
                            ><?php echo (!empty($blogGeneralOpts['main_title']))
                                    ? $blogGeneralOpts['main_title'] : null; ?></textarea>
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
            <!-- End Blogs -->

            <!-- Partners -->
            <div class="card card-primary mb-5 border border-primary" id="partner">
                <div class="card-header">
                    <h3 class="card-title">Partners</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="partner">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'partner') ? getMessage($msg, $msgType) : null;
                        $homePartner = json_decode(getOption('home_partner'), true);
                        if (!empty($homePartner['general'])) {
                            $partnerGeneralOpts = json_decode($homePartner['general'], true);
                        }
                        ?>
                        <div class="form-group">
                            <label>Background Title</label>
                            <input type="text" name="home_partner[general][bg_title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($partnerGeneralOpts['bg_title']))
                                       ? $partnerGeneralOpts['bg_title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Main Title</label>
                            <textarea name="home_partner[general][main_title]" class="form-control editor"
                            ><?php echo (!empty($partnerGeneralOpts['main_title']))
                                    ? $partnerGeneralOpts['main_title'] : null; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;">List of Partners:</label>
                            <div class="partner-gallery">
                                <?php
                                if (!empty($homePartner['partner'])):
                                    $partners = json_decode($homePartner['partner'], true);
                                    if (!empty($partners) && is_array($partners)) :
                                        foreach ($partners as $partner) :
                                            ?>
                                            <!-- Partner Item -->
                                            <div class="partner-item movable">
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
                                                                class="btn btn-danger px-4 remove-partner-item">
                                                            <span class="d-block d-md-none">
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                            <span class="d-none d-md-inline">Delete</span>
                                                        </button>
                                                    </div>
                                                    <div class="card-body pt-5">
                                                        <div class="row">
                                                            <!-- Logo -->
                                                            <div class="col-md-6">
                                                                <div class="form-group ckfinder-group">
                                                                    <label>Partner Logo</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="text"
                                                                               name="home_partner[partner][partner_logo][]"
                                                                               class="form-control ckfinder-render-img"
                                                                               placeholder="Choose image..."
                                                                               value="<?php echo $partner['partner_logo']; ?>">
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
                                                            </div>
                                                            <!-- Link -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Partner Link</label>
                                                                    <input type="text" class="form-control"
                                                                           name="home_partner[partner][partner_link][]"
                                                                           placeholder="Link of Logo..."
                                                                           value="<?php echo $partner['partner_link']; ?>">
                                                                </div>
                                                            </div>
                                                        </div> <!-- /.row -->
                                                    </div> <!-- /.card-body (child) -->
                                                </div> <!-- /.card (child) -->
                                            </div>
                                            <!-- /.partner-item -->
                                        <?php
                                        endforeach;
                                    endif;
                                endif;
                                ?>
                            </div> <!-- /.partner-gallery -->
                        </div>

                        <!-- Add Slide Button -->
                        <button type="button" class="btn btn-warning px-3 add-partner-item">
                            <i class="fas fa-plus mr-1"></i> Add Partner
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
            <!-- End Partners -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
