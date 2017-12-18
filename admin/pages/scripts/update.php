<?php

include_once('../../../config.php');
include_once('../../../helpers.php');
include_once('../../../functions.php');

global $con;

if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {

    //store request in session
    $_SESSION['old'] = $_POST;

    //validate data
    $slug = $_POST['_slug'];
    $name = $_POST['name'];
    $parent = $_POST['parent'];
    $image = $_FILES['image'];
    $imageOld = $_POST['oldImage'];
    $body = $_POST['body'];
    $status = $_POST['status'];

    if (!required($name)) {
        $_SESSION['errors']['name'] = "Name is required.";
    }

    if ($imageOld == "" && $body == "") { //check if old(current) image and body are null
        $_SESSION['errors']['image'] = "Image/body is required.";
        $_SESSION['errors']['body'] = "Body/Image is required.";
    }

    if (!required($status)) {
        $_SESSION['errors']['status'] = "Status is required.";
    }

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route("admin/pages/edit.php?page={$slug}"));
    }

    //check if image is not null
    if ($image['name'] != "") {
        //image upload
        $imagePath = imageUpload($image, "pages");
    }

    //check if image path is not null else set it to old path
    $imagePath = isset($imagePath) ? $imagePath : $imageOld;

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route("admin/pages/edit.php?page={$slug}"));
    }

    //save
    $stmt = $con->prepare("UPDATE `pages` SET `name` = ?, `body` = ?, `image` = ?, `parent_id` = ?, `status` = ? WHERE `slug` = ?");
    $stmt->bind_param("sssids", $name, $body, $imagePath, $parent, $status, $slug);
    $stmt->execute();

    if ($stmt->affected_rows) {

        //unset login details
        unset($_SESSION['old']);

        //set success message
        $_SESSION['success'] = "Page updated successfully.";

        //redirect to index with success
        return header("Location: " . route('admin/pages/index.php'));
    }

    //error
    $_SESSION['info'] = "No changes made.";

    $stmt->close();

    //back to edit with error
    return header("Location: " . route("admin/pages/edit.php?page={$slug}"));

}

//back to index with error
return header("Location: " . route('admin/pages/index.php'));
