<?php
include_once('../../config.php');
include_once('../../helpers.php');

global $con;

if (isset($_POST)) {
    //store request in session
    $_SESSION['old'] = $_POST;

    //validate data
    $id = $_POST['id'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['password_confirmation'];
    $password = $_POST['old_password'];

    if (!required($new_password)) {
        $_SESSION['errors']['new_password'] = "New password is required.";
    }

    if (!required($password)) {
        $_SESSION['errors']['old_password'] = "Password is required.";
    }

    if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
        //back to profile with error
        return header("Location: " . route("user/profile.php"));
    }

    //check length
    if (!min_length($new_password, 6) || !max_length($new_password, 20)) {
        $_SESSION['errors']['new_password'] = "New password should be 6 - 20 characters long.";
    }

    if (count($_SESSION['errors']) > 0) {
        //back to profile with error
        return header("Location: " . route("user/profile.php"));
    }

    //check if passwords match
    if (!is_match($new_password, $confirm_password)) {
        $_SESSION['errors']['new_password'] = "New passwords don't match.";
    }

    if (count($_SESSION['errors']) > 0) {
        //back to profile with error
        return header("Location: " . route("user/profile.php"));
    }

    //using prepared statements to prevent sql injection
    //check if user exists
    $stmt = $con->prepare("SELECT * FROM `users` WHERE `id` = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {   //update if given id exists

        //catch return row as an array
        $tempUser = $result->fetch_assoc();

        if (password_verify($password, $tempUser['password'])) { //update if password verified

            //hash password
            $newPassword = password_hash($new_password, PASSWORD_BCRYPT);

            //update
            $stmt = $con->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?");
            $stmt->bind_param('si', $newPassword, $id);
            $stmt->execute();

            if($stmt->affected_rows == 0) {
                //set error message
                $_SESSION['error'] = "Password update failed. Please try again!";

                //back to profile with error
                header("Location: " . route("user/profile.php"));
            }

            //unset old input
            unset($_SESSION['old']);

            //close connection
            $stmt->close();

            //set success message
            $_SESSION['success'] = "Password updated successfully.";

            //redirect to profile with success
            return header("Location: " . route("user/profile.php"));
        }else {
            $_SESSION['errors']['old_password'] = "Password not a match.";

            //back to profile with error
            return header("Location: " . route("user/profile.php"));
        }
    } else {
        $_SESSION['error'] = "Invalid operation.";

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