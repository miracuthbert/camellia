<?php

    include_once('../../../config.php');
    include_once('../../../helpers.php');
    include_once('../../../functions.php');

    global $con;

    if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {
        //store request in session
        $_SESSION['old'] = $_POST;

        //validate data
        $id = $_POST['_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_FILES['image'];
        $imageOld = $_POST['oldImage'];
        $details = $_POST['details'];
        $status = $_POST['status'];

        if (!required($name)) {
            $_SESSION['errors']['name'] = "Name is required.";
        }

        if (!required($price)) {
            $_SESSION['errors']['price'] = "Price is required.";
        }

        if ($category == "") {
            $_SESSION['errors']['category'] = "Category is required.";
        }

        if ($details == "") {
            $_SESSION['errors']['details'] = "Details is required.";
        }

        if (!required($status)) {
            $_SESSION['errors']['status'] = "Status is required.";
        }

        //check if image is not null
        if ($image['name'] != "") {
            //image upload
            $imagePath = imageUpload($image, "foods");
        }

        //check if image path is not null else set it to old path
        $imagePath = isset($imagePath) ? $imagePath : $imageOld;

        if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
            //back to create with error
            return header("Location: " . route("admin/meals/edit.php?meal={$id}"));
        }

        //save
        $stmt = $con->prepare("UPDATE `foods` SET `name` = ?, `category_id` = ?, `details` = ?, `image` = ?, `price` = ?, `usable` = ? WHERE `id` = ?");
        $stmt->bind_param("sissddi", $name, $category, $details, $imagePath, $price, $status, $id);
        $stmt->execute();

        if ($stmt->affected_rows) {

            //unset login details
            unset($_SESSION['old']);

            //set success message
            $_SESSION['success'] = "Food updated successfully.";

            //redirect to index with success
            return header("Location: " . route('admin/meals/index.php'));
        }

        //error
        $_SESSION['info'] = "No changes made.";

        $stmt->close();

        //back to edit with error
        return header("Location: " . route("admin/meals/edit.php?meal={$id}"));

    }

    //back to index with error
    return header("Location: " . route('admin/meals/index.php'));
