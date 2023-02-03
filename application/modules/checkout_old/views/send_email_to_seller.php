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
	<p><strong>Hello <?php if($seller_detail['first_name'] == ""){ echo $seller_detail['email']; } else{ echo $seller_detail['first_name']." ".$seller_detail['last_name']; }?>,
		<br> Congratulations, <b style="color: #777777;"> <?php if ($user_detail['first_name'] == "") { echo $user_detail['email']; }else{ echo $user_detail['first_name']." ".$user_detail['last_name'];} ?></b></strong> has just bought <?php echo count($order_books); ?> book(s) from you.</p>
	<p>Please send the books in the next two days by mail:</p>
	<p> <strong>To the following address:</strong> </p>
	<p> <strong>Address: </strong> <?php echo $order_address;  ?> </p>
	<p> <strong>Email: </strong> <?php echo $user_detail['email']; ?> </p>
	<br>
	<table class="table">
		<thead>
			<tr>
				<th width='50%'>Book Name</th>
				<th width='50%'>ISBN</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($order_books as $order) { ?>
				<tr>
					<td> <?php echo $order['book_name']; ?> </td>
					<td> <?php echo $order['ISBN']; ?> </td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<br>
	<p> Please fill out your payment details in your account so we can send you your money.</p>
	<p> Thanks,<br>	Student Trade </p>
</body>
</html>