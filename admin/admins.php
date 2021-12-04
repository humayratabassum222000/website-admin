<?php
	include "includes/header.php"; 
?>
<?php 
	if(isset($_POST['add'])) {
		
		// Random Token
		
		$alpha = "abcdefghijklmnopqrstuvwxyz";
		$alpha_upper = strtoupper($alpha);
		$numeric = "0123456789";
		$special = ".-+=_,!@$#*%<>[]{}";
		$chars = "";
		 

		// default [a-zA-Z0-9]{9}
		$chars = $alpha . $alpha_upper . $numeric;
		$length = 16;
		 
		$len = strlen($chars);
		$pw = '';
		 
		for ($i=0;$i<$length;$i++)
				$pw .= substr($chars, rand(0, $len-1), 1);
		 
		// the finished password
		$pw = str_shuffle($pw);
		
		
		$fields['username']		= mysqli_real_escape_string($conn, $_POST['username']);
		$fields['password']		= mysqli_real_escape_string($conn, $_POST['password']);
		$fields['date_added']	= date("d/m/Y");
		$fields['Token']		= $pw;

		$sql	= InsertInTable('admins',$fields);
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Added As Admin');
		} else {
			adminMessage('red', $conn->error);
		}
	}
	
	if(isset($_POST['update'])) {
		$id						= mysqli_real_escape_string($conn, $_POST['id']);
		$fields['username']		= mysqli_real_escape_string($conn, $_POST['username']);
		$fields['password']		= mysqli_real_escape_string($conn, $_POST['password']);

		$sql	= UpdateTable('admins',$fields,"id = '{$id}'");
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Update Admin Info');
		} else {
			adminMessage('red', $conn->error);
		}
	}
	if(isset($_GET['delete'])) {
		$id		= mysqli_real_escape_string($conn, $_GET['id']);
		$sql	= DeleteTable('admins',"id='{$id}'");
		
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Deleted Admin');
			echo "
				<script> 
					setTimeout(function(){window.location.href='admins.php';},7000);
				</script>
				
				";
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
			});
		</script>
		
		<div class="main-grid">
			<div class="agile-grids">	
				<!-- tables -->
				
				<div class="table-heading">
					<h2>Admins</h2>
				</div>
				<div class="agile-tables">
					<div class="w3l-table-info">
					    <table id="table">
							<thead>
								<tr>
									<th>Id</th>
									<th>Username</th>
									<th>Date Added</th>
									<th style="width: 20%;">Action</th>
								</tr>
							</thead>
							<tbody>
						<?php
							$result_admins = get_admins();
							while($row_admins = $result_admins->fetch_array()) {
						?>
						
								<tr>
									<td><?php echo "$row_admins[id]" ; ?></td>
									<td><?php echo "$row_admins[username]" ; ?></td>
									<td><?php echo "$row_admins[date_added]" ; ?></td>
								
									<td>
										<button class="btn btn-info" 
											data-username="<?php echo "$row_admins[username]" ; ?>" 
											data-password="<?php echo "$row_admins[password]" ; ?>"
											data-id="<?php echo "$row_admins[id]" ; ?>"> Change</button>
										
										<a href="?delete=1&id=<?php echo $row_admins['id']; ?>">
											<button class="btn btn-danger">Delete</button>
										</a>
									</td>
								</tr>
						
						<?php
							}
							mysqli_free_result($result_admins);
						?>

							</tbody>
						</table>
					</div>
					<script>
						$('.btn-info').click(function(){
							var id 			= $(this).attr('data-id');
							var username 	= $(this).attr('data-username');
							var password 	= $(this).attr('data-password');
							
							$('#field-1-1').val(id);
							$('#field-1-2').val(username);
							$('#field-1-3').val(password);
							
							$('#submit').attr('name','update');
							$('#submit').attr('value','Update');
						})
					</script>
					
					<p> &nbsp; </p>
					
					<div class="forms-grids">
						<div class="w3agile-validation">
							<div class="panel panel-widget agile-validation">
								<div class="my-div">
									<form enctype="multipart/form-data" method="post" action="" class="valida" >
										<input type="hidden" id="field-1-1" name="id" value="">
										
										<label for="field-1-2">Username</label>
										<div class="form-group">
											<input type="text" id="field-1-2" name="username" class="form-control">
										</div>
										
										<label for="field-1-3">Password</label>
										<div class="form-group">
											<input type="text" id="field-1-3" name="password" class="form-control">
										</div>
										<hr>

										<p>
											<input type="submit" id="submit" name="add" value="Add" class="btn btn-primary">
											<input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-danger">
										</p>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php
	include "includes/footer.php";
?>