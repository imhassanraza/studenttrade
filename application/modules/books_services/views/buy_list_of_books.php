<?php $this->load->view('common/header'); ?>
<style>
	.select2-search__field {
		width: 300px !important;
	}
</style>
<input type="hidden" id="university" value="<?php echo $req_university; ?>">
<div id="ajax_wrapper">
	<section class="show-space section-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2><?php echo lang('next_semester_book'); ?></h2>
					<form id="user_details" action="" method="">
						<input type="hidden" name="form_id" value="show_more_books">
						<div class="row">

							<div class="col-md-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group pull-left">
									<select class="form-control js-example-basic-multiple" name="optional_module[]" id="optional_module" multiple="multiple" style="width: 100%; height: 48px;">
										<?php
										if(empty(get_session('buy_session_optional_module'))) {
											$o_module = array();
										} else {
											$o_module = get_session('buy_session_optional_module');
										} ?>
										<?php foreach ($modules as $module) { ?>
											<option value="<?php echo $module['module']; ?>" <?php if(in_array($module['module'], $o_module)) { ?> selected="" <?php } ?>> <?php echo $module['module']; ?> </option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div id="optional_module_books" class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th width="15%" class="visible-xs"><?php echo lang('add_to_basket'); ?></th>
												<th width="25%"><?php echo lang('module'); ?> <span class="tooltiper" data-tooltip="<?php echo lang('required_books_display'); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
												<th width="40%"><?php echo lang('book_name'); ?></th>
												<th width="5%"><?php echo lang('condition'); ?></th>
												<th width="10%"><?php echo lang('price'); ?></th>
												<th width="15%" class="hidden-xs"><?php echo lang('add_to_basket'); ?></th>
											</tr>
										</thead>

										<tbody>
											<?php if(empty($books)) { ?>
												<tr>
													<td colspan="6">
														<span style="color: red;"><?php echo lang('books_not_found'); ?></span>
													</td>
												</tr>
											<?php } ?>
											<?php foreach ($books as $book) {
												$is_in_cart = in_cart($book['id']);
												if($is_in_cart) {
													$cart_details = get_cart_details($book['id']);
												} else {
													$cart_details = "";
												}
												$used_book = get_used_book_detail($book['book_name']);
												if($book['only_used'] && empty($used_book)) {
													continue;
												}
												?>
												<tr>
													<td align="center" class="visible-xs">
														<div class="form-check">
															<label>
																<input type="checkbox" value="<?php echo $book['id']; ?>" <?php if($is_in_cart) { ?> class="remove_from_cart" checked="" <?php } else { ?> class="add_to_cart" <?php } ?> <?php if($book['price'] < 1) { ?> disabled="" <?php } ?>>
																<span class="label-text"> </span><span class="remb"></span>
															</label>
														</div>
													</td>
													<td><?php echo $book['module']; ?></td>
													<td><?php echo wordwrap($book['book_name'], 51, "<br />", TRUE); ?></td>
													<td>
														<?php if($is_in_cart) { ?>
															<?php if($cart_details['options']['book_condition']) { ?>
																<?php echo lang('used'); ?>
															<?php } else { ?>
																<?php echo lang('new'); ?>
															<?php } ?>
														<?php } else if(!empty($used_book['id'])) { ?>
															<?php if($used_book['book_condition']) { ?>
																<?php echo lang('used'); ?>
															<?php } else { ?>
																<?php echo lang('new'); ?>
															<?php } ?>
														<?php } else if(empty($used_book['id'])) { ?>
															<?php echo lang('new'); ?>
														<?php } ?>
													</td>
													<td>
														<?php if($is_in_cart) { ?>
															<?php if($cart_details['price'] > 0) { ?>
																<?php echo number_format($cart_details['price'], 0); ?> CHF
															<?php } else { ?>
																<label class="label label-danger"><?php echo lang('not_available'); ?></label>
															<?php } ?>
														<?php } else if(!empty($used_book['id'])) { ?>
															<?php if($used_book['book_condition']) { ?>
																<?php echo number_format($book['price']  * (60/100), 0); ?> CHF
															<?php } else { ?>
																<?php echo number_format($book['price'] * (70/100), 0); ?> CHF
															<?php } ?>
														<?php } else { ?>
															<?php if($book['price'] > 0) { ?>
																<?php echo number_format($book['price'], 0); ?> CHF
															<?php } else { ?>
																<label class="label label-danger"><?php echo lang('not_available'); ?></label>
															<?php } ?>
														<?php } ?>
													</td>
													<td align="center" class="hidden-xs">
														<div class="form-check">
															<label>
																<input type="checkbox" value="<?php echo $book['id']; ?>" <?php if($is_in_cart) { ?> class="remove_from_cart" checked="" <?php } else { ?> class="add_to_cart" <?php } ?> <?php if($book['price'] < 1) { ?> disabled="" <?php } ?>>
																<span class="label-text"> </span><span class="remb"></span>
															</label>
														</div>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-12">
								<hr>
								<div class="col-md-4 col-xs-12 form-group pull-right">
									<a href="<?php echo base_url(); ?>shopping_cart" class="btn next-btn col-xs-12"><?php echo lang('proceed'); ?></a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>

<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#optional_module').select2({
			placeholder: '<?php echo lang('which_module_do_you_have');?>',
		});
	});
	$(document).ready(function(){
		toolTiper();
	});

	$(document).on('change', '#optional_module', function() {
		var identifiers = $("#optional_module option:selected").map(function() {
			return $(this).data("available_text");
		}).get();

		console.log(identifiers);
		var op_module = $(this).val();
		if(op_module == "" || op_module == null) {
			$('#optional_module_books').html('');
			return false;
		}

		var university = $("#university").val();

		$.ajax({
			url:'<?php echo base_url(); ?>books_services/get_more_buy_books',
			type:'post',
			data:{identifiers: identifiers, university: university ,op_module: op_module },
			dataType:'json',
			success:function(status){
				if(status.msg=='success'){
					$("#optional_module_books").fadeOut(function(){$("#optional_module_books").html(status.response).fadeIn();});
				}
			}
		});
	});
</script>