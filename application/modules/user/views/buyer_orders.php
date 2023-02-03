<?php $this->load->view('common/header'); ?>
<!-- Edit Profile -->
<section class="panel-bg">
	<div class="container">
		<div class="row">
			<?php $this->load->view('common/dashboard_sidebar'); ?>
			<div class="col-md-9">
				<div class="panel with-nav-tabs panel-default">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#storagetab1" data-toggle="tab"><?php echo lang('active'); ?></a></li>
							<li><a href="#storagetab2" data-toggle="tab"><?php echo lang('completed'); ?></a></li>
							<li><a href="#storagetab3" data-toggle="tab"><?php echo lang('cancelled'); ?></a></li>
							<!-- <li><a href="#storagetab4" data-toggle="tab">Refunded</a></li> -->
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">

							<div class="tab-pane fade in active bookings_list" id="storagetab1">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th><?php echo lang('order_date'); ?></th>
												<th><?php echo lang('order_id'); ?></th>
												<!-- <th><?php // echo lang('transaction_id'); ?></th> -->
												<th><?php echo lang('amount'); ?></th>
												<th><?php echo lang('discount_code'); ?></th>
												<!-- <th><?php // echo lang('sub_total'); ?></th> -->
												<th><?php echo lang('action'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(!empty($orders)){ ?>
												<?php foreach ($orders as $order){ ?>
													<tr>
														<td><?php echo date('d/m/Y' , strtotime($order['order_date'])); ?></td>
														<td><?php echo $order['id']; ?></td>
														<!--  //<td><?php echo $order['trx_id']; ?></td> -->
														<td><?php echo number_format($order['trx_amount'], 0); ?> CHF</td>
														<td> <?php echo $order['discount_code']; ?> </td>
														<!-- <td> <?php // echo $order['sub_total']; ?></td> -->
														<td>
															<button class="btn btn-info btn-xs active_buyer_orders" data-id="<?php echo $order['id']; ?>"><i class="fa fa-info-circle"></i> <?php echo lang('details'); ?> </button>
														</td>
													</tr>
												<?php } ?>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>

							<div class="tab-pane fade bookings_list" id="storagetab2">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th><?php echo lang('order_date'); ?></th>
												<th><?php echo lang('order_id'); ?></th>
												<!-- <th><?php // echo lang('transaction_id'); ?></th> -->
												<th><?php echo lang('amount'); ?></th>
												<th><?php echo lang('discount_code'); ?></th>
												<!-- <th><?php // echo lang('sub_total'); ?></th> -->
												<th><?php echo lang('action'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(!empty($completed_orders)){ ?>
												<?php foreach ($completed_orders as $com_order){ ?>
													<tr>
														<td><?php echo date('d/m/Y' , strtotime($com_order['order_date'])); ?></td>
														<td><?php echo $com_order['id']; ?></td>
														<!-- <td><?php // echo $com_order['trx_id']; ?></td> -->
														<td><?php echo number_format($com_order['trx_amount'], 0); ?> CHF</td>
														<td> <?php echo $com_order['discount_code']; ?> </td>
														<!-- <td> <?php // echo $com_order['sub_total']; ?></td> -->
														<td>
															<button class="btn btn-info btn-xs completed_buyer_orders" data-id="<?php echo $com_order['id']; ?>"><i class="fa fa-info-circle"></i> <?php echo lang('details'); ?> </button>
														</td>
													</tr>
												<?php } ?>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>


							<div class="tab-pane fade bookings_list" id="storagetab3">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th><?php echo lang('order_date'); ?></th>
												<th><?php echo lang('order_id'); ?></th>
												<!-- <th><?php // echo lang('transaction_id'); ?></th> -->
												<th><?php echo lang('amount'); ?></th>
												<th><?php echo lang('discount_code'); ?></th>
												<!-- <th><?php // echo lang('sub_total'); ?></th> -->
												<th><?php echo lang('action'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(!empty($cancel_orders)){ ?>
												<?php foreach ($cancel_orders as $can_order){ ?>
													<tr>
														<td><?php echo date('d/m/Y' , strtotime($can_order['order_date'])); ?></td>
														<td><?php echo $can_order['id']; ?></td>
														<!-- <td><?php // echo $can_order['trx_id']; ?></td> -->
														<td><?php echo number_format($can_order['trx_amount'], 0); ?> CHF</td>
														<td> <?php echo $can_order['discount_code']; ?> </td>
														<!-- <td> <?php // echo $can_order['sub_total']; ?></td> -->
														<td>
															<button class="btn btn-info btn-xs active_buyer_orders" data-id="<?php echo $can_order['id']; ?>"><i class="fa fa-info-circle"></i> <?php echo lang('details'); ?> </button>
														</td>
													</tr>
												<?php } ?>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>

							<!-- <div class="tab-pane fade bookings_list" id="storagetab4">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th><?php // echo lang('order_date'); ?></th>
												<th><?php // echo lang('order_id'); ?></th>
												<th><?php // echo lang('transaction_id'); ?></th>
												<th><?php // echo lang('amount'); ?></th>
												<th>Amount Refund</th>
												<th><?php // echo lang('action'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php // if(!empty($refund_orders)){ ?>
											<?php // foreach ($refund_orders as $ref_order){ ?>
												<tr>
													<td><?php // echo date('d/m/Y' , strtotime($ref_order['order_date'])); ?></td>
													<td><?php // echo $ref_order['id']; ?></td>
													<td><?php // echo $ref_order['refund_trx_id']; ?></td>
													<td><?php // echo $ref_order['trx_amount']; ?> CHF</td>
													<td><?php // echo $ref_order['amount_refund']; ?> CHF</td>
													<td>
														<button class="btn btn-info btn-xs active_buyer_orders" data-id="<?php // echo $ref_order['id']; ?>"><i class="fa fa-info-circle"></i> <?php // echo lang('details'); ?> </button>
													</td>
												</tr>
											<?php // } ?>

											<?php // }else{?>
												<td colspan="5"><span class="text text-danger"><?php // echo lang('orders_not_found'); ?></span></td>
											<?php // } ?>
										</tbody>
									</table>
								</div>
							</div> -->

						</div>
					</div>
				</div>
			</div>
		</div>

		<!--Start Active Modal Bax -->
		<div class="modal" id="active_orders_modal">
			<div class="modal-dialog modal-xl">
				<div class="modal-content" id="active_orders_modal_body"></div>
			</div>
		</div>
		<!--End Active Modal Bax -->

	</div>
</section>
<!-- Modal -->

<!-- Edit Profile End-->
<?php $this->load->view('common/footer'); ?>

<script type="text/javascript">

	$(document).on("click" , ".active_buyer_orders" , function() {
		var id = $(this).attr('data-id');
		$.ajax({
			url:'<?php echo base_url(); ?>user/active_buyer_orders_detail',
			type: 'POST',
			data: { id : id},
			dataType:'json',
			success:function(status){
				if(status.msg=='success'){
					$('#active_orders_modal_body').html(status.response);
					$('#active_orders_modal').modal('show');
				}
				else if(status.msg == 'error'){
					$.gritter.add({
						title: 'Error!',
						sticky: false,
						time: '5000',
						before_open: function () {
							if ($('.gritter-item-wrapper').length >= 3)
							{
								return false;
							}
						},
						text: status.response,
						class_name: 'gritter-error'
					});

				}
			}
		});
	});

	$(document).on("click" , ".completed_buyer_orders" , function() {
		var id = $(this).attr('data-id');
		$.ajax({
			url:'<?php echo base_url(); ?>user/completed_buyer_orders_detail',
			type: 'POST',
			data: { id : id},
			dataType:'json',
			success:function(status){
				if(status.msg=='success'){
					$('#active_orders_modal_body').html(status.response);
					$('#active_orders_modal').modal('show');
				}
				else if(status.msg == 'error'){
					$.gritter.add({
						title: 'Error!',
						sticky: false,
						time: '5000',
						before_open: function () {
							if ($('.gritter-item-wrapper').length >= 3)
							{
								return false;
							}
						},
						text: status.response,
						class_name: 'gritter-error'
					});

				}
			}
		});
	});


	$('body').on('click', '#add_books_to_marketplace', function (event) {
		var btn = $(this);
		$(btn).button('loading');
		var value = $("#user_books_form").serialize();
		$.ajax({
			url:'<?php echo base_url(); ?>user/submit_user_books_data',
			type:'post',
			data:value,
			dataType:'json',
			success:function(status){
				if(status.msg=='success'){
					$.gritter.add({
						title: '<?php echo lang('success'); ?>',
						sticky: false,
						time: '5000',
						before_open: function(){
							if($('.gritter-item-wrapper').length >= 3)
							{
								return false;
							}
						},
						text: status.response,
						class_name: 'gritter-success'
					});
					setTimeout(function(){
						location.reload();
					}, 3000);
				} else if(status.msg == 'error') {
					$.gritter.add({
						title: '<?php echo lang('error'); ?>',
						sticky: false,
						time: '5000',
						before_open: function(){
							if($('.gritter-item-wrapper').length >= 3)
							{
								return false;
							}
						},
						text: status.response,
						class_name: 'gritter-error'
					});
					$(btn).button('reset');
				}else{
					$(btn).button('reset');
				}
			}
		});
	});

</script>