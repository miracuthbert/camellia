<?php

    include_once("../../config.php");

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
