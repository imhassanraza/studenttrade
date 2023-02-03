<?php if(empty($books)) { ?>
	<?php if (get_session('university') == 'ZHAW') { ?>
		<p style="color: red;"> <?php echo lang('optional_module_books_not_available'); ?> </p>
	<?php } else { ?>
		<p style="color: red;"> <?php echo lang('books_not_found'); ?> </p>
	<?php } ?>
<?php } else { ?>
<!-- 	<div class="col-md-12">
		<div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right">
			<input type="text" id="other_search_book" class="form-control" onkeyup="other_search_filter()" placeholder="<?php // echo lang('find_book_by_name'); ?>">
		</div>
	</div> -->
	<table class="table" id="other_books_table">
		<thead>
			<tr>
				<th width="15%" class="visible-xs"><?php echo lang('add_to_marketplace'); ?></th>
				<!-- <th width="20%"><?php // echo lang('module'); ?></th>
				<th width="10%"><?php // echo lang('semester'); ?></th> -->
				<th width="75%"><?php echo lang('book_name'); ?></th>
				<th width="10%"><?php echo lang('price'); ?></th>
				<th width="15%" class="hidden-xs"><?php echo lang('add_to_marketplace'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($books as $book) { ?>
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
					<!-- <td><?php // echo $book['module']; ?></td> -->
					<!-- <td><?php // echo !empty($book['semester']) ? $book['semester'] : "NA"; ?></td> -->
					<td><?php echo wordwrap($book['book_name'], 100, "<br />", TRUE); ?></td>
					<td>
						<span id="net_price_<?php echo $book['id']; ?>">
							<?php echo number_format($book['price'] * (50/100), 0); ?>
						</span> CHF
					</td>
					<td class="hidden-xs">
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
			<?php //unset_session('sell_session'); ?>
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready(function(){
			toolTiper();
		});

		$(document).on('change', '.book_tag', function() {

			var val = $(this).val();

			if (!$(this).is(":checked")) {
				$('.book_tag'+val).prop( "checked", false );
			}

		});

		function other_search_filter() {
			var input, filter, table, tr, td, i;
			input = document.getElementById("other_search_book");
			filter = input.value.toUpperCase();
			table = document.getElementById("other_books_table");
			tr = table.getElementsByTagName("tr");
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[3];
				console.log(td);
				if (td) {
					if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
						tr[i].style.display = "";
					} else {
						tr[i].style.display = "none";
					}
				}
			}
		}
	</script>
	<?php } ?>