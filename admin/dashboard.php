<?php
    include_once("../config.php");
    include_once("../helpers.php");
    include_once("../functions.php");
    unauthenticated();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('../partials/_head.php') ?>
</head>
<body>
<div id="app">
    <?php include_once('partials/_navigation.php') ?>

    <div class="container">
        <?php include_once('../partials/_alerts.php') ?>

        <div class="row">
            <div class="col-sm-3">
                <?php include_once('partials/_sidebar.php') ?>
            </div>

            <div class="col-sm-9">
                Welcome to Admin Panel!
            </div>
        </div>
    </div>

</div>

<?php include_once('../partials/_scripts.php') ?>
</body>
</html>
