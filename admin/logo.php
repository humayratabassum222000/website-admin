<?php
	include "includes/header.php";
?>
<?php  
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$target_path 	= "../"; 
		$target_path 	= $target_path  . basename( $_FILES["image"]['name']); 
		
		if(move_uploaded_file($_FILES["image"]['tmp_name'], $target_path)) {
			$file 	= basename( $_FILES["image"]['name']);
		
			if(file_exists("{$target_path}")){
				rename ("../{$file}" , "../images/logo.png");
				adminMessage('green', 'Successfully Updated Logo');
			}
		} else {
			adminMessage('red', 'Uploaded Logo Error');
		}
	}
	
?>
		<div class="main-grid">
			<div class="agile-grids">	
				<!-- validation -->
				<div class="grids">
					<div class="progressbar-heading grids-heading">
						<h2>Site Logo</h2>
					</div>
					
					<div class="forms-grids">	
						<div class="w3agile-validation w3ls-validation">
							<div class="panel panel-widget agile-validation">
								<div class="my-div"> 
									<div class="form-body form-body-info">
										<form enctype="multipart/form-data" method="post" action="" class="valida" >
											<div class="row">
												<div class="col-md-6 col-md-offset-3 add-new">
													<img src="../images/logo.png?random=323527528432525.24234" class="img-responsive logo-image" alt="" style="margin: 0 auto;">
													<div class="form-group">
														<label for="input-25" class="control-label">Image <span class="image-size">(Format: PNG)</span></label>
														<input id="input-25" name="image" type="file" class="file"
															data-show-upload="false">
													</div>
													
													<p> &nbsp; </p>
													<div class="form-group">
														<button type="submit" class="btn btn-primary">Submit</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="js/valida.2.1.6.min.js"></script>
		<script type="text/javascript" >
			$(document).ready(function() {
				$('.valida').valida();
			});
			$("#input-25").fileinput({
				rtl: true,
				allowedFileExtensions: ["png"]
			});
		</script>
		<script src="js/validator.min.js"></script>
<?php
	include "includes/footer.php";
?>