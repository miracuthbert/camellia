<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="<?php echo route(''); ?>">
                <?php echo APP_NAME; ?>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="<?php echo route(''); ?>">View Site</a></li>&nbsp;
                <li><a href="<?php echo route("admin/dashboard.php"); ?>">Dashboard</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <?php if (!session_has("user")) { ?>

                    <!-- Authentication Links -->
                    <li><a href="<?php echo route("auth/login.php"); ?>">Login</a></li>
                    <li><a href="<?php echo route("auth/register.php"); ?>">Register</a></li>

                <?php } else { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Add new
                            <span class="caret"></span>
                        </a>
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

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                           aria-haspopup="true">
                            <?php echo session_has('user', 'first_name') ? session_get('user', 'first_name') : '' ?>
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="<?php echo route("dashboard.php"); ?>">My Dashboard</a></li>
                            <li><a href="<?php echo route("user/profile.php"); ?>">My Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="<?php echo route("logout.php"); ?>"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="<?php echo route("logout.php"); ?>" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>

            <a role="button" href="<?php echo route('admin/orders/index.php'); ?>"
               class="btn btn-primary navbar-btn pull-right">
                <i class="fa fa-shopping-basket"></i> Orders
                <span class="badge"><?php echo count(pendingOrders()) > 0 ? count(pendingOrders()) : ''; ?></span>
            </a>

        </div>
    </div>
</nav>