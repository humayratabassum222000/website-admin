<?php
	include "includes/config.php";
	require_once "includes/functions.php";
	ini_set('display_errors', '1');
	
	if(!isset($_COOKIE['user']))header('Location: login.php');
?>
<!DOCTYPE html>
<head>
	<title>Admin Panel V-4.1</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Colored Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/font.css" type="text/css"/>
	<link href="css/font-awesome.css" rel="stylesheet"> 
	
	<link rel="stylesheet" href="css/morris.css">
	<link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
	<link href="css/theme.css" media="all" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="css/summernote.css">
	
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src="js/modernizr.js"></script>
	<script src="js/fileinput.js" type="text/javascript"></script>
</head>
<body class="dashboard-page">
	<?php
		$token = $_COOKIE['user']; $check = "SELECT * FROM admins where Token = '".addslashes($token)."'";
		$list = $conn->query($check);
		if($list->num_rows  == 1) {
			$list_row	= $list->fetch_array(); $check_username = $list_row['username'];
		} else {
	?>
	<div class="alert alert-danger notification text-center">
		Invail Token ! Or Admin may be deleted ! <a href="logout.php">Login Again</a>
	</div>
	<?php
			exit;
		}
	?>
	<nav class="main-menu">
		<ul>
			<li>
				<a href="index.php">
					<i class="fa fa-home nav_icon"></i>
					<span class="nav-text"> Dashboard </span>
				</a>
			</li>
			<li>
				<a href="mailbox.php">
					<i class="fa fa-envelope-o nav_icon"></i>
					<span class="nav-text"> Mailbox </span>
				</a>
			</li>
			<li>
				<a href="orders.php">
					<i class="fa fa-bell-o nav_icon"></i>
					<span class="nav-text"> Orders </span>
				</a>
			</li>
			<li class="has-subnav">
				<a href="javascript:void(0);">	
					<i class="fa fa-cubes nav_icon"></i><span class="nav-text"> Products </span>
					<i class="icon-angle-right"></i><i class="icon-angle-down"></i>
				</a>
				<ul>
					<li><a class="subnav-text" href="all_products.php">Product Stock</a></li>
					<li><a class="subnav-text" href="add-product.php">Add</a></li>
					<li><a class="subnav-text" href="update-product.php">Update</a></li>
					<li><a class="subnav-text" href="delete-product.php">Delete</a></li>
				</ul>
			</li>
			<li>
				<a href="product-category.php">
					<i class="fa fa-file-text-o nav_icon"></i>
					<span class="nav-text"> Proudct Category </span>
				</a>
			</li>
			<li>
				<a href="javascript:void(0)">
					<i class="fa fa-wpexplorer nav-icon"></i>
					<span class="nav-text">	Users Info </span>
					<i class="icon-angle-right"></i><i class="icon-angle-down"></i>
				</a>
				<ul>
					<!-- <li><a class="subnav-text" href="title.php">Title</a></li> -->
					<!-- <li><a class="subnav-text" href="logo.php">Logo</a></li>
					<li><a class="subnav-text" href="contact.php">Contact Information</a></li> -->
					<li><a class="subnav-text" href="registered-users.php">Registered Users</a></li>
					<li><a class="subnav-text" href="newsletter.php">Newsletters</a></li>
	 			</ul>
			</li> 
			<!-- <li>
				<a href="inner-pages.php">
					<i class="fa fa-address-card-o nav-icon"></i>
					<span class="nav-text"> Inner Pages </span>
				</a>
			</li>
			<li>
				<a href="javascript:void(0)">
					<i class="fa fa-picture-o nav-icon"></i>
					<span class="nav-text"> Sliders &amp; Stickers </span>
					<i class="icon-angle-right"></i><i class="icon-angle-down"></i>
				</a>
				<ul>
					<li>
						<a class="subnav-text" href="banners.php">Banners &amp; Sliders</a>
					</li>
					<li>
						<a class="subnav-text" href="stickers.php">Stickers</a>
					</li>
				</ul>
			</li> -->
			<li>
				<a href="orders_report.php">
					<i class="fa fa-bell-o nav_icon"></i>
					<span class="nav-text"> Reports </span>
				</a>
			</li>
		</ul>
		<ul class="logout">
			<li>
				<a href="logout.php">
					<i class="icon-off nav-icon"></i>
					<span class="nav-text"> Logout </span>
				</a>
			</li>
		</ul>
	</nav>
	
	<section class="wrapper scrollable">
		<div class="site-message">Hi </div>
		<nav class="user-menu">
			<a href="javascript:;" class="main-menu-access">
			<i class="icon-proton-logo"></i>
			<i class="icon-reorder"></i>
			</a>
		</nav>
		<section class="title-bar">
			<div class="logo">
				<h1><a href="index.php"><img src="../images/logo.png" alt="" /></a></h1>
			</div>
			<div class="header-right">
				<div class="profile_details_left">
					<div class="header-right-left">
						<!--notifications of menu start -->
						<ul class="nofitications-dropdown">
							<li class="dropdown head-dpdn">
							<?php
								$unread_message 		= get_unread_message();
								$unread_message_count	= $unread_message->num_rows;
							?>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i><?php if($unread_message_count != 0){ ?><span class="badge"><?php echo $unread_message_count; ?></span><?php } ?></a>
								<ul class="dropdown-menu anti-dropdown-menu w3l-msg">
									<li>
										<div class="notification_header">
											<h3>You have <?php echo $unread_message_count; ?> new messages</h3>
										</div>
									</li>
								<?php
									$result_messages	= get_message(3);
									while($row_message = $result_messages->fetch_array()) {
								?>
								
									<li>
										<a href="mailbox.php#mail-<?php echo $row_message['Id']; ?>">
											<div class="user_img">
												<i class="fa fa-envelope"></i>
											</div>
											<div class="notification_desc">
												<p><?php echo $row_message['Name']; ?><?php if($row_message['admin_read'] == 0){ ?> <span style="color: red!important">(NEW)</span> <?php } ?></p>
												<p><span><?php echo $row_message['Email']; ?></span></p>
											</div>
											<div class="clearfix"></div>	
										</a>
									</li>
								
								<?php
									}
									mysqli_free_result($result_messages);
								?>
								
									<li>
										<div class="notification_bottom">
											<a href="mailbox.php">See all messages</a>
										</div> 
									</li>
								</ul>
							</li>
							<li class="dropdown head-dpdn">
							<?php
								$unread_order		= get_unread_order();
								$unread_order_count	= $unread_order->num_rows;
							?>
							
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><?php if($unread_order_count != 0){ ?><span class="badge blue"><?php echo $unread_order_count; ?></span><?php } ?></a>
								<ul class="dropdown-menu anti-dropdown-menu agile-notification">
									<li>
										<div class="notification_header">
											<h3>You have <?php echo $unread_order_count; ?> new orders</h3>
										</div>
									</li>
									
								<?php
									$result_order	= get_order(4);
									while($row_order = $result_order->fetch_array()) {
								?>
								
									<li>
										<a href="orders.php#order-<?php echo $row_order['id']; ?>">
											<div class="user_img">
												<i class="fa fa-bell"></i>
											</div>
											<div class="notification_desc">
												<p><?php echo "$row_order[name]"; ?> <?php if($row_order['admin_read'] == 0){ ?> <span style="color: red!important">(NEW)</span> <?php } ?></p>
												<p><span><?php echo "$row_order[pr_id]"; ?></span></p>
											</div>
											<div class="clearfix"></div>	
										</a>
									</li>
									
								<?php
									}
									mysqli_free_result($result_order);
								?>
								
									 <li>
										<div class="notification_bottom">
											<a href="orders.php">See all orders</a>
										</div> 
									</li>
								</ul>
							</li>	
							<li class="dropdown head-dpdn">
							<?php
								$unread_comments		= get_unread_comments();
								$unread_comments_count	= $unread_comments->num_rows;
							?>
							
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-comments"></i><?php if($unread_comments_count != 0){ ?><span class="badge blue1"><?php echo $unread_comments_count; ?></span><?php } ?></a>
								<ul class="dropdown-menu anti-dropdown-menu agile-task">
									<li>
										<div class="notification_header">
											<h3>You have <?php echo $unread_comments_count; ?> pending comments</h3>
										</div>
									</li>
								<?php
									$result_comments	= get_comments(10);
									while($row_comments = $result_comments->fetch_array()) {
								?>
								
									<li>
										<a href="#">
											<div class="user_img">
												<!--<img src="images/3.png" alt="">-->
											</div>
											<div class="notification_desc">
												<p><?php echo "$row_comments[name]"; ?></p>
												<p><span><?php echo "$row_comments[prid]"; ?></span></p>
											</div>
											<div class="clearfix"></div>	
										</a>
									</li>
									
								<?php
									}
									mysqli_free_result($result_comments);
								?>
								
								</ul>
							</li>	
							<div class="clearfix"> </div>
						</ul>
					</div>	
					<div class="profile_details">		
						<ul>
							<li class="dropdown profile_details_drop">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<div class="profile_img">	
										<span class="prfil-img"><i class="fa fa-user" aria-hidden="true"></i></span> 
										<div class="clearfix"></div>
										<b><?php echo "$check_username"; ?></b>
									</div>	
								</a>
								<ul class="dropdown-menu drp-mnu">
									<li> <a href="admins.php"><i class="fa fa-user-circle-o"></i> Manage Admins</a> </li>
									<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</section>
		<?php if($unread_order_count > 0 || $unread_message_count >0){ ?>
		<div class="alert alert-danger notification text-center">
		<?php if($unread_order_count > 0){ ?>
			You Have <strong><?php echo $unread_order_count; ?></strong> New <a href="orders.php" class="alert-link"> Product Orders</a>
		<?php } ?>
		<?php 
			if($unread_order_count > 0 && $unread_message_count >0){
		?>
			, And <strong><?php echo $unread_message_count; ?></strong> New <a href="mailbox.php" class="alert-link"> Message</a>.
		<?php 
			} else if($unread_message_count >0) {
		?>
			You Have <strong><?php echo $unread_message_count; ?></strong> New <a href="mailbox.php" class="alert-link"> Message</a>.
		<?php } ?>
		</div>
		<?php } ?>