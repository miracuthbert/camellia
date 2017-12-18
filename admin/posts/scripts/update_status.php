<?php

include_once('../../../config.php');
include_once('../../../helpers.php');
include_once('../../../functions.php');

global $con;

if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {

    //catch data
    $id = $_POST['_id'];
    $status = $_POST['status'];

    //save
    $stmt = $con->prepare("UPDATE `posts` SET `status` = ? WHERE `id` = ?");
    $stmt->bind_param("di", $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {

        //set success message
        $_SESSION['success'] = "Post status updated successfully.";

        //back to register with error
        return header("Location: " . route('admin/posts/index.php'));
    }

    $stmt->close();
}

//error
$_SESSION['error'] = "Some error occurred. Please try again!";

//back to create with error
return header("Location: " . route('admin/posts/index.php'));

