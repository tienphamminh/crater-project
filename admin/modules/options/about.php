<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'About Options'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];
    $formName = trim($body['form_name']);

    if ($formName == 'leader') {
        if (!empty($body['about_leader'])) {

            if (!empty($body['about_leader']['general'])) {
                $general = $body['about_leader']['general'];
                $body['about_leader']['general'] = json_encode($general);
            } else {
                $body['about_leader']['general'] = '';
            }

            if (!empty($body['about_leader']['leader'])) {
                // Convert all leaders data to Json
                $leaderFields = $body['about_leader']['leader'];
                $totalPartners = count($leaderFields['leader_avt']);
                $leaders = [];
                for ($index = 0; $index < $totalPartners; $index++) {
                    $leaderData = [
                        'leader_avt' => $leaderFields['leader_avt'][$index],
                        'leader_name' => $leaderFields['leader_name'][$index],
                        'leader_role' => $leaderFields['leader_role'][$index],
                        'leader_fb' => $leaderFields['leader_fb'][$index],
                        'leader_twitter' => $leaderFields['leader_twitter'][$index],
                        'leader_linked' => $leaderFields['leader_linked'][$index],
                        'leader_behance' => $leaderFields['leader_behance'][$index],
                    ];

                    $leaders[] = $leaderData;
                }
                $body['about_leader']['leader'] = json_encode($leaders);
            } else {
                // If delete all leaders, set to empty
                $body['about_leader']['leader'] = '';
            }
        } else {
            $body['about_leader'] = ['general' => '', 'leader' => ''];
        }
        $body['about_leader'] = json_encode($body['about_leader']);
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
    redirect('admin/?module=options&action=about' . '#' . $formName);
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

            <!-- Page Title & Breadcrumb -->
            <div class="card card-primary mb-5 border border-primary" id="page-title">
                <div class="card-header">
                    <h3 class="card-title">Title & Breadcrumbs</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="page-title">
                    <div class="card-body">
                        <?php echo ($formName == 'page-title') ? getMessage($msg, $msgType) : null; ?>
                        <div class="form-group">
                            <label><?php echo getOption('about_title', true); ?></label>
                            <input type="text" name="about_title" class="form-control"
                                   value="<?php echo getOption('about_title'); ?>">
                        </div>
                        <div class="form-group">
                            <label><?php echo getOption('about_breadcrumb_title', true); ?></label>
                            <input type="text" name="about_breadcrumb_title" class="form-control"
                                   value="<?php echo getOption('about_breadcrumb_title'); ?>">
                        </div>
                        <div class="form-group ckfinder-group">
                            <label><?php echo getOption('about_breadcrumb_bg', true); ?></label>
                            <div class="input-group mb-3">
                                <input type="text"
                                       name="about_breadcrumb_bg"
                                       class="form-control ckfinder-render-img"
                                       placeholder="Choose image..."
                                       value="<?php echo getOption('about_breadcrumb_bg'); ?>">
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
                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'about'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div>
            <!-- End Page Title & Breadcrumb -->

            <!-- Leaders -->
            <div class="card card-primary mb-5 border border-primary" id="leader">
                <div class="card-header">
                    <h3 class="card-title">Leaders</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="leader">
                    <div class="card-body py-4">
                        <?php
                        echo ($formName == 'leader') ? getMessage($msg, $msgType) : null;
                        $aboutLeader = json_decode(getOption('about_leader'), true);
                        if (!empty($aboutLeader['general'])) {
                            $leaderGeneralOpts = json_decode($aboutLeader['general'], true);
                        }
                        ?>
                        <div class="form-group">
                            <label>Background Title</label>
                            <input type="text" name="about_leader[general][bg_title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($leaderGeneralOpts['bg_title']))
                                       ? $leaderGeneralOpts['bg_title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Main Title</label>
                            <textarea name="about_leader[general][main_title]" class="form-control editor"
                            ><?php echo (!empty($leaderGeneralOpts['main_title']))
                                    ? $leaderGeneralOpts['main_title'] : null; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;">List of Leaders:</label>
                            <div class="leader-gallery">
                                <?php
                                if (!empty($aboutLeader['leader'])):
                                    $leaders = json_decode($aboutLeader['leader'], true);
                                    if (!empty($leaders) && is_array($leaders)) :
                                        foreach ($leaders as $leader) :
                                            ?>
                                            <!-- Leader Item -->
                                            <div class="leader-item movable">
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
                                                                class="btn btn-danger px-4 remove-leader-item">
                                                            <span class="d-block d-md-none">
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                            <span class="d-none d-md-inline">Delete</span>
                                                        </button>
                                                    </div>
                                                    <div class="card-body pt-5">
                                                        <!-- Avatar -->
                                                        <div class="form-group ckfinder-group">
                                                            <label>Leader Avatar</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text"
                                                                       name="about_leader[leader][leader_avt][]"
                                                                       class="form-control ckfinder-render-img"
                                                                       placeholder="Choose image..."
                                                                       value="<?php echo $leader['leader_avt']; ?>">
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
                                                                    <label>Leader Name</label>
                                                                    <input type="text" class="form-control"
                                                                           name="about_leader[leader][leader_name][]"
                                                                           placeholder="Leader Name..."
                                                                           value="<?php echo $leader['leader_name']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Leader Role</label>
                                                                    <input type="text" class="form-control"
                                                                           name="about_leader[leader][leader_role][]"
                                                                           placeholder="Leader Role..."
                                                                           value="<?php echo $leader['leader_role']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Facebook</label>
                                                                    <input type="text" class="form-control"
                                                                           name="about_leader[leader][leader_fb][]"
                                                                           value="<?php echo $leader['leader_fb']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Twitter</label>
                                                                    <input type="text" class="form-control"
                                                                           name="about_leader[leader][leader_twitter][]"
                                                                           value="<?php echo $leader['leader_twitter']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>LinkedIn</label>
                                                                    <input type="text" class="form-control"
                                                                           name="about_leader[leader][leader_linked][]"
                                                                           value="<?php echo $leader['leader_linked']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Behance</label>
                                                                    <input type="text" class="form-control"
                                                                           name="about_leader[leader][leader_behance][]"
                                                                           value="<?php echo $leader['leader_behance']; ?>">
                                                                </div>
                                                            </div>
                                                        </div> <!-- /.row -->
                                                    </div> <!-- /.card-body (child) -->
                                                </div> <!-- /.card (child) -->
                                            </div>
                                            <!-- /.leader-item -->
                                        <?php
                                        endforeach;
                                    endif;
                                endif;
                                ?>
                            </div> <!-- /.leader-gallery -->
                        </div>

                        <!-- Add Slide Button -->
                        <button type="button" class="btn btn-warning px-3 add-leader-item">
                            <i class="fas fa-plus mr-1"></i> Add Leader
                        </button>

                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'about'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div>
            <!-- End Leaders -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
