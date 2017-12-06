<?php
    include_once("config.php");
    include_once("helpers.php");
    include_once("functions.php");
    unauthenticated();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('partials/_head.php') ?>
</head>
<body>
<div id="app">
    <?php include_once('partials/_navigation.php') ?>

    <div class="container">
        <?php include_once('partials/_alerts.php') ?>

        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                <?php
                    print_r($_SESSION['user']);
                ?>
            </div>
        </div>
    </div>

</div>

<?php include_once('partials/_scripts.php') ?>
</body>
</html>
