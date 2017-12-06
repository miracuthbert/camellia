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
if (!function_exists('orderFoods')) {
    /**
     * Fetch foods.
     */
    function orderFoods()
    {

        global $con;

        $true = true;

        if (!isset($_SESSION['cart']['orders'])
            && !isset($_SESSION['cart']['orderQty'])
            && !isset($_SESSION['cart']['orderPrices'])) {
            $_SESSION['error'] = "Please add at least one item to cart, before checkout";

            return header("Location: " . route("orders/menu.php"));
        }

        $fullArr = $_SESSION['cart']['orders']; //merge `parent` in WHERE IN array with other value(s)
        $clause = implode(',', array_fill(0, count($fullArr), '?')); //create `x` question marks

        array_push($fullArr, $true);

        $types = str_repeat('i', (count($fullArr))); //create `x` ints for bind_param


        //find foods
        $stmt = $con->prepare("SELECT 
                                      `foods`.*, 
                                      `categories`.`id` AS `categoryId`, 
                                      `categories`.`name` AS `categoryName`, 
                                      `categories`.`slug` AS `categorySlug` 
                                        FROM `foods` 
                                          INNER JOIN 
                                            `categories` 
                                              ON `foods`.`category_id` = `categories`.`id` 
                                      WHERE `foods`.`id` IN ($clause)
                                        AND `foods`.`usable` = ? 
                                        AND `foods`.`usable` IS NOT NULL 
                                        AND `foods`.`category_id` IS NOT NULL");
        $stmt->bind_param($types, ...$fullArr);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['error'] = "Please add at least one item to cart, before checkout";

            return header("Location: " . route("orders/menu.php"));
        };
        $rows = $result->fetch_all(MYSQLI_BOTH);

        $stmt->close();

        return $rows;
    }
}

if (!function_exists('cartTotal')) {
    /**
     * Calculate cart total.
     */
    function cartTotal()
    {
        $total = 0;

        if(isset($_SESSION['cart']['orders']) && isset($_SESSION['cart']['orderPrices'])) {
            foreach ($_SESSION['cart']['orderPrices'] as $orderPrice) {
                $total += $orderPrice;
            }
        }

        return $total;
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