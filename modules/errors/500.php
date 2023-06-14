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

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo _WEB_HOST_CORE_TEMPLATE; ?>/assets/images/crater-favicon.png"/>

    <title>500 Internal Server Error</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">

    <!-- Custom stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_CORE_TEMPLATE; ?>/assets/css/style-error.css"/>
</head>

<body>

<div id="error-page">
    <div class="error-page">
        <div class="error-page-bg sad-emoji"></div>
        <h1>500</h1>
        <h2>Oops! Something went wrong</h2>
        <p>
            Sorry, something went wrong on our end.
            We are currently trying to fix the problem.
        </p>
        <a href="">Back to Homepage</a>
    </div>
</div>

</body>

</html>
