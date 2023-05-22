<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Edit Portfolio'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

$body = getBody();

if (!empty($body['id'])) {
    $portfolioId = $body['id'];
    $sql = "SELECT * FROM portfolios WHERE id=:id";
    $data = ['id' => $portfolioId];
    $portfolioDetails = getFirstRow($sql, $data);
    if (empty($portfolioDetails)) {
        setFlashData('msg', 'Something went wrong, please try again.');
        setFlashData('msg_type', 'danger');
        redirect('admin/?module=portfolios');
    }
} else {
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
    redirect('admin/?module=portfolios');
}

if (isPost()) {
    $errors = [];

    // Portfolio title: Required
    $portfolioName = trim($body['name']);
    if (empty($portfolioName)) {
        $errors['name']['required'] = 'Required field';
    }

    // Portfolio slug: Required, valid format
    $portfolioSlug = trim($body['slug']);
    if (empty($portfolioSlug)) {
        $errors['slug']['required'] = 'Required field';
    } elseif (!isSlug($portfolioSlug)) {
        $errors['slug']['isSlug'] = 'Invalid slug format';
    }

    // Portfolio Category: Required
    $portfolioCategory = trim($body['portfolio_category_id']);
    if (empty($portfolioCategory)) {
        $errors['portfolio_category_id']['required'] = 'Required field';
    }

    // Portfolio thumbnail: Required
    $portfolioThumbnail = trim($body['thumbnail']);
    if (empty($portfolioThumbnail)) {
        $errors['thumbnail']['required'] = 'Required field';
    }

    // Portfolio video: Required
    $portfolioVideo = trim($body['video']);
    if (empty($portfolioVideo)) {
        $errors['video']['required'] = 'Required field';
    }

    // Portfolio content: Required
    $portfolioContent = trim($body['content']);
    if (empty($portfolioContent)) {
        $errors['content']['required'] = 'Required field';
    }

    if (empty($errors)) {
        // Validation successful

        // Update portfolio in table 'portfolios'
        $dataUpdate = [
            'name' => $portfolioName,
            'slug' => $portfolioSlug,
            'portfolio_category_id' => $portfolioCategory,
            'thumbnail' => $portfolioThumbnail,
            'video' => $portfolioVideo,
            'description' => trim($body['description']),
            'content' => $portfolioContent,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $condition = "id=:id";
        $dataCondition = ['id' => $portfolioId];
        $isDataUpdated = update('portfolios', $dataUpdate, $condition, $dataCondition);

        if ($isDataUpdated) {
            setFlashData('msg', 'Portfolio has been updated successfully.');
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

    redirect('admin/?module=portfolios&action=edit&id=' . $portfolioId);
}

// Retrieve category data for  <select name="portfolio_category_id">
$categories = getAllRows("SELECT id, name FROM portfolio_categories ORDER BY name");

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
if (empty($errors)) {
    $formValues = $portfolioDetails;
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
                    <input type="hidden" name="id" value="<?php echo $portfolioId; ?>">
                    <div class="card-body">
                        <?php echo getMessage($msg, $msgType); ?>
                        <div class="form-group">
                            <label for="portfolio-name">Portfolio Name</label>
                            <input type="text" name="name" class="form-control source-title"
                                   id="portfolio-name" placeholder="Portfolio Name..."
                                   value="<?php echo getOldFormValue('name', $formValues); ?>">
                            <?php echo getFormErrorMsg('name', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="page-slug">URL-friendly Slug</label>
                            <input type="text" name="slug" class="form-control render-slug"
                                   id="page-slug" placeholder="URL-friendly Slug..."
                                   value="<?php echo getOldFormValue('slug', $formValues); ?>">
                            <?php echo getFormErrorMsg('slug', $errors); ?>
                        </div>

                        <div class="form-group">
                            <p class="render-link"><b>Portfolio URL: </b> <span></span></p>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="portfolio_category_id" class="form-control">
                                <option value="">
                                    Choose Category
                                </option>
                                <?php
                                if (!empty($categories)):
                                    foreach ($categories as $category):
                                        ?>
                                        <option value="<?php echo $category['id']; ?>"
                                            <?php
                                            echo (getOldFormValue('portfolio_category_id', $formValues)
                                                == $category['id'])
                                                ? 'selected'
                                                : null; ?>
                                        >
                                            <?php echo $category['name']; ?>
                                        </option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                            <?php echo getFormErrorMsg('portfolio_category_id', $errors); ?>
                        </div>

                        <div class="form-group ckfinder-group">
                            <label for="">Thumbnail</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" name="thumbnail" class="form-control ckfinder-render-img"
                                           placeholder="Insert icon tag or choose image..."
                                           value="<?php echo getOldFormValue('thumbnail', $formValues); ?>">
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-success btn-block ckfinder-choose-img">
                                        <i class="fas fa-upload"></i>
                                        <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="ckfinder-show-image image-popup" style="cursor: pointer"></span>
                            </div>
                            <?php echo getFormErrorMsg('thumbnail', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="portfolio-video">Video URL</label>
                            <input type="url" name="video" class="form-control"
                                   id="portfolio-video" placeholder="https://www.youtube.com/..."
                                   value="<?php echo getOldFormValue('video', $formValues); ?>">
                            <?php echo getFormErrorMsg('video', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="portfolio-description">Description</label>
                            <textarea name="description" class="form-control"
                                      id="portfolio-description" placeholder="Description..."
                            ><?php echo getOldFormValue('description', $formValues); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" class="form-control editor"
                            ><?php echo getOldFormValue('content', $formValues); ?></textarea>
                            <?php echo getFormErrorMsg('content', $errors); ?>
                        </div>

                    </div> <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Update</button>
                        <a href="<?php echo getAbsUrlAdmin('portfolios'); ?>"
                           class="btn btn-outline-secondary px-4 float-right">
                            Back
                        </a>
                        <a href="<?php echo getAbsUrlAdmin('portfolios', 'edit') . '&id=' . $portfolioId; ?>"
                           class="btn btn-outline-success px-4 mr-2 float-right">
                            Reset
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
