<?php

include_once('../../../config.php');
include_once('../../../helpers.php');
include_once('../../../functions.php');

global $con;

if (isset($_POST)) {
    //store request in session
    $_SESSION['old'] = $_POST;

    //validate data
    $role = $_POST['role'];
    $user = $_POST['id'];

    //find role
    $role = role($role);

    if(!isset($user)) {
        $_SESSION['errors']['user'] = "User is required. Please select a valid user.";
    }

    if(!isset($role)) {
        $_SESSION['errors']['role'] = "Invalid role. Please select a valid role.";
    }

    if (hasRoles($user, $role['slug'])) {
        $_SESSION['errors']['role'] = "You cannot assign `{$role['name']}` role to this user twice.";
        $_SESSION['info'] = "Disable the present role then reassign again.";

        return header("Location: " . route("admin/roles/edit.php?user={$user}"));
    }


    $stmt = $con->prepare("INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES(?, ?)");
    $stmt->bind_param("ii", $user, $role['id']);
    $stmt->execute();

    if ($stmt->insert_id) {

        //close connection
        $stmt->close();

        //unset login details
        unset($_SESSION['old']);

        //set success message
        $_SESSION['success'] = "`{$role['name']}` role assigned to user successfully.";

        return header("Location: " . route("admin/roles/edit.php?user={$user}"));
    }

    $_SESSION['error'] = "Failed assigning role to user. Please try again.";

    return header("Location: " . route("admin/roles/edit.php?user={$user}"));
}