<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if blog exists in table 'blogs'
        $blogId = getBody()['id'];
        $sql = "SELECT id FROM blogs WHERE id=:id";
        $data = ['id' => $blogId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Check how many comments are left in the blog
            $sql = "SELECT id FROM blog_comments WHERE blog_id=:blog_id";
            $data = ['blog_id' => $blogId];
            $commentsLeft = getNumberOfRows($sql, $data);
            if ($commentsLeft > 0) {
                setFlashData('msg', 'Can not delete, this blog still has ' . $commentsLeft . ' comments left.');
                setFlashData('msg_type', 'danger');
                redirect('admin/?module=blogs');
            } else {
                // If there are no comments left in the blog, delete the blog
                $condition = "id=:id";
                $dataCondition = ['id' => $blogId];
                $isBlogDeleted = delete('blogs', $condition, $dataCondition);
                if ($isBlogDeleted) {
                    setFlashData('msg', 'Blog has been deleted successfully.');
                    setFlashData('msg_type', 'success');
                    redirect('admin/?module=blogs');
                }
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=blogs');
