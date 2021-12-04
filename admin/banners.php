<?php
	include "includes/header.php"; 
?>
<?php 
	if(isset($_POST['add'])) {
		$fields['image_heading']= isset($_POST['image_heading']) ? mysqli_real_escape_string($conn, $_POST['image_heading']) : '';
		$fields['image_text1']	= isset($_POST['image_text1']) ? mysqli_real_escape_string($conn, $_POST['image_text1']) : '';
		$fields['image_text2']	= isset($_POST['image_text2']) ? mysqli_real_escape_string($conn, $_POST['image_text2']) : '';
		$fields['image_text3']	= isset($_POST['image_text3']) ? mysqli_real_escape_string($conn, $_POST['image_text3']) : '';
		$fields['image_link']	= isset($_POST['image_link']) ? mysqli_real_escape_string($conn, $_POST['image_link']) : '';
		$fields['heading_link']	= isset($_POST['heading_link']) ? mysqli_real_escape_string($conn, $_POST['heading_link']) : '';
		$fields['text1_link']	= isset($_POST['text1_link']) ? mysqli_real_escape_string($conn, $_POST['text1_link']) : '';
		$fields['text2_link']	= isset($_POST['text2_link']) ? mysqli_real_escape_string($conn, $_POST['text2_link']) : '';
		$fields['text3_link']	= isset($_POST['text3_link']) ? mysqli_real_escape_string($conn, $_POST['text3_link']) : '';
		
		$fields['page']			= mysqli_real_escape_string($conn, $_POST['page']);
		$fields['position']		= $_POST['position'];
		
		if(!empty($_FILES["image"]['name'])) {
			$imageName	= "image";  $outputFolder	= "../images/slider";
			$file	= upload_image_noArray($imageName, $outputFolder);
			
			$fields['image']	= "images/slider/{$file}?1222259157.415";
			$sql	= InsertInTable('sliders',$fields);
				
			if($conn->query($sql) == true) {
				adminMessage('green', 'Successfully Added Banner');
			} else {
				adminMessage('red', $conn->error);
			}
		} else {
			adminMessage('red','Product Image Not Found');
		}
	}
?>

<?php 
	if(isset($_POST['update'])) {
		$id			= $_POST['slider_id'];
		
		$fields['image_heading']= isset($_POST['image_heading']) ? mysqli_real_escape_string($conn, $_POST['image_heading']) : '';
		$fields['image_text1']	= isset($_POST['image_text1']) ? mysqli_real_escape_string($conn, $_POST['image_text1']) : '';
		$fields['image_text2']	= isset($_POST['image_text2']) ? mysqli_real_escape_string($conn, $_POST['image_text2']) : '';
		$fields['image_text3']	= isset($_POST['image_text3']) ? mysqli_real_escape_string($conn, $_POST['image_text3']) : '';
		$fields['image_link']	= isset($_POST['image_link']) ? mysqli_real_escape_string($conn, $_POST['image_link']) : '';
		$fields['heading_link']	= isset($_POST['heading_link']) ? mysqli_real_escape_string($conn, $_POST['heading_link']) : '';
		$fields['text1_link']	= isset($_POST['text1_link']) ? mysqli_real_escape_string($conn, $_POST['text1_link']) : '';
		$fields['text2_link']	= isset($_POST['text2_link']) ? mysqli_real_escape_string($conn, $_POST['text2_link']) : '';
		$fields['text3_link']	= isset($_POST['text3_link']) ? mysqli_real_escape_string($conn, $_POST['text3_link']) : '';
		
		$fields['page']			= mysqli_real_escape_string($conn, $_POST['page']);
		$fields['position']		= $_POST['position'];
		
		if(!empty($_FILES["image"]['name'])) {
			if(file_exists('../'.$_POST['old_image'])) {
				unlink('../'.$_POST['old_image']);
			}
			
			$imageName	= "image";  $outputFolder	= "../images/slider";
			$file	= upload_image_noArray($imageName, $outputFolder);
			
			$fields['image']	= "images/slider/{$file}?1222259157.415";
			adminMessage('green', 'Successfully Updated Banner');
		}
		
		$sql	= UpdateTable('sliders',$fields, "id='{$id}'");
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Updated Banner');
		} else {
			adminMessage('red', $conn->error);
		}
	}
?>

<?php 
	if(isset($_GET['delete'])) {
		$id		= $_GET['delete'];
		$sql	= DeleteTable('sliders',"id='{$id}'");
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Deleted');
			echo "<script>setTimeout(function(){window.location='banners.php'}, 4000)</script>";
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
						<h2>Banner &amp; Sliders</h2>
					</div>
				<?php
					foreach($bannerToEdit as $key => $value) {
				?>
					<div class="forms-grids">
						<div class="w3agile-validation">
							<div class="panel panel-widget agile-validation">
								<div class="my-div">									
									<h4> <?php echo $key; ?> </h4>
									<p> &nbsp; </p>
									
									<div class="row">
										<div>
										<?php 
											$sliders_i		= 1;
											$result_sliders	= get_sliders($value['page'], $value['position']);
											while($row_sliders	= $result_sliders->fetch_array()) {
												$old_image 		= explode('?', $row_sliders['image'], 2);
												$old_image		= $old_image[0];
												
												$imageInfo	= get_image_information('../'.$old_image);
										?>
											<div class="col-md-4 sticker-grids">
												<img src="../<?php echo $row_sliders['image']; ?>" class="img-responsive" alt=""  style="margin: 0 auto;" />
												<form enctype="multipart/form-data" method="post" action="" class="valida" >
													<input type="hidden" name="slider_id" value="<?php echo $row_sliders['id']; ?>"/>
													<input type="hidden" name="update" value="1"/>
													<input type="hidden" name="page" value="<?php echo $value['page']; ?>"/>
													<input type="hidden" name="position" value="<?php echo $value['position']; ?>"/>
													<input type="hidden" name="old_image" value="<?php echo $old_image; ?>"/>
													
													
													<div class="form-group">
														<label for="input-b0" class="control-label">Image <span class="image-size">(Size: <?php echo $imageInfo[0]; ?>&times;<?php echo $imageInfo[1]; ?>, Format: <?php echo $imageInfo[2]; ?>)</span></label>
														<input id="input-b0" name="image" type="file" class="file"
															data-show-upload="false" data-name="image"
															data-show-caption="true" 
															data-msg-placeholder="Select {files} for upload...">
														
													<?php
														$fieldsArray	= explode(',', $value['fields']);
														for($fields_i = 0; $fields_i < count($fieldsArray); $fields_i++){
															$fieldInfo	= get_edit_field_name_and_label($fieldsArray[$fields_i]);
													?>
														<label> <?php echo $fieldInfo['label']; ?> </label>
														<input type="text" class="form-control" name="<?php echo $fieldInfo['name']; ?>" value="<?php echo $row_sliders[$fieldInfo['name']]; ?>"/>
													<?php 
														}
													?>
													
														<p> &nbsp; </p>
														<input type="submit" name="update" value="Update" class="btn btn-primary">
														<a href="?delete=<?php echo $row_sliders['id']; ?>"  class="btn btn-danger">Delete</a>
													</div>
												</form>
											</div>
											<?php if($sliders_i%3 == 0) { ?>
											<div class="clearfix"></div>
											<?php } ?>
											
											<?php
													$sliders_i++;
												}
												mysqli_free_result($result_sliders);
											?>
										</div>
										<div class="clearfix"></div>
										
										
										<div class="col-md-6 col-md-offset-3 add-new">
											<h4 class="text-center">Add New</h4>
											<form enctype="multipart/form-data" method="post" action="" class="valida" >
												<input type="hidden" name="add" value="1"/>
												<input type="hidden" name="page" value="<?php echo $value['page']; ?>"/>
												<input type="hidden" name="position" value="<?php echo $value['position']; ?>"/>
												
												<div class="form-group">
													<label for="input-b0" class="control-label">Image <span class="image-size">(Size: <?php echo $imageInfo[0]; ?>&times;<?php echo $imageInfo[1]; ?>, Format: <?php echo $imageInfo[2]; ?>)</span></label>
													<input id="input-b0" name="image" type="file" class="file"
														data-show-upload="false" data-name="image"
														data-show-caption="true" 
														data-msg-placeholder="Select {files} for upload..."/>
													
												<?php
													for($fields_i = 0; $fields_i < count($fieldsArray); $fields_i++){
													$fieldInfo	= get_edit_field_name_and_label($fieldsArray[$fields_i]);
												?>
													<label> <?php echo $fieldInfo['label']; ?> </label>
													<input type="text" class="form-control" name="<?php echo $fieldInfo['name']; ?>"/>
												<?php 
													}
												?>
													
													<p> &nbsp; </p>
													<input type="submit" value="ADD" class="btn btn-primary">
												</div>
											</form>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div>
				<?php
					}
				?>	
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="js/valida.2.1.6.min.js"></script>
		<script type="text/javascript" >
			$(document).ready(function() {
				$('.valida').valida();
			});
		</script>
		<!-- //input-forms -->
		<!--validator js-->
		<script src="js/validator.min.js"></script>
		<!--//validator js-->
<?php
	include "includes/footer.php";
?>
