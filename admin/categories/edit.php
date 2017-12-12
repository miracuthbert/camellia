<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();

$categories = categories();

$slug = $_GET['category'];

$category = category($slug);
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
                    <div class="panel-heading">Edit Category</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route("admin/categories/scripts/update.php?category={$category['slug']}"); ?>">

                            <input type="hidden" name="_id" id="_id" value="<?php echo $category['id']; ?>">
                            <input type="hidden" name="_method" id="_method" value="PUT">

                            <div class="form-group<?php echo session_has('errors', 'name') ? ' has-error' : ''; ?>">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="<?php echo string_get(session_pop('old', 'name'), $category['name']); ?>"
                                           required autofocus>

                                    <?php if (session_has('errors', 'name')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'name'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'parent') ? ' has-error' : ''; ?>">
                                <label for="parent" class="col-md-4 control-label">Parent</label>

                                <div class="col-md-6">
                                    <select name="parent" id="parent" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($categories as $sel_category) { ?>
                                            <option value="<?php echo $sel_category['id']; ?>"
                                                <?php if (session_pop('old', 'parent') == $sel_category['id']) {
                                                    echo "selected";
                                                } else {
                                                    echo $category['parent_id'] == $sel_category['id'] ? "selected" : '';
                                                } ?>>
                                                <?php echo $sel_category['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <?php if (session_has('errors', 'parent')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'parent'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'details') ? ' has-error' : ''; ?>">
                                <label for="details" class="col-md-4 control-label">Details</label>

                                <div class="col-md-6">
                                    <textarea name="details" id="details" rows="5"
                                              class="form-control"><?php echo string_get($category['details'], session_pop('old', 'details')); ?></textarea>

                                    <?php if (session_has('errors', 'details')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'details'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'status') ? ' has-error' : ''; ?>">
                                <label for="status" class="col-md-4 control-label">Status</label>

                                <div class="col-md-6">
                                    <label>
                                        <input type="radio" name="status" id="disabled"
                                               value="0" <?php echo string_get(session_get('old', 'status'), $category['status']) == 0 ? "checked" : ""; ?>>
                                        Closed
                                    </label>
                                    <label>
                                        <input type="radio" name="status" id="active"
                                               value="1" <?php echo string_get(session_get('old', 'status'), $category['status']) == 1 ? "checked" : ""; ?>>
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
                                    <input type="checkbox" name="slug_update" id="slug_update" value="1"> Update slug

                                    <span class="help-block">
                                        Check this field if you want to update the slug too.
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
