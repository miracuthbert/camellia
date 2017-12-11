<?php
include_once("config.php");
include_once("helpers.php");
include_once("functions.php");
unauthenticated();

$orders = userOrders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('partials/_head.php') ?>
</head>
<body>
<div id="app">
    <?php include_once('partials/_navigation.php') ?>

    <div class="container">
        <?php include_once('partials/_alerts.php') ?>

        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                <h3>My Orders</h3>
                <p class="text-muted">A list of orders sorted by latest first</p>
                <hr>

                <?php if (count($orders) > 0) { ?>
                    <div class="row hidden-xs">
                        <div class="col-sm-3">
                            <strong>Pickup/Delivery Date</strong>
                        </div>
                        <div class="col-sm-3">
                            <strong>Created At Date</strong>
                        </div>
                        <div class="col-sm-2">
                            <strong>Items</strong>
                        </div>
                        <div class="col-sm-2">
                            <strong>Total Price</strong>
                        </div>
                        <div class="col-sm-2">
                            &nbsp;
                        </div>
                    </div>
                    <hr>
                    <?php foreach ($orders as $order) { ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <a href="<?php echo route("user/order.php?order={$order['id']}") ?>">
                                    <?php echo $order['booked_at']; ?>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <?php echo $order['created_at']; ?>
                            </div>
                            <div class="col-sm-2">
                                <span class="lead"><?php echo orderItemsCount($order['id']); ?></span>
                            </div>
                            <div class="col-sm-2">
                                <?php echo APP_CURRENCY; ?>
                                <span class="lead"><?php echo orderTotal($order['id']); ?></span>
                            </div>
                            <div class="col-sm-2">
                                <ul class="list-inline">
                                    <?php if (!isset($order['paid_at'])) { ?>
                                        <li>
                                            <a href="">
                                                Cancel Order
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <hr>
                    <?php } ?>
                <?php } else { ?>
                    <p class="text-muted">No orders found.</p>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

<?php include_once('partials/_scripts.php') ?>
</body>
</html>
