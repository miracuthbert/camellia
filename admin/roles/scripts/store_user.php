<?php

include_once('../../../config.php');
include_once('../../../helpers.php');
include_once('../../../functions.php');

global $con;

if (isset($_POST)) {
    //store request in session
    $_SESSION['old'] = $_POST;

    //validate data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (!required($first_name)) {
        $_SESSION['errors']['first_name'] = "First name is required.";
    }

    if (!required($last_name)) {
        $_SESSION['errors']['last_name'] = "Last name is required.";
    }

    if (!required($email)) {
        $_SESSION['errors']['email'] = "Email is required.";
    }

    if (!required($phone)) {
        $_SESSION['errors']['phone'] = "Phone no. is required.";
    }

    if (!required($password)) {
        $_SESSION['errors']['password'] = "Password is required.";
    }

    if (count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route("admin/roles/create/php"));
    }

    //check name length
    if (!min_length($first_name, 2)) {
        $_SESSION['errors']['first_name'] = "First name cannot be less than 2 characters.";
    }

    if (!min_length($last_name, 2)) {
        $_SESSION['errors']['last_name'] = "Last name cannot be less than 2 characters.";
    }

    //check if email is valid
    if (!is_email($email)) {
        $_SESSION['errors']['email'] = "Email is invalid.";
    }

    //check if phone no is valid
    if (!is_phone($phone) || !min_length($phone, 6) || !max_length($password, 14)) {
        $_SESSION['errors']['phone'] = "Phone no. is invalid.";
    }

    if (!min_length($password, 6) || !max_length($password, 20)) {
        $_SESSION['errors']['password'] = "Password should be 6 - 20 characters long.";
    }

    if (count($_SESSION['errors']) > 0) {
        //back to create with error
        return header("Location: " . route("admin/roles/create/php"));
    }

    //hash password
    $password = password_hash($password, PASSWORD_BCRYPT);

    //using prepared statements to prevent sql injection
    //check if email exists
    $stmt = $con->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {

        //insert
        $stmt = $con->prepare("INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone`, `password`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssis', $first_name, $last_name, $email, $phone, $password);
        $stmt->execute();

        $user = $stmt->insert_id;

        //unset login details
        unset($_SESSION['old']);

        $stmt->close();

        //set success message
        $_SESSION['success'] = "User added successfully. You can now assign them a role.";

        //redirect to roles edit
        return header("Location: " . route("admin/roles/edit.php?user={$user}"));
    } else {
        $_SESSION['errors']['email'] = "This email is already in use. Enter another email.";

        //back to create with error
        return header("Location: " . route("admin/roles/create/php"));
    }


} else {
    //set error message
    $_SESSION['error'] = "Some error occurred. Please try again!";

    //back to create with error
    return header("Location: " . route("admin/roles/create/php"));
}