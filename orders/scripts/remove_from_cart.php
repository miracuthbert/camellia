<?php

    include_once "../../config.php";
    include_once "../../helpers.php";
    include_once "../../functions.php";


    if (isset($_POST)) {
        $id = $_POST['id'];

        if (isset($_SESSION['cart']) && isset($_SESSION['cart']['items'])) {

            if (isset($_SESSION['cart']['items'][$id])) {

                $name = $_SESSION['cart']['items'][$id]['name'];

                //remove item
                unset($_SESSION['cart']['items'][$id]);

                //decrement cart item qty
                $_SESSION['cart']['qty']--;

                //set success
                $_SESSION['success'] = "`{$name}` removed from cart.";

                if(cartTotal() >= 1) {
                    //redirect to cart
                    return header("Location: " . route("orders/cart.php"));
                }

                //unset cart
                unset($_SESSION['cart']);
                unset($_SESSION['old']);

                //redirect to menu with info
                $_SESSION['info'] = "Your cart has been emptied. You can start adding new items again.";
                return header("Location: " . route("orders/menu.php"));
            }

            //error if item does not exist
            $_SESSION['success'] = "You cannot remove an item that does not exist in cart.";

            return header("Location: " . route("orders/cart.php"));
        }

        //error if cart does not exist
        $_SESSION['error'] = "Add at least one item to cart.";

    }

    return header("Location: " . route("orders/menu.php"));
