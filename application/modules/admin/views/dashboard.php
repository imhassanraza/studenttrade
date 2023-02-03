<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');
?>
<!-- Main-body start-->
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Dashboard</h4>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card table-card">
                        <div class="">
                            <div class="row-table">
                                <div class="col-sm-3 card-block-big br">
                                    <a href="<?php echo admin_url(); ?>users">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <i class="icofont icofont-users text-success"></i>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <h5><?php echo get_all_users(); ?></h5>
                                                <span>Users</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-3 card-block-big br">
                                    <a href="<?php echo admin_url(); ?>books">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <i class="ti-book text-success"></i>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <h5><?php echo get_all_books(); ?></h5>
                                                <span>New Books</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-3 card-block-big br">
                                    <a href="<?php echo admin_url(); ?>books/used_books">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <i class="ti-book text-success"></i>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <h5><?php echo get_used_books(); ?></h5>
                                                <span>Used Books</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-3 card-block-big br">
                                    <a href="<?php echo admin_url(); ?>orders">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <i class="fa fa-clipboard-list text-success"></i>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <h5><?php echo get_booking_oders(array('1','2')); ?></h5>
                                                <span>Orders</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<!-- Main-body end-->
<?php $this->load->view('common/admin_footer'); ?>