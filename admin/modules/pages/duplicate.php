<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

$body = getBody();

if (!empty($body['id'])) {
    $pageId = $body['id'];
    $sql = "SELECT * FROM `pages` WHERE id=:id";
    $data = ['id' => $pageId];
    $pageDetails = getFirstRow($sql, $data);
    if (!empty($pageDetails)) {
        $duplicate = $pageDetails['duplicate'];
        $duplicate++;
        $newPageTitle = $pageDetails['title'] . ' (' . $duplicate . ')';
        $newPageSlug = $pageDetails['slug'] . '-' . $duplicate;
        $pageDetails['title'] = $newPageTitle;
        $pageDetails['slug'] = $newPageSlug;
        $pageDetails['created_at'] = date('Y-m-d H:i:s');

        unset($pageDetails['id']);
        unset($pageDetails['duplicate']);
        unset($pageDetails['updated_at']);

        $isDataInserted = insert('pages', $pageDetails);

        if ($isDataInserted) {
            setFlashData('msg', 'Page has been duplicated successfully.');
            setFlashData('msg_type', 'success');

            // Update 'duplicate' field of the original page
            $dataUpdate = ['duplicate' => $duplicate];
            $condition = "id=:id";
            $dataCondition = ['id' => $pageId];
            update('pages', $dataUpdate, $condition, $dataCondition);

            redirect('admin/?module=pages');
        }
    }
}

setFlashData('msg', 'Something went wrong, please try again.');
setFlashData('msg_type', 'danger');
redirect('admin/?module=pages');
