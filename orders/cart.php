<?php
include_once("../config.php");
include_once("../helpers.php");
include_once("../functions.php");
unauthenticated();

$foods = orderFoods();

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

                <form class="form-horizontal" method="POST"
                      action="<?php /*echo route('orders/scripts/calculate_cart.php'); */ ?>"
                      enctype="application/x-www-form-urlencoded">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3><?php echo APP_NAME; ?> Menu</h3>
                            <p>Choose meal(s) and (or) beverage(s) from below:</p>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4"><strong>Name</strong></div>
                                <div class="col-sm-2"><strong>Price</strong></div>
                                <div class="col-sm-2"><strong>Qty.</strong></div>
                                <div class="col-sm-2"><strong>Total</strong></div>
                            </div>
                            <hr>

                            <?php foreach ($foods as $key => $food) { ?>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <input type="hidden" name="order[]" id="food-<?php echo $food['id']; ?>"
                                               value="<?php echo $food['id']; ?>">

                                        <img class="media-object" src="<?php echo $food['image']; ?>" alt="image"
                                             class="img-responsive">
                                    </div>
                                    <div class="col-sm-4">
                                        <h4 data-toggle="tooltip" title="<?php echo $food['details']; ?>">
                                            <?php echo $food['name']; ?>
                                            <i class="fa fa-info"></i>
                                        </h4>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php echo APP_CURRENCY; ?> <strong><?php echo $food['price']; ?></strong>
                                    </div>
                                    <div class="col-sm-2">
                                        <strong><?php echo $_SESSION['cart']['orderQty'][$key]; ?></strong>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php echo APP_CURRENCY; ?>
                                        <strong><?php echo $_SESSION['cart']['orderPrices'][$key]; ?></strong>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-4">
                                    <a role="button" href="<?php echo route('orders/menu.php'); ?>"
                                       class="btn btn-warning">
                                        <i class="fa fa-shopping-basket"></i> Cancel and Place New Order
                                    </a>
                                </div>

                                <div class="col-sm-2 col-sm-offset-6">
                                    <?php echo APP_CURRENCY; ?> <strong><?php echo cartTotal(); ?></strong>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Submit Order
                                    </button>
                                </div>
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
