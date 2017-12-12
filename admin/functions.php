<?php

if (!function_exists('categories')) {
    /**
     * Fetch categories.
     * @param array $parameter
     * @return array|mixed
     */
    function categories($parameter = [])
    {

        global $con;
        $false = false;
        $true = true;

        $rows = [];

        $stmt = $con->prepare("SELECT * FROM `categories` ORDER BY `created_at` DESC");

        if (isset($parameter) && isset($parameter["status"]) && isset($parameter["slug"])) {
            $slug = $parameter['slug'];

            //find meals category
            $stmt = $con->prepare("SELECT * FROM `categories` WHERE `slug` = ? ORDER BY `created_at` DESC");
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                exit("Category with slug `{$slug}` not found.");
            };
            $meal = $result->fetch_assoc();
            $stmt->close();

            //find meals category children
            $stmt = $con->prepare("SELECT * FROM `categories` WHERE `status` = ? AND `parent_id` = ? AND `parent_id` IS NOT NULL");
            $stmt->bind_param("ds", $true, $meal['id']);
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

if (!function_exists('category')) {
    /**
     * Fetch passed category.
     */
    function category($slug)
    {

        global $con;

        $row = [];

        if (!isset($slug)) {

            //set success message
            $_SESSION['error'] = "Page not found.";

            //back to register with error
            return header("Location: " . route('admin/categories/index.php'));

        }

        $stmt = $con->prepare("SELECT * FROM `categories` WHERE `slug` = ? ORDER BY `created_at` DESC");
        $stmt->bind_param("s", $slug);
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

if (!function_exists('meals')) {
    /**
     * Fetch meals.
     */
    function meals()
    {

        global $con;

        $false = false;
        $true = true;
        $slug = isset($_GET['category']) ? $_GET['category'] : 'meals';

        $categories = [];
        $children = [];
        $rows = [];

        //find meal category
        $stmt = $con->prepare("SELECT * FROM `categories` WHERE `slug` = ? ORDER BY `created_at` DESC");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            exit("Category with slug `{$slug}` not found.");
        };
        $meal = $result->fetch_assoc();
        $stmt->close();

        //find meal categories
        $stmt = $con->prepare("SELECT id FROM `categories` WHERE `status` = ? AND `parent_id` = ? AND `parent_id` IS NOT NULL");
        $stmt->bind_param("ds", $true, $meal['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            //log or fail
        }
        $categories = $result->fetch_all(MYSQLI_ASSOC);

        //build children
        foreach ($categories as $category) {
            array_push($children, $category['id']);
        }
        $stmt->close();

        //find foods
        $fullArr = array_merge($children, [$meal['id']]); //merge `parent` in WHERE IN array with other value(s)
        $clause = implode(',', array_fill(0, count($fullArr), '?')); //create `x` question marks
        $types = str_repeat('i', count($fullArr)); //create `x` ints for bind_param

        $stmt = $con->prepare("SELECT 
                                      `foods`.*, 
                                      `categories`.`id` AS `categoryId`, 
                                      `categories`.`name` AS `categoryName`, 
                                      `categories`.`slug` AS `categorySlug` 
                                        FROM `foods` 
                                          INNER JOIN 
                                            `categories` 
                                              ON `foods`.`category_id` = `categories`.`id` 
                                      WHERE `category_id` IN ($clause) 
                                        AND `foods`.`category_id` IS NOT NULL 
                                      ORDER BY `foods`.`created_at` DESC");
        $stmt->bind_param($types, ...$fullArr);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $rows = $result->fetch_all(MYSQLI_BOTH);
        };

        $stmt->close();

        return $rows;
    }
}

if (!function_exists('meal')) {
    /**
     * Fetch passed meal.
     */
    function meal($meal)
    {

        global $con;

        $row = [];

        if (!isset($meal)) {

            //set success message
            $_SESSION['error'] = "Page not found.";

            //back to register with error
            return header("Location: " . route('admin/meals/index.php'));

        }

        $stmt = $con->prepare("SELECT * FROM `foods` WHERE `id` = ?");
        $stmt->bind_param("i", $meal);
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
