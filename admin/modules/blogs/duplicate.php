<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

$body = getBody();

if (!empty($body['id'])) {
    $blogId = $body['id'];
    $sql = "SELECT * FROM blogs WHERE id=:id";
    $data = ['id' => $blogId];
    $blogDetails = getFirstRow($sql, $data);
    if (!empty($blogDetails)) {
        $duplicate = $blogDetails['duplicate'];
        $duplicate++;
        $newBlogTitle = $blogDetails['title'] . ' (' . $duplicate . ')';
        $newBlogSlug = $blogDetails['slug'] . '-' . $duplicate;
        $blogDetails['title'] = $newBlogTitle;
        $blogDetails['slug'] = $newBlogSlug;
        $blogDetails['created_at'] = date('Y-m-d H:i:s');

        unset($blogDetails['id']);
        unset($blogDetails['duplicate']);
        unset($blogDetails['updated_at']);

        $isDataInserted = insert('blogs', $blogDetails);

        if ($isDataInserted) {
            setFlashData('msg', 'Blog has been duplicated successfully.');
            setFlashData('msg_type', 'success');

            // Update 'duplicate' field of the original blog
            $dataUpdate = ['duplicate' => $duplicate];
            $condition = "id=:id";
            $dataCondition = ['id' => $blogId];
            update('blogs', $dataUpdate, $condition, $dataCondition);

            redirect('admin/?module=blogs');
        }
    }
}

setFlashData('msg', 'Something went wrong, please try again.');
setFlashData('msg_type', 'danger');
redirect('admin/?module=blogs');
