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
require_once '../includes/permalink.php';


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
