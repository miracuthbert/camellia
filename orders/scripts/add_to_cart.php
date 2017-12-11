<?php

    include_once "../../config.php";
    include_once "../../helpers.php";
    include_once "../../functions.php";

    if (isset($_POST)) {

        //catch input
        $order = $_POST['order'];
        $orderQty = $_POST['order_quantity'];

        //find food
        $food = food($order);

        //calculate total price
        $price = ($food['price'] * $orderQty);

        //create item for cart
        $item = [
            'id' => $order,
            'name' => $food['name'],
            'image' => $food['image'],
            'price' => $food['price'],
            'qty' => $orderQty,
            'totalPrice' => $price
        ];

        //create cart if it does not exist
        if (!isset($_SESSION['cart']['items'])) {
            $_SESSION['cart']['items'] = [];
        }

        //catch cart
        $cart = $_SESSION['cart']['items'];

        if(!array_key_exists($order, $cart)) {

            //assign new cart items
            $_SESSION['cart']['items'][$order] = $item;

            //assign new cart total
            $_SESSION['cart']['qty']++;
        }

        //redirect to menu with success
        $_SESSION['success'] = "`{$food['name']}` added to cart";

        return header("Location: " . route("orders/menu.php"));
    }

    return header("Location: " . route("orders/menu.php"));
