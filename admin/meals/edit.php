<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../categories/functions.php");
include_once("functions.php");

unauthenticated();
$categories = categories(['status' => true, 'slug' => "meals"]);
$categories = array_merge($categories, categories(['status' => true, 'slug' => "drinks"]));

$meal = $_GET['meal'];

$meal = meal($meal);
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
                    <div class="panel-heading">Edit Meal/Beverage</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route("admin/meals/scripts/update.php?meal={$meal['id']}"); ?>">

                            <input type="hidden" name="_id" id="_id" value="<?php echo $meal['id']; ?>">
                            <input type="hidden" name="_method" id="_method" value="PUT">

                            <div class="form-group<?php echo session_has('errors', 'name') ? ' has-error' : ''; ?>">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="<?php echo string_get(session_pop('old', 'name'), $meal['name']); ?>"
                                           required autofocus>

                                    <?php if (session_has('errors', 'name')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'name'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'price') ? ' has-error' : ''; ?>">
                                <label for="price" class="col-md-4 control-label">Price</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><?php echo APP_CURRENCY; ?></span>
                                        <input id="price" type="text" class="form-control" name="price"
                                               value="<?php echo string_get(session_pop('old', 'price'), $meal['price']); ?>" required>
                                    </div>

                                    <?php if (session_has('errors', 'price')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'price'); ?></strong>
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

                            <div class="form-group<?php echo session_has('errors', 'category') ? ' has-error' : ''; ?>">
                                <label for="category" class="col-md-4 control-label">Category</label>

                                <div class="col-md-6">
                                    <select name="category" id="category" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($categories as $sel_category) { ?>
                                            <option value="<?php echo $sel_category['id']; ?>"
                                                <?php if (session_pop('old', 'category') == $sel_category['id']) {
                                                    echo "selected";
                                                } else {
                                                    echo $meal['category_id'] == $sel_category['id'] ? "selected" : '';
                                                } ?>>
                                                <?php echo $sel_category['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <?php if (session_has('errors', 'category')) ; ?>
                                    <span class="help-block">
                                        <strong><?php echo session_pop('errors', 'category'); ?></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group<?php echo session_has('errors', 'details') ? ' has-error' : ''; ?>">
                                <label for="details" class="col-md-4 control-label">Details</label>

                                <div class="col-md-6">
                                    <textarea name="details" id="details" rows="5"
                                              class="form-control"><?php echo string_get($meal['details'], session_pop('old', 'details')); ?></textarea>

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
                                               value="0" <?php echo string_get(session_get('old', 'status'), $meal['usable']) == 0 ? "checked" : ""; ?>>
                                        Closed
                                    </label>
                                    <label>
                                        <input type="radio" name="status" id="active"
                                               value="1" <?php echo string_get(session_get('old', 'status'), $meal['usable']) == 1 ? "checked" : ""; ?>>
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
