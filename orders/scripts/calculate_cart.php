<?php

    include_once "../../config.php";
    include_once "../../helpers.php";
    include_once "../../functions.php";

    if (isset($_POST)) {
        $_SESSION['old'] = $_POST;

        //catch orders
        $orders = $_POST['order'];
        $orderItems = $_POST['order_quantity'];
        $foodPrices = [];
        $orderPrices = [];

        //check if no items are selected then redirect back
        if(!isset($orders) || !isset($orderItems)) {
            $_SESSION['error'] = "Add at least one item to cart.";

            return header("Location: " . route("orders/menu.php"));
        }

        foreach ($orders as $key => $order) {
            //find food
            $food = food($order);

            //push to food prices
            array_push($foodPrices, $food['price']);

            //calculate total price
            $price = $food['price'] * $orderItems[$key];

            //push to order price
            array_push($orderPrices, $price);

//            echo "{$key} . {$order} | {$orderItems[$key]} * {$food['price']} = ({$price}) .<br/>";
        }

        //create cart
        $_SESSION['cart']['orders'] = $orders;
        $_SESSION['cart']['orderQty'] = $orderItems;
        $_SESSION['cart']['orderPrices'] = $orderPrices;
        $_SESSION['cart']['foodPrices'] = $foodPrices;

        return header("Location: " . route("orders/cart.php"));
    }

    $_SESSION['error'] = "Please add at least one item to cart first before proceeding to cart.";

    header("Location: " . route("orders/menu.php"));