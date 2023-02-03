<?php $this->load->view('common/header'); ?>
<section class="panel-bg">
	<div class="container">
		<div class="row">
			<?php $this->load->view('common/dashboard_sidebar'); ?>
			<div class="col-md-9">
				<div class="panel with-nav-tabs panel-default">
					<div class="panel-heading">
						<ul class="nav nav-tabs seller_nav">
							<li class="active"><a href="#tab1default" data-toggle="tab"><?php echo lang('my_books'); ?></a></li>
							<div class="btn-seller">
								<a href="<?php echo base_url(); ?>sell/university" class="btn btn-primary  pull-right"><?php echo lang('start_sell'); ?></a>
							</div>
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1default">
								<table class="table" id="books_table">
									<thead>
										<tr>
											<th><?php echo lang('module'); ?></th>
											<th><?php echo lang('book_name'); ?></th>
											<th><?php echo lang('price'); ?></th>
											<th><?php echo lang('sold'); ?></th>
											<th><?php echo lang('action'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($books)){ ?>
											<?php foreach ($books as $book) { ?>
												<tr>
													<td><?php echo $book['module']; ?></td>
													<td><?php echo wordwrap($book['book_name'], 51, "<br />", TRUE); ?></td>
													<td>
														<?php
														echo number_format(number_format($book['price'],0) / 2, 0);
														?> CHF
													</td>
													<td>
														<?php if($book['is_orderd'] > 0) { ?>
															<label class="label label-primary"><?php echo lang('yes'); ?></label>
														<?php } else { ?>
															<label class="label label-info"><?php echo lang('no'); ?></label>
														<?php } ?>
													</td>

													<td align="center">
														<?php if($book['is_orderd'] == 1) { ?>
															<button type="button" class="btn btn-danger btn-sm" data-id="<?php echo $book['b_id'];?>" disabled > <i class="fa fa-trash"></i> <?php echo lang('delete'); ?> </button>
														<?php }else{ ?>
															<button type="button" class="btn btn-danger btn-sm btn_delete_book" data-id="<?php echo $book['b_id'];?>" > <i class="fa fa-trash"></i> <?php echo lang('delete'); ?> </button>
														<?php } ?>
													</td>
												</tr>
											<?php } ?>
										<?php } ?>





										<?php if(!empty($order_books)){ ?>
											<?php foreach ($order_books as $book) { ?>
												<tr>
													<td><?php echo $book['module']; ?></td>
													<td><?php echo wordwrap($book['book_name'], 51, "<br />", TRUE); ?></td>
													<td>
														<?php
														echo number_format(number_format($book['orignal_price'],0) / 2, 0);
														?> CHF
													</td>
													<td>

														<label class="label label-primary"><?php echo lang('yes'); ?></label>

													</td>

													<td align="center">

														<button type="button" class="btn btn-danger btn-sm" disabled > <i class="fa fa-trash"></i> <?php echo lang('delete'); ?> </button>

													</td>
												</tr>

											<?php } ?>

										<?php } ?>


									</tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>

<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">

	$(document).on("click" , ".btn_delete_book" , function() {
		var id = $(this).attr('data-id');

		swal({
			title: "<?php echo lang('are_you_sure');?>",
			// text: "<?php // echo lang('you_want_to_delete_this_book');?>",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "<?php echo lang('yes_delete');?>",
			cancelButtonText: "<?php echo lang('no_cancel_please');?>",
			closeOnConfirm: false,
			closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {

				$.ajax({
					url:'<?php echo base_url(); ?>user/delete_book',
					type:'post',
					dataType: 'json',
					data:{id: id },
					success:function(res){
						if(res.msg == 'success'){
							swal({title: "<?php echo lang('deleted');?>", text: res.response, type: "success"},
								function(){
									location.reload();
								});
						}else if (res.msg = 'error'){
							swal("<?php echo lang('cancelled_msg');?>", res.response, "error");
						}
					}
				});
			} else {
				swal("<?php echo lang('cancelled_msg');?>", "", "error");
			}
		});
	});

</script>