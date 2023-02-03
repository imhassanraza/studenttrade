<?php
$r_class = $this->router->fetch_class();
?>
<?php if(empty($books)) { ?>
	<h4> 0 <?php echo lang('result_found'); ?> </h4>
<?php } else { ?>
	<h4 style="padding-left: 5px;"> <?php echo count($books); ?> <?php echo lang('result_found'); ?> </h4>
	<br>
	<table class="table">
		<thead>
			<tr>
				<th width="15%" class="visible-xs"><?php echo lang('add_to_basket'); ?></th>
				<th width="70%"><?php echo lang('book_name'); ?></th>
				<th width="10%"><?php echo lang('condition'); ?></th>
				<th width="10%"><?php echo lang('price'); ?></th>
				<th width="10%" class="hidden-xs"><?php echo lang('add_to_basket'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($books as $book) {
				$is_in_cart = in_cart($book['id']);

				if($is_in_cart) {
					$cart_details = get_cart_details($book['id']);
				} else {
					$cart_details = "";
				}

				$used_book = get_used_book_detail($book['book_name']);
				if($book['only_used'] && empty($used_book)) {
					continue;
				}
				?>
				<tr>
					<td align="center" class="visible-xs">
						<div class="form-check">
							<label>
								<input type="checkbox" value="<?php echo $book['id']; ?>" <?php if($is_in_cart) { ?> class="remove_from_cart" checked="" <?php } else { ?> class="add_to_cart" <?php } ?> <?php if($book['price'] < 1) { ?> disabled="" <?php } ?>>
								<span class="label-text"> </span><span class="remb"></span>
							</label>
						</div>
					</td>
					<td><?php echo wordwrap($book['book_name'], 100, "<br />", TRUE); ?></td>
					<td>

						<?php if($is_in_cart) { ?>
							<?php if($cart_details['options']['book_condition']) { ?>
								<?php echo lang('used'); ?>
							<?php } else { ?>
								<?php echo lang('new'); ?>
							<?php } ?>

						<?php } else if(!empty($used_book['id'])) { ?>
							<?php if($used_book['book_condition']) { ?>
								<?php echo lang('used'); ?>
							<?php } else { ?>
								<?php echo lang('new'); ?>
							<?php } ?>
						<?php } else if(empty($used_book['id'])) { ?>
							<?php echo lang('new'); ?>
						<?php } ?>

					</td>
					<td>
						<?php if($is_in_cart) { ?>
							<?php if($cart_details['price'] > 0) { ?>
								<?php echo number_format($cart_details['price'], 0); ?> CHF
							<?php } else { ?>
								<label class="label label-danger"><?php echo lang('not_available'); ?></label>
							<?php } ?>
						<?php } else if(!empty($used_book['id'])) { ?>

							<?php if($used_book['book_condition']) { ?>
								<?php echo number_format($book['price']  * (60/100), 0); ?> CHF
							<?php } else { ?>
								<?php echo number_format($book['price'] * (70/100), 0); ?> CHF
							<?php } ?>
						<?php } else { ?>
							<?php if($book['price'] > 0) { ?>
								<?php echo number_format($book['price'], 0); ?> CHF
							<?php } else { ?>
								<label class="label label-danger"><?php echo lang('not_available'); ?></label>
							<?php } ?>
						<?php } ?>
					</td>

					<td class="hidden-xs">
						<div class="form-check">
							<label>
								<input type="checkbox" value="<?php echo $book['id']; ?>" <?php if($is_in_cart) { ?> class="remove_from_cart" checked="" <?php } else { ?> class="add_to_cart" <?php } ?> <?php if($book['price'] < 1) { ?> disabled="" <?php } ?>>
								<span class="label-text"> </span><span class="remb"></span>
							</label>
						</div>
					</td>
				</tr>
			<?php } ?>

		</tbody>
	</table>
<?php } ?>
