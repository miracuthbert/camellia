<div class="panel panel-default">
    <div class="panel-heading">Menu</div>

    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="<?php echo route("admin/dashboard.php"); ?>">Dashboard</a></li>
            <li>
                <a href="<?php echo route('orders/index.php'); ?>">
                    Orders <sup class="badge">0</sup>
                </a>
            </li>
            <li role="separator" class="nav-divider"></li>
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Add new</a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="<?php echo route('admin/categories/create.php'); ?>">Category</a>
                        <a href="<?php echo route('admin/meals/create.php'); ?>">Meal</a>
                        <a href="<?php echo route('admin/beverages/create.php'); ?>">Beverages</a>
                        <a href="">User</a>
                    </li>
                </ul>
            </li>
            <li role="separator" class="nav-divider"></li>
            <li><a href="<?php echo route('admin/categories/index.php'); ?>">Categories</a></li>
            <li><a href="<?php echo route('admin/meals/index.php'); ?>">Meals</a></li>
            <li><a href="">Beverages</a></li>
            <li><a href="">Roles</a></li>
            <li><a href="">Users</a></li>
        </ul>
    </div>
</div>
