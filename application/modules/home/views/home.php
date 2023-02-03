<?php $this->load->view('common/header'); ?>
<section id="page-builder" class="page-section">

	<div class="row tpb-row hero-image-with-text hero-center-text bg-sec" style="margin:0; background-image: url('<?php echo base_url(); ?>assets/images/<?php echo get_section_content('home' , 'banner_image'); ?>'); background-position: top right; height: calc(100vh - 50px);display: flex;align-items: center; justify-content: center;">
		<div class="tpb tpb-jumbotron col-md-12">
			<div class="hero-image__wrapper">
				<h1 class="title" style="color: #fff; text-transform: uppercase; font-weight: 300;"><?php echo get_section_content('home' , 'welcome_text_'.get_session('site_lang')); ?> </h1>
				<!-- <div class="hero-image__text" style="color: white; font-weight: 300;">
					<?php // echo lang('answer'); ?> <strong><?php // echo lang('4_question'); ?> </strong> <?php // echo lang('and_we'); ?> <strong><?php // echo lang('take_care'); ?></strong> <?php // echo lang('of_your'); ?> <strong><?php // echo lang('book_management'); ?></strong>
				</div> -->
				<a href="<?php echo base_url(); ?>buy/university" class="btn btn-primary hero-image__button" style="background-color: #3FC0B7; border: none; padding: 11px 15px;width: 344px;max-width: 100%;"><?php echo lang('buy_books'); ?></a>
				<br>
				<br>
				<a href="<?php echo base_url(); ?>sell/university" class="btn btn-primary hero-image__button" style="background-color: #000; border: none; padding: 11px 15px;width: 344px;max-width: 100%;"><?php echo lang('sell_books'); ?></a>
			</div>
			<div class="tpb tpb-jumbotron col-md-12 text-center icon_sec">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="icon_box">
						<div class="icon_img">
							<img src="<?php echo base_url(); ?>assets/images/sale.png">
						</div>
						<div class="icon_text">
							<h3><?php echo lang('cheapest'); ?></h3>
							<p><?php echo lang('textbooks_in_switzerland'); ?></p>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="icon_box">
						<div class="icon_img">
							<img src="<?php echo base_url(); ?>assets/images/price.png">
						</div>
						<div class="icon_text">
							<h3><?php echo lang('price_match'); ?></h3>
							<p><?php echo lang('match_any_price'); ?></p>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="icon_box">
						<div class="icon_img">
							<img src="<?php echo base_url(); ?>assets/images/dispatch.png">
						</div>
						<div class="icon_text">
							<h3><?php echo lang('free_and_fast_dispatch'); ?></h3>
							<p><?php echo lang('item_leave_next_business_day'); ?></p>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="icon_box">
						<div class="icon_img">
							<img src="<?php echo base_url(); ?>assets/images/from_to_for.png">
						</div>
						<div class="icon_text">
							<h3><?php echo lang('from_students_for_students'); ?></h3>
							<p><?php echo lang('we_know_your_needs'); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section id="featured-room" style="padding-top: 100px; padding-bottom: 30px;">
		<div class="container">
			<div class="row tpb-row hero-image-with-text hero-center-text">
				<a href="<?php echo base_url()?>charity" style="margin:0; padding-top: 200px; padding-bottom: 200px; background-image: url('<?php echo base_url(); ?>assets/images/banner-tree.png'); background-size: contain; background-position: center center; width: 100%; height: auto; background-repeat: no-repeat;">
				</a>
			</div>
			<div class="section-header header-center">
				<h2 class="section-title" style="text-transform: unset; font-weight: 300; margin-top: 30px;"><?php echo lang('tree_text'); ?></h2>
			</div>
		</div>
	</section>

</section>
<?php $this->load->view('common/footer'); ?>