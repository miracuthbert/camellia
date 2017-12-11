<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("functions.php");

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
                    <div class="panel-heading">Edit Order</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST"
                              action="<?php echo route("admin/orders/scripts/update_paid_at.php?order={$order['id']}"); ?>">

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

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <?php if (!isset($order['paid_at'])) { ?>
                                        <button type="submit" class="btn btn-primary">
                                            Mark as Paid
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
                                            <img class="media-object" src="<?php echo $food['image']; ?>" alt="image"
                                                 class="img-responsive">
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

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
