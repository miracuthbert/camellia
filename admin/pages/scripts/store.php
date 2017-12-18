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
    $image = $_FILES['image'];
    $body = $_POST['body'];
    $status = $_POST['status'];

    if (!required($name)) {
        $_SESSION['errors']['name'] = "Name is required.";
    }

    if ($image['name'] == "" && $body == "") {
        $_SESSION['errors']['image'] = "Image/body is required.";
        $_SESSION['errors']['body'] = "Body/Image is required.";
    }

    if (!required($status)) {
        $_SESSION['errors']['status'] = "Status is required.";
    }

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route('admin/pages/create.php'));
    }

    //create slug
    $slug = slug($name);

    //check if image is not null
    if ($image['name'] != "") {
        //image upload
        $imagePath = imageUpload($image, "pages");
    }

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route('admin/pages/create.php'));
    }

    //check if image path is not null else set it to null
    $imagePath = isset($imagePath) ? $imagePath : null;

    //save
    $stmt = $con->prepare("INSERT INTO `pages` (`name`, `slug`, `body`, `image`, `parent_id`, `status`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssid", $name, $slug, $body, $imagePath, $parent, $status);
    $stmt->execute();

    if ($stmt->insert_id) {

        //unset login details
        unset($_SESSION['old']);

        //set success message
        $_SESSION['success'] = "Page added successfully.";

        //back to register with error
        return header("Location: " . route('admin/pages/index.php'));
    }

    $stmt->close();

}

//error
$_SESSION['error'] = "Failed creating page. Try again!";

//back to create with error
return header("Location: " . route('admin/pages/create.php'));
