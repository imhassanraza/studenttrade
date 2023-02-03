<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');
?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Completed Orders</h4>
            </div>
            <div class="page-header-breadcrumb">
                <a href="<?php echo admin_url(); ?>orders/get_completed_orders" class="btn btn-inverse btn_inverse_white"><i class="fa fa-download"></i> Export Orders</a>
            </div>
        </div>

        <div class="page-body">
            <div class="card">

                <div class="card-block">
                    <div class="table-contentt crm-tablee">
                        <div class="project-tablee">
                            <table id="order_contact" class="table table-striped dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>Buyer Name</th>
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
                                    <?php $i= 1; foreach ($orders as $order) { ?>
                                        <tr>
                                            <td> <?php echo $order['id']; ?> </td>
                                            <td><?php echo date('d/m/Y' , strtotime($order['order_date'])); ?></td>
                                            <td>
                                                <?php
                                                if ($order['first_name'] == "") {
                                                    echo $order['email'];
                                                }else{
                                                    echo $order['first_name']." ".$order['last_name'];
                                                }
                                                ?>
                                            </td>
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
                                                <?php if ($order['status'] == 3){ ?>
                                                    <label class="label label-info">Completed</label>
                                                <?php }else{ ?>
                                                    <label class="label label-danger">Error</label>
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
                                                <!-- <button class="btn btn-primary btn-sm release_payment" data-id="<?php // echo $order['id']; ?>" type="button" data-toggle="tooltip" data-placement="top" title="Release Payment"><i class="fa fa-share"></i> Release Payment</button> -->
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

        <!--BEGAN ORDER DETAIL MODAL BOX  -->
        <div class="modal" id="order_modalbox">
            <div class="modal-dialog modal-xl" id="order_modalbox_body"></div>
        </div>
        <!--END ORDER DETAIL MODAL BOX  -->

        <div class="modal" id="released_modalbox">
            <div class="modal-dialog modal-md">
                <div class="modal-content" id="released_modalbox_body"></div>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('common/admin_footer'); ?>
<script type="text/javascript">


    $('#order_contact').DataTable( {
        "lengthMenu": [[10, 25, 50 , 100, -1], [10, 25, 50, 100, "All"]]
    });


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

    $(document).on("click" , ".release_payment__remove" , function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url:'<?php echo admin_url(); ?>orders/release_payment',
            type: 'POST',
            data: { id : id},
            dataType:'json',
            success:function(status){
                if(status.msg=='success'){
                    $('#released_modalbox_body').html(status.response);
                    $('#released_modalbox').modal('show');
                }
                else if(status.msg == 'error'){
                    notify('Error! ', status.response, 'danger');
                }
            }
        });
    });

    $(document).on("click" , ".SubmitReleasePaymentCustomer" , function() {

        var trx_id = $('#trx_id').val();
        var trx_amount = $('#trx_amount').val();
        var total_amount = $('#total_amount').val();
        var user_id = $('#user_id').val();
        var order_id = $('#order_id').val();
        var user_email = $('#user_email').val();
        if (trx_id == "") {
            notify('Error! ', 'Transaction ID field is required', 'danger');
            return false;
        }
        if (trx_amount == "") {
            notify('Error! ', 'Refund Amount field is required', 'danger');
            return false;
        }

        if (trx_id != "" && trx_amount != "") {
            notify('Error! ', 'Under Workig', 'danger');
            return false;
        }

        $.ajax({
            url:'<?php echo admin_url(); ?>orders/add_release_payment',
            type: 'POST',
            data: { order_id: order_id, trx_id: trx_id, trx_amount: trx_amount, user_id: user_id, total_amount:total_amount, user_email:user_email},
            dataType:'json',
            success:function(status){
                if(status.msg=='success'){
                    notify('Updated! ', status.response, 'success');
                    location.reload();
                }else if(status.msg == 'error'){
                    notify('Error! ', status.response, 'danger');
                }
            }
        });
    });
</script>