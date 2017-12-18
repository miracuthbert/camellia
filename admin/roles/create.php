<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();

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
                    <div class="panel-heading">Add New User</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route('admin/roles/scripts/store_user.php'); ?>">

                            <!-- Use session has to check if field has an error then add `has-error` class -->
                            <div class="form-group<?php echo session_has('errors', 'first_name') ? ' has-error' : ''; ?>">
                                <label for="first_name" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <!-- Use session pop to fetch field's old value -->
                                    <input id="first_name" type="text" class="form-control" name="first_name"
                                           value="<?php echo session_pop('old', 'first_name'); ?>" required autofocus>

                                    <?php if (session_has('errors', 'first_name')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'first_name'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'last_name') ? ' has-error' : ''; ?>">
                                <label for="last_name" class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" name="last_name"
                                           value="<?php echo session_pop('old', 'last_name'); ?>" required>

                                    <?php if (session_has('errors', 'last_name')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'last_name'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'email') ? ' has-error' : ''; ?>">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="<?php echo session_pop('old', 'email'); ?>" required>

                                    <?php if (session_has('errors', 'email')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'email'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'phone') ? ' has-error' : ''; ?>">
                                <label for="phone" class="col-md-4 control-label">Phone No.</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone"
                                           value="<?php echo session_pop('old', 'phone'); ?>" required>

                                    <?php if (session_has('errors', 'phone')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'phone'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <!-- PASSWORD IS SET BY DEFAULT IN config.php -->
                            <div class="form-group<?php echo session_has('errors', 'password') ? ' has-error' : ''; ?>">
                                <label for="password" class="col-md-4 control-label"></label>

                                <div class="col-md-6">
                                    <input id="password" type="hidden" class="form-control" name="password"
                                           value="<?php echo DEFAULT_USER_PASSWORD; ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <span class="help-block">* Once user is added, you will be redirected to role edit page to assign the user a role</span>
                                    <button type="submit" class="btn btn-primary">
                                        Save
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
