<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();

$meals = meals();
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
                    <div class="panel-heading">Meals</div>

                    <?php if (isset($meals) && (count($meals) > 0)) { ?>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($meals as $meal) { ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo route($meal['image']); ?>" alt=""
                                                 class="img-responsive" width="100px" height="100px">
                                        </td>
                                        <td><?php echo $meal['name']; ?></td>
                                        <td>
                                            <a href="<?php echo route("admin/meals/index.php?category={$meal['categorySlug']}"); ?>">
                                                <?php echo $meal['categoryName']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $meal['price']; ?></td>
                                        <td><?php echo status_parse($meal['usable']); ?></td>
                                        <td>
                                            <ul class="list-inline">
                                                <li>
                                                    <a href="<?php echo route("admin/meals/edit.php?meal={$meal['id']}") ?>">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo route("admin/meals/scripts/update_status.php?meal={$meal['id']}"); ?>"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('meal-<?php echo $meal["id"]; ?>-status-form').submit();">
                                                        <?php echo status_button(!$meal['usable']); ?>
                                                    </a>

                                                    <form id="meal-<?php echo $meal['id']; ?>-status-form"
                                                          action="<?php echo route("admin/meals/scripts/update_status.php?meal={$meal['id']}"); ?>"
                                                          method="POST"
                                                          style="display: none;">

                                                        <input type="hidden" name="_id"
                                                               value="<?php echo $meal['id']; ?>">
                                                        <input type="hidden" name="status"
                                                               value="<?php echo !$meal['usable']; ?>">
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
                        <p class="text-muted text-center">No meals found.</p>
                    <?php }; ?>

                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
