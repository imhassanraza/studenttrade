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
							<p class="text-center text-danger"> Your profile is not complete yet. <a href="<?php echo base_url(); ?>user/profile"> click here </a> to update your profile. </p>
						</div>

					<?php else: ?>
						<div class="single-agent profile-box usr-profile">
							<div class="profile-content">
								<img src="<?php echo base_url(); ?>assets/profile_pictures/<?php echo get_session('profile_pic'); ?>" alt="<?php echo get_session('username'); ?>" class="profile-img">
								<div class="content-wrapper">
									<h3 class="profile-name">
										<a href="#" class=""><?php echo $user_detail['first_name']." ".$user_detail['last_name']; ?></a>
										<small>Member Since <?php echo date("j F, Y" , strtotime($user_detail['created_at'])); ?></small>
									</h3>
									<ul class="profile-contact">
										<li>
											<i class="fa fa-envelope"></i>
											<a href="mailto:<?php echo $user_detail['email']; ?>"><?php echo $user_detail['email']; ?></a>
										</li>
										<li>
											<i class="fa fa-mobile"></i>
											<a href="tel:<?php echo $user_detail['phone']; ?>"><?php echo $user_detail['phone']; ?></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="profile-description">
								<p><?php echo $user_detail['about']; ?></p>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>


		</div>
	</div>
</section>


<?php $this->load->view('common/footer'); ?>