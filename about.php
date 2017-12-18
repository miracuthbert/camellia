<?php
include_once("config.php");
include_once("helpers.php");
include_once("functions.php");

$page = page("about");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('partials/_head.php') ?>

    <?php if (isset($page['image'])) { ?>
        <style>
            .page-image {
                background-image: url(<?php echo route($page['image']); ?>);
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                height: 40vh;
            }
        </style>
    <?php } ?>
</head>
<body>
<div id="app">
    <?php include_once('partials/_navigation.php') ?>

    <div class="container">
        <?php include_once('partials/_alerts.php') ?>

        <div class="row">
            <div class="col-sm-12">
                <header class="page-image">
                    <h1 class="page-header">
                        <?php echo $page['name']; ?>
                    </h1>
                </header>

                <div class="clearfix">
                    <?php echo $page['body']; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once('partials/_scripts.php') ?>
</body>
</html>
