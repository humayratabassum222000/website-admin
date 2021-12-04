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
	if(isset($_POST['reply'])) {
		$email_to			= mysqli_real_escape_string($conn, $_POST['email']);
		$email_subject= mysqli_real_escape_string($conn, $_POST['subject']);
		$messageBody	= mysqli_real_escape_string($conn, $_POST['message']);
		$email_from		= get_contact_information('email');
		
		if(!isset($messageBody) || strlen($messageBody) <= 5) {
			exit('Message content must be greater than 5 letter...');		
		} else {
			$bad 	= array("content-type","bcc:","to:","cc:");
			$Xman = array("\r\n","\n");
			$email_message	= str_replace($bad,"",$messageBody);
			$email_message	= str_replace($Xman,"<br>",$email_message);
		}
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$email_from."\r\n";
		if(mail($email_to, $email_subject, $email_message, $headers)) {
			adminMessage('green', 'Email Successfully Sent !');
		} else {
			adminMessage('red', 'No Mailer Integrated !');
		}
	}
?>
		<div class="main-grid">
			<div class="agile-grids">	
				<div class="table-heading">
					<h2>Mailbox</h2>
				</div>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <div class="mailbox">
						<?php
							$result_message = get_message(1000000000);
							while($row_message = $result_message->fetch_array()) {
						?>
						  <div id="mail-<?php echo $row_message['Id']; ?>" data-toggle="collapse" data-target="#demo<?php echo $row_message['Id']; ?>" class="message <?php if($row_message['admin_read'] == 0){echo "active";}?>">
								<div class="button-group col-md-2 col-sm-3 col-xs-3">
									<a href="?update=1&id=<?php echo $row_message['Id']; ?>&value=0<?php if($row_message['admin_read']==0)echo"1"; ?>"><i class="fa fa-envelope-<?php if($row_message['admin_read']==1)echo"open-"; ?>o"></i></a>
									<a href="javascript:void(0)" class="replyBtn" data-reply-to="<?php echo $row_message['Email'] ; ?>"><i class="fa fa-reply"></i></a>
									<a href="?delete=1&id=<?php echo $row_message['Id']; ?>"><i class="fa fa-trash-o"></i></a>
									<a href="?delete=1&id=<?php echo $row_message['Id']; ?>"><i class="fa fa-flag-o"></i></a>
								</div>
								<div class="col-md-8 col-sm-6 col-xs-6"><?php echo $row_message['Name'] ; ?> &lt;<?php echo $row_message['Email'] ; ?>&gt;</div>
								<div class="col-md-2 col-sm-3 col-xs-3"><?php echo $row_message['date'] ; ?></div>
								<div class="clearfix"></div>
							</div>
							<div id="demo<?php echo $row_message['Id']; ?>" class="collapse">
								<div class="message-body">
									<p><strong>From :</strong> <?php echo $row_message['Name'] ; ?></p>
									<p><strong>Sender Email :</strong> <?php echo $row_message['Email'] ; ?></p>
									<p><strong>Sender Mobile Number :</strong> <?php echo $row_message['Number'] ; ?></p>
									<p><small><?php echo $row_message['date'] ; ?></small></p>
									<p> &nbsp; </p>
									<p><?php echo htmlspecialchars($row_message['Message']); ?></p>
								</div>
							</div>
						<?php
							}
							mysqli_free_result($result_message);
						?>
						</tbody>
					  </table>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="replyModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Reply</h4>
						</div>
						<div class="modal-body">
							<form id="" action="" method="post">
								<input type="hidden" name="reply" value="1"/>
								<div class="row">
									<div class="form-group col-md-6 col-sm-6 col-xs-12">
										<label>Email</label>
										<input type="text" name="email" class="form-control" id="reply-input" required />
									</div>
									<div class="form-group col-md-6 col-sm-6 col-xs-12">
										<label>Subject</label>
										<input type="text" name="subject" class="form-control" value="Reply mail from <?php echo htmlspecialchars($companyName); ?>" required />
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<label>Message</label>
										<textarea name="message" rows="5" class="form-control" id="field-1-4" required></textarea>
									</div>
								</div>
								
								<p> &nbsp; </p>
								<div class="row">
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<input type="submit" name="submit" value="Send" class="btn btn-success"/>
										<input type="reset" value="Reset" class="btn btn-warning"/>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
		<script type="text/javascript" src="js/summernote.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#field-1-4').summernote({
					height: 200,
					tabsize: 3
				});
				$('.replyBtn').click(function(e){
					var reply_to	= $(this).attr('data-reply-to');
					if(reply_to) {
						$('#reply-input').val(reply_to);
						$('#reply-input').prop('readonly', true);
						$('#replyModal').modal('show');
					} else {
						alert('Sender email is empty !');
					}
				});
			  
				if(window.location.hash) {
					var hash = window.location.hash.substring(1);
					$('#'+hash).css('border','1px solid red');
					window.location.hash = '';
				}
			});
		</script>
		
<?php
	include "includes/footer.php";
?>