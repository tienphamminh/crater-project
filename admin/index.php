<?php

session_start();
ob_start();

require_once '../config.php';

require_once '../includes/phpmailer/Exception.php';
require_once '../includes/phpmailer/PHPMailer.php';
require_once '../includes/phpmailer/SMTP.php';

require_once '../includes/functions.php';
require_once '../includes/connect.php';
require_once '../includes/database.php';
require_once '../includes/session.php';
require_once '../includes/exception.php';
require_once '../includes/permalink.php';

ini_set('display_errors', 0);
error_reporting(0);

// Register function: 'callbackErrorHandler' as a default error handler
set_error_handler('callbackErrorHandler');
// Register function: 'callbackExceptionHandler' as a default exception handler (Global exception handler)
set_exception_handler('callbackExceptionHandler');

if (_DEBUG) {
    // Debug On
    $debugError = getFlashData('debug_error');
    if (!empty($debugError)) {
        require_once 'modules/errors/debug.php';
        exit;
    }
} else {
    // Debug Off
    $serverError = getFlashData('server_error');
    if (!empty($serverError)) {
        http_response_code(500);
        require_once 'modules/errors/500.php';
        exit;
    }
}

$module = getCurrentModule();
if (empty($module)) {
    $module = _DEFAULT_ADMIN_MODULE;
}

$action = getCurrentAction();
if (empty($action)) {
    $action = _DEFAULT_ADMIN_ACTION;
}

$path = 'modules/' . $module . '/' . $action . '.php';
if (file_exists($path)) {
    require_once $path;
} else {
    http_response_code(404);
    require_once 'modules/errors/404.php';
    exit;
}
