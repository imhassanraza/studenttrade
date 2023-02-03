
<input type="hidden" name="is_discount_code_used" value="1">
<input type="hidden" name="discount_code" value="<?php echo $code_detail['code']; ?>">
<input type="hidden" name="discount_type" value="<?php echo $code_detail['code_type']; ?>">

<?php if($code_detail['code_type'] == 1) {
	$discount = $code_detail['code_value'];
	$total_amount =  $this->cart->total() - $discount;
} else {
	$discount = ($this->cart->total() * ($code_detail['code_value']/100));
	$total_amount =  $this->cart->total() - floor($discount);
} ?>

<div class="coupon">
	<span class="amount_heading"><?php echo lang('coupon_discount'); ?></span>
	<span class="amount margin_30"> <?php echo floor($discount); ?> <span class="currency">CHF</span></span>
</div>
<div class="all_total">
	<span class="amount_heading"><?php echo lang('total_amount'); ?></span>
	<span class="amount margin_30"><?php echo number_format($total_amount, 0);?> <span class="currency">CHF</span></span>
</div>

<input type="hidden" name="discount_amount" value="<?php echo floor($discount); ?>">
<input type="hidden" name="discounted_amount" value="<?php echo $total_amount; ?>">
<?php
set_session('pass_value_paypal', $total_amount);
set_session('discount_code_detail', $code_detail);
set_session('discount_amount', floor($discount));
?>