<?php
include_once("../config.php");
include_once("../helpers.php");
include_once("../functions.php");

unauthenticated();

$order = $_GET['order'];

$order = order($order);
$foods = orderItems($order['id']);
$payment = orderPayment($order['id']);
$cashier = isset($payment['user_id']) ? userById($payment['user_id']) : '';
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
            <div class="col-sm-12">

                <nav>
                    <ul class="breadcrumb">
                        <li><?php echo APP_NAME; ?></li>
                        <li>User</li>
                        <li>
                            <a href="<?php echo route("dashboard.php"); ?>">Orders</a>
                        </li>
                        <li>Order #<?php echo $order['id']; ?></li>
                    </ul>
                </nav>

                <div class="panel panel-default">
                    <div class="panel-heading">Order #<?php echo $order['id']; ?></div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route("user/scripts/cancel_order.php?order={$order['id']}"); ?>">

                            <input type="hidden" name="_id" id="_id" value="<?php echo $order['id']; ?>">
                            <input type="hidden" name="_method" id="_method" value="PUT">

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Pickup/Delivery Date</label>

                                <div class="col-md-6">
                                    <p class="form-control-static"><?php echo $order['booked_at']; ?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Created At Date</label>

                                <div class="col-md-6">
                                    <p class="form-control-static"><?php echo $order['created_at']; ?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Status</label>

                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        <?php if (isset($order['paid_at'])) { ?>
                                            <span class="label label-success">Paid</span>
                                        <?php } elseif (isset($order['expired_at'])) { ?>
                                            <span class="label label-danger">Cancelled</span>
                                        <?php } else { ?>
                                            <span class="label label-warning">Pending</span>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>

                            <?php if (!isset($order['paid_at'])) { ?>
                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Cancelled At</label>

                                    <div class="col-md-6">
                                        <p class="form-control-static"><?php echo $order['expired_at']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (!isset($order['expired_at'])) { ?>
                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Paid At</label>

                                    <div class="col-md-6">
                                        <p class="form-control-static"><?php echo $order['paid_at']; ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Processed by</label>

                                    <div class="col-md-6">
                                        <p class="form-control-static">
                                            <?php echo isset($cashier['id']) ? $cashier['first_name'] . ' ' . $cashier['last_name'] : ''; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <?php if (!isset($order['paid_at']) && !isset($order['expired_at'])) { ?>
                                        <button type="submit" class="btn btn-primary">
                                            Cancel Order
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>

                        <hr>
                        <h3>
                            Order Items
                            <span class="badge"><?php echo orderItemsCount($order['id']); ?></span>
                        </h3>
                        <p>
                            Total: <?php echo APP_CURRENCY; ?>
                            <span class="lead"><?php echo orderTotal($order['id']); ?></span>
                        </p>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Qty.</th>
                                    <th>Total</th>
                                </tr>
                                </thead>

                                <?php foreach ($foods as $key => $food) { ?>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <img src="<?php echo route($food['image']); ?>"
                                                 alt="<?php echo $food['name']; ?> image"
                                                 width="100px" height="70px">
                                        </td>
                                        <td>
                                            <h4 data-toggle="tooltip" title="<?php echo $food['details']; ?>">
                                                <?php echo $food['name']; ?>
                                                <i class="fa fa-info-circle"></i>
                                            </h4>
                                        </td>
                                        <td>
                                            <?php echo APP_CURRENCY; ?> <strong><?php echo $food['price']; ?></strong>
                                        </td>
                                        <td>
                                            <?php echo $food['quantity']; ?>
                                        </td>
                                        <td>
                                            <?php echo APP_CURRENCY; ?>
                                            <strong><?php echo $food['price'] * $food['quantity']; ?></strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                <?php } ?>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include_once('../partials/_scripts.php'); ?>
</body>
</html>
