<?php if(empty($books) && empty($selected_books)) { ?>
	<?php if (get_session('university') == 'ZHAW') { ?>
		<p style="color: red;"> <?php echo lang('optional_module_books_not_available'); ?> </p>
	<?php } else { ?>
		<p style="color: red;"> <?php echo lang('books_not_found'); ?> </p>
	<?php } ?>
<?php } else { ?>
	<table class="table" id="search_books_table">
		<thead>
			<tr>
				<th width="15%" class="visible-xs"><?php echo lang('add_to_marketplace'); ?></th>
				<?php if (!get_session('university') == 'other_university') { ?>
					<th width="20%"><?php echo lang('module'); ?></th>
				<?php } ?>
				<!-- <th width="10%"><?php // echo lang('semester'); ?></th> -->
				<th width="75%"><?php echo lang('book_name'); ?></th>
				<th width="10%"><?php echo lang('price'); ?></th>
				<th width="15%" class="hidden-xs"><?php echo lang('add_to_marketplace'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($selected_books as $book) { ?>

				<?php
				if(get_session('university') == 'ETH Zürich' || get_session('university') == 'Universität Zürich') {
					if(!empty($optional_module) && !empty($book['module'])){
						if(in_array($book['module'] , @$optional_module)) {

							continue;
						}
					}
				}
				?>

				<?php
				if(get_session('university') == 'ZHAW') {
					$opt_module_books = get_session('optional_module_books');
					if(in_array($book['id'], $opt_module_books)) {
						continue;
					}
				}
				?>

				<tr>
					<td align="center" class="visible-xs">
						<div class="form-check">
							<label>
								<?php if(empty(get_session('sell_session'))) {
									if(empty(get_session('sell_session_multi'))) {
										$op_sell_session = array();
									}else {
										$op_sell_session = get_session('sell_session_multi');
									}
								} else {
									$op_sell_session = get_session('sell_session');
								} ?>
								<input type="checkbox" class="book_tag book_tag<?php echo $book['id']; ?>" value="<?php echo $book['id']; ?>" name="sell_books[]" <?php if(in_array($book['id'], $op_sell_session)) { ?> checked <?php } ?>>
								<span class="label-text"> </span><span class="remb"></span>
							</label>
						</div>
					</td>
					<?php if (!get_session('university') == 'other_university') { ?>
						<td><?php echo $book['module']; ?></td>
					<?php } ?>
					<!-- <td><?php // echo !empty($book['semester']) ? $book['semester'] : "NA"; ?></td> -->
					<td><?php echo wordwrap($book['book_name'], 100, "<br />", TRUE); ?></td>
					<td>
						<span id="net_price_<?php echo $book['id']; ?>">
							<?php echo number_format($book['price'] * (50/100), 0); ?>
						</span> CHF
					</td>
					<td align="center" class="hidden-xs">
						<div class="form-check">
							<label>
								<?php if(empty(get_session('sell_session'))) {
									if(empty(get_session('sell_session_multi'))) {
										$op_sell_session = array();
									}else {
										$op_sell_session = get_session('sell_session_multi');
									}
								} else {
									$op_sell_session = get_session('sell_session');
								} ?>
								<input type="checkbox" class="book_tag book_tag<?php echo $book['id']; ?>" value="<?php echo $book['id']; ?>" name="sell_books[]" <?php if(in_array($book['id'],$op_sell_session)) { ?> checked <?php } ?>>
								<span class="label-text"> </span><span class="remb"></span>
							</label>
						</div>
					</td>
				</tr>
			<?php } ?>

			<?php foreach ($books as $book) {  ?>

				<?php
				if(get_session('university') == 'ETH Zürich' || get_session('university') == 'Universität Zürich') {
					if(!empty($optional_module) && !empty($book['module'])){
						if(in_array($book['module'] , @$optional_module)) {

							continue;
						}
					}
				}
				?>

				<?php
				if(get_session('university') == 'ZHAW') {
					$opt_module_books = get_session('optional_module_books');
					if(in_array($book['id'], $opt_module_books)) {
						continue;
					}
				}
				?>
				<tr>
					<td align="center" class="visible-xs">
						<div class="form-check">
							<label>
								<?php if(empty(get_session('sell_session'))) {
									if(empty(get_session('sell_session_multi'))) {
										$op_sell_session = array();
									}else {
										$op_sell_session = get_session('sell_session_multi');
									}
								} else {
									$op_sell_session = get_session('sell_session');
								} ?>
								<input type="checkbox" class="book_tag book_tag<?php echo $book['id']; ?>" value="<?php echo $book['id']; ?>" name="sell_books[]" <?php if(in_array($book['id'], $op_sell_session)) { ?> checked <?php } ?>>
								<span class="label-text"> </span><span class="remb"></span>
							</label>
						</div>
					</td>
					<?php if (!get_session('university') == 'other_university') { ?>
						<td><?php echo $book['module']; ?></td>
					<?php } ?>
					<!-- <td><?php // echo !empty($book['semester']) ? $book['semester'] : "NA"; ?></td> -->
					<td><?php echo wordwrap($book['book_name'], 100, "<br />", TRUE); ?></td>
					<td>
						<span id="net_price_<?php echo $book['id']; ?>">
							<?php echo number_format($book['price'] * (50/100), 0); ?>
						</span> CHF
					</td>
					<td align="center" class="hidden-xs">
						<div class="form-check">
							<label>
								<?php if(empty(get_session('sell_session'))) {
									if(empty(get_session('sell_session_multi'))) {
										$op_sell_session = array();
									}else {
										$op_sell_session = get_session('sell_session_multi');
									}
								} else {
									$op_sell_session = get_session('sell_session');
								} ?>
								<input type="checkbox" class="book_tag book_tag<?php echo $book['id']; ?>" value="<?php echo $book['id']; ?>" name="sell_books[]" <?php if(in_array($book['id'],$op_sell_session)) { ?> checked <?php } ?>>
								<span class="label-text"> </span><span class="remb"></span>
							</label>
						</div>
					</td>
				</tr>
			<?php } ?>

			<tr id="search_books_table_error" style="display: none;">
				<td>
					<p style="color: red;"> <?php echo lang('books_not_found'); ?> </p>
				</td>
			</tr>

		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready(function(){
			toolTiper();

			var rowCount = $("#search_books_table > tbody > tr").length;
			if(rowCount == 1) {
				$("#search_books_table_error").show();
			}
		});

		$(document).on('change', '.book_tag', function() {
			var val = $(this).val();
			if (!$(this).is(":checked")) {
				$('.book_tag'+val).prop( "checked", false );
			}
		});

	</script>
	<?php } ?>