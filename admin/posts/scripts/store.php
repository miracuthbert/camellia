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
    $page = $_POST['page'];
    $category = $_POST['category'];
    $image = $_FILES['image'];
    $body = $_POST['body'];
    $status = $_POST['status'];
    $user = auth();

    if (!isset($user)) {
        $_SESSION['error'] = "You are currently not logged in. Please login first.";

        return header("Location: " . route('auth/login.php'));
    }

    if (!required($name)) {
        $_SESSION['errors']['name'] = "Name is required.";
    }

    if ($page == "") {
        $_SESSION['errors']['body'] = "Body is required.";
    }

    if (pageById($page)['slug'] != "help" && $category == "") {
        $_SESSION['errors']['body'] = "Category is required.";
    }

    if ($body == "") {
        $_SESSION['errors']['body'] = "Body is required.";
    }

    if (!required($status)) {
        $_SESSION['errors']['status'] = "Status is required.";
    }

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route('admin/posts/create.php'));
    }

    //set category to null if page is `help
    if (pageById($page)['slug'] == "help") {
        $category = null;
    }

    //check if image is not null
    if ($image['name'] != "") {
        //image upload
        $imagePath = imageUpload($image, "posts");
    }

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route('admin/posts/create.php'));
    }

    //check if image path is not null else set it to null
    $imagePath = isset($imagePath) && $imagePath != "" ? $imagePath : null;

    //save
    $stmt = $con->prepare("INSERT INTO `posts` (`name`, `body`, `image`, `user_id`, `page_id`, `category_id`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiid", $name, $body, $imagePath, $user['id'], $page, $category, $status);
    $stmt->execute();

    if ($stmt->insert_id) {

        //unset login details
        unset($_SESSION['old']);

        //set success message
        $_SESSION['success'] = "Post added successfully.";

        //back to register with error
        return header("Location: " . route('admin/posts/index.php'));
    }

    $stmt->close();

}

//error
$_SESSION['error'] = "Failed creating post. Try again!";

//back to create with error
return header("Location: " . route('admin/posts/create.php'));
