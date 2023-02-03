<?php $this->load->view('common/header'); ?>

<script src="https://www.paypal.com/sdk/js?client-id=AfCN1sy5LNXBRcsfh8gmADo5SQLIu0eKoSAveBd8_aS45axIlR_7xcXymvfn03qWpAz8LZ_rHVaU-Til&currency=CHF"></script>

<!-- Become Space Provider -->
<div id="ajax_wrapper" style="margin-top: 97px;">
	<section class="show-space section-bg">
		<div class="container">
			<div class="row">
				<?php $my_cart = $this->cart->contents(); ?>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2 class="pull-left">Checkout</h2>
					<h2 class="pull-right">Total item in cart: <span id="total_items"><?php echo count($my_cart); ?></span></h2>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">

								<table class="table">
									<thead>
										<tr>
											<th>Module</th>
											<th>Book Name</th>
											<th>Price</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($my_cart)) { ?>
											<?php foreach ($my_cart as $mycart) { ?>
												<tr id="row_<?php echo $mycart['id']; ?>">
													<td><?php echo $mycart['options']['module']; ?></td>
													<td><?php echo wordwrap($mycart['name'], 60, "<br />", TRUE); ?></td>

													<td>
														<?php if($mycart['price'] > 0) { ?>
															<?php echo number_format($mycart['price'], 0); ?> CHF
														<?php } else { ?>
															Not available
														<?php } ?>
													</td>
												</tr>
											<?php } ?>
											<tr style="font-size: 20px;">
												<td colspan="2" align="right">
													<b>Total Amount</b>
												</td>
												<td colspan="2" id="total_amount">
													<b><?php echo $this->cart->format_number($this->cart->total()); ?> CHF</b>
												</td>
											</tr>

										<?php } else { ?>
											<tr>
												<td colspan="4">
													Your cart is empty.
												</td>
											</tr>
										<?php } ?>

									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-12">
							<?php if(!empty($my_cart)) { ?>
								<?php if(profile_updated()) { ?>
									<div class="col-md-4 col-xs-12 form-group pull-right">
										<div id="paypal-button-container"></div>
									</div>
								<?php } else { ?>
									<div class="col-md-12 col-xs-12 form-group pull-right">
										<div class="alert alert-danger">
											<strong>Note:</strong> Your profile is not complete. <a href="<?php echo base_url(); ?>user/edit_profile"> Click here </a> to complete your profile. Reload this page after completing your profile. Thanks
										</div>
									</div>
								<?php } ?>
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
<!-- Become Space Provider End-->
<?php $this->load->view('common/footer'); ?>
<script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
        	locale: 'en_US',
        	style: {
        		size: 'small',
        		color: 'gold',
        		shape: 'rect',
        		label: 'checkout'
        	},

            // Set up the transaction
            createOrder: function(data, actions) {
            	return actions.order.create({
            		purchase_units: [{
            			amount: {
            				value: '<?php echo str_replace(',','', $this->cart->format_number($this->cart->total())); ?>'
            			}
            		}]
            	});
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
            	$('.page-loader').css('display' , 'flex');
            	return actions.order.capture().then(function(details) {
                    // Show a success message to the buyer
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
                    		}
                    	}
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>