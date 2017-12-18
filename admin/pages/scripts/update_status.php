<?php

include_once('../../../config.php');
include_once('../../../helpers.php');
include_once('../../../functions.php');

global $con;

if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {

    //validate data
    $slug = $_POST['_slug'];
    $status = $_POST['status'];

    //save
    $stmt = $con->prepare("UPDATE `pages` SET `status` = ? WHERE `slug` = ?");
    $stmt->bind_param("ds", $status, $slug);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {

        //set success message
        $_SESSION['success'] = "Page status updated successfully.";

        //back to register with error
        return header("Location: " . route('admin/pages/index.php'));
    }

    $stmt->close();
}

//error
$_SESSION['error'] = "Some error occurred. Please try again!";

//back to create with error
return header("Location: " . route('admin/pages/index.php'));

