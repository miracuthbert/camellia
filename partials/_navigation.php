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
                <li><a href="<?php echo route(''); ?>">Home</a></li>&nbsp;
                <li><a href="<?php echo route("about.php"); ?>">About</a></li>
                <li><a href="<?php echo route("contact.php"); ?>">Contact</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <?php if (!session_has("user")) { ?>

                    <!-- Authentication Links -->
                    <li><a href="<?php echo route("auth/login.php"); ?>">Login</a></li>
                    <li><a href="<?php echo route("auth/register.php"); ?>">Register</a></li>

                <?php } else { ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                           aria-haspopup="true">
                            <?php echo session_has('user', 'first_name') ? session_get('user', 'first_name') : '' ?>
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <?php if (hasRoles(auth()['id'])) { ?>
                                <li>
                                    <a href="<?php echo route("admin/dashboard.php"); ?>">Admin Panel</a>
                                </li>
                                <li role="separator" class="divider"></li>
                            <?php } ?>
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

            <?php if (session_has('cart')) { ?>
                <a role="button" href="<?php echo route('orders/menu.php'); ?>"
                   class="btn btn-success navbar-btn pull-right" style="margin-right: 7px;">
                    <i class="fa fa-shopping-basket"></i> Menu
                </a>

                <a role="button" href="<?php echo route('orders/cart.php'); ?>"
                   class="btn btn-success navbar-btn pull-right" style="margin-right: 7px;">
                    <i class="fa fa-shopping-cart"></i> Cart
<!--                    <span class="badge">--><?php //echo APP_CURRENCY; ?><!-- --><?php //echo cartTotal(); ?><!--</span>-->
                    <sup class="badge"><?php echo session_get('cart', 'qty'); ?></sup>
                </a>
            <?php } else { ?>
                <a role="button" href="<?php echo route('orders/menu.php'); ?>"
                   class="btn btn-success navbar-btn pull-right" style="margin-right: 7px;">
                    <i class="fa fa-shopping-basket"></i> Place an Order
                </a>
            <?php } ?>
        </div>
    </div>
</nav>