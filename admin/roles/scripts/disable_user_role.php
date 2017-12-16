<?php

include_once('../../../config.php');
include_once('../../../helpers.php');
include_once('../../../functions.php');

global $con;

if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {

    //data
    $id = $_POST['_id'];
    $user = $_POST['user_id'];
    $role = $_POST['role'];

    //find role
    $role = role($role);

    if (isset($role)) {
        //save
        $stmt = $con->prepare("UPDATE `user_roles` SET `expired_at` = CURRENT_TIMESTAMP WHERE `id` = ? AND `user_id` = ?");
        $stmt->bind_param("ii", $id, $user);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            $stmt->close();

            //set success message
            $_SESSION['success'] = "User's `{$role['name']}` role disabled successfully.";

            //back to user role
            return header("Location: " . route("admin/roles/edit.php?user={$user}"));
        }

        $stmt->close();
    }

    //error
    $_SESSION['error'] = "Failed disabling user role. Please try again!";

    //back to edit with error
    return header("Location: " . route("admin/roles/edit.php?user={$user}"));
}
//error
$_SESSION['error'] = "Page not found.";

//back to edit with error
return header("Location: " . route("admin/roles/index.php"));
