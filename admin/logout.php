<?php
	if (!isset($_COOKIE['user'])) {
		header('Location: login.php'); 	
	} else {
		setcookie('user','user',time()-24*60*60,"/");
		header('Location: login.php');
	}
?>