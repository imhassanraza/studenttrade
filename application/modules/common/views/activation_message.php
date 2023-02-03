<?php if (!empty($this->session->flashdata('success_status'))) { ?>
	<div class="dashboad-strip activation_message" style="background: white;">
	    <p class="text-center text-success container">
	    	<?php echo $this->session->flashdata('success_status'); ?>
	</div>	
<?php } ?>

<?php if (!empty($this->session->flashdata('error_status'))) { ?>
	<div class="dashboad-strip activation_message" style="background: white;">
	    <p class="text-center text-danger container">
	    	<?php echo $this->session->flashdata('error_status'); ?>
	</div>	
<?php } ?>

<script type="text/javascript">
	setTimeout(function(){ $('.activation_message').hide(); }, 3000);
</script>