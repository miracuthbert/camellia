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
    $page = $_POST['page'];
    $category = $_POST['category'];
    $image = $_FILES['image'];
    $imageOld = $_POST['oldImage'];
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
        return header("Location: " . route("admin/posts/edit.php?post={$id}"));
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

    //check if image path is not null else set it to old path
    $imagePath = isset($imagePath) && $imagePath != "" ? $imagePath : $imageOld;

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route("admin/posts/edit.php?post={$id}"));
    }

    //save
    $stmt = $con->prepare("UPDATE `posts` SET `name` = ?, `body` = ?, `image` = ?, `page_id` = ?, `category_id` = ?, `status` = ? WHERE `id` = ?");
    $stmt->bind_param("sssiidi",  $name, $body, $imagePath, $page, $category, $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows) {

        //unset login details
        unset($_SESSION['old']);

        //set success message
        $_SESSION['success'] = "Post updated successfully.";

        //redirect to index with success
        return header("Location: " . route('admin/posts/index.php'));
    }

    //error
    $_SESSION['info'] = "No changes made.";

    $stmt->close();

    //back to edit with error
    return header("Location: " . route("admin/posts/edit.php?post={$id}"));

}

//back to index with error
return header("Location: " . route('admin/posts/index.php'));
