<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();

$id = $_GET['user'];

$user = userById($id);

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
                    <div class="panel-heading">User Details</div>

                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="first_name" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo $user['first_name']; ?>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="last_name" class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo $user['last_name']; ?>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo $user['email']; ?>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-md-4 control-label">Phone No.</label>

                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo $user['phone']; ?>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-md-4 control-label">Joined</label>

                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo $user['created_at']; ?>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-md-4 control-label">Orders</label>

                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo count(userOrders($user)); ?> |
                                        <a href="<?php echo route("admin/orders/index.php?user={$user['id']}") ?>">
                                            View Orders
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <?php if (hasRoles($user['id'])) { ?>
                                <div class="form-group">
                                    <label for="phone" class="col-md-4 control-label">Roles</label>

                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo count(getRoles($user['id'])); ?> |

                                            <a href="<?php echo route("admin/roles/edit.php?user={$user['id']}") ?>">
                                                Manage Roles
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
