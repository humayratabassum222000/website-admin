<?php
	ob_start();
	include "includes/header.php"; 
?>
<?php 
	if(isset($_GET['delete'])) {
		
		$id		= isset($_GET['id']) ? $_GET['id']: exit(header('Location: orders.php'));
		$sql	= DeleteTable('contact'," Id = '{$id}' ");
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Message Deleted');
			header('Refresh: 5; URL=mailbox.php');
		} else {
			adminMessage('red', $conn->error);
		} 
	}
	if(isset($_GET['update'])) {
		
		$id						= isset($_GET['id']) ? $_GET['id']: exit(header('Location: orders.php'));
		$fields['admin_read']	= $_GET['value'];
		$sql	= UpdateTable('contact',$fields," id = '{$id}' ");
			
		if($conn->query($sql) == true) {
			header("Location:mailbox.php#mail-".$id);
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
			<h2>Mailbox</h2>
		</div>
		
		<div class="agile-tables">
			<div class="w3l-table-info">
				<h3>Your Mailbox</h3>
				<table id="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Number</th>
							<th>Message</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$result_message = get_message(1000000000);
						while($row_message = $result_message->fetch_array()) {
					?>
						<tr id="mail-<?php echo $row_message['Id']; ?>" class="<?php if($row_message['admin_read']==0){echo "active";}?>">
							<td><?php echo $row_message['Name'] ; ?></td>
							<td><?php echo $row_message['Email'] ; ?></td>
							<td><?php echo $row_message['Number'] ; ?></td>
							<td><?php echo $row_message['Message'] ; ?></td>
							<td style="vertical-align: top;">
								Status: 
								<select class="order-status" data-order-id="<?php echo $row_message['Id']; ?>">
									<option value="0" <?php if($row_message['admin_read'] == 0){echo "selected";}?> > Unreviewed </option>
									<option value="1" <?php if($row_message['admin_read'] == 1){echo "selected";}?>> Read </option>
								</select>
								<p> &nbsp; </p>
								<a href="?delete=1&id=<?php echo $row_message['Id']; ?>">
									<button class="btn btn-danger">Delete</button>
								</a>
							</td>
						</tr>
					<?php
						}
						mysqli_free_result($result_message);
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
</div>
<?php
	include "includes/footer.php";
?>