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
                        <div class="col-sm-4">
                            <form id="food-<?php echo $food['id']; ?>" class="text-center" method="POST"
                                  action="<?php echo route('orders/scripts/add_to_cart.php'); ?>"
                                  enctype="application/x-www-form-urlencoded">
                                <input type="hidden" name="order" value="<?php echo $food['id']; ?>">

                                <img class="media-object" src="<?php echo $food['image']; ?>" alt="image"
                                     class="img-responsive">

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
<script>
    $(document).on('order-quantity', 'focus', (event)
    {
        var $this = $(this);

        var food = $this.attr('data-target');

        //check food of focused quanntity
        $(food).prop('checked', true);
    }
    )
    ;
</script>
</body>
</html>
