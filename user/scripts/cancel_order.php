<?php

include_once "../../config.php";
include_once('../../helpers.php');
include_once('../../functions.php');

global $con;

if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {

    //catch post data
    $id = $_POST['_id'];

    //update
    $stmt = $con->prepare("UPDATE `orders` SET `expired_at` = CURRENT_TIMESTAMP WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {

        //set success message
        $_SESSION['success'] = "Order cancelled successfully.";

        $stmt->close();

        //redirect to orders
        return header("Location: " . route("user/order.php?order={$id}"));
    }

    $stmt->close();

    //error
    $_SESSION['error'] = "Failed cancelling order. Please try again!";

    return header("Location: " . route("user/order.php?order={$id}"));

}

return header("Location: " . route("dashboard.php"));
