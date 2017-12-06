<?php
    include_once("../config.php");
    include_once("../helpers.php");
    include_once("../functions.php");
    authenticated();
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
                    <div class="panel-heading">Login</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route('auth/scripts/login.php'); ?>">

                            <div class="form-group<?php echo session_has('errors', 'email') ? ' has-error' : ''; ?>">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="<?php echo session_pop('old', 'email'); ?>"
                                           required autofocus>

                                    <?php if (session_has('errors', 'email')) { ; ?>
                                        <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'email'); ?></strong>
                                    </span>
                                    <?php }; ?>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'password') ? ' has-error' : ''; ?>">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"
                                                <?php echo session_pop('old', 'remember') ? 'checked' : ''; ?>>
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
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
