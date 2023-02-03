<?php $this->load->view('common/header'); ?>

<!-- Become Space Provider -->
<div id="ajax_wrapper">
	<section class="show-space section-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h2><?php echo lang('search_for_book'); ?></h2>
					<div class="input-group">
						<input type="text" class="form-control book_name" name="book_name" id="book_name" placeholder="<?php echo lang('author_year_title'); ?>">
						<span class="input-group-btn">
							<button class="btn next-btn" type="button" id="get_search_result" style="height: 48px;"><span class="glyphicon glyphicon-search" aria-hidden="true">
							</span> <?php echo lang('search'); ?></button>
						</span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 20px;">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive" id="search_result" style="display: none;"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<hr>
					<?php if (!empty(get_session('semester'))) { ?>
						<div class="col-md-4 col-xs-12 form-group pull-left">
							<a href="<?php echo base_url(); ?>buy/books" class="btn back-btn col-xs-12"><?php echo lang('continue_buying_process'); ?></a>
						</div>
					<?php } ?>

					<div class="col-md-4 col-xs-12 form-group pull-right" id="proceed_btn" <?php if ((count($this->cart->contents())) > 0) { ?> style="display: none;" <?php } ?>>
						<a href="<?php echo base_url(); ?>shopping_cart" class="btn next-btn col-xs-12"><?php echo lang('proceed'); ?></a>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>
<!-- Become Space Provider End-->
<?php $this->load->view('common/footer'); ?>

<script type="text/javascript">
	$('.book_name').keypress(function(e){
		if(e.keyCode == 13){
			$('#get_search_result').click();
		}
	});

	// $(document).on('click', '#get_search_result', function() {

	// 	var book_name = $('#book_name').val();
	// 	if(book_name == "") {
	// 		$.gritter.add({
	// 			title: 'Error!',
	// 			sticky: false,
	// 			time: '5000',
	// 			before_open: function(){
	// 				if($('.gritter-item-wrapper').length >= 3)
	// 				{
	// 					return false;
	// 				}
	// 			},
	// 			text: "<?php // echo lang('enter_book_name_first'); ?>",
	// 			class_name: 'gritter-error'
	// 		});
	// 		return false;
	// 	}

	// 	$.ajax({
	// 		url:'<?php // echo base_url(); ?>search/get_search_result',
	// 		type:'post',
	// 		data:{ book_name : book_name },
	// 		dataType:'json',
	// 		success:function(status){
	// 			if(status.msg=='success'){
	// 				$("#search_result").fadeOut(function(){
	// 					$("#search_result").html(status.response).fadeIn();
	// 					$('#proceed_btn').show();
	// 				});
	// 			}
	// 		}
	// 	});
	// });

</script>