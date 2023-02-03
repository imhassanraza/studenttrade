<?php $this->load->view('common/header'); ?>
<!-- Edit Profile -->

<section class="panel-bg profile_pg">
	<div class="container">
		<div class="row">

			<?php $this->load->view('common/dashboard_sidebar'); ?>


			<div class="col-md-9">
				<div class="panel with-nav-tabs panel-default">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
							<li><a><i class="fa fa-user-circle"></i> <?php echo lang('edit_profile'); ?></a></li>

						</ul>
					</div>

					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1default">

								<!-- <div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<form id="profile_dp_form">
											<label class="btn-bs-file btn  btn-primary pull-right">
												<img src="<?php // echo base_url(); ?>assets/images/photo-camera.png"> <?php // echo lang('change_profile_picture'); ?>
												<input type="file" name="profile_dp" id="profile_dp" accept="image/*" />
											</label>
										</form>
									</div>
								</div> -->

								<form id="update_user" method="post" action="" novalidate>
									<h4 class="dark-sky"><?php echo lang('personal_information'); ?></h4>
									<hr />
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label><?php echo lang('first_name'); ?></label>
												<input type="text" class="form-control" name="first_name" value="<?php echo $user_detail['first_name']; ?>" required>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label><?php echo lang('last_name'); ?></label>
												<input type="text" class="form-control" name="last_name" value="<?php echo $user_detail['last_name']; ?>" required>
											</div>
										</div>
									</div>


									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label><?php echo lang('gender_label'); ?></label>
												<select name="gender" class="form-control" required>
													<option <?php if ($user_detail['gender'] == 'Male') { ?> selected  <?php } ?> value="Male"> <?php echo lang('male'); ?> </option>
													<option <?php if ($user_detail['gender'] == 'Female') { ?> selected  <?php } ?> value="Female"> <?php echo lang('female'); ?> </option>
													<!-- <option <?php // if ($user_detail['gender'] == 'Other') { ?> selected  <?php // } ?> value="Other"> Other </option> -->
												</select>
											</div>
										</div>
									</div>
									<br/>
									<h4 class="dark-sky"><?php echo lang('payment_information'); ?></h4>
									<hr>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="">
												<label><?php echo lang('money_transfer'); ?></label>
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12">
												<div class="form-check">
													<label>
														<input type="radio" name="amount_tranfer" value="0" <?php echo $user_detail['amount_tranfer'] ? "" : "checked"; ?>>
														<span class="label-text"></span>
														<span class="remb">Paypal</span>
													</label>
												</div>
											</div>
											<div class="col-md-2 col-sm-6 col-xs-12">
												<div class="form-check">
													<label>
														<input type="radio" name="amount_tranfer" value="1" <?php echo $user_detail['amount_tranfer'] ? "checked" : ""; ?>>
														<span class="label-text"></span>
														<span class="remb">Bank</span>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label><?php echo lang('paypal_email'); ?></label>
												<input type="email" class="form-control" name="paypal_email" value="<?php echo $user_detail['paypal_email']; ?>">
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label><?php echo lang('iban_number'); ?></label>
												<input type="text" class="form-control" name="iban_number" value="<?php echo $user_detail['iban_number']; ?>">
											</div>
										</div>
									</div>

								</div>

								<h4 class="dark-sky"><?php echo lang('contact_information'); ?></h4>
								<hr/>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label><?php echo lang('email_label'); ?></label>
											<input type="email" class="form-control" name="email" value="<?php echo $user_detail['email']; ?>" readonly>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label><?php echo lang('phone_number_label'); ?></label>
											<input type="text" class="form-control" name="phone" value="<?php echo $user_detail['phone']; ?>" id="phone_number" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('address1'); ?></label>
											<input type="text" class="form-control" name="address1" value="<?php echo $user_detail['address1']; ?>" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><?php echo lang('address2'); ?></label>
											<input type="text" class="form-control" name="address2" value="<?php echo $user_detail['address2']; ?>">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('city'); ?></label>
											<input type="text" class="form-control" name="city" value="<?php echo $user_detail['city']; ?>" required>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('state') ?></label>
											<input type="text" class="form-control" name="state" value="<?php echo $user_detail['state']; ?>">
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label><?php echo lang('zip') ?></label>
											<input type="text" class="form-control" name="zip" value="<?php echo $user_detail['zip']; ?>">
										</div>
									</div>

								</div>

								<div class="form-group text-left">
									<button type="button" class="btn back-btn cont-btn submit"><?php echo lang('submit') ?></button>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<!-- Edit Profile End-->
<?php $this->load->view('common/footer'); ?>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"
	type="text/javascript"></script>

	<script type="text/javascript">

		$('.submit').click(function(e){

			var btn = $(this);

			$(btn).button('loading');
			var value = $("#update_user").serialize();

			$.ajax({
				url:'<?php echo base_url(); ?>user/update_user',
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
						$(btn).button('reset');
						setTimeout(function(){ window.location = "<?php echo base_url().'user/profile'; ?>"; },1000);
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
						$(btn).button('reset');
					}
				}
			});
		});

	</script>


	<script>

		$("#profile_dp").on("change", function (e) {

			var file, img;
			var _URL = window.URL || window.webkitURL;
			var img_valid = true;
			if ((file = this.files[0])) {
				img = new Image();
				img.onload = function () {
                //alert(this.width + "*" + this.height);
                if (this.width > 600 || this.height > 600) {
                	$.gritter.add({
                		title: '<?php echo lang('error'); ?>',
                		sticky: false,
                		time: '5000',
                		before_open: function() {
                			if ($('.gritter-item-wrapper').length >= 3) {
                				return false;
                			}
                		},
                		text: "<?php echo lang('image_error'); ?> "+this.width+"X"+this.height+".",
                		class_name: 'gritter-error'
                	});
                }else{
                	var formData = new FormData($("#profile_dp_form")[0]);
                	$.ajax({
                		url: '<?php echo base_url(); ?>user/update_dp',
                		type: 'POST',
                		data: formData,
                		async: false,
                		cache: false,
                		dataType:'json',
                		contentType: false,
                		enctype: 'multipart/form-data',
                		processData: false,
                		success: function (status) {
                			if (status.msg == 'success') {
                				$.gritter.add({
                					title: '<?php echo lang('success_msg'); ?>',
                					sticky: false,
                					time: '5000',
                					before_open: function() {
                						if ($('.gritter-item-wrapper').length >= 3) {
                							return false;
                						}
                					},
                					text: status.response,
                					class_name: 'gritter-success'
                				});
                				setTimeout(function(){ location.reload(); },2000);
                			} else if (status.msg == 'error') {
                				$.gritter.add({
                					title: '<?php echo lang('error'); ?>',
                					sticky: false,
                					time: '5000',
                					before_open: function() {
                						if ($('.gritter-item-wrapper').length >= 3) {
                							return false;
                						}
                					},
                					text: status.response,
                					class_name: 'gritter-error'
                				});
                			}
                		}
                	});
                	return false;
                }
            };
            img.src = _URL.createObjectURL(file);
        }

    });


</script>

<script src="https://rawgit.com/RobinHerbots/Inputmask/4.x/dist/jquery.inputmask.bundle.js"></script>
<script>
	$('#phone_number').inputmask({mask: '+99 99 999 99 99'});
</script>