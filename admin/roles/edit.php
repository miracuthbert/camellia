<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();

$id = $_GET['user'];

$user = userById($id);
$userRoles = getRoles($user['id']);
$roles = roles();
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
                    <div class="panel-heading">User Role Details</div>

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
                                <label for="phone" class="col-md-4 control-label">Joined</label>

                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php echo $user['created_at']; ?>
                                    </p>
                                </div>
                            </div>
                        </form>

                        <?php if (hasRoles($user['id'])) { ?>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Expired At</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($userRoles as $key => $userRole) { ?>
                                        <tr>
                                            <td><?php echo role($userRole['role_id'])['name']; ?></td>
                                            <td><?php echo $userRole['created_at']; ?></td>
                                            <td><?php echo $userRole['expired_at']; ?></td>
                                            <td>
                                                <ul class="list-inline">
                                                    <?php if (!isset($userRole['expired_at'])) { ?>
                                                        <li>
                                                            <a href="<?php echo route("admin/roles/scripts/disable_user_role.php?role={$userRole['id']}"); ?>"
                                                               onclick="event.preventDefault();
                                                                       document.getElementById('role-<?php echo $userRole["id"]; ?>-disable-form').submit();">
                                                                Disable
                                                            </a>

                                                            <form id="role-<?php echo $userRole['id']; ?>-disable-form"
                                                                  action="<?php echo route("admin/roles/scripts/disable_user_role.php?role={$userRole['id']}"); ?>"
                                                                  method="POST"
                                                                  style="display: none;">

                                                                <input type="hidden" name="_id"
                                                                       value="<?php echo $userRole['id']; ?>">
                                                                <input type="hidden" name="user_id"
                                                                       value="<?php echo $userRole['user_id']; ?>">
                                                                <input type="hidden" name="role"
                                                                       value="<?php echo $userRole['role_id']; ?>">
                                                                <input type="hidden" name="_method" id="_method" value="PUT">
                                                            </form>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Assign New Role to User</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route('admin/roles/scripts/store_user_role.php'); ?>">

                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                            <div class="form-group<?php echo session_has('errors', 'role') ? ' has-error' : ''; ?>">
                                <label for="role" class="col-md-4 control-label">Role</label>

                                <div class="col-md-6">
                                    <select name="role" id="role" class="form-control">
                                        <option value="">Select role</option>
                                        <?php foreach ($roles as $key => $role) { ?>
                                            <?php if (session_pop('old', 'role') == $role['id']) { ?>
                                                <option value="<?php echo $role['id']; ?>" selected>
                                                    <?php echo $role['name']; ?>
                                                </option>
                                            <?php } else { ?>
                                                <option value="<?php echo $role['id']; ?>">
                                                    <?php echo $role['name']; ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>

                                    <?php if (session_has('errors', 'role')) ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'role'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Assign
                                    </button>
                                </div>
                            </div>
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
