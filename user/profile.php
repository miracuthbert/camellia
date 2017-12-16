<?php
include_once("../config.php");
include_once("../helpers.php");
include_once("../functions.php");
unauthenticated();

$user = auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('../partials/_head.php'); ?>
</head>
<body>
<div id="app">
    <?php include_once('../partials/_navigation.php'); ?>

    <div class="container">
        <?php include_once('../partials/_alerts.php'); ?>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User Profile</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route('user/scripts/update_profile.php'); ?>">

                            <input type="hidden" name="id" id="id" value="<?php echo $user['id']; ?>">

                            <!-- Use session has to check if field has an error then add `has-error` class -->
                            <div class="form-group<?php echo session_has('errors', 'first_name') ? ' has-error' : ''; ?>">
                                <label for="first_name" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <!-- Use session pop to fetch field's old value -->
                                    <input id="first_name" type="text" class="form-control" name="first_name"
                                           value="<?php echo string_get(session_pop('old', 'first_name'), $user['first_name']); ?>"
                                           required autofocus>

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
                                           value="<?php echo string_get(session_pop('old', 'last_name'), $user['last_name']); ?>"
                                           required>

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
                                           value="<?php echo string_get(session_pop('old', 'email'), $user['email']); ?>"
                                           required>

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
                                           value="<?php echo string_get(session_pop('old', 'phone'), $user['phone']); ?>"
                                           required>

                                    <?php if (session_has('errors', 'phone')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'phone'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'password') ? ' has-error' : ''; ?>">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    <?php if (session_has('errors', 'password')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'password'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
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

<?php include_once('../partials/_scripts.php'); ?>
</body>
</html>
