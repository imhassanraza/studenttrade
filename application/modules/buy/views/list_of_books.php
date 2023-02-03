<?php $this->load->view('common/header'); ?>
<!-- Become Space Provider -->
<div id="ajax_wrapper">
	<section class="show-space section-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2><?php echo lang('next_semester_book'); ?></h2>
					<!-- <form id="user_details"> -->
						<input type="hidden" name="form_id" value="show_more_books">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th width="15%" class="visible-xs"><?php echo lang('add_to_basket'); ?></th>
												<th width="25%"><?php echo lang('module'); ?> <span class="tooltiper" data-tooltip="<?php echo lang('required_books_display'); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></th>
												<th width="40%"><?php echo lang('book_name'); ?></th>
												<th width="7%"><?php echo lang('condition'); ?></th>
												<th width="8%"><?php echo lang('mandatory'); ?></th>
												<th width="10%"><?php echo lang('price'); ?></th>
												<th width="10%" class="hidden-xs"><?php echo lang('add_to_basket'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(empty($books)) { ?>
												<tr>
													<td colspan="6"> <span style="color: red;"><?php echo lang('books_not_found'); ?></span> </td>
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
													<td><?php echo wordwrap($book['module'], 30, "<br />", TRUE); ?></td>
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
														<?php if(!$book['mandatory_or_optional']) { ?>
															<?php echo lang('yes'); ?>
														<?php } else { ?>
															<?php echo lang('no'); ?>
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
													<td class="hidden-xs">
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

							<!-- NEW FIELD FOR SEARCH -->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<hr>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="input-group">
									<input type="text" class="form-control book_name" name="book_name" id="book_name" value="<?php echo get_session('book_name'); ?>" placeholder="<?php echo lang('author_year_title'); ?>">
									<span class="input-group-btn">
										<button class="btn next-btn" type="button" id="get_search_result" style="height: 48px;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <?php echo lang('search'); ?></button>
									</span>
								</div>
							</div>
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<div class="table-responsive" id="search_result" style="display: none;"></div>
							</div>
							<!-- END NEW FIELD FOR SEARCH -->

							<!-- OPTIONAL MUDULE FIELD -->
							<!-- <div class="col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-4 col-sm-6 col-xs-12 form-group pull-left">
									<select class="form-control" name="optional_module" id="optional_module" style="width: 100%;">
										<option value=""><?php // echo lang('choose_optional_module_buy'); ?></option>
										<?php // foreach ($modules as $module) { ?>
											<option value="<?php // echo $module['module']; ?>"> <?php // echo $module['module']; ?> </option>
										<?php // } ?>
									</select>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div id="optional_module_books" class="table-responsive"></div>
							</div> -->
							<!-- END OPTIONAL MUDULE FIELD -->

							<!-- BUTTONS -->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<hr>
								<div class="col-md-4 col-sm-12 col-xs-12 form-group pull-left">
									<button id="back_to_semester" type="button" class="btn back-btn col-xs-12"><?php echo lang('go_back'); ?></button>
								</div>

								<!-- <div class="col-md-4 col-sm-12 col-xs-12 form-group pull-left">
									<a href="<?php // echo base_url(); ?>search" class="btn back-btn col-xs-12"><?php // echo lang('further_books'); ?></a>
								</div> -->

								<div class="col-md-4 col-sm-12 col-xs-12 form-group pull-right">
									<a href="<?php echo base_url(); ?>shopping_cart" class="btn next-btn col-xs-12"><?php echo lang('proceed'); ?></a>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12 form-group pull-left">
									<?php echo lang('send_mail_if_book_not_found1');?>
									<a href="mailto:<?php echo get_section_content('contactus' , 'contactus_email'); ?>"> <?php echo lang('email_to'); ?></a>
									<?php echo lang('send_mail_if_book_not_found2'); ?>
								</div>
							</div>
							<!-- BUTTONS -->
						</div>
						<!-- </form> -->
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- Become Space Provider End-->
	<?php $this->load->view('common/footer'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			toolTiper();
		});

		// $(document).ready(function() {
		// 	$('#optional_module').select2();
		// });

		// $(document).on('change', '#optional_module', function() {
		// 	var op_module = $(this).val();
		// 	if(op_module == "") {
		// 		$('#optional_module_books').html('');
		// 		return false;
		// 	}
		// 	$.ajax({
		// 		url:'<?php // echo base_url(); ?>buy/get_more_books',
		// 		type:'post',
		// 		data:{ op_module : op_module },
		// 		dataType:'json',
		// 		success:function(status){
		// 			if(status.msg=='success'){
		// 				$("#optional_module_books").fadeOut(function(){$("#optional_module_books").html(status.response).fadeIn();});
		// 			}
		// 		}
		// 	});
		// });

		$("#back_to_semester").click(function() {
			$.ajax({
				url:'<?php echo base_url(); ?>buy/back_to_semester',
				type:'post',
				data:{},
				dataType:'json',
				success:function(status){
					if(status.msg=='success'){
						$("#ajax_wrapper").fadeOut(function(){$("#ajax_wrapper").html(status.response).fadeIn();});
						var stateObj = {};
						history.pushState(stateObj, "page 2", status.new_url);
						$('html, body').animate({ scrollTop: 0 }, 'slow');
					}
				}
			});
		});

	</script>

	<script type="text/javascript">

		$('.book_name').keypress(function(e){
			if(e.keyCode == 13){
				$('#get_search_result').click();
			}
		});


		// $(document).on('click', '#get_search_result', function() {
		// 	var book_name = $('#book_name').val();
		// 	if(book_name == "") {
		// 		$.gritter.add({
		// 			title: 'Error!',
		// 			sticky: false,
		// 			time: '5000',
		// 			before_open: function(){
		// 				if($('.gritter-item-wrapper').length >= 1){
		// 					return false;
		// 				}
		// 			},
		// 			text: "<?php // echo lang('enter_book_name_first'); ?>",
		// 			class_name: 'gritter-error'
		// 		});
		// 		return false;
		// 	}

		// 	$.ajax({
		// 		url:'<?php // echo base_url(); ?>buy/get_search_result',
		// 		type:'post',
		// 		data:{ book_name : book_name },
		// 		dataType:'json',
		// 		success:function(status){
		// 			if(status.msg=='success'){
		// 				$("#search_result").fadeOut(function(){
		// 					$("#search_result").html(status.response).fadeIn();
		// 					$('#proceed_btn').show();
		// 				});
		// 			}
		// 		}
		// 	});
		// });
	</script>