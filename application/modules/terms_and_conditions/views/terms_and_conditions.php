<?php $this->load->view('common/header'); ?>
<!-- Term & Conditions -->

<section class="page-header">
	<div class="container">
		<h1 class="page-header-title"><?php echo lang('term_and_condition'); ?> </h1>
		<!-- <ul class="breadcrumb">
			<li><a href="<?php // echo base_url(); ?>"><?php // echo lang('home'); ?></a></li>
			<li class="active"><?php // echo lang('term_and_condition'); ?></li>
		</ul> -->
</section>
<section class="page-section section-padd-bottom">
	<div class="container">
		<!-- Section Title -->
		<?php echo get_section_content('termconditions' , 'termconditions_'.get_session('site_lang')); ?>
	</div>
</section>
<!-- Term & Conditions End -->
<?php $this->load->view('common/footer'); ?>