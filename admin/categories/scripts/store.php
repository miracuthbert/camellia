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
    $parent = $_POST['parent'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    if (!required($name)) {
        $_SESSION['errors']['name'] = "Name is required.";
    }

    if (!required($details)) {
        $_SESSION['errors']['details'] = "Details is required.";
    }

    if (!required($status)) {
        $_SESSION['errors']['status'] = "Status is required.";
    }

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route('admin/categories/create.php'));
    }

    //create slug
    $slug = slug($name);

    //save
    $stmt = $con->prepare("INSERT INTO `categories` (`name`, `slug`, `details`, `parent_id`, `status`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $name, $slug, $details, $parent, $status);
    $stmt->execute();

    if ($stmt->insert_id) {

        //unset login details
        unset($_SESSION['old']);

        //set success message
        $_SESSION['success'] = "Category added successfully.";

        //back to register with error
        return header("Location: " . route('admin/categories/index.php'));
    }

    //TODO: Comment line below if on production env
    die(printf($stmt->error));

    $stmt->close();

}

//error
$_SESSION['error'] = "Failed creating category. Try again!";

//back to create with error
return header("Location: " . route('admin/categories/create.php'));
