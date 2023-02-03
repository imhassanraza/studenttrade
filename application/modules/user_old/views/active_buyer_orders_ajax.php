<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo lang('order_detail'); ?> <?php echo $orders[0]['id']?></h4>
</div>
<div class="modal-body">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width='5%'><?php echo lang('university'); ?></th>
                    <th width='30%'><?php echo lang('book_name'); ?></th>
                    <th width='10%'><?php echo lang('seller_name'); ?></th>
                    <th width='15%'><?php echo lang('field_of_study'); ?></th>
                    <th width='10%'><?php echo lang('module'); ?></th>
                    <th width='10%'><?php echo lang('price'); ?></th>
                    <th width='20%'><?php echo lang('deleted_reason'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td> <?php echo $order['university']; ?> </td>
                        <td> <?php echo $order['book_name']; ?> </td>
                        <td>
                            <?php if ($order['seller_id'] == 0){ ?>
                                <?php echo 'Admin'; ?>
                            <?php }else{?>
                                <?php
                                $seller = get_book_seller($order['seller_id']);
                                if ($seller['first_name'] == ""){
                                    echo $seller['email'];
                                }else{
                                    echo $seller['first_name']." ".$seller['last_name'];
                                }
                                ?>
                            <?php } ?>
                        </td>
                        <td><?php echo $order['field_of_study']; ?> </td>

                        <td> <?php echo $order['module']; ?> </td>
                        <td> <?php echo number_format($order['price'], 0); ?> CHF</td>
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
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('close'); ?></button>
</div>
