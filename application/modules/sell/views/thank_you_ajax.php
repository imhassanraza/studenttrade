<section class="show-space section-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h2><?php echo lang('dear'); ?> <?php $username = get_username(); echo !empty($username) ?  $username : get_session('email'); ?>, <span style="color: #3FC0B7;"><?php echo lang('thanks_for_adding_your_books_to_our_marketplace'); ?></span></h2>
				<br>
				<p style="font-size: 20px;">
					<?php echo lang('email_on_book_sold'); ?>
				</p>
			</div>
		</div>
	</div>

	<section id="featured-room" style="padding-top: 100px; padding-bottom: 30px;">
		<div class="container">
			<div class="row tpb-row hero-image-with-text hero-center-text" style="margin:0; padding-top: 200px; padding-bottom: 200px; background-image: url('<?php echo base_url(); ?>/assets/images/banner-tree.png'); background-size: contain; background-position: center center;">
			</div>
		</div>
	</section>
</section>