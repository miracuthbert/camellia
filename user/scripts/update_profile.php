<?php
include_once('../../config.php');
include_once('../../helpers.php');

global $con;

if (isset($_POST)) {
    //store request in session
    $_SESSION['old'] = $_POST;

    //validate data
    $id = $_POST['id'];
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

    if (isset($_SESSION['errors']) && isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to profile with error
        return header("Location: " . route("user/profile.php"));
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

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to profile with error
        return header("Location: " . route("user/profile.php"));
    }

    //using prepared statements to prevent sql injection
    //check if email exists
    if (auth()['email'] == $email) {
        $stmt = $con->prepare("SELECT * FROM `users` WHERE `email` = ? AND `id` = ?");
        $stmt->bind_param('si', $email, $id);
    } else {
        //check if passed email exists
        $_stmt = $con->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $_stmt->bind_param('s', $email);
        $_stmt->execute();
        $_result = $_stmt->get_result();

        if ($_result->num_rows >= 1) {
            $_stmt->close();

            $_SESSION['errors']['email'] = "This email is already in use. Enter another email.";

            //back to profile with error
            return header("Location: " . route("user/profile.php"));
        }
        $_stmt->close();

        $stmt = $con->prepare("SELECT * FROM `users` WHERE `id` = ?");
        $stmt->bind_param('i', $id);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows <= 1) {   //update if email with given id exists or id exists

        //catch return row as an array
        $tempUser = $result->fetch_assoc();

        if (password_verify($password, $tempUser['password'])) { //update if password verified

            //update
            $stmt = $con->prepare("UPDATE `users` SET `first_name` = ?, `last_name` = ?, `email` = ?, `phone` = ? WHERE `id` = ?");
            $stmt->bind_param('ssssi', $first_name, $last_name, $email, $phone, $id);
            $stmt->execute();

            //exclude fields
            unset($user['password']);

            //reset user details in session
            $_SESSION['user']['first_name'] = $first_name;
            $_SESSION['user']['last_name'] = $last_name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phone'] = $phone;

            //unset old input
            unset($_SESSION['old']);

            //close connection
            $stmt->close();

            //set success message
            $_SESSION['success'] = "Profile updated successfully.";

            //redirect to login with success
            return header("Location: " . route("user/profile.php"));
        }else {
            $_SESSION['errors']['password'] = "Password not a match.";

            //back to profile with error
            return header("Location: " . route("user/profile.php"));
        }
    } else {
        $_SESSION['errors']['email'] = "This email is already in use. Enter another email.";

        //back to profile with error
        return header("Location: " . route("user/profile.php"));
    }

    $stmt->close();

} else {
    //set error message
    $_SESSION['error'] = "Some error occurred. Please try again!";

    //back to profile with error
    header("Location: " . route("user/profile.php"));
}