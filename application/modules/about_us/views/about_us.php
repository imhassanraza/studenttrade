<?php $this->load->view('common/header'); ?>

<!-- ====== SINGLE PROPERTY PAGE HEADER ====== -->
<section class="page-header">
	<div class="container">
		<h1 class="page-header-title"><?php echo lang('about_us'); ?></h1>
		<!-- <ul class="breadcrumb">
			<li><a href="<?php // echo base_url(); ?>"><?php // echo lang('home'); ?></a></li>
			<li class="active"><?php // echo lang('about_us'); ?></li>
		</ul> -->
	</div>
</section>

<!-- ====== ADVANTAGES ====== -->
<section class="page-section section-padd-bottom">
	<div class="container">
		<!-- Section Title -->
		<?php echo get_section_content('aboutus' , 'about_us_'.get_session('site_lang')); ?>
	</div>
</section>

<?php $this->load->view('common/footer'); ?>