
<!-- Become Space Provider -->

<section class="location_map section-bg">
	<div class="container">
		<div class="row">

			<div class="col-md-6 col-sm-10 col-xs-12 col-md-offset-3 col-sm-offset-1">
				<div class="col-md-12">
					<h2><?php echo lang('full_time_or_part_time'); ?></h2>


					<form id="user_details" action="" method="">

						<input type="hidden" name="form_id" value="study_type">
						<div class="form-check">
							<label>

								<input type="radio" name="study_type" value="Full Time" <?php echo ( get_session('study_type') == "Full Time") ? "checked" : ""; ?>>
								<span class="label-text"> </span><span class="remb"> <?php echo lang('full_time'); ?> </span>
							</label>
						</div>

						<div class="form-check">
							<label>

								<input type="radio" name="study_type" value="Part Time" <?php echo ( get_session('study_type') == "Part Time") ? "checked" : ""; ?>>
								<span class="label-text"> </span><span class="remb"> <?php echo lang('part_time'); ?> </span>
							</label>
						</div>

					</form>
				</div>

				<div class="col-md-12">
					<div class="form-group pull-left">
						<button id="back_to_field_of_study" type="button" class="btn back-btn"><?php echo lang('go_back'); ?></button>
					</div>
					<div class="form-group pull-right">
						<a href="javascript:void(0)" id="get_book_details" class="btn next-btn"><?php echo lang('next_step'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Become Space Provider End-->

<script type="text/javascript">
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