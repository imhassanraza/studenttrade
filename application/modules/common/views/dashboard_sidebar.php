<?php  $url = $_SERVER['REQUEST_URI']; ?>
<?php
$r_class = $this->router->fetch_class();
$r_method = $this->router->fetch_method();
?>


<div class="col-md-3">
    <div class="list-group user-dashboard">
        <!-- <a href="<?php // echo base_url(); ?>user/dashboard" class="list-group-item <?php // if($r_class == 'user' && $r_method == 'dashboard') { ?> active <?php // } ?>">
            <i  class="fa fa-tachometer"></i><?php // echo lang('dashboard'); ?>
        </a> -->
        <a href="<?php echo base_url(); ?>user/profile" class="list-group-item <?php if (preg_match("/profile/i", $url )) { ?> active <?php } ?> <?php if($r_class == 'user' && $r_method == 'dashboard') { ?> active <?php } ?>"><i class="fa fa-user"></i><?php echo lang('profile'); ?></a>

        <a href="<?php echo base_url(); ?>user/seller_orders" class="list-group-item <?php if($r_class == 'user' && $r_method == 'seller_orders') { ?> active <?php } ?>"><i class="fa fa-cart-arrow-down"></i><?php echo lang('orders'); ?> <span class="label label-info pull-right"><?php echo lang('seller'); ?></span></a>

        <a href="<?php echo base_url(); ?>user/buyer_orders" class="list-group-item <?php if($r_class == 'user' && $r_method == 'buyer_orders') { ?> active <?php } ?>"><i class="fa fa-cart-arrow-down"></i><?php echo lang('orders'); ?> <span class="label label-success pull-right"><?php echo lang('buyer'); ?></span></a>


        <a href="<?php echo base_url(); ?>user/settings" class="list-group-item <?php if($r_class == 'user' && $r_method == 'settings') { ?> active <?php } ?>"><i class="fa fa-wrench"></i><?php echo lang('settings'); ?></a>

        <a href="<?php echo base_url(); ?>user/books" class="list-group-item <?php if($r_class == 'user' && $r_method == 'books') { ?> active <?php } ?>"><i class="fa fa-book"></i><?php echo lang('books'); ?></a>

    </div>
</div>