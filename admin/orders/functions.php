<?php

include_once("../../config.php");

if (!function_exists('orders')) {
    /**
     * Fetch orders.
     * 
     * @param array $parameters
     * @return array|mixed
     */
    function orders($parameters = [])
    {

        global $con;
        $false = false;
        $true = true;

        $rows = [];

        $stmt = $con->prepare("SELECT 
                                        `orders`.*, 
                                        `users`.`first_name`, `users`.`last_name` 
                                        FROM 
                                          `orders` 
                                        INNER JOIN 
                                          `users` 
                                        ON 
                                          `users`.`id` = `orders`.`user_id` 
                                          ORDER BY 
                                          `created_at` DESC,  
                                          `booked_at` DESC");

        if (isset($_GET["user"])) {
            $user = $_GET['user'];

            //find meals order
            $stmt = $con->prepare("SELECT
                                        `orders`.*,
                                        `users`.`first_name`, `users`.`last_name`
                                        FROM
                                          `orders`
                                        INNER JOIN
                                          `users`
                                        ON
                                          `users`.`id` = `orders`.`user_id`
                                        WHERE
                                          `orders`.`user_id` = ?
                                        ORDER BY
                                          `created_at` DESC, 
                                          `booked_at` DESC");
            $stmt->bind_param("i", $user);
        }

        if (isset($parameters) && isset($parameters["status"]) && $parameters['status'] == "pending") {

            //find meals order
            $stmt = $con->prepare("SELECT
                                        `orders`.*,
                                        `users`.`first_name`, `users`.`last_name`
                                        FROM
                                          `orders`
                                        INNER JOIN
                                          `users`
                                        ON
                                          `users`.`id` = `orders`.`user_id`
                                        WHERE
                                          `orders`.`paid_at` IS NULL
                                          AND 
                                            `orders`.`expired_at` IS NULL 
                                        ORDER BY
                                          `created_at` DESC, 
                                          `booked_at` DESC");
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $rows = $result->fetch_all(MYSQLI_BOTH);
        };

        $stmt->close();

        return $rows;
    }
}

if (!function_exists('pendingOrders')) {
    /**
     * Fetch pending orders.
     */
    function pendingOrders()
    {

        return orders(['status' => "pending"]);
    }
}

if (!function_exists('order')) {
    /**
     * Fetch passed order.
     *
     * @param $order
     * @return array|void
     */
    function order($order)
    {

        global $con;

        $row = [];

        if (!isset($order)) {

            //set success message
            $_SESSION['error'] = "Page not found.";

            //back to register with error
            return header("Location: " . route('admin/orders/index.php'));

        }

        $stmt = $con->prepare("SELECT * FROM `orders` WHERE `id` = ? LIMIT 1");
        $stmt->bind_param("i", $order);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            die('Page not found.');
        };

        $stmt->close();

        return $row;
    }
}

if (!function_exists('orderPayment')) {
    /**
     * Fetch passed order payment details.
     *
     * @param $order
     * @return array
     */
    function orderPayment($order)
    {

        global $con;

        $row = [];

        if (!isset($order)) {
            return $row;
        }

        $stmt = $con->prepare("SELECT * FROM `order_payments` WHERE `order_id` = ? LIMIT 1");
        $stmt->bind_param("i", $order);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        }

        $stmt->close();

        return $row;
    }
}

if (!function_exists('orderItems')) {
    /**
     * Fetch passed order items.
     */
    function orderItems($order)
    {

        global $con;

        $rows = [];

        if (!isset($order)) {

            return $rows;
        }

        $stmt = $con->prepare("SELECT
                                        `order_items`.*,
                                        `foods`.`name`,
                                        `foods`.`details`,
                                        `foods`.`image`
                                    FROM
                                        `order_items`
                                    INNER JOIN `foods` 
                                    WHERE 
                                    `order_items`.`food_id` = `foods`.`id` 
                                    AND `order_id` = ?");
        $stmt->bind_param("s", $order);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $rows = $result->fetch_all(MYSQLI_BOTH);
        }

        $stmt->close();

        return $rows;
    }
}
