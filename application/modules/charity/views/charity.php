<?php $this->load->view('common/header'); ?>

<!-- Policies -->

<section class="page-header">
	<div class="container">
		<h1 class="page-header-title"><?php echo lang('charity'); ?></h1>
		<!-- <ul class="breadcrumb">
			<li><a href="<?php // echo base_url(); ?>"><?php // echo lang('home'); ?></a></li>
			<li class="active"><?php // echo lang('charity'); ?></li>
		</ul> -->
	</div>
</section>

<section class="page-section section-padd-bottom charity-page">
	<div class="container">
		<!-- Section Title -->
		<?php echo get_section_content('charity' , 'charity_'.get_session('site_lang')); ?>
	</div>
</section>
<?php $this->load->view('common/footer'); ?>