<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();

$posts = posts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('../../partials/_head.php'); ?>
</head>
<body>
<div id="app">
    <?php include_once('../partials/_navigation.php'); ?>

    <div class="container">
        <?php include_once('../../partials/_alerts.php'); ?>

        <div class="row">
            <div class="col-sm-3">
                <?php include_once('../partials/_sidebar.php') ?>
            </div>

            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Posts</div>

                    <?php if (isset($posts) && (count($posts) > 0)) { ?>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Page</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($posts as $post) { ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo route($post['image']); ?>"
                                                 alt="<?php echo $post['name']; ?> image" height="70px" width="100px">
                                        </td>
                                        <td><?php echo $post['name']; ?></td>
                                        <td>
                                            <?php if (!empty(pageById($post['page_id'])['name'])) {
                                                echo pageById($post['page_id'])['name'];
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if (!empty(categoryById($post['category_id'])['name'])) {
                                                echo categoryById($post['category_id'])['name'];
                                            } ?>
                                        </td>
                                        <td><?php echo status_parse($post['status']); ?></td>
                                        <td>
                                            <ul class="list-inline">
                                                <li>
                                                    <a href="<?php echo route("admin/posts/edit.php?post={$post['id']}") ?>">
                                                        Edit
                                                    </a>
                                                </li>
                                                <!-- Post Status Toggle Link -->
                                                <li>
                                                    <a href="<?php echo route("admin/posts/scripts/update_status.php?post={$post['id']}"); ?>"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('post-<?php echo $post["id"]; ?>-status-form').submit();">
                                                        <?php echo status_button(!$post['status']); ?>
                                                    </a>

                                                    <!--
                                                        Post status form
                                                        Used to send a post request instead of get to prevent
                                                        Cross Site Forgery Attacks & Sql injections

                                                        We use PUT to specify that it is an update request
                                                    -->
                                                    <form id="post-<?php echo $post['id']; ?>-status-form"
                                                          action="<?php echo route("admin/posts/scripts/update_status.php?post={$post['id']}"); ?>"
                                                          method="POST"
                                                          style="display: none;">

                                                        <input type="hidden" name="_id"
                                                               value="<?php echo $post['id']; ?>">
                                                        <input type="hidden" name="status"
                                                               value="<?php echo !$post['status']; ?>">
                                                        <input type="hidden" name="_method" id="_method" value="PUT">
                                                    </form>
                                                </li>
                                                <!-- Post Delete Link -->
                                                <li>
                                                    <a class="text-danger"
                                                       href="<?php echo route("admin/posts/scripts/delete.php?post={$post['id']}"); ?>"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('post-<?php echo $post["id"]; ?>-delete-form').submit();">
                                                        Delete
                                                    </a>

                                                    <!--
                                                        Post status form
                                                        Used to send a post request instead of get to prevent
                                                        Cross Site Forgery Attacks & Sql injections

                                                        We use DELETE to specify that it is an update request
                                                    -->
                                                    <form id="post-<?php echo $post['id']; ?>-delete-form"
                                                          action="<?php echo route("admin/posts/scripts/delete.php?post={$post['id']}"); ?>"
                                                          method="POST"
                                                          style="display: none;">

                                                        <input type="hidden" name="_id"
                                                               value="<?php echo $post['id']; ?>">
                                                        <input type="hidden" name="_method" id="_method" value="DELETE">
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php }; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p class="text-muted text-center">No posts found.</p>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
