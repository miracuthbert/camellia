<?php

    include_once('../../config.php');
    include_once('../../helpers.php');

    global $con;

    if (isset($_POST)) {
        //store request in session
        $_SESSION['old'] = $_POST;

        //validate data
        $first_name = $_POST['first_name'];
        $last_name = $_POST['first_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $password_conf = $_POST['password_confirmation'];

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
            //back to register with error
            return header("Location: ../register.php");
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

        //check if passwords match
        if (!is_email($email)) {
            $_SESSION['errors']['email'] = "Email is invalid.";
        }

        //check if passwords match
        if (!is_match($password, $password_conf)) {
            $_SESSION['errors']['password'] = "Passwords don't match.";
        }

        if (count($_SESSION['errors']) > 0) {
            //back to register with error
            return header("Location: ../register.php");
        }

        //hash password
        $password = password_hash($password, PASSWORD_BCRYPT);

        //check email
        $stmt = $con->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->bind_param('i', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows() == 0) {

            //insert
            $stmt = $con->prepare("INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone`, `password`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss', $first_name, $last_name, $email, $phone, $password);
            $stmt->execute();

            //TODO: auto login user

            //unset login details
            unset($_SESSION['old']);

            $stmt->close();

            //set success message
            $_SESSION['success'] = "Sign up successful. Login to proceed.";

            //back to register with error
            return header("Location: ../login.php");

        } else {
            $_SESSION['errors']['email'] = "This email is already in use. Enter another email.";

            //back to register with error
            return header("Location: ../register.php");
        }


    } else {
        //set error message
        $_SESSION['error'] = "Some error occurred. Please try again!";

        //back to register with error
        header("Location: ../register.php");
    }