<!-- Become Space Provider -->

<section class="room section-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h2><?php echo lang('which_field'); ?></h2>
				<form id="user_details" action="" method="post">
					<div class="row">
						<input type="hidden" name="form_id" value="field_of_study">
						<div class="col-md-12">
							<div class="form-group">
								<select class="form-control" name="field_of_study" id="field_of_study" style="width: 100%;">
									<!-- <option value=""><?php // echo lang('select_field'); ?></option> -->
									<option></option>
									<?php foreach ($fields_of_study as $field_of_study) { ?>
										<option value="<?php echo $field_of_study['field_of_study']; ?>" <?php if(get_session('field_of_study') == $field_of_study['field_of_study']) { ?> selected="" <?php } ?>> <?php echo $field_of_study['field_of_study']; ?> </option>
									<?php } ?>
									<?php if (get_session('university') != 'Universität St. Gallen (HSG)') { ?>
										<option value="other_degree" <?php if(get_session('field_of_study') == 'other_degree') { ?> selected="" <?php } ?>>
											<?php echo lang('other_degree'); ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group pull-left">
								<button id="back_to_university" type="button" class="btn back-btn"><?php echo lang('go_back'); ?></button>
							</div>
							<div class="form-group pull-right">
								<button id="get_book_details" type="button" class="btn next-btn"><?php echo lang('next_step'); ?></button>
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
	$('#field_of_study').select2({
		placeholder: "<?php echo lang('select_field'); ?>",
	});
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
</script>