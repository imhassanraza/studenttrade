<!-- Forgot Password Popup Model -->

<div class="modal fade login-popup centered-modal" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close close-login" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo lang('reset_password'); ?></h4>
			</div>
			<form id="retrieve_password_form" action="" method="post" novalidate>
				<div class="modal-body">

					<p><?php echo lang('enter_your_email'); ?></p>
					<div class="input-group" style="width:100%;">
						<span><i class="fa fa-envelope mail-icon"></i></span>
						<input type="email" class="form-control" name="email" placeholder="<?php echo lang('email_address'); ?>" required>
					</div>

				</div>

				<div class="modal-footer text-center">
					<p class="pull-left back-login"><a href="javascript:void(0)" id="back_to_login_mdl"><i class="fa fa-angle-left"></i> <?php echo lang('back_to_login'); ?> </a> </p>
					<button type="submit" data-loading-text="<?php echo lang('please_wait'); ?>" id="retrieve_password" class="btn next-btn pull-right"><?php echo lang('send_reset_link'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Forgot Password End -->

<!-- Login Popup Model -->

<div class="modal fade login-popup centered-modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close close-login" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo lang('login'); ?></h4>
			</div>

			<div class="modal-body">

				<div id="verification_error" class="alert alert-danger clearfix" style="display: none;">

				</div>

				<div id="verification_success" class="alert alert-success clearfix" style="display: none;">

				</div>

				<form id="login_form" action="" method="post">

					<div class="input-group" style="width:100%;">
						<span><i class="fa fa-envelope mail-icon"></i></span>
						<input type="email" class="form-control" name="login_email" placeholder="<?php echo lang('email_address'); ?>" required>
					</div>


					<div class="input-group" style="width:100%;">
						<span><i class="fa fa-lock lock-icon"></i></span>
						<input type="password" class="form-control" name="login_password" placeholder="<?php echo lang('password'); ?>" required>
					</div>

					<div class="forgot-outer">
						<div class="form-check" style="margin-left: -17px;">
							<label>
								<input type="checkbox" name="check"> <span class="label-text" > </span><span class="remb"><?php echo lang('remember_me'); ?></span>
							</label>
						</div>
						&nbsp; &nbsp; &nbsp;
						<div>

							<span class="label-text forgot"><a href="javascript:void(0)" id="forgot_mdl_btn"><?php echo lang('forgot_password'); ?></a> </span>

						</div>
					</div>

					<div class="form-group">
						<button type="submit" data-loading-text="<?php echo lang('please_wait'); ?>" id="login_btn" class="login-btn btn"><?php echo lang('login'); ?></button>
					</div>
				</form>
			</div>

			<div class="modal-footer text-center">
				<p class="pull-left"><?php echo lang('dont_have_an_account');?></p>
				<a href="javascript:void(0)" id="signup_mdl_btn" class="btn sign-btn pull-right"><?php echo lang('sign_up'); ?></a>
			</div>

		</div>
	</div>
</div>

<!-- Login Popup End -->


<!-- SignUp Popup Model -->

<div class="modal fade login-popup sign-pop centered-modal" id="signModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close close-login" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo lang('sign_up'); ?></h4>
			</div>

			<div class="modal-body">
				<form id="registration_form" action="" method="post">

					<div class="input-group" style="width:100%;">
						<span><i class="fa fa-envelope lock-icon"></i></span>
						<input type="email" class="form-control" id="register_email"  name="email" placeholder="<?php echo lang('email_address'); ?>" required>
					</div>

					<div class="input-group" style="width:100%;">
						<span><i class="fa fa-phone lock-icon"></i></span>
						<input type="text" class="form-control" id="phone_no1"  name="phone_no" placeholder="<?php echo lang('phone_no'); ?>" required>
					</div>

					<div class="input-group" style="width:100%;">
						<span><i class="fa fa-lock lock-icon"></i></span>
						<input type="password" name="password" id="password" class="form-control" placeholder="<?php echo lang('password'); ?>" required>
					</div>

					<div class="input-group" style="width:100%;">
						<span><i class="fa fa-lock lock-icon"></i></span>
						<input type="password" name="c_password" class="form-control" placeholder="<?php echo lang('confirm_password'); ?>" required>
					</div>

					<div class="forgot-outer">
						<div class="form-check pull-left confirm-agreement">
							<label>
								<input type="checkbox" name="check_policy" id="check_policy"> <span class="label-text" > </span><span class="remb"><?php echo lang('i_accept_the'); ?> <a href="<?php echo base_url(); ?>terms_and_conditions" target="_blank"> <?php echo lang('terms_of_use'); ?> </a> <?php echo lang('and'); ?> <a href="<?php echo base_url(); ?>privacy_policy" target="_blank"> <?php echo lang('privacy_policy1'); ?> </a> </span>
								<p id="confirm_error" class="text-danger"></p>
							</label>
						</div>
					</div>

					<div class="form-group">
						<button type="submit" data-loading-text="<?php echo lang('please_wait'); ?>" id="registration_btn" class="signup-btn btn"><?php echo lang('sign_up'); ?></button>
					</div>

				</form>
			</div>

			<div class="modal-footer text-center">
				<p class="pull-left"><?php echo lang('already_have_an_account'); ?></p>
				<a href="javascript:void(0)" class="btn sign-btn pull-right" id="login_mdl_btn"><?php echo lang('log_in'); ?></a>
			</div>


		</div>
	</div>
</div>

<!-- SignUp Popup End -->


<!-- ====== FOOTER ====== -->
<footer id="footer" class="position-md-absolute">
	<div class="container-fluid">
		<div class="row footer-body">
			<!-- Footer Brand Column -->
			<div class="col-md-4 col-sm-12 footer-column">
				<a href="<?php echo base_url(); ?>" id="footer-brand" class="footer-brand">
					<img class="img-responsive" src="<?php echo base_url(); ?>assets/images/footer_logo.png" alt="Student Trade Property">
				</a>
				<p><?php echo get_section_content('home' , 'footer_text_'.get_session('site_lang')); ?> <a href='<?php echo base_url(); ?>about_us'><?php echo lang('read_more'); ?></a></p>
			</div>

			<!-- Usefull Link Column -->
			<div class="col-md-3 col-md-offset-1 col-sm-6 footer-column">
				<h3 class="footer-title"><?php echo lang('usefull_link'); ?></h3>
				<ul class="footer-menu">
					<li><a href="<?php echo base_url(); ?>search"><?php echo lang('search_book'); ?></a></li>
					<li><a href="<?php echo base_url(); ?>charity"><?php echo lang('charity'); ?></a></li>
					<!-- <li><a href="<?php // echo base_url(); ?>how_it_works"><?php // echo lang('how_it_work'); ?></a></li> -->
					<li><a href="<?php echo base_url(); ?>about_us"><?php echo lang('about_us'); ?></a></li>
					<li><a href="<?php echo base_url(); ?>contact_us"><?php echo lang('contact_us'); ?></a></li>
					<li><a href="<?php echo base_url(); ?>terms_and_conditions"><?php echo lang('term_and_condition'); ?></a></li>
					<li><a href="<?php echo base_url(); ?>privacy_policy"><?php echo lang('privacy_policy'); ?></a></li>
				</ul>
			</div>
			<!-- Information Column -->
			<!-- <div class="col-md-2 col-sm-6 footer-column">
				<h3 class="footer-title"><?php // echo lang('information'); ?></h3>
				<ul class="footer-menu">
					<li><a href="<?php // echo base_url(); ?>contact_us"><?php // echo lang('contact_us'); ?></a></li>
					<li><a href="<?php // echo base_url(); ?>terms_and_conditions"><?php // echo lang('term_and_condition'); ?></a></li>
					<li><a href="<?php // echo base_url(); ?>privacy_policy"><?php // echo lang('privacy_policy'); ?></a></li>
				</ul>
			</div> -->
			<!-- Contact Us Column -->
			<div class="col-md-3 col-md-offset-1 col-sm-6 footer-column footer-icon">
				<h3 class="footer-title"><?php echo lang('contact_us'); ?></h3>

				<div class="row">
					<div class="col-md-11 col-sm-11 col-xs-12">
						<p class="item-text"><i class="fa fa-map-marker fa-1x"></i> <?php echo get_section_content('contactus' , 'contactus_address'); ?></p>
					</div>
				</div>

				<!-- <div class="row">
					<div class="col-md-11 col-sm-11 col-xs-12">
						<p class="item-text"> <a href="tel:<?php //echo get_section_content('contactus' , 'contactus_phone'); ?>"><i class="fa fa-phone fa-1x" style="color: white;"></i>  <?php //echo get_section_content('contactus' , 'contactus_phone'); ?> </a> </p>
					</div>
				</div> -->
				<div class="row" >
					<div class="col-md-11 col-sm-11 col-xs-12">
						<p class="item-text"> <a href="mailto:<?php echo get_section_content('contactus' , 'contactus_email'); ?>"><i class="fa fa-envelope fa-1x" style="color: white;"></i>  <?php echo get_section_content('contactus' , 'contactus_email'); ?></a> </p>
					</div>
				</div>

				<!-- <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 social-icon">
						<ul class="social-network social-circle">
							<li><a href="<?php // echo get_section_content('social_links' , 'facebook'); ?>" class="icoFacebook"  target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
							<li><a href="<?php // echo get_section_content('social_links' , 'twitter'); ?>" class="icoTwitter" target="_blank"  title="Twitter"><i class="fa fa-twitter"></i></a></li>
							<li><a href="<?php // echo get_section_content('social_links' , 'instagram'); ?>"  class="icoInsta"  target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a></li>

						</ul>

					</div>

				</div> -->

			</div>
		</div>
	</div>

	<!-- Copyright -->
	<div class="copyright">
		<div class="container clearfix">
			<p><?php echo lang('copyright'); ?> &copy; <?php echo date('Y'); ?> - <?php echo lang('all_rights_reserved'); ?></p>

		</div>
	</div>

	<div class="scroll-top-wrapper">
		<span class="scroll-top-inner">
			<i class="fa fa-2x fa-angle-double-up"></i>
		</span>
	</div>
</footer>
<div class="opc" ></div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.gritter.min.js"></script>

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- sweet alert js -->
<script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://rawgit.com/RobinHerbots/Inputmask/4.x/dist/jquery.inputmask.bundle.js"></script>
<script>
	$('#phone_no').inputmask({mask: '+99 99 999 99 99'});
	$('#phone_no1').inputmask({mask: '+99 99 999 99 99'});
	$('#phone_no2').inputmask({mask: '+99 99 999 99 99'});

	$(document).on('click', '.add_to_cart', function() {
		var btn = $(this);
		var book_id = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>buy/add_to_cart',
			type:'post',
			data: { book_id : book_id },
			dataType:'json',
			success:function(status){
				if(status.msg == 'success'){
					$(btn).removeClass('add_to_cart').addClass('remove_from_cart');
					$('#cart_items').text(status.items);
				} else if(status.msg == 'error') {
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

	$(document).on('click', '.remove_from_cart', function() {
		var btn = $(this);
		var book_id = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>buy/remove_from_cart',
			type:'post',
			data: { book_id : book_id },
			dataType:'json',
			success:function(status){
				if(status.msg == 'success'){
					$(btn).removeClass('remove_from_cart').addClass('add_to_cart');
					$('#cart_items').text(status.items);

				} else if(status.msg == 'error') {
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


	$(document).on('click', "#signup_mdl_btn", function() {
		$('#loginModal').modal('hide');
		$('#loginModal').one('hidden.bs.modal', function () {
			$('#signModal').modal('show');
		});
	});


	$(document).on('click', "#login_mdl_btn", function() {
		$('#signModal').modal('hide');
		$('#signModal').one('hidden.bs.modal', function () {
			$('#loginModal').modal('show');
		});
	});


	$(document).on('click', "#forgot_mdl_btn", function() {
		$('#loginModal').modal('hide');
		$('#loginModal').one('hidden.bs.modal', function () {
			$('#forgotModal').modal('show');
		});
	});

	$('#back_to_login_mdl').click(function(){
		$('#forgotModal').modal('hide');
		$('#forgotModal').one('hidden.bs.modal', function () {
			$('#loginModal').modal('show');
		});
	});

	// $('#retrieve_password').click(function(){
		$('#retrieve_password_form').on('submit', function(event) {
			event.preventDefault();
		// var btn = $(this);

		$("#retrieve_password").button('loading');
		var value = $("#retrieve_password_form").serialize();
		$.ajax({
			url:'<?php echo base_url(); ?>forgot_password/retrieve_password',
			type:'post',
			data:value,
			dataType:'json',
			success:function(status){
				$("#retrieve_password").button('reset');
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
					$('#forgotModal').modal('hide');
					$('#forgotModal').one('hidden.bs.modal', function () {
						$('#loginModal').modal('show');
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

		$('body').on('click', '#submit_user_details', function (event) {

			var btn = $(this);

			$(btn).button('loading');
			var form_name = $('input[name=form_id]').val();
			var value = $("#user_details").serialize();

			$.ajax({
				url:'<?php echo base_url(); ?>buy/submit_data',
				type:'post',
				data:value,
				dataType:'json',
				success:function(status){
					if(status.msg=='success'){

						if(form_name == 'semester' || form_name == 'university') {
							$('#cart_items').text(status.items);
						}

						$("#ajax_wrapper").fadeOut(function(){$("#ajax_wrapper").html(status.response).fadeIn();});

						var stateObj = {};
						history.pushState(stateObj, "page 2", status.new_url);
						$('html, body').animate({ scrollTop: 0 }, 'slow');
					} else if(status.msg == 'error') {
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

					}else{
						$(btn).button('reset');
					}
				}
			});
		});


		$('body').on('click', '#get_book_details', function (event) {

			var btn = $(this);

			$(btn).button('loading');
			var form_name = $('input[name=form_id]').val();
			var value = $("#user_details").serialize();

			$.ajax({
				url:'<?php echo base_url(); ?>sell/submit_data',
				type:'post',
				data:value,
				dataType:'json',
				success:function(status){
					if(status.msg == 'not_login') {

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
						$('#loginModal').modal('show');

					} else if(status.msg=='success'){

						if(form_name == 'semester') {
							$('#cart_items').text(status.items);
						}

						$("#ajax_wrapper").fadeOut(function(){$("#ajax_wrapper").html(status.response).fadeIn();});

						var stateObj = {};
						history.pushState(stateObj, "page 2", status.new_url);

						$('html, body').animate({ scrollTop: 0 }, 'slow');

					} else if(status.msg == 'error') {
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

					}else{
						$(btn).button('reset');
					}
				}
			});
		});

	</script>


	<script>
		$(document).on('click', '.number-spinner button', function () {
			var btn = $(this);
			oldValue = btn.closest('.number-spinner').find('input').val().trim();

			if (oldValue == '') {
				oldValue = 0;
			}

			newVal = 0;

			if (btn.attr('data-dir') == 'up') {
				newVal = parseInt(oldValue) + 1;
			} else {
				if (oldValue > 1) {
					newVal = parseInt(oldValue) - 1;
				} else {
					newVal = 1;
				}
			}
			btn.closest('.number-spinner').find('input').val(newVal);
		});
	</script>

	<script>

		$(document).on('click', '.open-nav', function(){
			$('.opc').show();

		});

		$(document).on('click', '.closebtn', function(){
			$('.opc').hide();

		});

	</script>


	<script>
		function openNav() {
			document.getElementById("mySidenav").style.width = "280px";
			document.getElementById("main").style.marginLeft = "0px";

		}

		function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
			document.getElementById("main").style.marginLeft= "0";
		}

	</script>

	<script>

		$(document).ready(function(){

			$(function(){

				$(document).on( 'scroll', function(){

					if ($(window).scrollTop() > 100) {
						$('.scroll-top-wrapper').addClass('show');
					} else {
						$('.scroll-top-wrapper').removeClass('show');
					}
				});

				$('.scroll-top-wrapper').on('click', scrollToTop);
			});

			function scrollToTop() {

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}

		});

	</script>

</body>
</html>

<style type="text/css">
	#map > div > div > div:nth-child(1) > div:nth-child(4) > div:nth-child(4) > div > img {
		right: 45px !important;
		top: 7px !important;
		background-image:url("<?php echo base_url(); ?>assets/images/close.png") !important;
	}
</style>

<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>

<script type="text/javascript">


	$("#login_form").validate({
		errorElement: 'div',
		errorClass: 'text-danger',
		focusInvalid: true,
		ignore: "",
		rules: {
			login_email: {
				required: true,
				email: true
			},
			login_password: {
				required: true,
			},
		},
		messages: {
			login_email: {
				required: "<?php echo lang('login_email_required'); ?>",
				email: "<?php echo lang('login_email_valid'); ?>",
			},
			login_password: {
				required: "<?php echo lang('login_password_required'); ?>",
			},
		},
		highlight: function (e) {
			$(e).closest('.input-group').removeClass('has-info').addClass('has-error');
		},
		success: function (e) {
            $(e).closest('.input-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },
        errorPlacement: function (error, element) {
        	if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
        		var controls = element.closest('div[class*="col-"]');
        		if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
        		else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
        	}
        	else if(element.is('.select2')) {
        		error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
        	}
        	else if(element.is('.chosen-select')) {
        		error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
        	}
        	else error.insertBefore(element.parent());
        },
        submitHandler: function (form) {
        },
        invalidHandler: function (form , validator) {

        	if (!validator.numberOfInvalids())
        		return;

        	$('html, body').animate({
        		scrollTop: $(validator.errorList[0].element).offset().top - 300
        	}, 1000);
        }
    });


	// $('#login_btn').click(function(){
		$('#login_form').on('submit', function(event) {
			event.preventDefault();

			if($("#login_form").valid()){

				var btn = $(this);
				$("#login_btn").button('loading');
				var value = $("#login_form").serialize();
				$.ajax({
					url:'<?php echo base_url(); ?>login/login_verify',
					type:'post',
					data:value,
					dataType:'json',
					success:function(status){
						$("#login_btn").button('reset');
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
								text: "<?php echo lang('successfully_loggedin'); ?>",
								class_name: 'gritter-success'
							});
							$("#loginModal").modal('hide');
							location.reload();
						} else if(status.msg == 'error'){

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

						} else if(status.msg == 'error_verification') {
							$("#verification_success").hide();
							$("#verification_error").html(status.response).show();
							resendfun();
						}
					}
				});
			}
		});


		$("#registration_form").validate({
			errorElement: 'span',
			errorClass: 'text-danger',
			focusInvalid: true,
			ignore: "",
			rules: {
				email: {
					required: true,
					email: true,
					remote: {
						url : '<?php echo base_url(); ?>register/check_email',
						type: "post"
					}
				},
				password: {
					required: true,
					minlength: 6
				},
				c_password: {
					required: true,
					equalTo: "#password"
				},

			},
			messages: {
				email: {
					required: "<?php echo lang('login_email_required'); ?>",
					email: "<?php echo lang('login_email_valid'); ?>",
					remote: jQuery.validator.format('<?php echo lang('email_already_associated'); ?>')
				},
				password: {
					required: "<?php echo lang('login_password_required'); ?>",
					minlength: jQuery.validator.format("<?php echo lang('least_characters'); ?>")
				},
				c_password: {
					required: "<?php echo lang('repeat_password'); ?>",
					equalTo: "<?php echo lang('same_password'); ?>"
				},
			},
			highlight: function (e) {
				$(e).closest('.input-group').removeClass('has-info').addClass('has-error');
			},
			success: function (e) {
            $(e).closest('.input-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },

        errorPlacement: function (error, element) {
        	if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
        		var controls = element.closest('div[class*="col-"]');
        		if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
        		else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
        	}
        	else if(element.is('.select2')) {
        		error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
        	}
        	else if(element.is('.chosen-select')) {
        		error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
        	}
        	else error.insertBefore(element.parent());
        },

        submitHandler: function (form) {
        },
        invalidHandler: function (form , validator) {
        	if (!validator.numberOfInvalids())
        		return;
        	$('html, body').animate({
        		scrollTop: $(validator.errorList[0].element).offset().top - 300
        	}, 1000);
        }
    });

	// $('#registration_btn').click(function(){

		$('#registration_form').on('submit', function(event) {
			event.preventDefault();
			if($("#registration_form").valid()){
				var confirm_1 = $('#check_policy').prop("checked");
				if(confirm_1 == false){
					$('.remb').css('color' , 'red');
					return false;
				}else{
					$('.remb').css('color' , '');
				}

			// var btn = $(this);

			$("#registration_btn").button('loading');
			var value = $("#registration_form").serialize();
			$.ajax({
				url:'<?php echo base_url(); ?>register/submit_user',
				type:'post',
				data:value,
				dataType:'json',
				success:function(status){
					$("#registration_btn").button('reset');
					if(status.msg=='success'){
						$.gritter.add({
							title: '<?php echo lang('success_msg'); ?>',
							sticky: false,
							time: '3000',
							before_open: function(){
								if($('.gritter-item-wrapper').length >= 3)
								{
									return false;
								}
							},
							text: "<?php echo lang('successfully_signup'); ?>",
							class_name: 'gritter-success'
						});
						$("#registration_form")[0].reset();
						$("#signModal").modal('hide');
						setTimeout( function() { location.reload(); } , 2000);
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
		}
	});


		function resendfun() {
			$('#resend').click(function(){
				var btn = $(this);
				btn.button('loading');
				var email = $(this).attr('data-id');
				$.ajax({
					url:'<?php echo base_url(); ?>activation/resend',
					type:'post',
					data:{email : email},
					dataType:'json',
					success:function(status){
						if(status.msg=='success'){
							$("#verification_error").hide();
							$("#verification_success").html(status.response).show();
							btn.button('reset');
						}
						else if(status.msg=='error'){
							$.gritter.add({
								title: '<?php echo lang('error'); ?>',
								sticky: false,
								time: '3000',
								before_open: function(){
									if($('.gritter-item-wrapper').length >= 3)
									{
										return false;
									}
								},
								text: status.response,
								class_name: 'gritter-danger'
							});
							btn.button('reset');
						}
					}
				});
			});
		}

		$(document).ready(function(){
			toolTiper();
		});

		function toolTiper(effect) {
			$('.tooltiper').each(function(){
				var eLcontent = $(this).attr('data-tooltip'),
				eLtop = $(this).position().top,
				eLleft = $(this).position().left;
				$(this).append('<span class="tooltip">'+eLcontent+'</span>');
				var eLtw = $(this).find('.tooltip').width(),
				eLth = $(this).find('.tooltip').height();
				$(this).find('.tooltip').css({
					"top": '27px',
					"left":'-20px'
				});
			});
		}
	</script>
	<script type="text/javascript">
		<?php if(confirm_money_transfer()) { ?>
			$.gritter.add({
				title: '<?php echo lang('alert'); ?>',
				sticky: true,
				text: "<b><?php echo lang('congratulations'); ?></b> <?php echo lang('update_payment_details_message1'); ?> <a href='<?php echo base_url(); ?>user/edit_profile'> <?php echo lang('click_here'); ?> </a> <?php echo lang('update_payment_details_message2'); ?>",
				class_name: 'gritter-info close_alert_msg'

			});
		<?php } ?>

		$(".close_alert_msg .gritter-close").on('click', function(){
			$.ajax({
				url:'<?php echo base_url(); ?>buy/close_alert',
				type:'post',
				data:{},
				dataType:'json',
				success:function(status){}
			});
		});
	</script>