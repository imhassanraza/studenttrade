<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');

?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Refunded Orders</h4>
            </div>
        </div>

        <div class="page-body">
            <div class="card">

                <div class="card-block">
                    <div class="table-content crm-table">
                        <div class="project-table">
                            <table id="order_contact" class="table table-striped dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>Buyer Name</th>
                                        <th>Transaction ID</th>
                                        <th>Refundable Amount</th>
                                        <th>Refunded Amount</th>
                                        <th>Payment Status</th>
                                        <th>Orders Status</th>
                                        <th>Payer Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i= 1; foreach ($orders as $order) { ?>
                                        <tr>
                                            <td> <?php echo $order['id']; ?> </td>
                                            <td><?php echo date('d/m/Y' , strtotime($order['order_date'])); ?></td>
                                            <td>
                                                <?php echo $order['first_name']." ".$order['last_name']; ?>
                                            </td>
                                            <td> <?php echo $order['refund_trx_id']; ?> </td>
                                            <td> <?php echo $order['trx_amount']; ?> CHF </td>
                                            <td> <?php echo $order['amount']; ?> CHF </td>
                                            <td>

                                                <?php if ($order['payment_status'] == 1){ ?>
                                                    <label class="label label-info">Completed</label>
                                                <?php }else{ ?>
                                                    <label class="label label-danger">Pending</label>
                                                <?php } ?>

                                            </td>
                                            <td>
                                                <?php if ($order['status'] == 4){ ?>
                                                    <label class="label label-info">Refunded</label>
                                                <?php }else{ ?>
                                                    <label class="label label-danger">Error</label>
                                                <?php } ?>
                                            </td>
                                            <td> <?php echo $order['payer_email']; ?> </td>
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

        <div class="modal" id="order_modalbox">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Orders Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="order_modalbox_body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('common/admin_footer'); ?>
<script type="text/javascript">
    $('#order_contact').dataTable({
        "paging": true,
        "searching": true,
        "bInfo":true,
        "responsive": true,
        "order": [[ 1, "desc" ]],
        "columnDefs": [
        { "responsivePriority": 1, "targets": 0 },
        { "responsivePriority": 2, "targets": -1 },
        ]
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

</script>