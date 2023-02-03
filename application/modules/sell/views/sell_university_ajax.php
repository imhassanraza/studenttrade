<section class="become-space section-bg">
	<div class="container">
		<div class="row">

			<div class="col-md-6 col-md-offset-3">

				<!-- <h2><?php // echo get_session('username'); ?> <?php // echo lang('lets_start'); ?></h2> -->

				<h2><?php echo lang('which_university'); ?></h2>

				<form id="user_details" action="" method="post">
					<input type="hidden" name="form_id" value="university">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<select class="form-control" name="university" id="university" style="width: 100%;">
									<!-- <option value=""><?php // echo lang('select_university'); ?></option> -->
									<option></option>
									<?php foreach ($universities as $university) { ?>

										<option value="<?php echo $university['university']; ?>" <?php if(get_session('university') == $university['university']) { ?> selected="" <?php } ?>> <?php echo $university['university']; ?> </option>
									<?php } ?>


									<option value="other_university_ub" <?php if(get_session('new_university') == 'other_university_ub') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_ub'); ?>
									</option>
									<option value="other_university_uba" <?php if(get_session('new_university') == 'other_university_uba') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_uba'); ?>
									</option>
									<option value="other_university_kzn" <?php if(get_session('new_university') == 'other_university_kzn') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_kzn'); ?>
									</option>
									<option value="other_university_ke" <?php if(get_session('new_university') == 'other_university_ke') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_ke'); ?>
									</option>
									<option value="other_university_kr" <?php if(get_session('new_university') == 'other_university_kr') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_kr'); ?>
									</option>
									<option value="other_university_kw" <?php if(get_session('new_university') == 'other_university_kw') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_kw'); ?>
									</option>
									<option value="other_university_kzu" <?php if(get_session('new_university') == 'other_university_kzu') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_kzu'); ?>
									</option>
									<option value="other_university_gbb" <?php if(get_session('new_university') == 'other_university_gbb') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_gbb'); ?>
									</option>
									<option value="other_university_kzbs" <?php if(get_session('new_university') == 'other_university_kzbs') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university_kzbs'); ?>
									</option>

									<option value="other_university" <?php if(get_session('new_university') == 'other_university') { ?> selected="" <?php } ?>>
										<?php echo lang('other_university'); ?>
									</option>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<a href="javascript:void(0)" id="get_book_details" class="btn cont-btn"><?php echo lang('continue'); ?></a>
							</div>
						</div>

					</div>
				</form>
			</div>

		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('#university').select2({
			placeholder: "<?php echo lang('select_university'); ?>",
		});
	});
</script>