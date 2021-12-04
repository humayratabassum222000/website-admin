<?php
	include "includes/config.php";
	require_once "includes/functions.php"; 
	
	if(isset($_GET['orderno'])) {
		$today			= date("d-m-Y");
		$orderno		= $_GET['orderno'];
		$name				= isset($_GET['name']) ? $_GET['name'] : '';
		$mobile			= isset($_GET['mobile']) ? $_GET['mobile'] : '';
		$email			= isset($_GET['email']) ? $_GET['email'] : '';
		$address		= isset($_GET['address']) ? $_GET['address'] : '';
		$location		= isset($_GET['location']) ? $_GET['location'] : '';
		$shipment		= isset($_GET['shipment']) ? $_GET['shipment'] : '';
		$payment		= isset($_GET['payment']) ? $_GET['payment'] : '';
		$payment_number	= isset($_GET['payment_number']) ? $_GET['payment_number'] : '';
		$payment_trid	= isset($_GET['payment_trid']) ? $_GET['payment_trid'] : '';
		$pr_id			= isset($_GET['pr_id']) ? $_GET['pr_id'] : '';
		$pr_size		= isset($_GET['pr_size']) ? $_GET['pr_size'] : '';
		$pr_qty			= isset($_GET['pr_qty']) ? $_GET['pr_qty'] : '';
		$pr_color		= isset($_GET['pr_color']) ? $_GET['pr_color'] : '';
			
?>
<!doctype thml>
<html>
	<head>
		<title>Invoice Id : <?php echo $orderno; ?></title>
		<link rel="stylesheet" href="css/bootstrap.css" />
		<style>
			#thank-you {
				background-color: #f9f8f8;
			}
			#thank-you h2.successfull {
				text-align: center;
				margin: 2em 0;
				font-size: 26px;
				color: #fdb90b;
				text-shadow: 1px 1px 1px #666;
			}
			#thank-you span.p-title {
				text-align: center;
				margin: 1.5em 0;
				background-color: #fdb90b;
				color: #f9f8f8;
				font-size: 20px;
				padding: .3em .6em;
				display: inline-block;
			}
			#thank-you .separator {
				height: 10px;
			}
			#thank-you .background-white {
				background: #fff;
				border: 1px solid #fdb90b;
				padding: .5em;
			}
			#thank-you .your-data, #thank-you .your-bill {
				text-align: center;
			}
			#thank-you .your-data table{
				width: 100%;
				border-collapse: collapse;
				border-spacing: 0;
				border: 0;
			}
			#thank-you .your-data table tr td{
				padding: 2px;
				font-size: 12px;
				text-align: left;
				color: #666
			}
			#thank-you .your-bill p {
				text-align: right;
			}
			#thank-you .your-bill .invoice-print {
				color: #333;
				text-decoration: underline;
				font-size: 18px;
				font-weight: 600;
				font-family: 'Times New Roman';
				cursor: pointer;
			}
			#thank-you .invoice {
				width: 800px;
				margin: 50px auto;
				text-align: left;
				padding: 50px 65px;
				box-shadow: 0px 0px 20px #ccc;
			}
			#thank-you .invoice-top img {
				max-width: 100%;
				height: 100px;
			}
			#thank-you .invoice-top .tagline h2.company-name{
				font-weight: bold;
				font-size: 28px;
				line-height: 1em;
				text-transform: none;
				margin: 0;
			}
			#thank-you .invoice-top .tagline p{
				text-align: left;
				color: #888;
				font-size: 14px;
				margin-bottom: 0;
				line-height: 19.6px;
			}
			#thank-you .invoice-top .qr {
				text-align: right;
			}
			#thank-you .invoice-middle .invoice-id {
				margin-top: 60px;
				margin-bottom: 40px;
			}
			#thank-you .invoice-middle h1{
				font-size: 50px;
				font-family: 'impact';
				color: #396E00;
				line-height: 50px;
			}
			#thank-you .invoice-middle .invoice-info table{
				width: auto;
				border-collapse: collapse;
				border-spacing: 0;
			}
			#thank-you .invoice-middle .invoice-info table tr td{
				padding: 1px 3px;
			}
			#thank-you .invoice-middle .invoice-bill-to p {
				text-align:left;
				margin-bottom: 2px;
				font-size: 14px;
				color: #000;
			}
			#thank-you .invoice-table .itemLists {
				width: 100%;
				border-collapse: collapse;
				border-spacing: 0;
				margin-top: 40px;
				font-size: 14px;
			}
			#thank-you .invoice-table .itemLists td,#thank-you .invoice-table .itemLists th{
				padding: 10px;
			}
			#thank-you .invoice-table .itemLists thead tr{
				border-bottom: 2px solid #aaa;
				color: #333;
				font-weight: 600;
			}
			#thank-you .invoice-table .itemLists tbody tr{
				border-bottom: 1px solid #ccc;
				color: #333;
				font-weight: 500;
			}
			#thank-you .invoice-table .itemTotal {
				width: 35%;
				border-collapse: collapse;
				border-spacing: 0;
				margin-top: 10px;
				font-size: 14px;
				float: right;
				color: #333;
			}
			#thank-you .invoice-table .itemTotal tr.subtotal {
				color: #396E00;
				border-top: 2px dotted #aaa;
				font-size: 16px;
			}
			#thank-you .invoice-table .itemTotal tr td{
				padding: 5px;
			}
			#thank-you .invoice-table .payment-info {
				color: #888;
				font-size: 12px;
				margin-top: 20px;
				width: 100%;
				font-weight: normal;
			}
			@media print {
				body * {
					visibility: hidden;
				}
				.invoice, .invoice * {
					visibility: visible;
				}
				.invoice {
					width: 100%;
					position: absolute;
					left: 0;
					top: 0;
				}
			}
		</style>
		<script>
			window.onload = window.print();
		</script>
	</head>
	<body>
		<div id="thank-you">
			<div class="your-bill">				
				<div class="background-white">
				<p><span class="invoice-print" onclick="window.print()"><i class="fa fa-print"></i> Print</span></p> 
					<div class="invoice">
						<div class="row invoice-top">
							<div class="col-md-3 col-sm-3 col-xs-3 logo">
								<img src="../images/logo.png">
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 tagline">
								<h2 class="company-name">Daily Shop</h2>
								<div class="separator"></div>
								<p class="company-address"><?php echo get_contact_information('address'); ?></p>
								<p class="company-contact"><?php echo get_contact_information('mobile1'); ?> | <?php echo get_contact_information('email'); ?></p>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 qr">
								
							</div>
						</div>
						<div class="row invoice-middle">
							<div class="col-md-12 invoice-id">
								<h1>INVOICE</h1>
								<div class="separator"></div>
								<h3>#<?php echo $orderno; ?></h3>
							</div>
							<div class="clearfix"></div>

							<div class="col-md-6 col-sm-6 col-xs-6 invoice-info">
								<table border="0">
									<tr><td>Issue Date</td><td>:</td><td><?php echo date("d-m-Y") ?> </td></tr>
									<tr><td>Net</td><td>:</td><td> <?php echo 50; ?> </td></tr>
									<tr><td>Currency</td><td>:</td><td> <?php echo $currency; ?> </td></tr>
									<tr><td>Delivery Type</td><td>:</td><td> Normal </td></tr>
									<tr><td>Payment Type</td><td>:</td><td>  <?php if($payment == 'rocket') {echo 'Rocket';} else if($payment == 'bkash'){echo 'bkash';} else {echo 'Cash On Delivery';} ?> </td></tr>
								</table>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 invoice-bill-to">
								<p><u>Bill To: </u></p>
								<p><strong><?php echo $name; ?></strong></p>
								<p><?php echo $address; ?></p>
								<p>Delivery Location: <?php echo $location; ?></p>
								<p><?php echo $mobile; ?></p>
								<p><?php echo $email; ?></p>
							</div>
						</div>
						<div class="row invoice-table">
							<div class="col-md-12">
								<table border="0" class="itemLists">
									<thead>
										<tr><th> Sl No </th><th> Description </th><th> Quantity </th><th> Size </th><th> Color </th><th> Price </th></tr>
									</thead>
									<tbody>
										<?php
											$prids = explode(',' , $pr_id) ; $qty = explode(',' , $pr_qty) ;
											$size = explode(',' , $pr_size) ; $color = explode(',' , $pr_color) ;
											
											$length = count($prids); $subtotal = 0; $discounttotal = 0; $id = 0;
											
											for($i = 0;$i < $length;$i++) {
												$id = $id+1; $prid = $prids[$i];
												$row_details	= details_page($prid); $total_item	= $qty[$i];
												
												$pr_price = $row_details['price']; $pr_discount_tk = $pr_price*($row_details['discount']/100);
												
												$price_after_discount	= $pr_price - $pr_discount_tk; $total_after_discount = $total_item*$price_after_discount;
												$total_discount = $total_item*$pr_discount_tk;
										?>
										<tr>
											<td><?php echo $id; ?> </td>
											<td><?php echo $row_details['name']; ?></td>
											<td><?php echo $qty[$i]; ?></td>
											<td><?php echo $size[$i]; ?></td>
											<td><?php echo $color[$i]; ?></td>
											<td><?php echo $currency.' '.$row_details['price']; ?></td>
										</tr>
										<?php 
												$subtotal	= $subtotal+$row_details['price']; $discount_total	= $discounttotal+$total_discount;
											}
											$couponDiscount	= 0;
											$get	= "SELECT * FROM coupons";
											$result	= $conn->query($get);
											while($row_c = $result->fetch_array()) {
												if(!empty($row_c['used_order_no'])) {
													$uon	= explode(',', $row_c['used_order_no']);
													$k_c	= array_search($orderno, $uon);
													if($k_c	!== false) {
														$ua	= explode(',', $row_c['used_amount']);
														$couponDiscount	= $ua[$k_c];
														break;
													} 
												}
											}
										?>
									</tbody>
								</table>
								<table class="itemTotal" border="0">
									<tr><td>Total</td><td><?php echo $currency.' '.$subtotal ?></td></tr>
									<tr><td>Discount</td><td><?php echo $currency.' '.($discount_total+$couponDiscount); ?></td></tr>
									<tr><td>Delivery Cost</td><td><?php if(strtolower(trim($location)) == 'dhaka'){$dcharge = 60;} else if(strtolower(trim($location)) == 'abroad'){$dcharge = 800;} else {$dcharge = 100;} echo $currency.' '.$dcharge ?></td></tr>
									<tr class="subtotal"><td>Subtotal</td><td><?php $almost = $subtotal-($discount_total+$couponDiscount)+$dcharge; echo $currency.' '.$almost;?></td></tr>
								</table>
								<div class="clearfix"></div>
								
								<div class="separator"></div>
								<div class="payment-info">
									Payment Details: <?php if($payment == 'rocket') {echo 'Rocket';} else if($payment == 'bkash'){echo 'bKash';} else {echo 'Cash On Delivery';} ?>
									<?php if($payment == 'bkash' || $payment == 'rocket') { ?>
									, Number: <?php echo $payment_number; ?> 
									, Trxn ID: <?php echo $payment_trid; ?>
									<?php } ?>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	} else {
		exit(header('Location: orders.php'));
	}
?>