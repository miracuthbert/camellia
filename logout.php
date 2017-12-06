<?php
    include_once("config.php");

    session_destroy();
    session_start();

    $_SESSION['success'] = "You have successfully logged out. See you soon!";

    return header("Location: /camellia");
