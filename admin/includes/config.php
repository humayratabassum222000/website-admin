<?php
	$base			= "https://localhost/run/jwellaryshop";
	$companyName	= "Jewellery Shop";
	$currency		= "BDT";
	$EmailToSend	= "support@jewelleryshop.com";
	$uri_parts 		= explode('?', $_SERVER['REQUEST_URI'], 2);
	$self_url		= 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
	$min_prid		= "100100";
	$GoogleMapApi	= 'AIzaSyCM2ZcxLK4zaOcu8UCvyYxkFYP2j0a48_4'; 
	
	/*
		Case 1	: Image
		Case 2	: Image Link
		Case 3	: Image Heading
		Case 4	: Heading Link
		Case 5	: Text Line 1
		Case 6	: Text Line 1 Link
		Case 7	: Text Line 2
		Case 8	: Text Line 2 Link
		Case 9	: Text Line 3
		Case 10	: Text Line 3 Link	
	*/
	$bannerToEdit	= array(
						"home page banners"		=> array("page" => 'index', "position" => 1, "fields" => "3,5,7,9,10"),
						"featured brand"		=> array("page" => 'index', "position" => 7, "fields" => "2"));	
	$stickersToEdit	= array(
						"home page stickers top 1"		=> array("page" => 'index', "position" => 2, "fields" => "2"),
						"home page stickers top 2"		=> array("page" => 'index', "position" => 3, "fields" => "2"),
						"home page stickers middle 2"		=> array("page" => 'index', "position" => 4, "fields" => "2,5,7,9,10"),
						"home page stickers middle 3"		=> array("page" => 'index', "position" => 5, "fields" => "2,5,7,9,10"),
						"home page stickers bottom 1"		=> array("page" => 'index', "position" => 6, "fields" => "2,5,7,9,10"));
	
	$stickersToEdit_NoDb	= array(
						"proudct page sticker"		=> array("total_image" => 2, "old_image" => "images/shop/happynewyear.png,images/shop/summer.png"));
	
	$servername = "";
	$username 	= "root";
	$password 	= '';
	$dbname 	= "jwellary_shop";
//connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check
if($conn->connect_error) {
	die("connection failed !" .  $conn->connect_error);
}
?>