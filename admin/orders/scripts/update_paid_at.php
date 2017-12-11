<?php

include_once "../../../config.php";
include_once('../../../helpers.php');
include_once('../../../functions.php');

global $con;

if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {

    //catch post data
    $id = $_POST['_id'];
    $user = auth();

    //activate mysqli reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $con->autocommit(FALSE); //turn on transactions
        //create new order
        $stmt = $con->prepare("INSERT INTO `order_payments` (`order_id`, `user_id`) VALUES (?, ?)");
        $stmt->bind_param("ii", $id, $user['id']);
        $stmt->execute();
        $paymentId = $stmt->insert_id;   //catch order payment id

        //update
        $stmt = $con->prepare("UPDATE `orders` SET `paid_at` = CURRENT_TIMESTAMP WHERE `id` = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt->close();
        $con->autocommit(TRUE); //turn off transactions + commit queued queries

        //set success message
        $_SESSION['success'] = "Order status set to `paid` successfully.";

        //redirect to orders index
        return header("Location: " . route('admin/orders/index.php'));
    } catch (Exception $e) {
        $con->rollback(); //remove all queries from queue if error (undo)

        //call chained functions of $e to get more error reports;
        // //use in development
        $_SESSION['errors'] = [
            $e->getMessage()
        ];

        error_log($e); //use in production
    }

    $_SESSION['error'] = "Order status update failed.";

    return header("Location: " . route("admin/orders/edit.php?order=$id"));
}

return header("Location: " . route("admin/orders/index.php"));
