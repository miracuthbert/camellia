<?php
include_once("config.php");
include_once("helpers.php");
include_once("functions.php");

$page = page("home");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('partials/_head.php') ?>

    <?php if (isset($page['image'])) { ?>
        <style>
            body {
                background-image: url(<?php echo route($page['image']); ?>);
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                height: 100vh;
            }

            .welcome-title {
                color: #ffffff;
            }
        </style>
    <?php } else { ?>
        <style>
            .welcome-title {
                color: #dddddd;
            }
        </style>
    <?php } ?>
</head>
<body>
<div id="app">
    <?php include_once('partials/_navigation.php') ?>

    <div class="container">
        <?php include_once('partials/_alerts.php') ?>

        <div class="text-center" style="margin-top: calc(40vh)">
            <h2 class="welcome-title">Welcome to <?php echo APP_NAME; ?></h2>

            <p>
                <?php if (session_has('cart')) { ?>
                    <a role="button" href="<?php echo route('orders/menu.php'); ?>"
                       class="btn btn-success btn-lg">
                        <i class="fa fa-shopping-basket"></i> Menu
                    </a>
                <?php } else { ?>
                    <a role="button" href="<?php echo route('orders/menu.php'); ?>"
                       class="btn btn-success btn-lg">
                        <i class="fa fa-shopping-basket"></i> Place an Order
                    </a>
                <?php } ?>
            </p>
        </div>
    </div>

</div>

<?php include_once('partials/_scripts.php') ?>
</body>
</html>
