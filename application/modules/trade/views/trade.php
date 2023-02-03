<?php $this->load->view('common/header'); ?>

<!-- Become Space Provider -->

<section class="become-space section-bg">
	<div class="container">
		<div class="row">

			<div class="col-md-6 col-md-offset-3">

				<h2 class="text-center" style="text-transform: none;"><?php echo lang('select_trade_type'); ?></h2>

				<div class="col-md-12">
					<div class="form-group">
						<a href="<?php echo base_url(); ?>buy/university" class="btn btn-block list-btn next-btn"> <?php echo lang('i_want_to_buy'); ?></a>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<a href="<?php echo base_url(); ?>sell/university" class="btn btn-block list-btn back-btn"> <?php echo lang('i_want_to_sell'); ?> </a>
					</div>
				</div>

			</div>

		</div>
	</div>
</section>

<!-- Become Space Provider End-->
<?php $this->load->view('common/footer'); ?>