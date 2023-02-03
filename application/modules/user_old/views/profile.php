<?php $this->load->view('common/header'); ?>
<!-- Edit Profile -->

<section class="panel-bg">
	<div class="container">
		<div class="row">

			<?php $this->load->view('common/dashboard_sidebar'); ?>

			<div class="col-md-9">
				<div id="content">
					<?php if($user_detail['profile_updated'] == '0'): ?>
						<div class="single-agent profile-box usr-profile">
							<p class="text-center text-danger"> <?php echo lang('profile_not_completed'); ?> <a href="<?php echo base_url(); ?>user/edit_profile"> <?php echo lang('click_here'); ?> </a> <?php echo lang('update_your_profile'); ?> </p>
						</div>

						<?php else: ?>
							<div class="single-agent profile-box usr-profile">

								<div class="profile-content">
									<div class="profile-img" style="background-image:url(<?php echo base_url(); ?>assets/profile_pictures/<?php echo get_session('profile_pic'); ?>); height:100px; width:100%; background-size:cover; background-position: center center;"></div>
									<div class="content-wrapper">
										<a class="btn btn-info btn-xs float-right" href="<?php echo base_url(); ?>user/edit_profile"> <i class="fa fa-edit"></i> <?php echo lang('edit_profile'); ?> </a>
										<h3 class="profile-name">
											<a href="#" class=""><?php echo $user_detail['first_name']." ".$user_detail['last_name']; ?></a>
											<small>
												<?php echo lang('member_since'); ?>
												<?php if ($this->session->userdata('site_lang') == 'english'){ ?>
													<?php echo date("j F, Y" , strtotime($user_detail['created_at'])); ?>
												<?php } else { ?>
													<?php setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');
													echo strftime("%d. %B %Y",strtotime($user_detail['created_at'])); ?>
												<?php } ?>
											</small>
										</h3>
										<ul class="profile-contact">
											<li>
												<label> <?php echo lang('email'); ?> </label>
												<a href="mailto:<?php echo $user_detail['email']; ?>"><?php echo $user_detail['email']; ?></a>
											</li>
											<li>
												<label> <?php echo lang('phone_number'); ?> </label>
												<a href="tel:<?php echo $user_detail['phone']; ?>"><?php echo $user_detail['phone']; ?></a>
											</li>
											<?php if(!empty($user_detail['gender'])){ ?>
												<li>
													<label> <?php echo lang('gender'); ?> </label>
													<b>
														<?php if ($user_detail['gender'] == 'Male'){ ?>
															<?php echo lang('male'); ?>
														<?php } else if ($user_detail['gender'] == 'Female'){ ?>
															<?php echo lang('female'); ?>
														<?php } else { ?>
														<?php } ?>
													</b>
												</li>
											<?php } ?>
										</ul>
										<p>
											<label> <?php echo lang('address_label'); ?> </label>
											<b>
												<?php echo $user_detail['address1'].", "; ?>
												<?php echo $user_detail['zip']." ".$user_detail['city']; ?>
											</b>
										</p>
										<hr>
										<h3 class="profile-name">
											<?php echo lang('payment_information'); ?>
										</h3>
										<?php if (empty($user_detail['paypal_email']) && empty($user_detail['iban_number'])) { ?>
											<ul class="profile-contact">
												<li><?php echo lang('update_payment_detail'); ?> </li>
											</ul>
										<?php }else{ ?>
											<ul class="profile-contact">
												<li>
													<label> <?php echo lang('credited'); ?> </label>
													<?php if (empty($user_detail['amount_tranfer'])) { ?>
														<b><?php echo lang('paypal_account'); ?></b>
													<?php } else { ?>
														<b><?php echo lang('bank_account'); ?></b>
													<?php } ?>
												</li>
												<?php if (!empty($user_detail['paypal_email'])) { ?>
													<li>
														<label> <?php echo lang('paypal_id'); ?> </label>
														<a href="mailto:<?php echo $user_detail['paypal_email']; ?>"><?php echo $user_detail['paypal_email']; ?></a>
													</li>
												<?php } ?>
												<?php if (!empty($user_detail['iban_number'])) { ?>
													<li>
														<label> <?php echo lang('iban'); ?> </label>
														<b><?php echo $user_detail['iban_number']; ?></b>
													</li>
												<?php } ?>
											</ul>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>


			</div>
		</div>
	</section>


	<?php $this->load->view('common/footer'); ?>