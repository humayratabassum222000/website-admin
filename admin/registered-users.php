<?php
	include "includes/header.php"; 
?>
<?php 
	if(isset($_GET['delete'])) {
		$id		= mysqli_real_escape_string($conn, $_GET['id']);
		$sql	= DeleteTable('users',"id='{$id}'");
		
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Deleted Users');
			echo "
				<script> 
					setTimeout(function(){window.location.href='registered-users.php';},7000);
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
					<h2>Registered Users</h2>
				</div>
				<div class="agile-tables">
					<div class="w3l-table-info">
					    <table id="table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Username</th>
									<th>Mobile Number</th>
									<th style="width: 30%;">Address</th>
									<th style="width: 10%;">Action</th>
								</tr>
							</thead>
							<tbody>
						<?php
							$result_users = get_registered_users();
							while($row_users = $result_users->fetch_array()) {
						?>
						
								<tr>
									<td><?php echo $row_users['first_name'].' '.$row_users['last_name'] ; ?></td>
									<td><?php echo $row_users['username'] ; ?></td>
									<td><?php echo $row_users['mobile_number'] ; ?></td>
									<td><?php echo $row_users['address'].'<br/>- '.$row_users['city'].'<br/>- '.$row_users['district'] ; ?></td>
								
									<td>
										<a href="?delete=1&id=<?php echo $row_users['id']; ?>">
											<button class="btn btn-danger">Delete</button>
										</a>
									</td>
								</tr>
						
						<?php
							}
							mysqli_free_result($result_users);
						?>

							</tbody>
						</table>
					</div>
				</div>
			</div>

<?php
	include "includes/footer.php";
?>