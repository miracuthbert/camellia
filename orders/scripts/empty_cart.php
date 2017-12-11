<?php

    include_once "../../config.php";
    include_once "../../helpers.php";
    include_once "../../functions.php";

    if (isset($_POST)) {

        //check if cart exists and remove it
        if (isset($_SESSION['cart'])) {

            //remove cart from session
            unset($_SESSION['cart']);
            unset($_SESSION['old']);


            $_SESSION['success'] = "Your cart has been emptied. You can start adding new items again.";

            return header("Location: " . route("orders/menu.php"));

        }
    }

    $_SESSION['error'] = "Invalid request. Please try again.";

    return header("Location: " . route("orders/cart.php"));
