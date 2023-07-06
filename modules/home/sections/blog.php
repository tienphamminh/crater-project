<?php
// Retrieve data
$columnNames = "blogs.id, blogs.blog_category_id, blogs.title, blogs.description, blogs.thumbnail, blogs.views_count, blogs.created_at, blog_categories.name AS category_name";
$sql = "SELECT $columnNames FROM blogs INNER JOIN blog_categories ON blogs.blog_category_id=blog_categories.id ORDER BY blogs.created_at DESC";
$blogs = getAllRows($sql);
$homeBlog = json_decode(getOption('home_blog'), true);
if (!empty($homeBlog['general'])) {
    $blogGeneralOpts = json_decode($homeBlog['general'], true);
}
?>
<!-- Blogs Area -->
<section class="blogs-main section">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeInUp">
                <div class="section-title">
                        <span class="title-bg"><?php echo (!empty($blogGeneralOpts['bg_title']))
                                ? $blogGeneralOpts['bg_title'] : null; ?></span>
                    <?php echo (!empty($blogGeneralOpts['main_title']))
                        ? html_entity_decode($blogGeneralOpts['main_title']) : null; ?>
                </div>
            </div>
        </div>
        <?php
        if (!empty($blogs)) :
            $temp = $blogs;
            while (count($blogs) <= 4) {
                $blogs = array_merge($blogs, $temp);
            }
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="row blog-slider">
                        <?php foreach ($blogs as $blog): ?>
                            <div class="col-lg-4 col-12">
                                <!-- Single Blog -->
                                <div class="single-blog">
                                    <div class="blog-head">
                                        <img src="<?php echo $blog['thumbnail']; ?>"
                                             alt="#"/>
                                    </div>
                                    <div class="blog-bottom">
                                        <div class="blog-inner">
                                            <h4>
                                                <a href="#"><?php echo $blog['title']; ?></a>
                                            </h4>
                                            <p>
                                                <?php echo $blog['description']; ?>
                                            </p>
                                            <div class="meta">
                                                    <span><i class="fa fa-folder"></i><a
                                                                href="#"><?php echo $blog['category_name']; ?></a></span>
                                                <span><i class="fa fa-calendar"></i><?php
                                                    echo getFormattedDate($blog['created_at'], 'd-m-Y');
                                                    ?></span>
                                                <span><i class="fa fa-eye"></i><?php echo $blog['views_count']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Blog -->
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<!--/ End Blogs Area -->