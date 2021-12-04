<?php
	include "includes/header.php"; 
?>
<?php 
	if(isset($_GET['delete'])) {
		$id		= mysqli_real_escape_string($conn, $_GET['id']);
		$sql	= DeleteTable('newsletter',"id='{$id}'");
		
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Deleted Users');
			echo "
				<script> 
					setTimeout(function(){window.location.href='newsletter.php';},7000);
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
				<div class="table-heading">
					<h2>Newsletter Subscriptions</h2>
				</div>
				<div class="agile-tables">
					<div class="w3l-table-info">
					    <table id="table">
							<thead>
								<tr>
									<th>Sl No.</th>
									<th>Email</th>
									<th style="width: 22%;">Action</th>
								</tr>
							</thead>
							<tbody>
						<?php
							$sli = 1; $to_array = [];
							$result_users = get_newsletters();
							while($row_users = $result_users->fetch_array()) {
						?>
								<tr>
									<td><?php echo $sli; ?></td>
									<td><?php echo $row_users['email']; ?></td>
									<td>
										<a href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=<?= $row_users['email']; ?>&su=Newsletter+From+<?= urlencode($companyName); ?>&shva=1" target="_blank">
											<button class="btn btn-success">Send Mail</button>
										</a>
										<a href="?delete=1&id=<?php echo $row_users['id']; ?>">
											<button class="btn btn-danger">Delete</button>
										</a>
									</td>
								</tr>
						
						<?php
								$to_array[] = $row_users['email'];$sli++;
							}
							mysqli_free_result($result_users); $mail_to = implode(',', $to_array);
						?>
								<tr>
									<td colspan="3" style="text-align: center;">
										<a href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=<?= $mail_to; ?>&su=Newsletter+From+<?= urlencode($companyName); ?>&shva=1" target="_blank">
											<button class="btn btn-success">Send Mail To All Person</button>
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

<?php
	include "includes/footer.php";
?>