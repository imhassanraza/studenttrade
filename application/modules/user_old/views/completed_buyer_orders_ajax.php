<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo lang('order_detail'); ?> <?php echo $orders[0]['id']?></h4>
</div>
<div class="modal-body">
    <form id="user_books_form" action="" method="">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width='5%'><?php echo lang('university'); ?></th>
                        <th width='20%'><?php echo lang('book_name'); ?></th>
                        <th width='10%'><?php echo lang('seller_name'); ?></th>
                        <th width='10%'><?php echo lang('field_of_study'); ?></th>
                        <th width='10%'><?php echo lang('module'); ?></th>
                        <th width='10%'><?php echo lang('price'); ?></th>
                        <th width='20%'><?php echo lang('deleted_reason'); ?></th>
                        <th width='20%'><?php echo lang('add_to_marketplace'); ?></th>
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
                            <td> <?php echo $order['price']; ?> CHF</td>
                            <td>
                                <?php if ($order['is_deleted'] == 1) { ?>
                                    <?php
                                    echo wordwrap($order['deleted_reason'], 50, "<br>\n");
                                    ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($order['is_deleted'] == 1) { ?>
                                    <?php
                                    echo wordwrap($order['deleted_reason'], 50, "<br>\n");
                                    ?>
                                <?php } else { ?>
                                    <div class="form-check">
                                        <label>
                                            <input type="checkbox" <?php if(!check_add_to_marketplace($order['book_id'])) { ?> value="<?php echo $order['book_id']; ?>" name="user_sell_books[]" <?php } ?> <?php if(check_add_to_marketplace($order['book_id'])) { ?> disabled <?php } ?>>
                                            <span class="label-text"> </span><span class="remb"></span>
                                        </label>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn next-btn" id="add_books_to_marketplace"><?php echo lang('add_to_our_marketplace'); ?></button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('close'); ?></button>
</div>