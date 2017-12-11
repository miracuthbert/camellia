<?php

include_once('../../../config.php');
include_once('../../../helpers.php');
include_once('../../../functions.php');

global $con;

if (isset($_POST)) {
    //store request in session
    $_SESSION['old'] = $_POST;

    //validate data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    if (!required($name)) {
        $_SESSION['errors']['name'] = "Name is required.";
    }

    if (!required($price)) {
        $_SESSION['errors']['price'] = "Price is required.";
    }

    if (!required($category)) {
        $_SESSION['errors']['category'] = "Category is required.";
    }

    if (!required($details)) {
        $_SESSION['errors']['details'] = "Details is required.";
    }

    if (!required($status)) {
        $_SESSION['errors']['status'] = "Status is required.";
    }

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route('admin/meals/create.php'));
    }

    //image upload
    $imagePath = null;

    //save
    $stmt = $con->prepare("INSERT INTO `foods` (`name`, `category_id`, `details`, `image`, `price`, `usable`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissdd", $name, $category, $details, $imagePath, $price, $status);
    $stmt->execute();

    if ($stmt->insert_id) {

        //unset login details
        unset($_SESSION['old']);

        //set success message
        $_SESSION['success'] = "Food added successfully.";

        //redirect to index with success
        return header("Location: " . route('admin/meals/index.php'));
    }

    //TODO: Comment line below if on production env
//    die(printf($stmt->error));

    $stmt->close();

}

//error
$_SESSION['error'] = "Failed adding meal. Try again!";

//back to create with error
return header("Location: " . route('admin/meals/create.php'));
