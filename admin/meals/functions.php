<?php

include_once("../../config.php");

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
