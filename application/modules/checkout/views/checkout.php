<?php $this->load->view('common/header'); ?>

<?php if(ENVIRONMENT == 'development') { ?>
	<script src="https://www.paypal.com/sdk/js?client-id=Afw7WkREQFzoIemeBqh1lV5BC66O6Dhgjrl67mKZAJlNW5dTxjvU_Vu7XgIRCcfNBChcbzHe-o1QuT8u&currency=CHF&locale=de_CH"></script>
<?php } else { ?>
	<script src="https://www.paypal.com/sdk/js?client-id=AVam1HNWrj6rFW6mu7OLPQ9RWew8oXRZahj0E0jEgrPJ3VAax2frQfFCGHJbF6taQly8JhqcAkR2nOkd&currency=CHF&locale=de_CH"></script>
<?php } ?>

<div id="ajax_wrapper" style="margin-top: 97px;">
	<section class="show-space section-bg">
		<div class="container">
			<div class="row">
				<?php $my_cart = $this->cart->contents(); ?>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2 class="pull-left"><?php echo lang('checkout'); ?></h2>
					<!-- <h2 class="pull-right"><?php // echo lang('total_item'); ?><span id="total_items"><?php echo count($my_cart); ?></span></h2> -->
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">

								<table class="table">
									<thead>
										<tr>
											<?php if (!get_session('university') == 'other_university') { ?>
												<th><?php echo lang('module'); ?></th>
											<?php } ?>
											<th><?php echo lang('book_name'); ?></th>
											<th width="10%" class="text-right" style="padding-right: 26px;"><?php echo lang('price'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($my_cart)) { ?>
											<?php foreach ($my_cart as $mycart) { ?>
												<tr id="row_<?php echo $mycart['id']; ?>">
													<?php if (!get_session('university') == 'other_university') { ?>
														<td><?php echo $mycart['options']['module']; ?></td>
													<?php } ?>
													<td><?php echo wordwrap($mycart['name'], 130, "<br />", TRUE); ?></td>

													<td class="text-right" style="padding-right: 15px;">
														<?php if($mycart['price'] > 0) { ?>
															<?php echo number_format($mycart['price'], 0); ?> CHF
														<?php } else { ?>
															<?php echo lang('not_available'); ?>
														<?php } ?>
													</td>
												</tr>
											<?php } ?>
										<?php } else { ?>
											<tr>
												<td colspan="4">
													<?php echo lang('empty_cart'); ?>
												</td>
											</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<?php if (!get_session('university') == 'other_university') { ?>
												<th></th>
											<?php } ?>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>

							</div>
						</div>
						<div class="col-md-12">
							<?php if(!empty($my_cart)) { ?>
								<div class="col-md-8 col-xs-12"></div>
								<div class="col-md-4 col-xs-12 form-group pull-right">

									<div class="amount_div">
										<div class="sub_total">
											<span class="amount_heading"><?php echo lang('sub_total'); ?></span>
											<span class="amount margin_30"><?php echo number_format($this->cart->total(), 0);?> CHF</span>
										</div>
										<div id="discount_code_wrap">
											<input type="hidden" name="is_discount_code_used" value="0">
										</div>
									</div>
									<div class="form-group checkout_field" style="display:none;">
										<input type="hidden" class="form-control discount_code" name="discount_code" placeholder="Enter Discount Code" <?php if(get_session('discount_code_applied_for_click') == '1') { ?> value="<?php echo get_session('discount_code'); ?>" <?php } ?> readonly="">
										<button type="button" class="btn back-btn btn-sm cont-btn apply_discount_code" style="display:none;" >Apply Code</button>
									</div>

									<?php if(!empty($reference_id)) { ?>

										<div id="paypal-button-container"></div>

									<?php } else { ?>

										<p> Something went wrong! </p>

									<?php } ?>


								</div>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>
<div class="page-loader">
	<div class="loader-wrap">
		<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
	</div>
</div>
<?php if(get_session('discount_code_applied_for_click') == '1') {
	$cart_amount = get_session('pass_value_paypal');
} else {
	$cart_amount = $this->cart->total();
} ?>
<?php $this->load->view('common/footer'); ?>
<script>
	paypal.Buttons({
		locale: 'en_US',
		style: {
			size: 'small',
			color: 'gold',
			shape: 'rect',
			label: 'checkout'
		},
		createOrder: function(data, actions) {
			return actions.order.create({
				purchase_units: [{
					reference_id: "<?php echo $reference_id; ?>",
					amount: {
						value: '<?php echo str_replace(',','', number_format($cart_amount, 0)); ?>'
					}
				}]
			});
		},

		onApprove: function(data, actions) {
			$('.page-loader').css('display' , 'flex');
			return actions.order.capture().then(function(details) {
				$.ajax({
					url:'<?php echo base_url(); ?>checkout/place_order',
					type:'post',
					data:details,
					dataType:'json',
					success:function(status){
						if(status.msg=='success'){
							$('#cart_items').text(0);
							$("#ajax_wrapper").fadeOut(function(){$("#ajax_wrapper").html(status.response).fadeIn();});
							$('.page-loader').hide();
							var stateObj = {};
							history.pushState(stateObj, "page 2", status.new_url);

							$('html, body').animate({ scrollTop: 0 }, 'slow');
						}
					}
				});
			});
		}
	}).render('#paypal-button-container');
</script>

<?php if(get_session('discount_code_applied_for_click') == '1') { ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.apply_discount_code').click();
		});
	</script>
<?php } ?>
<script>

	$(document).on('click', '.apply_discount_code', function() {
		var discount_code = $('.discount_code').val();
		if (discount_code == '') {
			$.gritter.add({
				title: 'Error!',
				sticky: false,
				time: '5000',
				before_open: function(){},
				text: 'Please enter discount code.',
				class_name: 'gritter-error'
			});
		}
		$.ajax({
			url:'<?php echo base_url(); ?>checkout/get_discount_code',
			type:'post',
			data: { discount_code : discount_code },
			dataType:'json',
			success:function(status){
				if(status.msg == 'success') {
					$('#discount_code_wrap').html(status.response);
				}  else if(status.msg == 'not_login') {
					$.gritter.add({
						title: 'Error!',
						sticky: false,
						time: '5000',
						before_open: function(){},
						text: status.response,
						class_name: 'gritter-error'
					});
				} else if(status.msg == 'error') {
					$.gritter.add({
						title: 'Error!',
						sticky: false,
						time: '5000',
						before_open: function(){},
						text: status.response,
						class_name: 'gritter-error'
					});
					$('#discount_code_wrap').html('<input type="hidden" name="is_discount_code_used" value="0">');

				}
			}

		});
	});

</script>