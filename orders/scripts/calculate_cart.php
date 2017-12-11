<?php

function calculateCart($orders, $orderQtys)
{

    //check if no items are selected then redirect back
    if (!isset($orders) || !isset($orderQtys)) {
        $_SESSION['error'] = "Add at least one item to cart.";

        return header("Location: " . route("orders/menu.php"));
    }

    foreach ($orders as $key => $order) {
        $item = $_SESSION['cart']['items'][$order];

        $_SESSION['cart']['items'][$order]['qty'] = $orderQtys[$key];
        $_SESSION['cart']['items'][$order]['totalPrice'] = $item['price'] * $orderQtys[$key];
    }

    $_SESSION['success'] = "Cart updated successfully.";

    return header("Location: " . route("orders/cart.php"));
}
