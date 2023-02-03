
<!-- Become Space Provider -->
<section class="show-space section-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h2><?php echo lang('sell_book_of_last_semeseter'); ?></h2>
				<form id="user_details" action="" method="">
					<input type="hidden" name="form_id" value="add_books_to_market">
					<div class="row">
						<!-- <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right">
								<input type="text" id="search_book" class="form-control" onkeyup="search_filter()" placeholder="<?php // echo lang('find_book_by_name'); ?>">
							</div>
						</div> -->
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table" id="books_table">
									<thead>
										<tr>
											<th width="15%" class="visible-xs"><?php echo lang('add_to_marketplace'); ?></th>
											<th width="20%"><?php echo lang('module'); ?></th>
											<th width="10%"><?php echo lang('semester'); ?></th>
											<th width="45%"><?php echo lang('book_name'); ?></th>
											<th width="10%"><?php echo lang('price'); ?></th>
											<th width="15%" class="hidden-xs"><?php echo lang('add_to_marketplace'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($books)){ ?>
											<?php foreach ($books as $book) { ?>
												<tr>
													<td align="center" class="visible-xs">
														<div class="form-check">
															<label>
																<input type="checkbox" value="<?php echo $book['id']; ?>" name="sell_books[]">
																<span class="label-text"> </span><span class="remb"></span>
															</label>
														</div>
													</td>
													<td><?php echo $book['module']; ?></td>
													<td><?php echo $book['semester']; ?></td>
													<td><?php echo wordwrap($book['book_name'], 70, "<br />", TRUE); ?></td>

													<td>
														<span id="net_price_<?php echo $book['id']; ?>">
															<?php echo number_format(number_format($book['price'],0) / 2, 0); ?>
														</span> CHF
													</td>

													<td align="center" class="hidden-xs">
														<div class="form-check">
															<label>
																<input type="checkbox" value="<?php echo $book['id']; ?>" name="sell_books[]">
																<span class="label-text"> </span><span class="remb"></span>
															</label>
														</div>
													</td>
												</tr>
											<?php } ?>
										<?php } else { ?>
											<tr style="color: red;">
												<td colspan="5">
													<?php echo lang('books_not_found'); ?>
												</td>
											</tr>
										<?php } ?>

									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-5 col-sm-6 col-xs-12 form-group pull-left">
								<select class="form-control" name="optional_module" id="optional_module" style="width: 100%;">
									<option value=""><?php echo lang('choose_optional_module'); ?></option>
									<?php foreach ($modules as $module) { ?>
										<option value="<?php echo $module['module']; ?>"> <?php echo $module['module']; ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div id="optional_module_books" class="table-responsive" style="margin-left: 14px;">

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
							<div class="col-md-4 col-xs-12 form-group pull-left">
								<button id="back_to_semester" type="button" class="btn back-btn col-xs-12"><?php echo lang('go_back'); ?></button>
							</div>
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
<!-- Become Space Provider End-->

<script type="text/javascript">
	$(document).ready(function() {
		$('#optional_module').select2();
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
			url:'<?php echo base_url(); ?>sell/get_more_books',
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

	function search_filter() {

		var input, filter, table, tr, td, i;
		input = document.getElementById("search_book");

		filter = input.value.toUpperCase();
		table = document.getElementById("books_table");
		tr = table.getElementsByTagName("tr");

		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[3];

			if (td) {
				if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}

	$("#back_to_semester").click(function() {
		$.ajax({
			url:'<?php echo base_url(); ?>sell/back_to_semester',
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
</script>