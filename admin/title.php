<?php
	include "includes/header.php"; 
?>

<?php 
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(!empty($_FILES['image']['name'])) {
			$target_path 	= "../"; 
			$target_path 	= $target_path  . basename( $_FILES["image"]['name']); 
			
			if(move_uploaded_file($_FILES["image"]['tmp_name'], $target_path)) {
				$file 	= basename( $_FILES["image"]['name']);
			
				if(file_exists($target_path)){
					rename ("../".$file , "../favicon.ico");
				}
			}
		}
		
		$fields['title']	= mysqli_real_escape_string($conn, $_POST['title']);
		
		$sql	= UpdateTable('site_settings',$fields,'1');
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Updated Title');
		} else {
			adminMessage('red', $conn->error);
		} 
	}
?>
	<div class="main-grid">
		<div class="agile-grids">	
			<!-- validation -->
			<div class="grids">
				<div class="progressbar-heading grids-heading">
					<h2>Page Title &amp; Icon</h2>
				</div>
				
				<div class="forms-grids">	
					<div class="w3agile-validation w3ls-validation">
						<div class="panel panel-widget agile-validation">
							<div class="my-div"> 
								<div class="form-body form-body-info">
									<form enctype="multipart/form-data" method="post" action="" class="valida" >
										<div class="row">
											<div class="col-md-6 col-md-offset-3 add-new">
												<img src="../favicon.ico?1222259157.415" class="img-responsive" alt="No Page Icon Set Yet" style="margin: 0 auto;">
												<div class="form-group">
													<label for="input-25" class="control-label">Image <span class="image-size">(Format: ICO)</span></label>
													<input id="input-25" name="image" type="file" class="file"
														data-name="image"
														data-show-upload="false">
												</div>
												
												<label> Page Title </label>
												<input type="text" class="form-control" placeholder="Page Title" name="title" value="<?php echo get_page_title(); ?>">
												
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
			allowedFileExtensions: ["ico"]
		});
	</script>
	<script src="js/validator.min.js"></script>
<?php
	include "includes/footer.php";
?>