<?php
	include "includes/header.php"; 
?>
<?php 
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$fields['address']	= mysqli_real_escape_string($conn, $_POST['address']);
		$fields['address2']	= mysqli_real_escape_string($conn, $_POST['address2']);
		$fields['mobile1']	= mysqli_real_escape_string($conn, $_POST['mobile1']);
		$fields['mobile2']	= mysqli_real_escape_string($conn, $_POST['mobile2']);
		$fields['mobile3']	= mysqli_real_escape_string($conn, $_POST['mobile3']);
		$fields['phone']		= mysqli_real_escape_string($conn, $_POST['phone']);
		$fields['email']		= mysqli_real_escape_string($conn, $_POST['email']);
		
		$fields['facebook']	= mysqli_real_escape_string($conn, $_POST['facebook']);
		$fields['twitter']	= mysqli_real_escape_string($conn, $_POST['twitter']);
		$fields['instagram']	= mysqli_real_escape_string($conn, $_POST['instagram']);
		$fields['googleplus']= mysqli_real_escape_string($conn, $_POST['googleplus']);
		$fields['gmail']		= mysqli_real_escape_string($conn, $_POST['gmail']);
		$fields['youtube']	= mysqli_real_escape_string($conn, $_POST['youtube']);
		$fields['yahoo']		= mysqli_real_escape_string($conn, $_POST['yahoo']);
		$fields['skype']		= mysqli_real_escape_string($conn, $_POST['skype']);

		$sql	= UpdateTable('contact_information',$fields,'1');
			
		if($conn->query($sql)) {
			adminMessage('green', 'Successfully Updated Contact Information');
		} else {
			adminMessage('red', $conn->error);
		}
	}
?>

	<div class="main-grid">
		<div class="agile-grids">	
			<div class="grids">
				<div class="progressbar-heading grids-heading">
					<h2>Add Data</h2>
				</div>
				<div class="forms-grids">
					<div class="w3agile-validation">
						<div class="panel panel-widget agile-validation">
							<div class="my-div">
								<form enctype="multipart/form-data" method="post" action="" class="valida" autocomplete="on" novalidate="novalidate">
									<div class="form-group">
										<h4> Contact Information </h4>
									</div>
									
									<label for="field-3">Address</label>
									<div class="form-group">
										<textarea name="address" required="true" id="field-3" class="form-control"><?php echo get_contact_information('address'); ?></textarea>
									</div>
									
									<label for="field-3-2">Address Line 2</label>
									<div class="form-group">
										<textarea name="address2" id="field-3-2" class="form-control"><?php echo get_contact_information('address2'); ?></textarea>
									</div>
									
									<label for="field-4">Mobile Number 1</label>
									<div class="form-group">
										<input type="text" value="<?php echo get_contact_information('mobile1'); ?>" name="mobile1" required="true" id="field-4" class="form-control">
									</div>
									
									<label for="field-5">Mobile Number 2</label>
									<div class="form-group">
										<input type="text" name="mobile2" value="<?php echo get_contact_information('mobile2'); ?>" id="field-5" class="form-control">
									</div>
									
									<label for="field-6">Mobile Number 3</label>
									<div class="form-group">
										<input type="text" name="mobile3" value="<?php echo get_contact_information('mobile3'); ?>" id="field-6" class="form-control">
									</div>
									
									<label for="field-7">Telephone</label>
									<div class="form-group">
										<input type="text" name="phone" value="<?php echo get_contact_information('phone'); ?>" id="field-7" class="form-control">
									</div>
									
									<label for="field-8">E-mail </label>
									<div class="form-group">
										<input type="email" name="email" value="<?php echo get_contact_information('email'); ?>" id="field-8" class="form-control">
									</div>
									
									<!----- Social Information ----->
									
									<div class="form-group">
										<p> &nbsp; </p><h4> Social Information </h4>
									</div>
									
									<label for="field-9" style="color: #3b5998;"><i class="fa fa-facebook"></i> Facebook</label>
									<div class="form-group">
										<input type="text" name="facebook" value="<?php echo get_contact_information('facebook'); ?>" id="field-9" class="form-control">
									</div>
									
									<label for="field-10" style="color: #55acee;"><i class="fa fa-twitter"></i> Twitter</label>
									<div class="form-group">
										<input type="text" name="twitter" value="<?php echo get_contact_information('twitter'); ?>" id="field-10" class="form-control">
									</div>
									
									<label for="field-11" style="color: #8a3ab9;"><i class="fa fa-instagram"></i> Instagram</label>
									<div class="form-group">
										<input type="text" name="instagram" value="<?php echo get_contact_information('instagram'); ?>" id="field-11" class="form-control">
									</div>
									
									<label for="field-12" style="color: #D84B37;"><i class="fa fa-google-plus"></i> Google Plus</label>
									<div class="form-group">
										<input type="text" name="googleplus" value="<?php echo get_contact_information('googleplus'); ?>" id="field-12" class="form-control">
									</div>
									
									<label for="field-12c" style="color: #d54b3d;"><i class="fa fa-envelope"></i> Gmail</label>
									<div class="form-group">
										<input type="text" name="gmail" value="<?php echo get_contact_information('gmail'); ?>" id="field-12c" class="form-control">
									</div>
									
									<label for="field-12d" style="color: #f00;"><i class="fa fa-youtube"></i> YouTube</label>
									<div class="form-group">
										<input type="text" name="youtube" value="<?php echo get_contact_information('youtube'); ?>" id="field-12d" class="form-control">
									</div>
									
									<label for="field-13" style="color: #400090;"><i class="fa fa-yahoo"></i> Yahoo</label>
									<div class="form-group">
										<input type="text" name="yahoo" value="<?php echo get_contact_information('yahoo'); ?>" id="field-13" class="form-control">
									</div>
									
									<label for="field-14" style="color: #00aff0;"><i class="fa fa-skype"></i> Skype</label>
									<div class="form-group">
										<input type="text" name="skype" value="<?php echo get_contact_information('skype'); ?>" id="field-14" class="form-control">
									</div>

									<hr>
									<p>
										<input type="submit" name="sub-1" value="Submit" class="btn btn-primary">
										<input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-danger">
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="js/valida.2.1.6.min.js"></script>
	<script type="text/javascript" >
		$(document).ready(function() {
			$('.valida').valida();
		});
	</script>
	<script src="js/validator.min.js"></script>
<?php
	include "includes/footer.php";
?>
