<?php
	ob_start();
	include "includes/config.php";
	if(isset($_COOKIE['user'])) {
		header('Location: index.php');
	}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<title>Login To Admin Panel</title>
<!-- Meta tag Keywords -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Meta tag Keywords -->
<!-- css files -->
<link href="css/login.css" rel="stylesheet" type="text/css" media="all">

<body>
<div class="main-w3l">
<div class="w3layouts-main">
	<h2>Login To Admin Panel</h2>
	<form method="post">
		<input value="USERNAME" name="username" type="text" required="" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'username';}"/>
		<input value="PASSWORD" name="password" type="password" required="" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password';}"/>
		<span class="remember"><input type="checkbox" checked="true"/>Remember Me</span>
		
		<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$username = strip_tags($_POST['username']);
			$password = strip_tags($_POST['password']);
			
			$username = $conn->real_escape_string($username);	//Real Escape String
			$password = $conn->real_escape_string($password);	//Real Escape String
				
			$get 		= "SELECT * FROM admins WHERE username = '{$username}' AND password = '{$password}'";
			$result 	= $conn->query($get) or trigger_error($conn->error." [$get]");
			$user_num 	= $result->num_rows;
	
			$row	= $result->fetch_array();
			$token 	= isset($row['Token']) ? $row['Token']: 'ahfkajfklajfo';

			if ($user_num == 1) {
				setcookie("user","{$token}", time() + (86400 * 30),"/");
				header('Location: index.php');
				ob_clean();	
			} else {
				echo "<span class=\"error\"> Incorrect Username or Password !! </span><br>";
			}		
		}
		?>
		<div class="clear"></div>
		<input type="submit" value="login" name="login">
	</form>
</div>
</div>

</body>
</html>