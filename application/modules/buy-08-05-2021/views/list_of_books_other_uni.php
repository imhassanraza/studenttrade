<?php $this->load->view('common/header'); ?>
<style>
	.select2-search__field {
		width: 300px !important;
	}
</style>
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
							<?php if (get_session('university') == 'other_university') { ?>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="input-group">
										<input type="text" class="form-control book_name" name="book_name" id="book_name" placeholder="<?php echo lang('author_year_title'); ?>">
										<span class="input-group-btn">
											<button class="btn next-btn" type="button" id="get_search_result" style="height: 48px;"><span class="glyphicon glyphicon-search" aria-hidden="true">
											</span> <?php echo lang('search'); ?></button>
										</span>
									</div>
								</div>
							<?php } else { ?>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<select class="form-control js-example-basic-multiple" name="optional_module[]" id="optional_module" multiple="multiple" style="width: 100%; height: 48px;">
										<?php foreach ($modules as $module) { ?>
											<option value="<?php echo $module['module']; ?>"> <?php echo $module['module']; ?> </option>
										<?php } ?>
									</select>
								</div>
							<?php } ?>
							<?php if (get_session('university') == 'other_university') { ?>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top: 20px;">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive" id="search_result" style="display: none;"></div>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div id="optional_module_books" class="table-responsive"></div>
								</div>
							<?php } ?>

							<?php if (get_session('university') == 'other_university') { ?>
							<?php } else { ?>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<hr>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="input-group">
										<input type="text" class="form-control book_name" name="book_name" id="book_name" value="<?php echo get_session('book_name'); ?>" placeholder="<?php echo lang('author_year_title'); ?>">
										<span class="input-group-btn">
											<button class="btn next-btn" type="button" id="get_search_result" style="height: 48px;"><span class="glyphicon glyphicon-search" aria-hidden="true">
											</span> <?php echo lang('search'); ?></button>
										</span>
									</div>
								</div>
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
									<div class="table-responsive" id="search_result" style="display: none;"></div>
								</div>
							<?php } ?>

							<!-- BUTTONS -->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<hr>
								<?php if (get_session('university') == 'Universität St. Gallen (HSG)') { ?>
									<div class="col-md-4 col-sm-12 col-xs-12 form-group pull-left">
										<button id="back_to_field_of_study" type="button" class="btn back-btn col-xs-12"><?php echo lang('go_back'); ?></button>
									</div>
								<?php } else { ?>
									<div class="col-md-4 col-sm-12 col-xs-12 form-group pull-left">
										<button id="back_to_university" type="button" class="btn back-btn col-xs-12"><?php echo lang('go_back'); ?></button>
									</div>
								<?php } ?>
								<!-- <?php // if (get_session('university') != 'other_university') { ?> -->
									<!-- <div class="col-md-4 col-xs-12 form-group pull-left">
										<a href="<?php // echo base_url(); ?>search" class="btn back-btn col-xs-12"><?php // echo lang('further_books'); ?></a>
									</div> -->
									<!-- <?php // } ?> -->

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
			$(document).ready(function() {
				$('#optional_module').select2({
					placeholder: '<?php echo lang('which_module_do_you_have');?>',
				});
			});
			$(document).ready(function(){
				toolTiper();
			});

			$(document).on('change', '#optional_module', function() {
				var op_module = $(this).val();
				if(op_module == "") {
					$('#optional_module_books').html('');
					return false;
				}
				$.ajax({
					url:'<?php echo base_url(); ?>buy/get_other_uni_books',
					type:'post',
					data:{ op_module : op_module },
					dataType:'json',
					success:function(status){
						if(status.msg=='success'){
							$("#optional_module_books").fadeOut(function(){$("#optional_module_books").html(status.response).fadeIn();});
						}
					}
				});
			});

			$("#back_to_university").click(function() {
				$.ajax({
					url:'<?php echo base_url(); ?>buy/back_to_university',
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

			$("#back_to_field_of_study").click(function() {
				$.ajax({
					url:'<?php echo base_url(); ?>buy/back_to_field_of_study',
					type:'post',
					data:{ },
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