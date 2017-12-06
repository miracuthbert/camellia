<?php

    /**
     * Start Session
     */
    ob_start();
    session_start();

    /**
     * App Settings
     */
    define("APP_NAME", "Camellia");
    define("APP_CURRENCY", "KShs.");
    define("APP_URL", "/camellia");

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