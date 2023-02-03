<section class="show-space section-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php if($order_response['user_account'] == 'loggedin') {
					$user_detail = get_owner_detail(get_session('user_id'));
					$username = $user_detail['first_name'];
					$email = $user_detail['email'];
				} else if($order_response['user_account'] == 'registered') {
					$username = $order_response['user_details']['first_name'];
					$email = $order_response['user_details']['email'];
				} else {
					$username = $first_name;
					$email = $payer_email;
				} ?>
				<h2><span style="color: #3FC0B7;"><?php echo lang('thanks_for_purchase'); ?> <?php echo !empty(trim($username)) ? $username : $email; ?>!</span></h2>
				<p style="font-size: 14px;">
					<?php echo lang('your_order'); ?> <b>#<?php echo $order_id; ?></b>
				</p>
				<p style="font-size: 14px;"><?php echo lang('address'); ?> <?php echo $order_address; ?></p>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<h3><?php echo lang('order_details'); ?></h3>
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
									<?php foreach ($order_products as $book) { ?>
										<tr>
											<?php if (!get_session('university') == 'other_university') { ?>
												<td><?php echo $book['options']['module']; ?></td>
											<?php } ?>
											<td><?php echo wordwrap($book['name'], 130, "<br />", TRUE); ?></td>
											<td class="text-right" style="padding-right: 15px;">
												<?php if($book['price'] > 0) { ?>
													<?php echo number_format($book['price'], 0); ?> CHF
												<?php } else { ?>
													<?php echo lang('not_available'); ?>
												<?php } ?>
											</td>
										</tr>
									<?php } ?>
									<tfoot>
										<tr>
											<?php if (!get_session('university') == 'other_university') { ?>
												<th></th>
											<?php } ?>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-4 col-xs-12 form-group pull-right">
							<div class="amount_div">
								<?php if($discount_code_applied_or_not == '1') { ?>
									<div class="sub_total">
										<span class="amount_heading"><?php echo lang('sub_total'); ?></span>
										<span class="amount"><?php echo number_format($cart_total_amount, 0);?> CHF</span>
									</div>
									<div class="coupon">
										<span class="amount_heading"><?php echo lang('coupon_discount'); ?></span>
										<span class="amount"> <?php echo number_format(get_session('discount_amount'), 0 ); ?> <span class="currency">CHF</span></span>
									</div>
									<div class="all_total">
										<span class="amount_heading"><?php echo lang('total_amount'); ?></span>
										<span class="amount"><?php echo number_format($trx_amount, 0); ?> <span class="currency">CHF</span></span>
									</div>
								<?php } else { ?>
									<div class="all_total">
										<span class="amount_heading"><?php echo lang('total_amount'); ?></span>
										<span class="amount"><?php echo number_format($trx_amount, 0); ?> <span class="currency">CHF</span></span>
									</div>
								<?php } ?>
							</div>
							<a href="<?php echo base_url(); ?>sell/university" class="btn next-btn col-xs-12"><?php echo lang('start_sell'); ?></a>
						</div>

					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<h4 style="color: #3FC0B7;"><?php echo lang('congratulations'); ?></h4>
						<p style="font-size: 14px;"><?php echo lang('you_have_planted'); ?> <strong style="color: #3FC0B7;">
							<?php echo $products; ?>
							<?php if ($products > 1){ ?>
								<?php echo lang('trees'); ?>
							<?php } else { ?>
								<?php echo lang('tree'); ?>
							<?php } ?>
						</strong> <?php echo lang('purchase_text'); ?></p>
						<h4 style="color: #3FC0B7;"><?php echo lang('many_thanks'); ?></h4>

					</div>
				</div>

			</div>
		</div>
	</div>
	<section id="featured-room" style="padding-top: 100px; padding-bottom: 30px;">
		<div class="container">
			<div class="row tpb-row hero-image-with-text hero-center-text" style="margin:0; padding-top: 200px; padding-bottom: 200px; background-image: url('<?php echo base_url(); ?>/assets/images/banner-tree.png'); background-size: contain; background-position: center center;">
			</div>
		</div>
	</section>
</section>