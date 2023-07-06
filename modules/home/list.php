<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => ''];
addLayout('header', 'client', $dataHeader);

require_once 'sections/hero.php';
require_once 'sections/about.php';
require_once 'sections/service.php';
require_once 'sections/fact.php';
require_once 'sections/portfolio.php';
require_once 'sections/cta.php';
require_once 'sections/blog.php';
require_once 'sections/partner.php';

// Add Footer
addLayout('footer', 'client');
