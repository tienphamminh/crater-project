<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isLoggedIn()) {
    $loginToken = getSession('login_token');
    $condition = "token=:token";
    $dataCondition = ['token' => $loginToken];
    delete('login_tokens', $condition, $dataCondition);

    // Get Session Timeout message before remove all session variables
    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');

    removeSession();

    // Then re-set Session Timeout message
    if (!empty($msg) && !empty($msgType)) {
        setFlashData('msg', $msg);
        setFlashData('msg_type', $msgType);
    }
}

redirect('admin/?module=auth&action=login');
