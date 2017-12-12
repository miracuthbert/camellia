<?php
include_once("../../config.php");
include_once("../../helpers.php");
include_once("../../functions.php");
include_once("../functions.php");

unauthenticated();
$orders = orders();

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
                    <div class="panel-heading">Orders</div>

                    <?php if (isset($orders) && (count($orders) > 0)) { ?>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Pickup/Delivery Date</th>
                                <th>Created At Date</th>
                                <th>Status</th>
                                <th>Items</th>
                                <th>Total Price</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orders as $order) { ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo route("admin/orders/index.php?user={$order['user_id']}") ?>">
                                            <?php echo $order['first_name'] . ' ' . $order['last_name']; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $order['booked_at']; ?></td>
                                    <td><?php echo $order['created_at']; ?></td>
                                    <td>
                                        <?php if (isset($order['paid_at'])) { ?>
                                            <span class="label label-success">Paid</span>
                                        <?php } elseif(isset($order['expired_at'])) { ?>
                                            <span class="label label-danger">Cancelled</span>
                                        <?php } else { ?>
                                            <span class="label label-warning">Pending</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span class="lead"><?php echo orderItemsCount($order['id']); ?></span>
                                    </td>
                                    <td>
                                        <?php echo APP_CURRENCY; ?>
                                        <span class="lead"><?php echo orderTotal($order['id']); ?></span>
                                    </td>
                                    <td>
                                        <ul class="list-inline">
                                            <li>
                                                <a href="<?php echo route("admin/orders/edit.php?order={$order['id']}") ?>">
                                                    View
                                                </a>
                                            </li>
                                            <?php if (!isset($order['paid_at'])) { ?>
                                                <li>
                                                    <a href="<?php echo route("admin/orders/scripts/update_paid_at.php?order={$order['id']}"); ?>"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('order-<?php echo $order["id"]; ?>-paid-at-form').submit();">
                                                        Mark as paid
                                                    </a>

                                                    <form id="order-<?php echo $order['id']; ?>-paid-at-form"
                                                          action="<?php echo route("admin/orders/scripts/update_paid_at.php?order={$order['id']}"); ?>"
                                                          method="POST"
                                                          style="display: none;">

                                                        <input type="hidden" name="_id"
                                                               value="<?php echo $order['id']; ?>">
                                                        <input type="hidden" name="status"
                                                               value="<?php echo !$order['status']; ?>">
                                                        <input type="hidden" name="_method" id="_method" value="PUT">
                                                    </form>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                </div>
                <?php } else { ?>
                    <p class="text-muted text-center">No orders found.</p>
                <?php }; ?>
            </div>
        </div>
    </div>
</div>

</div>

<?php include_once('../../partials/_scripts.php'); ?>
</body>
</html>
