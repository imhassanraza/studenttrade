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
					<h2><?php echo lang('sell_book_of_last_semeseter'); ?></h2>
					<form id="user_details">
						<input type="hidden" name="form_id" value="add_books_to_market">
						<div class="row">
							<?php if (get_session('university') == 'other_university') { ?>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="input-group">
										<input type="text" class="form-control" name="book_name" id="book_name" value="<?php echo get_session('book_name'); ?>" placeholder="<?php echo lang('author_year_title'); ?>">
										<span class="input-group-btn">
											<button class="btn next-btn" type="button" id="get_search_sell_result" style="height: 48px;"><span class="glyphicon glyphicon-search" aria-hidden="true">
											</span> <?php echo lang('search'); ?></button>
										</span>
									</div>
								</div>
							<?php } else { ?>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-left"> -->
										<select class="form-control js-example-basic-multiple" name="optional_module[]" id="optional_module" multiple="multiple" style="width: 100%; height: 48px;">
											<?php if(empty(get_session('sell_session_optional_module'))) {
												$o_module = array();
											} else {
												$o_module = get_session('sell_session_optional_module');
											} ?>
											<?php foreach ($modules as $module) { ?>
												<option value="<?php echo $module['module']; ?>" <?php if(in_array($module['module'], $o_module)) { ?> selected="" <?php } ?>> <?php echo $module['module']; ?> </option>
											<?php } ?>
										</select>
										<!-- </div> -->
									</div>
								<?php } ?>
								<?php if (get_session('university') == 'other_university') { ?>
									<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
										<div class="table-responsive" id="search_result" style="display: none;"></div>
									</div>
								<?php } else { ?>
									<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
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
											<input type="text" class="form-control" name="book_name" id="book_name" value="<?php echo get_session('book_name'); ?>" placeholder="<?php echo lang('author_year_title'); ?>">
											<span class="input-group-btn">
												<button class="btn next-btn" type="button" id="get_search_sell_result" style="height: 48px;"><span class="glyphicon glyphicon-search" aria-hidden="true">
												</span> <?php echo lang('search'); ?></button>
											</span>
										</div>
									</div>

									<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
										<div class="table-responsive" id="search_result" style="display: none;"></div>
									</div>
								<?php } ?>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<hr>
									<div class="col-md-4 col-sm-12 col-xs-12 form-group pull-right">
										<div class="forgot-outer">
											<div class="form-check pull-left confirm-agreement" >
												<label>
													<input type="checkbox" name="sell_affidavit" id="sell_affidavit" <?php if (get_session('verify_checkbox')) { ?> checked <?php } ?>> <span class="label-text" > </span><span class="remb"><?php echo  lang('i_hereby_verify'); ?></span>
												</label>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">
									<?php if (get_session('university') == 'Universität St. Gallen (HSG)') { ?>
										<div class="col-md-4 col-xs-12 form-group pull-left">
											<button id="back_to_field_of_study" type="button" class="btn back-btn col-xs-12"><?php echo lang('go_back'); ?></button>
										</div>
									<?php } else  { ?>
										<div class="col-md-4 col-xs-12 form-group pull-left">
											<button id="back_to_university" type="button" class="btn back-btn col-xs-12"><?php echo lang('go_back'); ?></button>
										</div>
									<?php } ?>
									<div class="col-md-4 col-xs-12 form-group pull-right">
										<a href="javascript:void(0)" class="btn next-btn col-xs-12" id="get_book_details"><?php echo lang('add_to_our_marketplace'); ?></a>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-12 col-sm-12 col-xs-12 form-group pull-left">
										<?php echo lang('write_us_email_if_book_not_found');?>
										<a href="mailto:<?php echo get_section_content('contactus' , 'contactus_email'); ?>"> <?php echo lang('email_to'); ?></a>.
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- Become Space Provider End-->
	<?php $this->load->view('common/footer'); ?>

	<?php if(!empty(get_session('sell_session_optional_module'))) { ?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#optional_module').trigger('change');
			});
		</script>
	<?php } ?>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#optional_module').select2({
				placeholder: '<?php echo lang('choose_module_in_the_past');?>'
			});
		});

		$(document).on('change', '#optional_module', function() {

			var op_module = $(this).val();
			if(op_module == "" || op_module == null) {
				$('#optional_module_books').html('');
				return false;
			}
			var form_value = $("#user_details").serialize();

			$.ajax({
				url:'<?php echo base_url(); ?>sell/get_other_uni_books',
				type:'post',
				data:form_value,
				dataType:'json',
				success:function(status){
					if(status.msg=='success'){
						$("#optional_module_books").fadeOut(function(){$("#optional_module_books").html(status.response).fadeIn();});
					}
				}
			});
		});


	// function search_filter() {
	// 	var input, filter, table, tr, td, i;
	// 	input = document.getElementById("search_book");
	// 	filter = input.value.toUpperCase();
	// 	table = document.getElementById("books_table");
	// 	tr = table.getElementsByTagName("tr");
	// 	for (i = 0; i < tr.length; i++) {
	// 		td = tr[i].getElementsByTagName("td")[3];
	// 		if (td) {
	// 			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	// 				tr[i].style.display = "";
	// 			} else {
	// 				tr[i].style.display = "none";
	// 			}
	// 		}
	// 	}
	// }

	$("#back_to_university").click(function() {
		$.ajax({
			url:'<?php echo base_url(); ?>sell/back_to_university',
			type:'post',
			data:{},
			dataType:'json',
			success:function(status){
				if(status.msg=='success'){
					$("#ajax_wrapper").fadeOut(function(){$("#ajax_wrapper").html(status.response).fadeIn();});
					var stateObj = {};
					history.pushState(stateObj, "page 2", status.new_url);
				}
			}
		});
	});

	$("#back_to_field_of_study").click(function() {
		$.ajax({
			url:'<?php echo base_url(); ?>sell/back_to_field_of_study',
			type:'post',
			data:{ },
			dataType:'json',
			success:function(status){
				if(status.msg=='success'){
					$("#ajax_wrapper").fadeOut(function(){$("#ajax_wrapper").html(status.response).fadeIn();});
					var stateObj = {};
					history.pushState(stateObj, "page 2", status.new_url);
				}
			}
		});
	});
</script>

<?php if(!empty(get_session('book_name'))) { ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#get_search_sell_result').click();
		});
	</script>
<?php } ?>

<?php if (get_session('verify_checkbox')) { ?>
	<script type="text/javascript">
		$(document).ready(function() {
			setTimeout(function() { $('#get_book_details').click(); }, 2000);
		});
	</script>
<?php } ?>

<script type="text/javascript">
	$('#user_details').on('keypress', function(e) {
		if (e.keyCode == 13) {
			$('#get_search_sell_result').click();
			e.preventDefault();
			return false;
		}
	});

	$(document).on('click', '#get_search_sell_result', function() {
		var book_name = $('#book_name').val();
		if(book_name == "") {
			$.gritter.add({
				title: 'Error!',
				sticky: false,
				time: '5000',
				before_open: function(){
					if($('.gritter-item-wrapper').length >= 1){
						return false;
					}
				},
				text: "<?php echo lang('enter_book_name_first'); ?>",
				class_name: 'gritter-error'
			});
			return false;
		}
		var form_value = $("#user_details").serialize();
		$.ajax({
			url:'<?php echo base_url(); ?>search/get_search_books_for_sell',
			type:'post',
			data: form_value,
			dataType:'json',
			success:function(status){
				if(status.msg=='success'){
					$("#search_result").fadeOut(function(){
						$("#search_result").html(status.response).fadeIn();
						$('#proceed_btn').show();
					});
				}
			}
		});
	});
</script>
