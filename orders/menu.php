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

                <h3><?php echo APP_NAME; ?> Menu</h3>
                <p>Choose meal(s) and (or) beverage(s) from below:</p>

                <div class="row">
                    <?php foreach ($foods as $food) { ?>
                        <div class="col-sm-4" style="margin-top: 25px;padding: 25px 50px;">
                            <form id="food-<?php echo $food['id']; ?>" class="text-center" method="POST"
                                  action="<?php echo route('orders/scripts/add_to_cart.php'); ?>"
                                  enctype="application/x-www-form-urlencoded">
                                <input type="hidden" name="order" value="<?php echo $food['id']; ?>">

                                <?php if (!isset($food['image'])) { ?>
                                    <div class="text-center"
                                         style="width: 250px; height: 150px; border-radius: 100%; position: relative">
                                        <span style="position: absolute; top: 30%;">
                                            <?php echo $food['name']; ?> image
                                        </span>
                                    </div>
                                <?php } else { ?>
                                    <img src="<?php echo route($food['image']); ?>"
                                         alt="<?php echo $food['name']; ?> image"
                                         class="text-center img-circle" width="250px" height="150px">
                                <?php } ?>

                                <div class="form-group">
                                    <h4 data-toggle="tooltip" title="<?php echo $food['details']; ?>">
                                        <?php echo $food['name']; ?>
                                        <i class="fa fa-info-circle"></i>
                                    </h4>
                                </div>

                                <div class="form-group">
                                    <?php echo APP_CURRENCY; ?> <span class="lead"><?php echo $food['price']; ?></span>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">Qty.</span>

                                        <input type="number" name="order_quantity"
                                               class="form-control order-quantity"
                                               data-target="#food-<?php echo $food['id']; ?>" max="20" min="1"
                                               value="1">

                                        <span class="input-group-btn">
                                           <button type="submit" class="btn btn-success pull-right">
                                                <i class="fa fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('../partials/_scripts.php') ?>
</body>
</html>
