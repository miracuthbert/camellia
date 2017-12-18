<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();

$pages = pages();
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
                    <div class="panel-heading">Pages</div>

                    <?php if (isset($pages) && (count($pages) > 0)) { ?>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($pages as $page) { ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo route($page['image']); ?>"
                                                 alt="<?php echo $page['name']; ?> image" height="70px" width="100px">
                                        </td>
                                        <td><?php echo $page['name']; ?></td>
                                        <td><?php echo $page['slug']; ?></td>
                                        <td><?php echo status_parse($page['status']); ?></td>
                                        <td>
                                            <ul class="list-inline">
                                                <li>
                                                    <a href="<?php echo route("admin/pages/edit.php?page={$page['slug']}") ?>">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo route("admin/pages/scripts/update_status.php?page={$page['slug']}"); ?>"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('page-<?php echo $page["id"]; ?>-status-form').submit();">
                                                        <?php echo status_button(!$page['status']); ?>
                                                    </a>

                                                    <form id="page-<?php echo $page['id']; ?>-status-form"
                                                          action="<?php echo route("admin/pages/scripts/update_status.php?page={$page['slug']}"); ?>"
                                                          method="POST"
                                                          style="display: none;">

                                                        <input type="hidden" name="_id"
                                                               value="<?php echo $page['id']; ?>">
                                                        <input type="hidden" name="status"
                                                               value="<?php echo !$page['status']; ?>">
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
                        <p class="text-muted text-center">No pages found.</p>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
