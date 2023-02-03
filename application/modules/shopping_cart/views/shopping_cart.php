<?php $this->load->view('common/header'); ?>

<!-- Become Space Provider -->
<div id="ajax_wrapper" style="margin-top: 97px;">
	<section class="show-space section-bg">
		<div class="container">
			<div class="row">
				<?php $my_cart = $this->cart->contents(); ?>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2 class="pull-left"><?php echo lang('shopping_cart'); ?></h2>
					<!-- <h2 class="pull-right"><?php // echo lang('total_item_in_cart'); ?> <span id="total_items"><?php // echo count($my_cart); ?></span></h2> -->
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">

								<table class="table" style="width: 100%">
									<thead>
										<tr>
											<?php if (!get_session('university') == 'other_university') { ?>
												<th><?php echo lang('module'); ?></th>
											<?php } ?>
											<th><?php echo lang('book_name'); ?></th>
											<th width="10%"><?php echo lang('price'); ?></th>
											<th width="10%"><?php echo lang('action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($my_cart)) { ?>
											<?php foreach ($my_cart as $mycart) { ?>
												<tr id="row_<?php echo $mycart['id']; ?>">
													<?php if (!get_session('university') == 'other_university') { ?>
														<td><?php echo $mycart['options']['module']; ?></td>
													<?php } ?>
													<td><?php echo wordwrap($mycart['name'], 120 , "<br />", TRUE); ?></td>

													<td>
														<?php if($mycart['price'] > 0) { ?>
															<?php echo number_format($mycart['price'], 0); ?> CHF
														<?php } else { ?>
															Not available
														<?php } ?>
													</td>
													<td>
														<a href="javascript:void(0)" class="cart-btn btn_cancel remove_book" data-id="<?php echo $mycart['id']; ?>" style="color: #D73A71;"> <i class="fa fa-times"></i></a>
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
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
							<?php if(!empty($my_cart)) { ?>
								<div class="col-md-8 col-xs-12"></div>
								<div class="col-md-4 col-xs-12 form-group pull-right hide_all_components">

									<div class="amount_div">
										<div class="sub_total">
											<span class="amount_heading"><?php echo lang('sub_total'); ?></span>
											<span class="amount" id="total_amount"><?php echo number_format($this->cart->total(), 0);?> CHF</span>
										</div>
										<div id="discount_code_wrap">
											<input type="hidden" name="is_discount_code_used" value="0">
										</div>

									</div>
									<div class="form-group checkout_field">
										<input type="text" class="form-control discount_code" name="discount_code" placeholder="<?php echo lang('enter_discount_code'); ?>" <?php if(get_session('discount_code_applied_for_click') == '1') { ?> value="<?php echo get_session('discount_code'); ?>" <?php } ?>>
										<button type="button" class="btn back-btn btn-sm cont-btn apply_discount_code"><?php echo lang('apply_code'); ?></button>
									</div>

									<a href="javascript:void(0)" class="btn next-btn col-xs-12" id="checkout_button"><?php echo lang('checkout'); ?></a>
								</div>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>
<!-- Become Space Provider End-->
<?php $this->load->view('common/footer'); ?>

<script type="text/javascript">

	$(document).on('click', '#checkout_button', function() {

		var btn = $(this);
		$(btn).button('loading');

		window.location.href = "<?php echo base_url(); ?>checkout";

		// $.ajax({
		// 	url:'<?php //echo base_url(); ?>shopping_cart/check_login',
		// 	type:'post',
		// 	data: { },
		// 	dataType:'json',
		// 	success:function(status) {
		// 		if(status.msg == 'not_login'){
		// 			$.gritter.add({
		// 				title: 'Error!',
		// 				sticky: false,
		// 				time: '5000',
		// 				before_open: function(){
		// 					if($('.gritter-item-wrapper').length >= 3)
		// 					{
		// 						return false;
		// 					}
		// 				},
		// 				text: status.response,
		// 				class_name: 'gritter-error'
		// 			});
		// 			$(btn).button('reset');
		// 			$('#loginModal').modal('show');
		// 		} else {
		// 			window.location.href = "<?php //echo base_url(); ?>checkout";
		// 		}
		// 	}

		// });

	});

</script>
<script type="text/javascript">

	$(document).on('click', '.remove_book', function() {
		var book_id = $(this).attr('data-id');
		$.ajax({
			url:'<?php echo base_url(); ?>shopping_cart/remove_from_cart',
			type:'post',
			data: { book_id : book_id },
			dataType:'json',
			success:function(status){
				if(status.msg == 'success') {

					$('#cart_items').text(status.items);
					$('#total_items').text(status.items);
					$('#total_amount').html("<b>"+status.total_amount+" CHF</b>");
					var discount_code = $('.discount_code').val();
					if (discount_code != '') {
						$('.apply_discount_code').click();
					}
					if(status.items == 0) {
						$('tbody').html('<tr><td colspan="4"><?php echo lang('empty_cart'); ?></td></tr>');
						$('#checkout_button').hide();
						$('#total_amount').hide();
						$('.hide_all_components').hide();
					}
					$('#row_'+book_id).remove();

				}
			}
		});
	});
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
				before_open: function(){
					if($('.gritter-item-wrapper').length >= 1){
						return false;
					}
				},
				text: "<?php echo lang('please_enter_discount_code'); ?>",
				class_name: 'gritter-error'
			});
			return false;
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
						before_open: function(){
							if($('.gritter-item-wrapper').length >= 1){
								return false;
							}
						},
						text: status.response,
						class_name: 'gritter-error'
					});
				} else if(status.msg == 'error') {
					$.gritter.add({
						title: 'Error!',
						sticky: false,
						time: '5000',
						before_open: function(){
							if($('.gritter-item-wrapper').length >= 1){
								return false;
							}
						},
						text: status.response,
						class_name: 'gritter-error'
					});
					$('#discount_code_wrap').html('<input type="hidden" name="is_discount_code_used" value="0">');
					$('.discount_code').val('');
				}
			}

		});
	});

</script>