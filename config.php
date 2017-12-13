<?php

    /**
     * Start Session
     */
    ob_start();
    session_start();

    /**
     * Directory Settings
     */
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));


    /**
     * App Settings
     */
    define("APP_NAME", "Camellia Restaurant");
    define("APP_CURRENCY", "Rwf.");
    define("APP_URL", "/camellia");
    define("APP_DIR", "camellia");

    /**
     * Database Settings
     */

    define("DB_HOST", "localhost"); //host name
    define("DB_NAME", "camellia_db");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");

    $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($con->connect_errno > 0) {
        die("Connection failed: " .$db->connect_error);
    }