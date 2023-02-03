<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');
?>
<style type="text/css">
    [aria-hidden="true"] {
        opacity: 0;
        z-index: -9999;
        pointer-events: none;
    }
    .alert {
        z-index: 99999999999999 !important;
    }
</style>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>User Profile Detail</h4>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="content social-timeline">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-xs-12">

                                <div class="social-timeline-left">

                                    <div class="card" style="width: 280px;">
                                        <div class="social-profile text-center">
                                            <img class="img-fluid width-100" src='<?php echo base_url();?>assets/profile_pictures/<?php echo $user['profile_dp']; ?>'  alt="">
                                        </div>
                                        <div class="card-block social-follower">
                                            <h4><?php echo $user['first_name'].' '. $user['last_name']; ?></h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-8 col-xs-12 ">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">User Information</h5>
                                            </div>


                                            <div class="card-block">

                                                <div class="row invoive-info">
                                                    <div class="col-md-6 col-xs-12 ">
                                                        <h6 style="font-size: 14px;">Basic Information :</h6>
                                                        <p class="m-0 m-t-10"><strong>Email: </strong><a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></p>
                                                        <p class="m-0 m-t-10"><strong>Phone Number: </strong><a href="tel:<?php echo $user['phone']; ?>"><?php echo $user['phone']; ?></a></p>
                                                        <p class="m-0 m-t-10"><strong>Address: </strong><?php echo $user['address1'].' '. $user['address2'].' '. $user['city'].' '. $user['state'].' '. $user['zip']; ?></p>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <h6 style="font-size: 14px;">Payment Information :</h6>
                                                        <p class="m-0"><strong>Transfer Payment: </strong>
                                                            <?php if ($user['amount_tranfer'] == 0) { ?>
                                                                <label class="label label-success">PayPal</label>
                                                            <?php }else{ ?>
                                                                <label class="label label-success">Bank Account</label>
                                                            <?php } ?>
                                                        </p>

                                                        <?php if ($user['amount_tranfer'] == 0) { ?>
                                                            <strong>Paypal ID : </strong>
                                                            <?php if ($user['paypal_email'] == ""){ ?>
                                                             <label class="label label-danger">N/A</label>
                                                         <?php }else{ ?>
                                                            <span><?php echo $user['paypal_email']; ?></span>
                                                            <div class="btn-group" style="margin-left: 5px;">
                                                                <button type="button" onclick="copy_paypal_id();" class="btn btn-primary btn-mini waves-effect waves-light" title="Copy PayPal ID"><i class="fa fa-copy fa-lg"></i></button>
                                                            </div>
                                                            <input type="text" id="paypal" value="<?php echo $user['paypal_email']; ?>" aria-hidden="true">
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                        <strong>IBAN (BANK) Number : </strong>
                                                        <?php if ($user['iban_number'] == ""){ ?>
                                                         <label class="label label-danger">N/A</label>
                                                     <?php }else{ ?>
                                                        <span><?php echo $user['iban_number']; ?></span>
                                                        <div class="btn-group" style="margin-left: 5px;">
                                                            <button type="button" onclick="copy_iban_number();" class="btn btn-primary btn-mini waves-effect waves-light" title="Copy IBAN"><i class="fa fa-copy fa-lg"></i></button>
                                                        </div>
                                                        <input type="text" id="iban" value="<?php echo $user['iban_number']; ?>" aria-hidden="true">
                                                    <?php } ?>
                                                <?php } ?>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>








                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-header-text">User Orders</h5>
                                    </div>
                                    <div class="card-block">

                                       <div class="table-contentt crm-tablee">
                                        <div class="project-tablee">
                                            <table id="order_contact" class="table table-striped dt-responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Order Date</th>
                                                        <th>Transaction ID</th>
                                                        <th>Amount</th>
                                                        <th>Payment Status</th>
                                                        <th>Orders Status</th>
                                                        <th>Payer Email</th>
                                                        <th>University</th>
                                                        <th>Discount Code</th>
                                                        <th>Discount Type</th>
                                                        <th>Discount Value</th>
                                                        <th>Sub Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($orders as $order) { ?>
                                                        <tr>
                                                            <td> <?php echo $order['id']; ?> </td>
                                                            <td><?php echo date('d/m/Y' , strtotime($order['order_date'])); ?></td>
                                                            <td> <?php echo $order['trx_id']; ?> </td>
                                                            <td> <?php echo $order['trx_amount']; ?> CHF </td>
                                                            <td>

                                                                <?php if ($order['payment_status'] == 1){ ?>
                                                                    <label class="label label-info">Completed</label>
                                                                <?php }else{ ?>
                                                                    <label class="label label-danger">Pending</label>
                                                                <?php } ?>

                                                            </td>

                                                            <td>

                                                                <?php if($order['status'] == 1){ ?>
                                                                    <label class="label label-info">Pending</label>
                                                                <?php } elseif($order['status'] == 2){ ?>
                                                                    <label class="label label-info">Processing</label>
                                                                <?php } elseif($order['status'] == 3){ ?>
                                                                    <label class="label label-info">Complete</label>
                                                                <?php } else{ ?>
                                                                    <label class="label label-danger">Cancel</label>
                                                                <?php } ?>

                                                            </td>
                                                            <td> <?php echo $order['payer_email']; ?> </td>
                                                            <td><?php echo $order['selected_university']; ?></td>
                                                            <td> <?php echo $order['discount_code']; ?> </td>
                                                            <td>
                                                                <?php if ($order['code_type'] == 1) { ?>
                                                                    <label class="label label-info">Fixed Value</label>
                                                                <?php } else if ($order['code_type'] == 2) { ?>
                                                                    <label class="label label-success">Percentage</label>
                                                                <?php } else { ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php if($order['code_type'] == 1) { ?>
                                                                    <?php echo $order['code_amount']; ?>
                                                                <?php } else if ($order['code_type'] == 2) { ?>
                                                                    <?php echo $order['code_amount']; ?>%
                                                                <?php } else { ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td> <?php echo $order['sub_total']; ?> </td>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm orders_detail" data-id="<?php echo $order['id']; ?>" type="button" data-toggle="tooltip" data-placement="top" title="Details"><i class="fa fa-info-circle fa-lg"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
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
</div>
</div>
<!--BEGAN ORDER DETAIL MODAL BOX  -->
<div class="modal" id="order_modalbox">
    <div class="modal-dialog modal-xl" id="order_modalbox_body"></div>
</div>
<!--END ORDER DETAIL MODAL BOX  -->
</div>
</div>

<?php $this->load->view('common/admin_footer'); ?>
<script src="<?php echo base_url(); ?>admin_assets/js/jquery.validate.min.js" type="text/javascript"></script>

<script>
    $('#order_contact').DataTable( {
        "lengthMenu": [[10, 25, 50 , 100, -1], [10, 25, 50, 100, "All"]]
    });
    function copy_iban_number() {
        var copyText = document.getElementById("iban");
        copyText.select();
        document.execCommand("copy");
        notify('Success! ', 'Text copied', 'success');
    }
    function copy_paypal_id() {
        var copyText = document.getElementById("paypal");
        copyText.select();
        document.execCommand("copy");
        notify('Success! ', 'Text copied', 'success');
    }

    $(document).on("click" , ".orders_detail" , function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url:'<?php echo admin_url(); ?>orders/orders_detail',
            type: 'POST',
            data: { id : id},
            dataType:'json',
            success:function(status){
                if(status.msg=='success'){
                    $('#order_modalbox_body').html(status.response);
                    $('#order_modalbox').modal('show');
                }
                else if(status.msg == 'error'){
                    notify('Error! ', status.response, 'danger');
                }
            }
        });
    });
</script>