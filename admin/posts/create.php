<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();
$pages = postPages();
$categories = categories(['status' => true, 'slug' => "posts"]);

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
                    <div class="panel-heading">Add Post</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route('admin/posts/scripts/store.php'); ?>"
                              enctype="multipart/form-data">

                            <div class="form-group<?php echo session_has('errors', 'name') ? ' has-error' : ''; ?>">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="<?php echo session_pop('old', 'name'); ?>" required autofocus>

                                    <?php if (session_has('errors', 'name')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'name'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'page') ? ' has-error' : ''; ?>">
                                <label for="page" class="col-md-4 control-label">Page</label>

                                <div class="col-md-6">
                                    <select name="page" id="page" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($pages as $page) { ?>
                                            <option value="<?php echo $page['id']; ?>"
                                            <?php
                                                if(session_pop('old', 'page') == $page['id']) {
                                                    echo "selected";
                                                }
                                            ?>>
                                                <?php echo $page['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <span class="help-block">
                                        Page that this post should be displayed on
                                    </span>

                                    <?php if (session_has('errors', 'page')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'page'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'category') ? ' has-error' : ''; ?>">
                                <label for="category" class="col-md-4 control-label">Category</label>

                                <div class="col-md-6">
                                    <select name="category" id="category" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($categories as $sel_category) { ?>
                                            <option value="<?php echo $sel_category['id']; ?>">
                                                <?php echo $sel_category['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <span class="help-block">
                                        For `help` page posts category will be ignored.
                                    </span>

                                    <?php if (session_has('errors', 'category')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'category'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'image') ? ' has-error' : ''; ?>">
                                <label for="image" class="col-md-4 control-label">Image</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-image"></i></span>
                                        <input id="image" type="file" class="form-control" name="image"
                                               value="<?php echo session_pop('old', 'image'); ?>">
                                    </div>

                                    <?php if (session_has('errors', 'image')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'image'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'body') ? ' has-error' : ''; ?>">
                                <label for="body" class="col-md-4 control-label">Body</label>

                                <div class="col-md-6">
                                    <textarea name="body" id="body" rows="5"
                                              class="form-control"><?php echo session_pop('old', 'body'); ?></textarea>

                                    <?php if (session_has('errors', 'body')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'body'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'status') ? ' has-error' : ''; ?>">
                                <label for="status" class="col-md-4 control-label">Status</label>

                                <div class="col-md-6">
                                    <label>
                                        <input type="radio" name="status" id="disabled"
                                               value="0" <?php echo session_get('old', 'status') == 0 ? "checked" : ""; ?>>
                                        Disabled
                                    </label>
                                    <label>
                                        <input type="radio" name="status" id="active"
                                               value="1" <?php echo session_get('old', 'status') == 1 ? "checked" : ""; ?>>
                                        Active
                                    </label>

                                    <?php if (session_has('errors', 'status')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'status'); ?></strong>
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

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
