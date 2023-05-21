<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

/*Write functions to handle permalink*/

function getPrefixUrl(): ?string
{
    $currentModule = getCurrentModule();
    $prefixUrls = [
        'services' => 'dich-vu',
        'pages' => 'thong-tin'
    ];
    if (!empty($prefixUrls[$currentModule])) {
        return $prefixUrls[$currentModule];
    }

    return null;
}
