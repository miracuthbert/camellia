<?php

include_once "../../config.php";
include_once "../../helpers.php";
include_once "../../functions.php";
include_once "calculate_cart.php";

global $con;

if (isset($_POST)) {
    $_SESSION['old'] = $_POST;

    //catch input
    $orders = $_POST['order'];
    $orderQtys = $_POST['order_quantity'];

    if(isset($_POST['updateCart']) && $_POST['updateCart']) {  //check if only update cart

        //calculate cart
        calculateCart($orders, $orderQtys);

        return header("Location: " . route("orders/cart.php"));
    }

    //catch user
    $user = auth();

    //redirect to login if auth failed
    if (!isset($user)) {
        return header("Location: " . route("auth/login.php"));
    }

    //redirect if cart empty
    if (!isset($_SESSION['cart']['items'])) {
        return header("Location: " . route("orders/menu.php"));
    }

    //activate mysqli reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $con->autocommit(FALSE); //turn on transactions
        //create new order
        $stmt = $con->prepare("INSERT INTO `orders` (`user_id`, `booked_at`) VALUES (?, ?)");
        $stmt->bind_param("is", $user['id'], $bookedAt);
        $stmt->execute();
        $cart = $stmt->insert_id;   //catch order id

        //add items to order
        $stmt = $con->prepare("INSERT INTO `order_items` (`order_id`, `food_id`, `price`, `quantity`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iidi", $orderId, $foodId, $price, $quantity);

        //loop through orders
        foreach ($orders as $key => $item) {
            $orderId = $cart;   //order id
            $foodId = $item;   //food/item id
            $price = $_SESSION['cart']['items'][$item]['price'];
            $quantity = $orderQtys[$key];
            $stmt->execute();
        }

        //unset cart
        unset($_SESSION['cart']);
        unset($_SESSION['old']);

        $stmt->close();
        $con->autocommit(TRUE); //turn off transactions + commit queued queries

        //set success message
        $_SESSION['success'] = "Congratulations! Order placed successfully.";

        //redirect to user dashboard
        return header("Location: " . route("dashboard.php"));
    } catch (Exception $e) {
        $con->rollback(); //remove all queries from queue if error (undo)

//        echo $e; //use in development
//        $_SESSION['errors'] = [
//            $e->getMessage()
//        ];

        error_log($e); //use in production
    }

}

$_SESSION['error'] = "Some error occurred. Please try again!";

header("Location: " . route("orders/cart.php"));