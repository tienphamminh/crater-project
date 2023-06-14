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

    <title>Error</title>

    <!-- Custom stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_CORE_TEMPLATE; ?>/assets/css/style-error.css"/>
</head>

<body>

<div class="error-content">
    <label>Error</label>
    <ul>
        <?php if (!empty($debugError)): ?>
            <li><b>Message:</b> <?php echo $debugError['error_message']; ?></li>
            <li><b>File:</b> <?php echo $debugError['error_file']; ?></li>
            <li><b>Line:</b> <?php echo $debugError['error_line']; ?></li>
        <?php endif; ?>
    </ul>
</div>

</body>

</html>
