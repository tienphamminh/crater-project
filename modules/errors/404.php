<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>404 Not Found</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">

    <!-- Custom stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE; ?>/assets/css/style-error.css"/>
</head>

<body>

<div id="error-page">
    <div class="error-page">
        <div class="error-page-bg sad-emoji"></div>
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>
            Sorry, but the page you are looking for does not exist, has been removed, had its name changed, or is
            temporarily unavailable.
        </p>
        <a href="?module=home&action=list">Back to Homepage</a>
    </div>
</div>

</body>

</html>
