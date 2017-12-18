<?php
include_once("config.php");
include_once("helpers.php");
include_once("functions.php");

//fetch help page
$page = page("help");

//check if page exists or not
$pageId = isset($page['id']) ? $page['id'] : '';

//fetch help page posts
$posts = postsByPage($pageId, true);
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
                <hr>

                <div class="clearfix">
                    <?php if (isset($posts) && count($posts) > 0) { ?>

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                            <?php foreach ($posts as $key => $post) { ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapse<?php echo $post['id']; ?>"
                                               aria-expanded="<?php if ($key + 1 == 1) {
                                                   echo "true";
                                               } else {
                                                   echo "false";
                                               } ?>"
                                               aria-controls="collapse<?php echo $post['id']; ?>">
                                                <?php echo $post['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse<?php echo $post['id']; ?>" class="panel-collapse collapse
                                    <?php if ($key + 1 == 1) {
                                        echo "in";
                                    } ?>"
                                         role="tabpanel"
                                         aria-labelledby="heading<?php echo $post['id']; ?>">
                                        <div class="panel-body">
                                            <div class="media">
                                                <?php if (isset($post['image'])) { ?>
                                                    <div class="media-left">
                                                        <img src="<?php echo route($post['image']); ?>"
                                                             alt="<?php echo $post['name']; ?> image" width="100px"
                                                             height="100px">
                                                    </div>
                                                <?php } ?>
                                                <div class="media-body">
                                                    <?php echo $post['body']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php } else { ?>
                        <p>No help posts found.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once('partials/_scripts.php') ?>
</body>
</html>
