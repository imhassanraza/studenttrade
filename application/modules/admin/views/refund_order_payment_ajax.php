<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Refund Payment to Buyer</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div>
        <label>Paypal ID:<b><?php echo $orders['paypal_email']; ?></b></label>
    </div>
    <div>
        <label>Refundable Amount:<b><?php echo $orders['trx_amount']; ?> CHF</b></label>
    </div>
    <form id="releasePaymentCustomerForm">
        <div class="form-group">
            <label>Transaction ID:</label>
            <input type="text" name="trx_id" id="trx_id" class="form-control" placeholder="Enter trx id here" required>
            <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $orders['trx_amount']; ?>" >
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $orders['user_id']; ?>" >
            <input type="hidden" name="user_email" id="user_email" value="<?php echo $orders['email']; ?>" >
        </div>
        <input type="hidden" name="order_id" id="order_id" value="<?php echo $orders['id']; ?>">
        <div class="form-group">
            <label>Amount Refund:</label>
            <input type="text" name="trx_amount" id="trx_amount" class="form-control" placeholder="Enter refund amount here" required>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button class="btn btn-danger SubmitRefundPaymentCustomer">Submit</button>
</div>
