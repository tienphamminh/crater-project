<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Add Blog'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

if (isPost()) {
    $body = getBody();
    $errors = [];

    // Blog title: Required
    $blogTitle = trim($body['title']);
    if (empty($blogTitle)) {
        $errors['title']['required'] = 'Required field';
    }

    // Blog slug: Required, valid format
    $blogSlug = trim($body['slug']);
    if (empty($blogSlug)) {
        $errors['slug']['required'] = 'Required field';
    } elseif (!isSlug($blogSlug)) {
        $errors['slug']['isSlug'] = 'Invalid slug format';
    }

    // Blog category: Required
    $blogCategory = trim($body['blog_category_id']);
    if (empty($blogCategory)) {
        $errors['blog_category_id']['required'] = 'Required field';
    }

    // Blog thumbnail: Required
    $blogThumbnail = trim($body['thumbnail']);
    if (empty($blogThumbnail)) {
        $errors['thumbnail']['required'] = 'Required field';
    }

    // Blog content: Required
    $blogContent = trim($body['content']);
    if (empty($blogContent)) {
        $errors['content']['required'] = 'Required field';
    }

    if (empty($errors)) {
        // Validation successful

        // Insert into table 'blogs'
        $dataInsert = [
            'title' => $blogTitle,
            'slug' => $blogSlug,
            'blog_category_id' => $blogCategory,
            'thumbnail' => $blogThumbnail,
            'description' => trim($body['description']),
            'content' => $blogContent,
            'user_id' => getSession('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $isDataInserted = insert('blogs', $dataInsert);

        if ($isDataInserted) {
            setFlashData('msg', 'Blog has been added successfully.');
            setFlashData('msg_type', 'success');
            redirect('admin/?module=blogs');
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

    redirect('admin/?module=blogs&action=add');
}

// Retrieve category data for  <select name="blog_category_id">
$categories = getAllRows("SELECT id, name FROM blog_categories ORDER BY name");

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
                            <label for="blog-title">Blog Title</label>
                            <input type="text" name="title" class="form-control source-title"
                                   id="blog-title" placeholder="Blog Title..."
                                   value="<?php echo getOldFormValue('title', $oldValues); ?>">
                            <?php echo getFormErrorMsg('title', $errors); ?>
                        </div>

                        <div class="form-group">
                            <label for="blog-slug">Blog Slug</label>
                            <input type="text" name="slug" class="form-control render-slug"
                                   id="blog-slug" placeholder="Blog Slug..."
                                   value="<?php echo getOldFormValue('slug', $oldValues); ?>">
                            <?php echo getFormErrorMsg('slug', $errors); ?>
                        </div>

                        <div class="form-group">
                            <p class="render-link"><b>Blog URL: </b> <span></span></p>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="blog_category_id" class="form-control">
                                <option value="">
                                    Choose Category
                                </option>
                                <?php
                                if (!empty($categories)):
                                    foreach ($categories as $category):
                                        ?>
                                        <option value="<?php echo $category['id']; ?>"
                                            <?php
                                            echo (getOldFormValue('blog_category_id', $oldValues)
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
                            <?php echo getFormErrorMsg('blog_category_id', $errors); ?>
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

                        <div class="form-group">
                            <label for="blog-description">Description</label>
                            <textarea name="description" class="form-control"
                                      id="blog-description" placeholder="Description..."
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
                        <a href="<?php echo getAbsUrlAdmin('blogs'); ?>"
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
