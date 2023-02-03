<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="initial-scale=1.0" />
	<meta name="format-detection" content="telephone=no" />
	<style>
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td, th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}
	</style>
</head>
<body>
	<p><strong>Dear <?php if ($user_detail['first_name'] == "") { echo $user_detail['email']; }else{ echo $user_detail['first_name']." ".$user_detail['last_name']; } ?>,</strong>  Your order has been placed. </p>
	<p> <strong>Order ID:</strong> <?php echo $order_id; ?> </p>
	<p> <strong>Transaction ID:</strong> <?php echo $trx_id; ?> </p>
	<p> <strong>Amount:</strong> <?php echo number_format($trx_amount, 0); ?> CHF</p>
	<p> <strong>Address:</strong> <?php echo $order_address; ?> </p>
	<br>
	<table class="table">
		<thead>
			<tr>
				<th width='50%'>Book Name</th>
				<th width='50%'>ISBN</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$orders = $this->cart->contents();
			foreach ($orders as $book) {
				$book_detail = get_books_detail($book['id']); ?>
				<tr>
					<td> <?php echo $book_detail['book_name']; ?> </td>
					<td> <?php echo $book_detail['ISBN']; ?> </td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<p> Thanks,<br>	Student Trade </p>
</body>
</html>