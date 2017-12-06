<?php

    include_once('../../../config.php');
    include_once('../../../helpers.php');
    include_once('../../../functions.php');

    global $con;

    if (isset($_POST) && (isset($_POST['_method']) && ($_POST['_method'] == "PUT"))) {
        //store request in session
        $_SESSION['old'] = $_POST;

        //validate data
        $slug = $_GET['category'];
        $id = $_POST['_id'];
        $name = $_POST['name'];
        $parent = $_POST['parent'];
        $details = $_POST['details'];
        $status = $_POST['status'];

        if (!required($id)) {
            //error
            $_SESSION['error'] = "Whoops! Page or record not found.";

            //back to create with error
            return header("Location: " . route("admin/categories/edit.php?category={$slug}"));
        }

        if (!required($name)) {
            $_SESSION['errors']['name'] = "Name is required.";
        }

        if (!required($details)) {
            $_SESSION['errors']['details'] = "Details is required.";
        }

        if (!required($status)) {
            $_SESSION['errors']['status'] = "Status is required.";
        }

        if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
            //back to create with error
            return header("Location: " . route("admin/categories/edit.php?category={$slug}"));
        }

        $new_slug = $slug;

        if($_POST['slug_update'] == 1) {
            $new_slug = slug($name);
        }

        //save
        $stmt = $con->prepare("UPDATE `categories` SET `name` = ?, `slug` = ?, `details` = ?, `parent_id` = ? , `status` = ? WHERE `id` = ?");
        $stmt->bind_param("ssssdi", $name, $new_slug, $details, $parent, $status, $id);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {

            //unset login details
            unset($_SESSION['old']);

            //set success message
            $_SESSION['success'] = "Category updated successfully.";

            //back to register with error
            return header("Location: " . route('admin/categories/index.php'));
        }

        //TODO: Comment line below if you want clean error
        $error = $stmt->error;

        $stmt->close();

        //error
        $_SESSION['error'] = "Failed updating category. Error: {$error}";

        //back to create with error
        return header("Location: " . route("admin/categories/edit.php?category={$slug}"));
    }

    //back to index with error
    return header("Location: " . route('admin/categories/index.php'));
