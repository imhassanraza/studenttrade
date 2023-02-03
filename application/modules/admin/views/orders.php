<?php
$this->load->view('common/admin_header');
$this->load->view('common/admin_sidebar');
?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>New Orders</h4>
            </div>
            <div class="page-header-breadcrumb">
                <a href="<?php echo admin_url(); ?>orders/get_export_orders" class="btn btn-inverse btn_inverse_white"><i class="fa fa-download"></i> Export Orders</a>
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
                                                <select class="change_status form-control" name="status" data-id="<?php echo $order['id']; ?>" style="height:14px;  width: 70%; font-size: 12px;">
                                                    <option value="1" <?php if ($order['status'] == 1){ ?> selected <?php } ?> >Pending</option>
                                                    <option value="2" <?php if ($order['status'] == 2){ ?> selected <?php } ?> >Processing</option>
                                                    <option value="3" <?php if ($order['status'] == 3){ ?> selected <?php } ?> >Complete</option>
                                                    <option value="5" <?php if ($order['status'] == 5){ ?> selected <?php } ?> >Cancel</option>
                                                </select>
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
        <!--BEGAN ORDER DETAIL MODAL BOX  -->
        <div class="modal" id="order_modalbox">
            <div class="modal-dialog modal-xl" id="order_modalbox_body"></div>
        </div>
        <!--END ORDER DETAIL MODAL BOX  -->

        <div class="modal" id="deleted_reason_modalbox">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="deleted_reason_modalbox_body">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Enter Reason </label>
                            <div class="col-sm-12">
                                <input type="hidden" name="detail_id" id="detail_id">
                                <textarea id="deleted_reason" class="form-control" placeholder="Enter reason" name="deleted_reason" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete_order_books">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
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
            url:'<?php echo admin_url(); ?>orders/new_orders_detail',
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


    $(document).on("change" , ".change_status" , function() {
        var id = $(this).attr('data-id');
        var status = this.value;
        swal({
            title: "Are you sure?",
            text: "You want to update order status!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, update!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {

                $.ajax({
                    url:'<?php echo admin_url(); ?>orders/update_status',
                    type:'post',
                    dataType: 'json',
                    data:{id: id, status: status },
                    success:function(res){
                        if(res.msg == 'success'){
                            swal({title: "Updated!", text: res.response, type: "success"},
                                function(){
                                    location.reload();
                                });
                        }else if (res.msg = 'error'){
                            swal("Cancelled", res.response, "error");
                        }
                    }
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    });


    $(document).on("click" , ".enter_delete_reason" , function() {
        var detail_id = $(this).attr('data-id');
        $("#detail_id").val(detail_id);
        $('#deleted_reason_modalbox').modal('show');
        $('#order_modalbox').modal('hide');
    });

    $(document).on("click" , ".delete_order_books" , function() {
        var detail_id = $("#detail_id").val();
        var deleted_reason = $("#deleted_reason").val();
        if (deleted_reason == "") {
            notify('Error! ','Enter delete reason', 'danger');
            return false;
        }
        $.ajax({
            url:'<?php echo admin_url(); ?>orders/delete_books',
            type:'post',
            dataType: 'json',
            data:{detail_id: detail_id, deleted_reason: deleted_reason },
            success:function(res){
                if(res.msg == 'success'){
                    notify('Success! ', res.response, 'success');
                    location.reload();
                }else if (res.msg = 'error'){
                    notify('Error! ', res.response, 'danger');
                }
            }
        });
    });

</script>