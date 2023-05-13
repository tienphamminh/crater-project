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
    if ($currentModule == 'services') {
        return 'dich-vu';
    }
    
    return null;
}
