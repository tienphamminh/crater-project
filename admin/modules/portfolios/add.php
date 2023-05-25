<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Add Portfolio'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
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

    // Gallery: Required if there is any image item
    if (!empty($body['gallery'])) {
        $imgItems = $body['gallery'];
        foreach ($imgItems as $key => $imgItem) {
            if (empty(trim($imgItem))) {
                $errors['gallery']['required'][$key] = 'Required field';
            }
        }
    }

    if (empty($errors)) {
        // Validation successful

        // Insert into table 'portfolios'
        $dataInsert = [
            'name' => $portfolioName,
            'slug' => $portfolioSlug,
            'portfolio_category_id' => $portfolioCategory,
            'thumbnail' => $portfolioThumbnail,
            'video' => $portfolioVideo,
            'description' => trim($body['description']),
            'content' => $portfolioContent,
            'user_id' => getSession('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $isDataInserted = insert('portfolios', $dataInsert);

        if ($isDataInserted) {
            // Insert gallery into table 'portfolio_images'
            $insertedId = getLastInsertedId();
            if (!empty($imgItems)) {
                foreach ($imgItems as $imgItem) {
                    $imgData = [
                        'portfolio_id' => $insertedId,
                        'image' => trim($imgItem),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    insert('portfolio_images', $imgData);
                }
            }

            setFlashData('msg', 'Portfolio has been added successfully.');
            setFlashData('msg_type', 'success');
            redirect('admin/?module=portfolios');
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

    redirect('admin/?module=portfolios&action=add');
}

// Retrieve category data for  <select name="portfolio_category_id">
$categories = getAllRows("SELECT id, name FROM portfolio_categories ORDER BY name");

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
                            <label for="portfolio-name">Portfolio Name</label>
                            <input type="text" name="name" class="form-control source-title"
                                   id="portfolio-name" placeholder="Portfolio Name..."
                                   value="<?php echo getOldFormValue('name', $oldValues); ?>">
                            <?php echo getFormErrorMsg('name', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="page-slug">URL-friendly Slug</label>
                            <input type="text" name="slug" class="form-control render-slug"
                                   id="page-slug" placeholder="URL-friendly Slug..."
                                   value="<?php echo getOldFormValue('slug', $oldValues); ?>">
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
                                            echo (getOldFormValue('portfolio_category_id', $oldValues)
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
                                           value="<?php echo getOldFormValue('thumbnail', $oldValues); ?>">
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-success btn-block ckfinder-choose-img">
                                        <i class="fas fa-upload"></i>
                                        <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                    </button>
                                </div>
                            </div>
                            <!-- '.ckfinder-show-img' must be inside '.ckfinder-group' -->
                            <div class="mt-2 ckfinder-show-img image-popup" style="width: 200px; cursor: pointer;">
                            </div>
                            <?php echo getFormErrorMsg('thumbnail', $errors); ?>
                        </div>

                        <div class=" form-group">
                            <label for="portfolio-video">Video URL</label>
                            <input type="url" name="video" class="form-control"
                                   id="portfolio-video" placeholder="https://www.youtube.com/..."
                                   value="<?php echo getOldFormValue('video', $oldValues); ?>">
                            <?php echo getFormErrorMsg('video', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="portfolio-description">Description</label>
                            <textarea name="description" class="form-control"
                                      id="portfolio-description" placeholder="Description..."
                            ><?php echo getOldFormValue('description', $oldValues); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" class="form-control editor"
                            ><?php echo getOldFormValue('content', $oldValues); ?></textarea>
                            <?php echo getFormErrorMsg('content', $errors); ?>
                        </div>

                        <div class="form-group img-gallery-container">
                            <label for="">Gallery</label>
                            <!-- Image gallery -->
                            <div class="img-gallery" id="sortable">
                                <?php
                                if (!empty($errors['gallery'])) {
                                    $galleryErrors = reset($errors['gallery']);
                                }
                                $oldImgItems = getOldFormValue('gallery', $oldValues);
                                if (!empty($oldImgItems)):
                                    foreach ($oldImgItems as $key => $oldImgItem):
                                        ?>
                                        <!-- Image item -->
                                        <div class="img-item ckfinder-group">
                                            <div class="row">
                                                <div class="col-10 col-xl-11">
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="gallery[]" readonly
                                                               class="form-control ckfinder-render-img img-item-popup"
                                                               placeholder="Choose image..." style="cursor: pointer"
                                                               value="<?php echo (!empty($oldImgItem)) ? $oldImgItem : null; ?>">
                                                        <!-- Browse Button -->
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-success"
                                                                    id="choose-img-item-<?php echo $key; ?>">
                                                                <i class="fas fa-upload"></i>
                                                                <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2 col-xl-1">
                                                    <div class="d-flex">
                                                        <!-- Delete Button -->
                                                        <div style="width: 65%">
                                                            <button type="button" class="btn btn-danger btn-block"
                                                                    id="remove-img-item-<?php echo $key; ?>">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <!-- Drag Handle -->
                                                        <div class="ml-auto d-flex align-items-center drag-handle"
                                                             style="width: 20%; cursor: move;">
                                                            <i class="fas fa-sort fa-lg text-secondary"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (!empty($galleryErrors[$key])): ?>
                                                <div class="mt-n3 mb-2">
                                                    <small class="text-danger"><?php echo $galleryErrors[$key]; ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </div> <!-- /.img-item -->
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </div> <!-- /.img-gallery -->
                            <!-- Add Image Button -->
                            <button type="button" class="btn btn-warning add-img-item">
                                <i class="fas fa-plus mr-1"></i> Add Image
                            </button>
                        </div> <!-- /.form-group -->

                    </div> <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary px-4 float-left">Add</button>
                        <a href="<?php echo getAbsUrlAdmin('portfolios'); ?>"
                           class="btn btn-outline-secondary px-4 float-right">
                            Back
                        </a>
                    </div>
                </form>
            </div> <!-- /.card -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Image Modal
addLayout('modal-image', 'admin');
// Add Footer
addLayout('footer', 'admin');
