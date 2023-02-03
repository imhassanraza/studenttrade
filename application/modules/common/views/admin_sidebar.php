<?php  $url = $_SERVER['REQUEST_URI']; ?>
<?php
$r_class = $this->router->fetch_class();
$r_method = $this->router->fetch_method();
?>

<!-- Menu aside start -->
<div class="main-menu" id="menu-static">
    <div class="main-menu-header">
        <img class="img-40" src="<?php echo base_url(); ?>admin_assets/images/user.png" alt="User-Profile-Image">
        <div class="user-details">
            <span> <?php echo get_session('admin_username'); ?> </span>
        </div>
    </div>
    <div class="main-menu-content">
        <ul class="main-navigation">
            <li class="nav-item single-item <?php if (preg_match("/dashboard/i", $url )) { ?> has-class open <?php } ?>">
                <a href="<?php echo admin_url(); ?>dashboard">
                    <i class="ti-home"></i>
                    <span data-i18n="nav.dash.main">Dashboard</span>
                </a>
            </li>

            <li class="nav-item <?php if (preg_match("/books/i", $url )) { ?> has-class <?php } ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-book"></i>
                    <span data-i18n="nav.bootstrap-books.main">Books</span>
                </a>
                <ul class="tree-1 <?php if (preg_match("/books/i", $url )) { ?> open <?php } ?>">

                    <li class="<?php if($r_class == 'books' && $r_method == 'index') { ?>active<?php } ?>">
                        <a href="<?php echo admin_url(); ?>books" data-i18n="nav.bootstrap-books.books">New Books</a>
                    </li>

                    <li class="<?php if($r_class == 'books' && $r_method == 'used_books') { ?>active<?php } ?>">
                        <a href="<?php echo admin_url(); ?>books/used_books" data-i18n="nav.bootstrap-books.used_books">Used Books</a>
                    </li>

                </ul>
            </li>


            <li class="nav-item <?php if (preg_match("/users/i", $url )) { ?> has-class <?php } ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-users"></i>
                    <span data-i18n="nav.bootstrap-users.main">Users</span>
                </a>
                <ul class="tree-1 <?php if (preg_match("/users/i", $url )) { ?> open <?php } ?>">

                    <li class="<?php if($r_class == 'users' && $r_method == 'add_user') { ?>active<?php } ?> ">
                        <a href="<?php echo admin_url(); ?>users/add_user" data-i18n="nav.bootstrap-users.add_user">Add users</a>
                    </li>

                    <li class="<?php if($r_class == 'users' && $r_method == 'index') { ?>active<?php } ?> ">
                        <a href="<?php echo admin_url(); ?>users" data-i18n="nav.bootstrap-users.list_users">List of users</a>
                    </li>

                </ul>
            </li>

            <li class="nav-item <?php if (preg_match("/orders/i", $url )) { ?> has-class <?php } ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-clipboard-list"></i>
                    <span data-i18n="nav.bootstrap-orders.main">Orders</span>
                </a>
                <ul class="tree-1 <?php if (preg_match("/orders/i", $url )) { ?> open <?php } ?>">

                    <li class="<?php if($r_class == 'orders' && $r_method == 'index') { ?>active<?php } ?> ">
                        <a href="<?php echo admin_url(); ?>orders" data-i18n="nav.bootstrap-orders.main">New Orders</a>
                    </li>

                    <li class="<?php if($r_class == 'orders' && $r_method == 'completed') { ?>active<?php } ?> ">
                        <a href="<?php echo admin_url(); ?>orders/completed" data-i18n="nav.bootstrap-orders.list_users">Completed Orders</a>
                    </li>

                    <li class="<?php if($r_class == 'orders' && $r_method == 'cancelled') { ?>active<?php } ?> ">
                        <a href="<?php echo admin_url(); ?>orders/cancelled" data-i18n="nav.bootstrap-orders.list_users">Cancelled Orders</a>
                    </li>

                    <!-- <li class="<?php // if($r_class == 'orders' && $r_method == 'refunded') { ?>active<?php // } ?> ">
                        <a href="<?php // echo admin_url(); ?>orders/refunded" data-i18n="nav.bootstrap-orders.list_users">Refunded Orders</a>
                    </li> -->

                </ul>
            </li>

            <li class="nav-item single-item <?php if($r_class == 'discount_code' && $r_method == 'index') { ?> has-class <?php } ?>">
                <a href="<?php echo admin_url(); ?>discount_code">
                    <i class="fa fa-tag"></i>
                    <span data-i18n="nav.bootstrap-discount_code.main">Discount Codes</span>
                </a>
            </li>


            <li class="nav-item single-item <?php if($r_class == 'settings' && $r_method == 'index') { ?> has-class <?php } ?>">
                <a href="<?php echo admin_url(); ?>settings">
                    <i class="ti-settings"></i>
                    <span data-i18n="nav.bootstrap-settings.main">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Menu aside end -->