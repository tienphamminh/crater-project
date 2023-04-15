<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

/*Create a connection to MySQL using PDO*/
try {
    if (class_exists('PDO')) {
        $dsn = _DRIVER . ':dbname=' . _DBNAME . ';host=' . _HOST; // $dsn: Data Source Name
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Set the PDO error mode
        ];

        // Create connection
        $dbh = new PDO($dsn, _USERNAME, _PASSWORD, $options); // $dbh: database handle
    }
} catch (PDOException $e) {
    echo $e->getMessage() . '<br>';
    echo 'File: ' . $e->getFile() . ' - Line: ' . $e->getLine();
    exit;
}
