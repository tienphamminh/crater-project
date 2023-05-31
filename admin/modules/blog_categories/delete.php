<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if category exists in table 'blog_categories'
        $categoryId = getBody()['id'];
        $sql = "SELECT id FROM blog_categories WHERE id=:id";
        $data = ['id' => $categoryId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Check how many blogs are left in the category
            $sql = "SELECT id FROM blogs WHERE blog_category_id=:category_id";
            $data = ['category_id' => $categoryId];
            $blogsLeft = getNumberOfRows($sql, $data);
            if ($blogsLeft > 0) {
                setFlashData('msg', 'Can not delete, this category still has ' . $blogsLeft . ' blogs left.');
                setFlashData('msg_type', 'danger');
                redirect('admin/?module=blog_categories');
            } else {
                // If there are no blogs left in the category, delete the category
                $condition = "id=:id";
                $dataCondition = ['id' => $categoryId];
                $isCategoryDeleted = delete('blog_categories', $condition, $dataCondition);
                if ($isCategoryDeleted) {
                    setFlashData('msg', 'Category has been deleted successfully.');
                    setFlashData('msg_type', 'success');
                    redirect('admin/?module=blog_categories');
                }
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=blog_categories');
