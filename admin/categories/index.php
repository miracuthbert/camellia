<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("functions.php");
unauthenticated();
$categories = categories();

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
                    <div class="panel-heading">Categories</div>

                    <?php if (isset($categories) && (count($categories) > 0)) { ?>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($categories as $category) { ?>
                                    <tr>
                                        <td><?php echo $category['name']; ?></td>
                                        <td><?php echo $category['slug']; ?></td>
                                        <td><?php echo status_parse($category['status']); ?></td>
                                        <td>
                                            <ul class="list-inline">
                                                <li>
                                                    <a href="<?php echo route("admin/categories/edit.php?category={$category['slug']}") ?>">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo route("admin/categories/scripts/update_status.php?category={$category['slug']}"); ?>"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('category-<?php echo $category["id"]; ?>-status-form').submit();">
                                                        <?php echo status_button(!$category['status']); ?>
                                                    </a>

                                                    <form id="category-<?php echo $category['id']; ?>-status-form"
                                                          action="<?php echo route("admin/categories/scripts/update_status.php?category={$category['slug']}"); ?>"
                                                          method="POST"
                                                          style="display: none;">

                                                        <input type="hidden" name="_id"
                                                               value="<?php echo $category['id']; ?>">
                                                        <input type="hidden" name="status"
                                                               value="<?php echo !$category['status']; ?>">
                                                        <input type="hidden" name="_method" id="_method" value="PUT">
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
                        <p class="text-muted text-center">No categories found.</p>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
