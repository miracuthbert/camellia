<?php

    include_once('../../../config.php');
    include_once('../../../helpers.php');
    include_once('../../../functions.php');

    global $con;

    if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {

        //validate data
        $slug = $_GET['category'];
        $id = $_POST['_id'];
        $status = $_POST['status'];

        //save
        $stmt = $con->prepare("UPDATE `categories` SET `status` = ? WHERE `id` = ?");
        $stmt->bind_param("di", $status, $id);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {

            //set success message
            $_SESSION['success'] = "Category status updated successfully.";

            //back to register with error
            return header("Location: " . route('admin/categories/index.php'));
        }

        //TODO: Comment line below if on production env
        die(printf($stmt->error));

        $stmt->close();

    }

//error
$_SESSION['error'] = "Some error occurred. Please try again!";

//back to create with error
return header("Location: " . route('admin/categories/index.php'));

