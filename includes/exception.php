<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Convert error reporting to exceptions (only works with non-fatal errors)
function callbackErrorHandler($severity, $message, $filename, $lineno)
{
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
}

// Catch exception if it is not caught within a try/catch block
function callbackExceptionHandler(Throwable $exception): void
{
    if (_DEBUG) {
        // Debug On
        setFlashData('debug_error', [
            'error_message' => $exception->getMessage(),
            'error_file' => $exception->getFile(),
            'error_line' => $exception->getLine()
        ]);
    } else {
        // Debug Off
        setFlashData('server_error', 1);
    }

    $path = 'admin/';
    if (!empty($_SERVER['QUERY_STRING'])) {
        $path .= '?' . trim($_SERVER['QUERY_STRING']);
    }
    redirect($path);
}
