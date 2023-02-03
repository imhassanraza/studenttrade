<?php $this->load->view('common/header'); ?>
<section class="panel-bg profile_pg">
	<div class="container">
		<div class="row">
			<?php $this->load->view('common/dashboard_sidebar'); ?>
			<div class="col-md-9 account-setting-tab">
				<div class="panel with-nav-tabs panel-default">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab2default" data-toggle="tab">  <?php echo lang('change_email_associated'); ?> </a></li>
							<li><a href="#tab4default" data-toggle="tab"> <?php echo lang('change_password'); ?></a></li>
						</ul>
					</div>

					<div class="panel-body">
						<div class="tab-content">

							<div class="tab-pane fade in active" id="tab2default">
								<div class="col-md-8 col-md-offset-2">
									<div class="panel panel-inner">
										<div class="panel-heading"><?php echo lang('edit_email'); ?></div>
										<div class="panel-body">
											<!-- <p><?php // echo lang('change_email_text'); ?></p> -->
											<!-- <hr> -->

											<div class="row">
												<div class="col-md-3 col-sm-3 col-xs-3">
													<p style="margin-bottom: 4.5px;"><?php echo lang('email_label'); ?></p>
												</div>
												<div class="col-md-9 col-sm-9 col-xs-9 text-right">
													<p style="margin-bottom: 4.5px;"><?php echo $user_detail['email']; ?></p>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6 col-sm-6 col-xs-6">
													<p><?php echo lang('phone_number_label'); ?></p>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6 text-right">
													<p>
														<?php
														if (empty($user_detail['phone'])) {
															echo lang('not_found');
														}else{
															echo $user_detail['phone'];
														}
														?>
													</p>
													<label class="label label-info"><a href="javascript:void(0)" id="edit_email" data-toggle="modal" data-target="#changeemailModal" style="color:#fff; padding:4px 8px; font-size: 12px"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?> </a></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="tab3default"></div>

							<div class="tab-pane fade" id="tab4default">
								<div class="col-md-8 col-md-offset-2">

									<h3 class="dark-sky"><?php echo lang('change_password'); ?></h3>
									<!-- <hr> -->
									<!-- <span class="remb"><?php // echo lang('change_password_form'); ?></span> -->
									<form id="change_password_form" method="post" action="">

										<div class="row">

											<div class="col-md-12">
												<div class="form-group">
													<input class="form-control" name="old_password" placeholder="<?php echo lang('old_password'); ?>" type="password">
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<input class="form-control" name="password" placeholder="<?php echo lang('new_password'); ?>" type="password">
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<input class="form-control" name="c_password" placeholder="<?php echo lang('confirm_password') ?>" type="password">
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<button type="button" id="submit" class="btn btn-block cont-btn"><?php echo lang('change'); ?></button>
												</div>
											</div>

										</div>
									</form>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- chagne email Popup Model -->

<div class="modal fade login-popup centered-modal" id="changeemailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close close-login" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"> <?php echo lang('change_email'); ?> </h4>
			</div>

			<div class="modal-body">
				<form id="change_email_form" action="" method="post">
					<p><?php echo lang('new_email'); ?></p>
					<div class="input-group" style="width:100%;">
						<span><i class="fa fa-envelope mail-icon"></i></span>
						<input type="email" class="form-control" name="email" placeholder="<?php echo lang('email_address'); ?>" required="required">
					</div>
				</form>
			</div>

			<div class="modal-footer text-center">
				<button type="button" id="change_email_btn" class="btn next-btn pull-right"><?php echo lang('send_change_link'); ?></button>
			</div>

		</div>
	</div>
</div>

<!-- Change email modal End -->

<?php $this->load->view('common/footer'); ?>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"
	type="text/javascript"></script>
	<script type="text/javascript">

		$('#submit').click(function(e){

			var btn = $(this);
			var value = $("#change_password_form").serialize();
			$.ajax({
				url:'<?php echo base_url(); ?>user/update_password',
				type:'post',
				data:value,
				dataType:'json',
				success:function(status){
					console.log(status);
					if(status.msg=='success'){
						$.gritter.add({

							title: '<?php echo lang('success_msg'); ?>',

							sticky: false,
							time: '5000',
							before_open: function(){
								if($('.gritter-item-wrapper').length >= 3)
								{
									return false;
								}
							},
							text: status.response,
							class_name: 'gritter-success'
						});
						$("#change_password_form")[0].reset();
					}
					else if(status.msg == 'error'){
						$.gritter.add({
							title: '<?php echo lang('error'); ?>',
							sticky: false,
							time: '5000',
							before_open: function(){
								if($('.gritter-item-wrapper').length >= 3)
								{
									return false;
								}
							},
							text: status.response,
							class_name: 'gritter-error'
						});
					}
				}
			});
		});


		$('#notify_save').click(function(e){

			var btn = $(this);
			var value = $("#notify_setting").serialize();
			$.ajax({
				url:'<?php echo base_url(); ?>user/notify_setting',
				type:'post',
				data:value,
				dataType:'json',
				success:function(status){
					console.log(status);
					if(status.msg=='success'){
						$.gritter.add({

							title: '<?php echo lang('success_msg'); ?>',

							sticky: false,
							time: '5000',
							before_open: function(){
								if($('.gritter-item-wrapper').length >= 3)
								{
									return false;
								}
							},
							text: status.response,
							class_name: 'gritter-success'
						});

					}
					else if(status.msg == 'error'){
						$.gritter.add({
							title: '<?php echo lang('error'); ?>',
							sticky: false,
							time: '5000',
							before_open: function(){
								if($('.gritter-item-wrapper').length >= 3)
								{
									return false;
								}
							},
							text: status.response,
							class_name: 'gritter-error'
						});
					}
				}
			});
		});


		$('#change_email_btn').click(function(){
			var value = $("#change_email_form").serialize();
			$.ajax({
				url:'<?php echo base_url(); ?>user/change_email',
				type:'post',
				data:value,
				dataType:'json',
				success:function(status){
					if(status.msg=='success'){
						$.gritter.add({
							title: '<?php echo lang('success_msg'); ?>',
							sticky: false,
							time: '5000',
							before_open: function(){
								if($('.gritter-item-wrapper').length >= 3)
								{
									return false;
								}
							},
							text: status.response,
							class_name: 'gritter-success'
						});
						$('#changeemailModal').modal('hide');
						$('#change_email_form')[0].reset();
					}
					else if(status.msg == 'error'){
						$.gritter.add({
							title: '<?php echo lang('error'); ?>',
							sticky: false,
							time: '5000',
							before_open: function(){
								if($('.gritter-item-wrapper').length >= 3)
								{
									return false;
								}
							},
							text: status.response,
							class_name: 'gritter-error'
						});
					}
				}
			});
		});

	</script>