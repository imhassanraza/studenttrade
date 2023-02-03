<?php $this->load->view('common/header'); ?>

<!-- Become Space Provider -->
<div id="ajax_wrapper">
	<section class="room section-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-10 col-xs-12 col-md-offset-3 col-sm-offset-1">

					<h2><?php echo lang('which_semester_you_to_buy'); ?></h2>

					<form id="user_details" action="" method="">

						<input type="hidden" name="form_id" value="semester">

						<div class="row">

							<div class="col-md-12">
								<div class="form-group">
									<select class="form-control" name="semester" id="semester" style="width: 100%;">
										<!-- <option value=""><?php // echo lang('select_semester'); ?></option> -->
										<option></option>
										<option value="1" <?php if(get_session('semester') == 1) { ?> selected="" <?php } ?> > 1 </option>
										<option value="2" <?php if(get_session('semester') == 2) { ?> selected="" <?php } ?> > 2 </option>
										<option value="3" <?php if(get_session('semester') == 3) { ?> selected="" <?php } ?> > 3 </option>
										<option value="4" <?php if(get_session('semester') == 4) { ?> selected="" <?php } ?> > 4 </option>
										<option value="5" <?php if(get_session('semester') == 5) { ?> selected="" <?php } ?> > 5 </option>
										<option value="6" <?php if(get_session('semester') == 6) { ?> selected="" <?php } ?> > 6 </option>
										<option value="7" <?php if(get_session('semester') == 7) { ?> selected="" <?php } ?> > 7 </option>
										<option value="8" <?php if(get_session('semester') == 8) { ?> selected="" <?php } ?> > 8 </option>

										<!-- <?php // foreach ($semesters as $semester) { ?>
											<option value="<?php // echo $semester['semester']; ?>" <?php // if(get_session('semester') == $semester['semester']) { ?> selected="" <?php // } ?>> <?php // echo $semester['semester']; ?> </option>
											<?php // } ?> -->
										</select>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group pull-left">
										<button id="back_to_study_type" type="button" class="btn back-btn"><?php echo lang('go_back'); ?></button>
									</div>
									<div class="form-group pull-right">
										<a href="javascript:void(0)" id="submit_user_details" class="btn next-btn"><?php echo lang('next_step'); ?></a>
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

	<script type="text/javascript">

		$(document).ready(function() {
			$('#semester').select2({
				placeholder: "<?php echo lang('select_semester'); ?>",
			});
		});

		$("#back_to_study_type").click(function() {
			$.ajax({
				url:'<?php echo base_url(); ?>buy/back_to_study_type',
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