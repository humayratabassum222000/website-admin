<?php
	ob_start();
	include "includes/header.php"; 
?>
<?php 
	if(isset($_GET['delete'])) {
		
		$id		= isset($_GET['id']) ? $_GET['id']: exit(header('Location: orders.php'));
		$sql	= DeleteTable('p_order'," id = '{$id}' ");
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Order Deleted');
			header('Refresh: 5; URL=orders.php');
		} else {
			adminMessage('red', $conn->error);
		} 
	}
	if(isset($_GET['update'])) {
		
		$id						= isset($_GET['id']) ? $_GET['id']: exit(header('Location: orders.php'));
		$fields['admin_read']	= $_GET['value'];
		$sql	= UpdateTable('p_order',$fields," id = '{$id}' ");
			
		if($conn->query($sql) == true) {
			header("Location:orders.php#order-".$id);
		} else {
			adminMessage('red', $conn->error);
		} 
	}
?>
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#table').basictable();
		if(window.location.hash) {
			var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
			$('#'+hash).css('border','2px solid red');
			$('#'+hash).css('box-shadow','inset 0px 0px 10px red');
		}
	});
</script>

<div class="main-grid">
	<div class="agile-grids">	
		<div class="table-heading">
			<h2>Product Orders</h2>
		</div>
		<div class="agile-tables">
			<div class="w3l-table-info">
					<table id="table">
					<thead>
						<tr>
						<th>Order From</th>
						<th>Description</th>
						<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$result_order = get_order(1000000000);
						while($row_order = $result_order->fetch_array()) {
							if($row_order['name']!= 'Guest') {
								$row_user_info	= get_user_info($row_order['email']);
								$address = (!empty($row_user_info['district'])) 
													? $row_user_info['address'].", ".$row_user_info['district'].", ".$row_user_info['city'] 
													: $row_user_info['address'].", ".$row_user_info['city']." (".$row_user_info['country'].")";
							} else {
								$row_user_info['first_name']	= "Guest";
								$row_user_info['last_name']	= "";
								$row_user_info['email']			= "";
								$row_user_info['mobile_number']	= $row_order['phone'];
								$address	= $row_order['address'];
							}
							
					?>
					<tr id="order-<?php echo $row_order['id']; ?>" class="<?php if($row_order['admin_read'] == 0){echo "active";}?>">
						<td style="vertical-align: top;">
							<h4><?php echo $row_user_info['first_name']." ".$row_user_info['last_name'] ; ?> </h4>
							<p> &nbsp; </p>
							<p><strong>Mobile:</strong> <?php echo $row_user_info['mobile_number'] ; ?></p>
							<p><?php echo $row_user_info['email'] ; ?></p>
						</td>
						<td> 
							<p><strong> Order No : </strong>&nbsp; <?php echo $row_order['order_no'] ; ?> &nbsp; <strong> Order Date: </strong>&nbsp; <?php echo $row_order['date'] ; ?></p>
							<p><strong> Address: </strong>&nbsp; <?php echo $address; ?></p>
							<p><strong> Location: </strong>&nbsp; <?php echo ucwords($row_order['location']); ?></p>
							<p><strong> Shipment: </strong>&nbsp; <?php if($row_order['shipment'] == null) {echo "Normal";} else {echo $row_order['shipment'];} ?></p>
							<p><strong> Payment: </strong>&nbsp; <?php $payment = $row_order['payment']; if($payment == 'rocket') {echo 'Rocket';} else if($payment == 'bkash'){echo 'bKash';} else {echo 'Cash On Delivery';} ?></p>
							<?php if($row_order['payment'] == 'bkash') { ?>
							<p><strong>Bkash Number: </strong><?php echo $row_order['payment_number'] ; ?></p>
							<p><strong>Bkash Trxn ID: </strong><?php echo $row_order['payment_trxn_id'] ; ?></p>
							<?php } else if($row_order['payment'] == 'rocket') { ?>
							<p> Rocket Number: <strong><?php echo $row_order['payment_number'] ; ?></strong></p>
							<p> Rocket Trxn ID: <strong><?php echo $row_order['payment_trxn_id'] ; ?></strong></p>
							<?php	} ?>
							<p> &nbsp; </p>
							
							<table>
								<tr>
									<th> Products </th>
									<th> Size </th>
									<th> Color </th>
									<th> Quantity </th>
									<th> Action </th>
								</tr>
								<?php
									$o_products_id 		= explode(",", $row_order['pr_id']); $o_products_size	= explode(",", $row_order['pr_size']);
									$o_products_color	= explode(",", $row_order['pr_color']); $o_products_qty		= explode(",", $row_order['pr_qty']);
									
									$o_products_num = count($o_products_id) ;
									
									for($i = 0; $i < $o_products_num ; $i++) {
										$row_details	= details_page($o_products_id[$i]);
								?>
								<tr>
									<td> <?php echo $row_details['name']; ?> </td>
									<td> <?php echo $o_products_size[$i] ?> </td>
									<td> <?php echo $o_products_color[$i] ?> </td>
									<td> <?php echo $o_products_qty[$i] ?> </td>
									<td> <a href="<?php echo $base; ?>details/boys/<?php echo $o_products_id[$i] ?>" target="blank"> View </a> </td>
								</tr>
								<?php
									}
								?>
							</table>
						</td>
						<td style="vertical-align: top;">
							Status: 
							<select class="order-status" data-order-id="<?php echo $row_order['id']; ?>">
								<option value="0" <?php if($row_order['admin_read'] == 0){echo "selected";}?> > Unreviewed </option>
								<option value="1" <?php if($row_order['admin_read'] == 1){echo "selected";}?>> Proccessing </option>
								<option value="2" <?php if($row_order['admin_read'] == 2){echo "selected";}?>> Delivered </option>
								<option value="3" <?php if($row_order['admin_read'] == 3){echo "selected";}?>> Cancelled </option>
							</select>
							<p> &nbsp; </p>
							<p><a href="order-invoice.php?orderno=<?php echo $row_order['order_no'] ; ?>&name=<?php echo urlencode($row_user_info['first_name'])."%20".urlencode($row_user_info['last_name']) ; ?>&mobile=<?php echo urlencode($row_user_info['mobile_number']) ; ?>&email=<?php echo urlencode($row_user_info['email']) ; ?>&address=<?php echo urlencode($address); ?>&location=<?php echo urlencode($row_order['location']); ?>&shipment=Normal&payment=<?php echo $row_order['payment']; ?>&payment_number=<?php echo urlencode($row_order['payment_number']) ; ?>&payment_trid=<?php echo urlencode($row_order['payment_trxn_id']) ; ?>&pr_id=<?php echo $row_order['pr_id']; ?>&pr_size=<?php echo $row_order['pr_size']; ?>&pr_qty=<?php echo $row_order['pr_qty']; ?>&pr_color=<?php echo $row_order['pr_color']; ?>" target="_blank"><i class="fa fa-print"></i> Print Invoice</a></p>
							<p><a href="?delete=1&id=<?php echo $row_order['id']; ?>"><i class="fa fa-times"></i> Delete</a></p>
						</td>
					</tr>
					<?php
						}
						mysqli_free_result($result_order);
					?>
					</tbody>
				</table>
				
				<script>
					$('.order-status').on('change', function(){
						var value 	=$(this).val();
						var id 		=$(this).attr('data-order-id');
						window.location = "?update=1&id="+id+"&value="+value;
					});
				</script>
			</div>
		</div>
	</div>
<?php
	include "includes/footer.php";
?>