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
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Order Detail # <?php echo $orders[0]['id']; ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <div class="card-block">
            <div class="row invoive-info">
                <div class="col-md-6 col-xs-12 invoice-client-info">
                    <h4>Buyer Information</h4>
                    <p class="m-0"><strong>Buyer Name : </strong> <a href="<?php echo admin_url(); ?>users/detail/<?php echo $orders[0]['buyer_id']; ?>" title="View Buyer Profile"> <?php echo $orders[0]['first_name']." ".$orders[0]['last_name']; ?> </a> </p>
                    <p class="m-0"><strong>Buyer Email : </strong> <a href="<?php echo admin_url(); ?>users/detail/<?php echo $orders[0]['buyer_id']; ?>" title="View Buyer Profile"> <?php echo $orders[0]['email']; ?></a> </p>
                    <p class="m-0"><strong>Phone # : </strong> <a href="tel:<?php echo $orders[0]['phone']; ?>"> <?php echo $orders[0]['phone']; ?></a> </p>
                    <p><strong>Address : </strong> <?php echo $orders[0]['shipping_address']; ?> </p>
                </div>
                <div class="col-md-6 col-xs-12">
                    <h4>Payment Information</h4>
                    <p class="m-0"><strong>Transaction ID : </strong> <?php echo $orders[0]['trx_id']; ?> </p>
                    <p class="m-0"><strong>Transaction Amount : </strong> <?php echo $orders[0]['trx_amount']; ?> CHF</p>
                    <p class="m-0"><strong>Transfer Payment:  </strong>
                        <?php if ($orders[0]['amount_tranfer'] == 0) { ?>
                            <label class="label label-success">PayPal</label>
                        <?php }else{ ?>
                            <label class="label label-success">Bank Account</label>
                        <?php } ?>
                    </p>
                    <?php if ($orders[0]['amount_tranfer'] == 0) { ?>
                        <strong>Paypal ID : </strong> <span><?php echo $orders[0]['paypal_email']; ?></span>
                        <?php if ($orders[0]['paypal_email'] == "") { ?>
                            <label class="label label-danger">N/A</label>
                        <?php }else{ ?>
                            <div class="btn-group" style="margin-left: 5px;">
                                <button type="button" onclick="copy_paypal_id();" class="btn btn-primary btn-mini waves-effect waves-light" title="Copy PayPal ID"><i class="fa fa-copy fa-lg"></i></button>
                            </div>
                            <input type="text" id="paypal" value="<?php echo $orders[0]['paypal_email']; ?>" aria-hidden="true">
                        <?php } ?>
                    <?php }else{ ?>
                        <strong>IBAN (BANK) Number : </strong> <span><?php echo $orders[0]['iban_number']; ?></span>
                        <?php if ($orders[0]['iban_number'] == "") { ?>
                            <label class="label label-danger">N/A</label>
                        <?php }else{ ?>
                            <div class="btn-group" style="margin-left: 5px;">
                                <button type="button" onclick="copy_iban_number();" class="btn btn-primary btn-mini waves-effect waves-light" title="Copy IBAN"><i class="fa fa-copy fa-lg"></i></button>
                            </div>
                            <input type="text" id="iban" value="<?php echo $orders[0]['iban_number']; ?>" aria-hidden="true">
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
            <div class="table-content crm-table">
                <div class="project-table table-responsive">
                    <table id="order_detail" class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th >University</th>
                                <th >Book Name</th>
                                <th >Seller Name</th>
                                <th >Field Of Study</th>
                                <th >Module</th>
                                <th >Price</th>
                                <th >Action</th>
                                <th >Deleted Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) { if(empty($order['book_name'])) { continue; } ?>
                                <tr>
                                    <td> <?php echo $order['university']; ?> </td>
                                    <td>
                                        <?php
                                        echo wordwrap($order['book_name'], 50, "<br>\n");
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($order['seller_id'] == 0){ ?>
                                            <?php echo 'Admin'; ?>
                                        <?php }else{ ?>
                                            <?php
                                            $seller = get_book_seller($order['seller_id']);
                                            ?>
                                            <a href="<?php echo admin_url(); ?>users/detail/<?php echo $order['seller_id']; ?>" title="View Seller Profile"> <?php if($seller['first_name'] == ""){ echo $seller['email']; }else{ echo $seller['first_name']." ".$seller['last_name']; } ?> </a>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $order['field_of_study']; ?> </td>

                                    <td> <?php echo $order['module']; ?> </td>
                                    <td> <?php echo $order['price']; ?> CHF</td>
                                    <td>
                                        <?php if ($order['is_deleted'] == 0) { ?>
                                            <button class="btn btn-danger btn-sm enter_delete_reason" data-id="<?php echo $order['detail_id']; ?>" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash fa-lg"></i></button>
                                        <?php }else{ ?>
                                            <button class="btn btn-danger btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Deleted" disabled="disabled"><i class="fa fa-trash fa-lg"></i></button>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($order['is_deleted'] == 1) { ?>
                                            <?php
                                            echo wordwrap($order['deleted_reason'], 50, "<br>\n");
                                            ?>
                                        <?php } ?>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

<script>
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
</script>