<?php
include_once("../config.php");
include_once("../helpers.php");
include_once("../functions.php");
unauthenticated();

$foods = foods();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('../partials/_head.php') ?>
</head>
<body>
<div id="app">
    <?php include_once('../partials/_navigation.php') ?>

    <div class="container">
        <?php include_once('../partials/_alerts.php') ?>
        <div class="row">
            <div class="col-sm-12">

                <form class="form-horizontal" method="POST" action="<?php echo route('orders/scripts/calculate_cart.php'); ?>"
                      enctype="application/x-www-form-urlencoded">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3><?php echo APP_NAME; ?> Menu</h3>
                            <p>Choose meal(s) and (or) beverage(s) from below:</p>
                        </div>

                        <div class="panel-body">
                            <?php foreach ($foods as $food) { ?>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <input type="checkbox" name="order[]" id="food-<?php echo $food['id']; ?>"
                                               value="<?php echo $food['id']; ?>">

                                        <img class="media-object" src="<?php echo $food['image']; ?>" alt="image"
                                             class="img-responsive">
                                    </div>
                                    <div class="col-sm-8">

                                        <h4 data-toggle="tooltip" title="<?php echo $food['details']; ?>">
                                            <?php echo $food['name']; ?>
                                            <i class="fa fa-info"></i>
                                        </h4>
                                        <strong><?php echo APP_CURRENCY; ?><?php echo $food['price']; ?></strong>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <span class="input-group-addon">Qty.</span>
                                            <input type="number" name="order_quantity[]" class="form-control"
                                                   max="20"
                                                   value="1">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="panel-footer">
                            <div class="clearfix">
                                <button type="submit" class="btn btn-success pull-right">
                                    <i class="fa fa-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('../partials/_scripts.php') ?>
</body>
</html>
