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
                    <li><a href="<?php echo route("dashboard.php"); ?>">My Dashboard</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                           aria-haspopup="true">
                            <?php echo session_has('user', 'first_name') ? session_get('user', 'first_name') : '' ?>
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
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

            <a role="button" href="<?php echo route('orders/menu.php'); ?>" class="btn btn-success navbar-btn pull-right">
                <i class="fa fa-shopping-basket"></i> Place an Order
            </a>
        </div>
    </div>
</nav>