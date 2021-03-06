<?php
include_once("../config.php");
include_once("../helpers.php");
include_once("../functions.php");
unauthenticated();

//check if cart is empty and redirect to menu
cartEmpty();

$foods = session_get('cart', 'items');

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
                      action="<?php echo route('orders/scripts/store.php'); ?>"
                      enctype="application/x-www-form-urlencoded">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3><?php echo APP_NAME; ?> Menu</h3>
                            <p>Choose meal(s) and (or) beverage(s) from below:</p>
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-3"><strong>Name</strong></div>
                                <div class="col-sm-2"><strong>Price</strong></div>
                                <div class="col-sm-1"><strong>Qty.</strong></div>
                                <div class="col-sm-2"><strong>Total</strong></div>
                                <div class="col-sm-2"></div>
                            </div>
                            <hr>

                            <?php foreach ($foods as $key => $food) { ?>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <img src="<?php echo route($food['image']); ?>"
                                             alt="<?php echo $food['name']; ?> image" width="100px" height="70px">
                                    </div>
                                    <div class="col-sm-3">
                                        <h4 title="<?php echo $food['name']; ?>">
                                            <?php echo $food['name']; ?>
                                        </h4>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php echo APP_CURRENCY; ?> <strong><?php echo $food['price']; ?></strong>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="number" name="order_quantity[]"
                                               id="food-<?php echo $food['id']; ?>"
                                               class="form-control" value="<?php echo $food['qty']; ?>" min="1" max="20">
                                    </div>
                                    <div class="col-sm-2">
                                        <?php echo APP_CURRENCY; ?>
                                        <strong><?php echo $food['totalPrice']; ?></strong>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="order[]" id="food-<?php echo $food['id']; ?>"
                                               value="<?php echo $food['id']; ?>">
                                        <a class="btn btn-warning" href=""
                                           onclick="event.preventDefault();document.getElementById('remove-<?php echo $food["id"]; ?>-food-form').submit();">
                                            <i class="fa fa-remove"></i> Remove
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-8">
                                    <?php echo APP_CURRENCY; ?> <strong><?php echo cartTotal(); ?></strong>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-4">
                                    <a role="button" href="<?php echo route('orders/scripts/empty_cart.php'); ?>"
                                       class="btn btn-warning"
                                       onclick="event.preventDefault();document.getElementById('cancel-order-form').submit();">
                                        <i class="fa fa-shopping-basket"></i> Cancel and Place New Order
                                    </a>
                                </div>

                                <div class="col-sm-5 col-sm-offset-3">
                                    <a role="button" href="<?php echo route('orders/menu.php'); ?>"
                                       class="btn btn-success" style="margin-right: 7px;">
                                        <i class="fa fa-shopping-basket"></i> Menu
                                    </a>

                                    <button name="updateCart" class="btn btn-success"
                                            style="margin-right: 7px;" value="1">
                                        <i class="fa fa-refresh"></i> Update Cart
                                    </button>

                                    <button type="submit" name="storeCart" class="btn btn-primary"
                                            style="margin-right: 7px;" value="1">
                                        <i class="fa fa-check"></i> Submit Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Cancel Order Form -->
                <form id="cancel-order-form"
                      action="<?php echo route('orders/scripts/empty_cart.php'); ?>" method="POST"
                      style="display: none;">
                </form>

                <!-- Create Individual Forms to Remove Foods from Cart -->
                <?php foreach ($foods as $key => $food) { ?>
                    <!-- Remove Food Form -->
                    <form id="remove-<?php echo $food['id']; ?>-food-form"
                          action="<?php echo route('orders/scripts/remove_from_cart.php'); ?>" method="POST"
                          style="display: none;">
                        <input type="hidden" name="id" value="<?php echo $food['id']; ?>">
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include_once('../partials/_scripts.php') ?>
</body>
</html>
