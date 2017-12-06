<?php

    include_once('../../config.php');
    include_once('../../helpers.php');

    global $con;

    if (isset($_POST)) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        //store request in session
        $_SESSION['old'] = $_POST;

        //check if email is valid
        if (!is_email($email)) {
            $_SESSION['errors']['email'] = "These credentials do not match our records..";
        }

        if (count($_SESSION['errors']) > 0) {
            //back to login with error
            return header("Location: ../login.php");
        }

        $stmt = $con->prepare("SELECT * FROM `users` WHERE `email` = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($stmt->affected_rows === 1) {

            //check if password is match
            if(password_verify($password, $user['password'])) {

                //exclude fields
                unset($user['password']);

                //set user id
                $_SESSION['user'] = $user;

                //unset login details
                unset($_SESSION['old']);

                $stmt->close();

                //set success message
                $_SESSION['success'] = "Login successful.";

                //redirect to dashboard
                return header("Location: ../../dashboard.php");
            }   //end password check

        }   //end row

    }   //end post

    //set error message
    $_SESSION['errors']['email'] = "These credentials do not match our records.";

    //back to login with error
    header("Location: ../login.php");