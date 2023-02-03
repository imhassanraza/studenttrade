<style>
	.select2-search__field {
		width: 100% !important;
	}
</style>
<!-- Become Space Provider -->
<section class="room section-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-10 col-xs-12 col-md-offset-3 col-sm-offset-1">

				<h2><?php echo lang('which_semester_you_to_sell'); ?></h2>

				<form id="user_details" action="" method="">

					<input type="hidden" name="form_id" value="semester">

					<div class="row">

						<div class="col-md-12">
							<div class="form-group">
								<select class="form-control js-example-basic-multiple" name="semester[]" id="semester" style="width: 100%; height: 48px;" multiple="multiple">
										<?php if(empty(get_session('sell_semester'))) {
											$sell_semesters = array();
										} else {
											$sell_semesters = get_session('sell_semester');
										} ?>
										<option value="1" <?php if(in_array(1, $sell_semesters)){ ?> selected="selected" <?php } ?> > 1 </option>
										<option value="2" <?php if(in_array(2, $sell_semesters)){ ?> selected="selected" <?php } ?> > 2 </option>
										<option value="3" <?php if(in_array(3, $sell_semesters)){ ?> selected="selected" <?php } ?> > 3 </option>
										<option value="4" <?php if(in_array(4, $sell_semesters)){ ?> selected="selected" <?php } ?> > 4 </option>
										<option value="5" <?php if(in_array(5, $sell_semesters)){ ?> selected="selected" <?php } ?> > 5 </option>
										<option value="6" <?php if(in_array(6, $sell_semesters)){ ?> selected="selected" <?php } ?> > 6 </option>
										<option value="7" <?php if(in_array(7, $sell_semesters)){ ?> selected="selected" <?php } ?> > 7 </option>
										<option value="8" <?php if(in_array(8, $sell_semesters)){ ?> selected="selected" <?php } ?> > 8 </option>
									</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group pull-left">
								<button id="back_to_study_type" type="button" class="btn back-btn"><?php echo lang('go_back'); ?></button>
							</div>
							<div class="form-group pull-right">
								<a href="javascript:void(0)" id="get_book_details" class="btn next-btn"><?php echo lang('next_step'); ?></a>
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
		$('#semester').select2({
			placeholder: '<?php echo lang('select_semester');?>'
		});
	});

	$("#back_to_study_type").click(function() {
		$.ajax({
			url:'<?php echo base_url(); ?>sell/back_to_study_type',
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