<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if page exists in table 'pages'
        $pageId = getBody()['id'];
        $sql = "SELECT id FROM pages WHERE id=:id";
        $data = ['id' => $pageId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Delete the page
            $condition = "id=:id";
            $dataCondition = ['id' => $pageId];
            $isPageDeleted = delete('pages', $condition, $dataCondition);
            if ($isPageDeleted) {
                setFlashData('msg', 'Page has been deleted successfully.');
                setFlashData('msg_type', 'success');
                redirect('admin/?module=pages');
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=pages');
