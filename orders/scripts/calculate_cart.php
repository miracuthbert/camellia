<?php

    include_once "../../config.php";
    include_once "../../helpers.php";
    include_once "../../functions.php";

    if (isset($_POST)) {
        $_SESSION['old'] = $_POST;

        //catch orders
        $orders = $_POST['order'];
        $orderItems = $_POST['order_quantity'];
        $orderPrices = [];

        foreach ($orders as $key => $order) {
            //find food
            $food = food($order);

            //calculate total price
            $price = $food['price'] * $orderItems[$key];

            //push to price
            array_push($orderPrices, $price);

//            echo "{$key} . {$order} | {$orderItems[$key]} * {$food['price']} = ({$price}) .<br/>";
        }

        //create cart
        $_SESSION['cart']['orders'] = $orders;
        $_SESSION['cart']['orderQty'] = $orderItems;
        $_SESSION['cart']['orderPrices'] = $orderPrices;

        return header("Location: " . route("orders/cart.php"));
    }

    $_SESSION['error'] = "Please add at least one item to cart first before proceeding to cart.";

    header("Location: " . route("orders/menu.php"));