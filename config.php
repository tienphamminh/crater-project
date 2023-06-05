<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

// Prevent direct access to files from URL
const _INCODE = true;

// Debug Mode
const _DEBUG = true;

// Default module, default action
const _DEFAULT_MODULE = 'home';
const _DEFAULT_ACTION = 'list';

// Absolute path
const _DEFAULT_ADMIN_MODULE = 'dashboard';
const _DEFAULT_ADMIN_ACTION = 'list';

define('_WEB_HOST_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/crater-project');

const _WEB_HOST_ROOT_ADMIN = _WEB_HOST_ROOT . '/admin';
const _WEB_HOST_CLIENT_TEMPLATE = _WEB_HOST_ROOT . '/templates/client';
const _WEB_HOST_ADMIN_TEMPLATE = _WEB_HOST_ROOT . '/templates/admin';

const _DIR_PATH_ROOT = __DIR__;
const _DIR_PATH_TEMPLATE = _DIR_PATH_ROOT . '/templates';

// Database information
const _HOST = 'localhost';
const _DBNAME = 'crater_project';
const _USERNAME = 'root';
const _PASSWORD = '';
const _DRIVER = 'mysql';
