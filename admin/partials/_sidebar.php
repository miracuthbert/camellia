<div class="panel panel-default">
    <div class="panel-heading">Menu</div>

    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Add new</a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="<?php echo route('admin/categories/create.php'); ?>">Category</a>
                    </li>
                    <li>
                        <a href="<?php echo route('admin/meals/create.php'); ?>">Meal/Beverage</a>
                    </li>
                    <?php if (hasRoles(auth(), "admin")) { ?>
                        <li>
                            <a href="<?php echo route('admin/roles/create.php'); ?>">User</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo route('admin/pages/create.php'); ?>">Page</a>
                    </li>
                    <li>
                        <a href="<?php echo route('admin/posts/create.php'); ?>">Post</a>
                    </li>
                </ul>
            </li>

            <!-- Top Links -->
            <li role="separator" class="nav-divider"></li>
            <li><a href="<?php echo route("admin/dashboard.php"); ?>">Dashboard</a></li>
            <li>
                <a href="<?php echo route('admin/orders/index.php'); ?>">
                    Orders
                    <span class="badge"><?php echo count(pendingOrders()) > 0 ? count(pendingOrders()) : ''; ?></span>
                </a>
            </li>

            <!-- Pages and Posts -->
            <li role="separator" class="nav-divider"></li>
            <li><a href="<?php echo route('admin/pages/index.php'); ?>">Pages</a></li>
            <li><a href="<?php echo route('admin/posts/index.php'); ?>">Posts</a></li>

            <!-- Foods -->
            <li role="separator" class="nav-divider"></li>
            <li><a href="<?php echo route('admin/categories/index.php'); ?>">Categories</a></li>
            <li><a href="<?php echo route('admin/meals/index.php'); ?>">Meals</a></li>
            <li><a href="<?php echo route('admin/meals/index.php?category=drinks'); ?>">Beverages</a></li>

            <!-- Users & Roles - Accessible by `Admin` Role Holders Only -->
            <?php if (hasRoles(auth(), "admin")) { ?>
                <li role="separator" class="nav-divider"></li>
                <!--            <li><a href="">Roles</a></li>-->
                <li><a href="<?php echo route('admin/users/index.php'); ?>">Users</a></li>
            <?php } ?>
        </ul>
    </div>
</div>
