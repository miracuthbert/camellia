<?php

include_once "helpers.php";

if (!function_exists('authenticated')) {
    /**
     * Redirect if logged in.
     */
    function authenticated()
    {
        if (auth_check()) {
            return header("Location: " . route('orders/menu.php'));
        }
    }
}

if (!function_exists('unauthenticated')) {
    /**
     * Redirect unauthenticated to log in.
     */
    function unauthenticated()
    {
        if (!auth_check()) {
            return header("Location: " . route("auth/login.php"));
        }
    }
}

if (!function_exists('userById')) {
    /**
     * Fetch passed user.
     *
     * @param $user
     * @return array
     */
    function userById($user)
    {

        global $con;

        $row = [];

        if (!isset($user)) {
            return $row;
        }

        $stmt = $con->prepare("SELECT * FROM `users` WHERE `id` = ? LIMIT 1");
        $stmt->bind_param("i", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        }

        $stmt->close();

        return $row;
    }
}

if (!function_exists('hasRoles')) {
    /**
     * Check if user has roles.
     * @param $user
     * @param null $role
     * @param bool $expired
     * @return bool
     */
    function hasRoles($user, $role = null, $expired = false)
    {
        global $con;

        //holds
        $roleable = false;

        if (isset($user)) {

            if (isset($role)) { //with role
                $row = [];

                //get role
                $_stmt = $con->prepare("SELECT * FROM `roles` WHERE `slug` = ? AND `slug` IS NOT NULL");
                $_stmt->bind_param("s", $role);
                $_stmt->execute();

                //get result
                $result = $_stmt->get_result();

                //check if role exists
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();

                    if (($expired == true)) {   //with role but expired
                        $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `user_id` = ?  AND `role_id` = ? AND `expired_at` IS NOT NULL LIMIT 1");
                    } else {
                        $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `user_id` = ?  AND `role_id` = ? AND `expired_at` IS NULL LIMIT 1");
                    }

                    $stmt->bind_param("ii", $user, $row['id']);
                } else {
                    $roleable = false;
                }

            } else {//default (has role and it has not expired)
                $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `user_id` = ? AND `expired_at` IS NULL");
                $stmt->bind_param("i", $user);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows >= 1) {
                $roleable = true;
            }

            $stmt->close();
        }

        return $roleable;
    }
}

if (!function_exists('getRoles')) {
    /**
     * Get the user's roles/specified role.
     *
     * @param $user
     * @param null $role
     * @param bool $expired
     * @return bool
     */
    function getRoles($user, $role = null, $expired = false)
    {
        global $con;

        //holds
        $roles = [];

        if (isset($user)) {

            if (isset($role)) { //with role
                $row = [];

                //get role
                $_stmt = $con->prepare("SELECT * FROM `roles` WHERE `slug` = ? AND `slug` IS NOT NULL");
                $_stmt->bind_param("s", $role);
                $_stmt->execute();

                //get result
                $result = $_stmt->get_result();

                //check if role exists
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();

                    if (($expired == true)) {   //with role but expired
                        $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `user_id` = ?  AND `role_id` = ? AND `expired_at` IS NOT NULL LIMIT 1");
                    } else {
                        $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `user_id` = ?  AND `role_id` = ? AND `expired_at` IS NULL LIMIT 1");
                    }

                    $stmt->bind_param("ii", $user, $row['id']);
                }

            } else {//default (has role and it has not expired)
                $stmt = $con->prepare("SELECT * FROM `user_roles` WHERE `user_id` = ? AND `expired_at` IS NULL");
                $stmt->bind_param("i", $user);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows >= 1) {
                $roles = $result->fetch_all(MYSQLI_BOTH);
            }

            $stmt->close();
        }

        return $roles;
    }
}

if (!function_exists('foods')) {
    /**
     * Fetch foods.
     */
    function foods()
    {

        global $con;

        $true = true;

        $stmt = $con->prepare("SELECT 
                                          `foods`.*, 
                                          `categories`.`id` AS `categoryId`, 
                                          `categories`.`name` AS `categoryName`, 
                                          `categories`.`slug` AS `categorySlug` 
                                            FROM `foods` 
                                              INNER JOIN 
                                                `categories` 
                                                  ON `foods`.`category_id` = `categories`.`id` 
                                          WHERE `foods`.`usable` = ? 
                                            AND `foods`.`usable` IS NOT NULL 
                                            AND `foods`.`category_id` IS NOT NULL 
                                          ORDER BY `categories`.`name` DESC");
        $stmt->bind_param("d", $true);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $rows = $result->fetch_all(MYSQLI_BOTH);
        };

        $stmt->close();

        return $rows;
    }
}

//if (!function_exists('orderFoods')) {
//    /**
//     * Fetch foods.
//     */
//    function orderFoods()
//    {
//
//        global $con;
//
//        $true = true;
//
//        if (!isset($_SESSION['cart']['items'])) {
//            $_SESSION['error'] = "Please add at least one item to cart, before checkout";
//
//            return header("Location: " . route("orders/menu.php"));
//        }
//
//        $fullArr = array_keys($_SESSION['cart']['items'], 'id'); //merge `parent` in WHERE IN array with other value(s)
//        $clause = implode(',', array_fill(0, count($fullArr), '?')); //create `x` question marks
//
//        array_push($fullArr, $true);
//
//        $types = str_repeat('i', (count($fullArr))); //create `x` ints for bind_param
//
//
//        //find foods
//        $stmt = $con->prepare("SELECT
//                                      `foods`.*,
//                                      `categories`.`id` AS `categoryId`,
//                                      `categories`.`name` AS `categoryName`,
//                                      `categories`.`slug` AS `categorySlug`
//                                        FROM `foods`
//                                          INNER JOIN
//                                            `categories`
//                                              ON `foods`.`category_id` = `categories`.`id`
//                                      WHERE `foods`.`id` IN ($clause)
//                                        AND `foods`.`usable` = ?
//                                        AND `foods`.`usable` IS NOT NULL
//                                        AND `foods`.`category_id` IS NOT NULL");
//        $stmt->bind_param($types, ...$fullArr);
//        $stmt->execute();
//        $result = $stmt->get_result();
//
//        if ($result->num_rows === 0) {
//            $_SESSION['error'] = "Please add at least one item to cart, before checkout";
//
//            return header("Location: " . route("orders/menu.php"));
//        };
//        $rows = $result->fetch_all(MYSQLI_BOTH);
//
//        $stmt->close();
//
//        return $rows;
//    }
//}

if (!function_exists('cartTotal')) {
    /**
     * Calculate cart total.
     */
    function cartTotal()
    {
        $total = 0;

        if (isset($_SESSION['cart']['items']) && count($_SESSION['cart']['items'])) {
            foreach ($_SESSION['cart']['items'] as $item) {
                $total += $item['totalPrice'];
            }
        }

        return $total;
    }
}

if (!function_exists('cartEmpty')) {
    /**
     * Checks if cart is empty and redirects to menu.
     */
    function cartEmpty()
    {

        if (!isset($_SESSION['cart']['items']) || count($_SESSION['cart']['items']) <= 0) {
            $_SESSION['info'] = "Your cart is empty. Add at least one item first.";

            return header("Location: " . route("orders/menu.php"));
        }
    }
}

if (!function_exists('food')) {
    /**
     * Fetch passed food.
     */
    function food($food)
    {

        global $con;

        $row = [];

        if (!isset($food)) {

            //set success message
            $_SESSION['error'] = "Page not found.";

            //back to register with error
            return header("Location: " . route('orders/menu.php'));

        }

        $stmt = $con->prepare("SELECT * FROM `foods` WHERE `id` = ?");
        $stmt->bind_param("i", $food);
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

if (!function_exists('orderTotal')) {
    /**
     * Fetch total for passed order.
     * @param $order
     * @return mixed|null
     */
    function orderTotal($order)
    {

        global $con;

        $row = [];

        if (!isset($order)) {
            return null;
        }

        $stmt = $con->prepare("SELECT
                                        SUM(
                                            (
                                                `order_items`.`price` * `order_items`.`quantity`
                                            )
                                        ) AS `order_total`
                                    FROM
                                        `orders`
                                    INNER JOIN `order_items` 
                                    WHERE 
                                    `orders`.`id` = `order_items`.`order_id` 
                                    AND `order_id` = ? LIMIT 1");
        $stmt->bind_param("i", $order);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        }

        $stmt->close();

        return $row['order_total'];
    }
}

if (!function_exists('orderItemsCount')) {
    /**
     * Fetch item count for passed order.
     * @param $order
     * @return mixed|null
     */
    function orderItemsCount($order)
    {

        global $con;

        $row = [];

        if (!isset($order)) {
            return null;
        }

        $stmt = $con->prepare("SELECT
                                        COUNT(`order_items`.id) AS `order_items_count`
                                    FROM
                                        `orders`
                                    INNER JOIN `order_items` 
                                    WHERE 
                                    `orders`.`id` = `order_items`.`order_id` 
                                    AND `order_id` = ? LIMIT 1");
        $stmt->bind_param("i", $order);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        }

        $stmt->close();

        return $row['order_items_count'];
    }
}

if (!function_exists('userOrders')) {
    /**
     * Fetch orders placed by a given user /(logged in user).
     *
     * @param null $user
     * @return array|mixed|void
     */
    function userOrders($user = null)
    {

        global $con;

        $rows = [];

        $user = isset($user) ? $user : auth();

        //redirect to login if auth failed
        if (!isset($user)) {
            return header("Location: " . route("auth/login.php"));
        }

        $userId = isset($user['id']) ? $user['id'] : $user;

        $stmt = $con->prepare("SELECT * FROM `orders` WHERE `user_id` = ? ORDER BY `created_at` DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_BOTH);
        }

        $stmt->close();

        return $rows;
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

if (!function_exists('cancelExpired')) {
    /**
     * Cancel all orders that are past current date.
     *
     * @param null $user
     * @return int
     */
    function cancelExpired($user = null)
    {

        global $con;

        $rows = 0;

        if(isset($user)) {
            $id = auth()['id'];
            $stmt = $con->prepare("UPDATE `orders` SET `expired_at` = CURRENT_TIMESTAMP WHERE `user_id` = ? AND `booked_at` < CURRENT_DATE");
            $stmt->bind_param("i", $id);
        } else {
            $stmt = $con->prepare("UPDATE `orders` SET `expired_at` = CURRENT_TIMESTAMP WHERE `booked_at` < CURRENT_DATE");
        }
        $stmt->execute();

        if ($stmt->affected_rows >= 1) {
            $rows = $stmt->affected_rows;
        }

        $stmt->close();

        return $rows;
    }
}

/**
 * call automated functions below
 */
//cancel all orders with booked_at less than current date
cancelExpired();