<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Footer Options'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];
    $formName = trim($body['form_name']);

    if ($formName == 'widget-1') {
        if (!empty($body['footer_widget1'])) {
            if (!empty($body['footer_widget1']['general'])) {
                $general = $body['footer_widget1']['general'];
                $body['footer_widget1']['general'] = json_encode($general);
            } else {
                $body['footer_widget1']['general'] = '';
            }
        } else {
            $body['footer_widget1'] = ['general' => '',];
        }
        $body['footer_widget1'] = json_encode($body['footer_widget1']);
    }
    if ($formName == 'widget-2') {
        if (!empty($body['footer_widget2'])) {
            if (!empty($body['footer_widget2']['general'])) {
                $general = $body['footer_widget2']['general'];
                $body['footer_widget2']['general'] = json_encode($general);
            } else {
                $body['footer_widget2']['general'] = '';
            }
        } else {
            $body['footer_widget2'] = ['general' => '',];
        }
        $body['footer_widget2'] = json_encode($body['footer_widget2']);
    }
    if ($formName == 'widget-3') {
        if (!empty($body['footer_widget3'])) {
            if (!empty($body['footer_widget3']['general'])) {
                $general = $body['footer_widget3']['general'];
                $body['footer_widget3']['general'] = json_encode($general);
            } else {
                $body['footer_widget3']['general'] = '';
            }
        } else {
            $body['footer_widget3'] = ['general' => '',];
        }
        $body['footer_widget3'] = json_encode($body['footer_widget3']);
    }
    if ($formName == 'widget-4') {
        if (!empty($body['footer_widget4'])) {
            if (!empty($body['footer_widget4']['general'])) {
                $general = $body['footer_widget4']['general'];
                $body['footer_widget4']['general'] = json_encode($general);
            } else {
                $body['footer_widget4']['general'] = '';
            }
        } else {
            $body['footer_widget4'] = ['general' => '',];
        }
        $body['footer_widget4'] = json_encode($body['footer_widget4']);
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
    redirect('admin/?module=options&action=footer' . '#' . $formName);
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

            <!-- Widget 1 -->
            <div class="card card-primary mb-5" id="widget-1">
                <div class="card-header">
                    <h3 class="card-title">Widget 1</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="widget-1">
                    <div class="card-body">
                        <?php
                        echo ($formName == 'widget-1') ? getMessage($msg, $msgType) : null;
                        $footerWidget1 = json_decode(getOption('footer_widget1'), true);
                        if (!empty($footerWidget1['general'])) {
                            $widget1GeneralOpts = json_decode($footerWidget1['general'], true);
                        }
                        ?>

                        <div class="form-group">
                            <label>Widget Title</label>
                            <input type="text" name="footer_widget1[general][title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($widget1GeneralOpts['title']))
                                       ? $widget1GeneralOpts['title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Widget Description</label>
                            <textarea name="footer_widget1[general][description]" class="form-control editor"
                            ><?php echo (!empty($widget1GeneralOpts['description']))
                                    ? $widget1GeneralOpts['description'] : null; ?></textarea>
                        </div>
                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'footer'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div> <!-- /.card -->
            <!-- End Widget 1 -->

            <!-- Widget 2 -->
            <div class="card card-primary mb-5" id="widget-2">
                <div class="card-header">
                    <h3 class="card-title">Widget 2</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="widget-2">
                    <div class="card-body">
                        <?php
                        echo ($formName == 'widget-2') ? getMessage($msg, $msgType) : null;
                        $footerWidget2 = json_decode(getOption('footer_widget2'), true);
                        if (!empty($footerWidget2['general'])) {
                            $widget2GeneralOpts = json_decode($footerWidget2['general'], true);
                        }
                        ?>

                        <div class="form-group">
                            <label>Widget Title</label>
                            <input type="text" name="footer_widget2[general][title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($widget2GeneralOpts['title']))
                                       ? $widget2GeneralOpts['title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Widget Description</label>
                            <textarea name="footer_widget2[general][description]" class="form-control editor"
                            ><?php echo (!empty($widget2GeneralOpts['description']))
                                    ? $widget2GeneralOpts['description'] : null; ?></textarea>
                        </div>
                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'footer'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div> <!-- /.card -->
            <!-- End Widget 2 -->

            <!-- Widget 3 -->
            <div class="card card-primary mb-5" id="widget-3">
                <div class="card-header">
                    <h3 class="card-title">Widget 3</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="widget-3">
                    <div class="card-body">
                        <?php
                        echo ($formName == 'widget-3') ? getMessage($msg, $msgType) : null;
                        $footerWidget3 = json_decode(getOption('footer_widget3'), true);
                        if (!empty($footerWidget3['general'])) {
                            $widget3GeneralOpts = json_decode($footerWidget3['general'], true);
                        }
                        ?>
                        <div class="form-group">
                            <label>Widget Title</label>
                            <input type="text" name="footer_widget3[general][title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($widget3GeneralOpts['title']))
                                       ? $widget3GeneralOpts['title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Facebook Page URL</label>
                            <input type="text" name="footer_widget3[general][fb_page]" class="form-control"
                                   placeholder="Facebook Page URL..."
                                   value="<?php echo (!empty($widget3GeneralOpts['fb_page']))
                                       ? $widget3GeneralOpts['fb_page'] : null; ?>">
                        </div>
                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'footer'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div> <!-- /.card -->
            <!-- End Widget 3 -->

            <!-- Widget 4 -->
            <div class="card card-primary mb-5" id="widget-4">
                <div class="card-header">
                    <h3 class="card-title">Widget 4</h3>
                </div> <!-- /.card-header -->
                <!-- form start -->
                <form action="" method="post">
                    <input type="hidden" name="form_name" value="widget-4">
                    <div class="card-body">
                        <?php
                        echo ($formName == 'widget-4') ? getMessage($msg, $msgType) : null;
                        $footerWidget4 = json_decode(getOption('footer_widget4'), true);
                        if (!empty($footerWidget4['general'])) {
                            $widget4GeneralOpts = json_decode($footerWidget4['general'], true);
                        }
                        ?>
                        <div class="form-group">
                            <label>Widget Title</label>
                            <input type="text" name="footer_widget4[general][title]" class="form-control"
                                   placeholder="Background Title..."
                                   value="<?php echo (!empty($widget4GeneralOpts['title']))
                                       ? $widget4GeneralOpts['title'] : null; ?>">
                        </div>
                        <div class="form-group">
                            <label>Widget Description</label>
                            <textarea name="footer_widget4[general][description]" class="form-control editor"
                            ><?php echo (!empty($widget4GeneralOpts['description']))
                                    ? $widget4GeneralOpts['description'] : null; ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Text Input 1 | Placeholder</label>
                                    <input type="text" name="footer_widget4[general][input1_placeholder]"
                                           class="form-control"
                                           value="<?php echo (!empty($widget4GeneralOpts['input1_placeholder']))
                                               ? $widget4GeneralOpts['input1_placeholder'] : null; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Text Input 2 | Placeholder</label>
                                    <input type="text" name="footer_widget4[general][input2_placeholder]"
                                           class="form-control"
                                           value="<?php echo (!empty($widget4GeneralOpts['input2_placeholder']))
                                               ? $widget4GeneralOpts['input2_placeholder'] : null; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Button | Text</label>
                                    <input type="text" class="form-control"
                                           name="footer_widget4[general][btn_text]"
                                           placeholder="Text of Button..."
                                           value="<?php echo (!empty($widget4GeneralOpts['btn_text']))
                                               ? $widget4GeneralOpts['btn_text'] : null; ?>">
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('options', 'footer'); ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
                        </a>
                    </div> <!-- /.card-footer -->
                </form>
            </div> <!-- /.card -->
            <!-- End Widget 4 -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
