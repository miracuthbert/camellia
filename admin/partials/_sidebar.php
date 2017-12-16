<div class="panel panel-default">
    <div class="panel-heading">Menu</div>

    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="<?php echo route("admin/dashboard.php"); ?>">Dashboard</a></li>
            <li>
                <a href="<?php echo route('admin/orders/index.php'); ?>">
                    Orders
                    <span class="badge"><?php echo count(pendingOrders()) > 0 ? count(pendingOrders()) : ''; ?></span>
                </a>
            </li>
            <li role="separator" class="nav-divider"></li>
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Add new</a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="<?php echo route('admin/categories/create.php'); ?>">Category</a>
                        <a href="<?php echo route('admin/meals/create.php'); ?>">Meal/Beverage</a>
                        <a href="">User</a>
                    </li>
                </ul>
            </li>
            <li role="separator" class="nav-divider"></li>
            <li><a href="<?php echo route('admin/categories/index.php'); ?>">Categories</a></li>
            <li><a href="<?php echo route('admin/meals/index.php'); ?>">Meals</a></li>
            <li><a href="<?php echo route('admin/meals/index.php?category=drinks'); ?>">Beverages</a></li>
            <li><a href="">Roles</a></li>
            <li><a href="<?php echo route('admin/users/index.php'); ?>">Users</a></li>
        </ul>
    </div>
</div>
