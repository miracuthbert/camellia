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

    //default user password when added from admin
    define("DEFAULT_USER_PASSWORD", "secret");

    //default pages to be after database is created
    define("DEFAULT_PAGES", 'home, about, help');

    //default page which posts can be displayed on
    define("DEFAULT_POSTS_PAGE", 'help');

    //default food and posts categories to be created when database is created
    define("DEFAULT_CATEGORIES", 'meals, drinks, posts');

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