<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();
$users = users();

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
                    <div class="panel-heading">Users</div>

                    <?php if (isset($users) && (count($users) > 0)) { ?>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Joined</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user) { ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo route("admin/users/edit.php?user={$user['id']}") ?>">
                                                <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['phone']; ?></td>
                                        <td><?php echo $user['created_at']; ?></td>
                                        <td>
                                            <ul class="list-inline">
                                                <li>
                                                    <a href="<?php echo route("admin/users/edit.php?user={$user['id']}") ?>">
                                                        View
                                                    </a>
                                                </li>
                                                <?php if (hasRoles($user['id'])) { ?>
                                                    <li>
                                                        <a href="<?php echo route("admin/roles/edit.php?user={$user['id']}") ?>">
                                                            Manage Roles
                                                        </a>
                                                    </li>
                                                <?php } else { ?>
                                                    <li>
                                                        <a href="<?php echo route("admin/users/create.php?user={$user['id']}") ?>">
                                                            Assign Role(s)
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p class="text-muted text-center">No users found.</p>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
