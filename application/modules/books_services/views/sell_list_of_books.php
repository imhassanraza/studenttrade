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
					<h2><?php echo lang('sell_book_of_last_semeseter'); ?></h2>
					<form id="user_details" action="" method="">
						<input type="hidden" name="form_id" value="add_books_to_market">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group pull-left">
									<select class="form-control js-example-basic-multiple" name="optional_module[]" id="optional_module" multiple="multiple" style="width: 100%; height: 48px;">
										<?php
										if(empty(get_session('sell_session_optional_module'))) {
											if(empty(get_session('sell_api_session'))){
												$o_module = array();
											}else{
												$o_module =get_session('sell_api_session');
											}
										} else {
											$o_module = get_session('sell_session_optional_module');
										} ?>
										<?php foreach ($modules as $module) { ?>
											<option value="<?php echo $module['module']; ?>" <?php if(in_array($module['module'], $o_module)) { ?> selected="" <?php } ?>> <?php echo $module['module']; ?> </option>
										<?php } ?>

									</select>
								</div>
							</div>
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<div id="optional_module_books" class="table-responsive" style="margin-left: 14px;">
									<!-- <div class="col-md-12">
										<div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right">
											<input type="text" id="other_search_book" class="form-control" onkeyup="other_search_filter()" placeholder="<?php // echo lang('find_book_by_name'); ?>">
										</div>
									</div> -->
									<table class="table" id="other_books_table">
										<thead>
											<tr>
												<th width="15%" class="visible-xs"><?php echo lang('add_to_marketplace'); ?></th>
												<th width="20%"><?php echo lang('module'); ?></th>
												<!-- <th width="10%"><?php // echo lang('semester'); ?></th> -->
												<th width="45%"><?php echo lang('book_name'); ?></th>
												<th width="10%"><?php echo lang('price'); ?></th>
												<th width="15%" class="hidden-xs"><?php echo lang('add_to_marketplace'); ?></th>
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
											<?php foreach ($books as $book) { ?>
												<tr>
													<td align="center" class="visible-xs">
														<div class="form-check">
															<label>
																<?php if(empty(get_session('sell_session'))) {
																	if(!empty(get_session('sell_session_multi'))) {
																		$op_sell_session = get_session('sell_session_multi');
																	}else {
																		$op_sell_session = array();
																	}
																} else {
																	$op_sell_session = get_session('sell_session');
																} ?>
																<input type="checkbox" class="book_tag book_tag<?php echo $book['id']; ?>" value="<?php echo $book['id']; ?>" name="sell_books[]" <?php if(in_array($book['id'], $op_sell_session)) { ?> checked <?php } ?>>
																<span class="label-text"> </span><span class="remb"></span>
															</label>
														</div>
													</td>
													<td><?php echo $book['module']; ?></td>
													<!-- <td><?php // echo !empty($book['semester']) ? $book['semester'] : "NA"; ?></td> -->
													<td><?php echo wordwrap($book['book_name'], 70, "<br />", TRUE); ?></td>
													<td>
														<span id="net_price_<?php echo $book['id']; ?>">
															<?php echo number_format($book['price'] * (50/100), 0); ?>
														</span> CHF
													</td>
													<td align="center" class="hidden-xs">
														<div class="form-check">
															<label>
																<?php if(empty(get_session('sell_session'))) {
																	if(empty(get_session('sell_session_multi'))) {
																		$op_sell_session = array();
																	}else {
																		$op_sell_session = get_session('sell_session_multi');
																	}
																} else {
																	$op_sell_session = get_session('sell_session');
																} ?>
																<input type="checkbox" class="book_tag book_tag<?php echo $book['id']; ?>" value="<?php echo $book['id']; ?>" name="sell_books[]" <?php if(in_array($book['id'],$op_sell_session)) { ?> checked <?php } ?>>
																<span class="label-text"> </span><span class="remb"></span>
															</label>
														</div>
													</td>
												</tr>
											<?php } ?>
											<?php unset_session('sell_session'); ?>
										</tbody>
									</table>
								</div>
							</div>

							<div class="col-md-12 col-xs-12 form-group">
								<hr>
								<div class="col-md-4 col-xs-12 form-group pull-right">
									<div class="forgot-outer">
										<div class="form-check pull-left confirm-agreement" >
											<label>
												<input type="checkbox" name="sell_affidavit" id="sell_affidavit"> <span class="label-text" > </span><span class="remb"><?php echo  lang('i_hereby_verify'); ?></span>
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-4 col-xs-12 form-group pull-right">
									<a href="javascript:void(0)" class="btn next-btn col-xs-12" id="get_book_details"><?php echo lang('add_to_our_marketplace'); ?></a>
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
		var university = $("#university").val();

		var form_value = $("#user_details").serialize();

		$.ajax({
			url:'<?php echo base_url(); ?>books_services/get_more_sell_books',
			type:'post',
			data:form_value+"&university="+university,
			dataType:'json',
			success:function(status){
				if(status.msg=='success'){
					$("#optional_module_books").fadeOut(function(){$("#optional_module_books").html(status.response).fadeIn();});
				}
			}
		});
	});


	function other_search_filter() {
		var input, filter, table, tr, td, i;
		input = document.getElementById("other_search_book");
		filter = input.value.toUpperCase();
		table = document.getElementById("other_books_table");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[3];
			console.log(td);
			if (td) {
				if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}
</script>