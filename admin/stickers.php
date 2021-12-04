<?php
	include "includes/header.php"; 
?>
<?php 
	if(isset($_POST['update'])) {
		$id			= $_POST['slider_id'];
		
		$old_image 		= $_POST['old_image'];
		
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
			$target_path 	= "../"; 		
			$target_path 	= $target_path  . basename( $_FILES["image"]['name']); 
			if(move_uploaded_file($_FILES["image"]['tmp_name'], $target_path)) {
				if(file_exists($old_image) && $old_image != null) {
					unlink("../{$old_image}");
				}
				
				if(!file_exists("../images/slider")) {
					mkdir("../images/slider", 0777, true);
				}
				
				$file 	= basename( $_FILES["image"]['name']);
				if(file_exists($target_path)){
					rename ("../{$file}" , "../images/slider/{$file}");
					$fields['image']	= "images/slider/{$file}?1222259157.415";
					adminMessage('green', 'Successfully Updated Banner');
				}
			}
		}
		
		$sql	= UpdateTable('sliders',$fields, "id='{$id}'");
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Updated Sticker');
		} else {
			adminMessage('red', $conn->error);
		}
	}
?>
<?php 
	if(isset($_POST['update_nodatabase'])) {
		$old_image		= $_POST['old_image'];
		
		if(!empty($_FILES["image"]['name'])) {
			$target_path 	= "../"; 		
			$target_path 	= $target_path  . basename( $_FILES["image"]['name']); 
			if(move_uploaded_file($_FILES["image"]['tmp_name'], $target_path)) {
				unlink("../{$old_image}");
				//CREATE DIRECTORY IF NOT EXIXTS
				if (!file_exists("../images/slider")) {
					mkdir("../images/slider", 0777, true);
				}
				
				//RENAME AND MOVE TARGET FILE
				$file 	= basename( $_FILES["image"]['name']);
				
				if(file_exists($target_path)){
					rename ("../{$file}" , "../{$old_image}");
					adminMessage('green', 'Successfully Updated Sticker');
				}
			}
		} else {
			adminMessage('red', 'No Image Selected For Update');
		}
	}
?>

		<div class="main-grid">
			<div class="agile-grids">	
				<!-- validation -->
				<div class="grids">
					<div class="progressbar-heading grids-heading">
						<h2>Stickers</h2>
					</div>
					
					<div class="forms-grids">
						<div class="w3agile-validation">
							<div class="panel panel-widget agile-validation">
								<div class="my-div">									
									<h4> Dynamic Stickers </h4>
									<p> &nbsp; </p>
									
									<div class="row">
										<div>
										<?php
											foreach($stickersToEdit as $key => $value) {
												$row_stickers	= get_stickers($value['page'], $value['position']);
												
												$old_image 		= explode('?', $row_stickers['image'], 2);
												$old_image		= $old_image[0];
												$imageInfo	= get_image_information('../'.$old_image);
										?>
											<div class="col-md-6 sticker-grids">
												<h5> <?php echo $key; ?> </h5>
												<form enctype="multipart/form-data" method="post" action="" class="valida" >
													<input type="hidden" name="slider_id" value="<?php echo $row_stickers['id']; ?>"/>
													<input type="hidden" name="update" value="1"/>
													<input type="hidden" name="page" value="<?php echo $row_stickers['page']; ?>"/>
													<input type="hidden" name="position" value="<?php echo $row_stickers['position']; ?>"/>
													<input type="hidden" name="old_image" value="<?php echo $old_image; ?>"/>
													
													<div class="old-image">
														<img src="../<?php echo $old_image; ?>" alt="<?php echo $old_image; ?>"/>
													</div>
													<div class="form-group">
														<label for="input-b0" class="control-label">Image <span class="image-size">(Size: <?php echo $imageInfo[0]; ?>&times;<?php echo $imageInfo[1]; ?>, Format: <?php echo $imageInfo[2]; ?>)</span></label>
														<input id="input-b0" name="image" type="file" class="file"
															data-show-upload="false" data-name="image"
															data-show-caption="true" 
															data-msg-placeholder="Select {files} for upload..."/>
														<?php
															$fieldsArray	= explode(',', $value['fields']);
															for($fields_i = 0; $fields_i < count($fieldsArray); $fields_i++){
																$fieldInfo	= get_edit_field_name_and_label($fieldsArray[$fields_i]);
														?>
															<label> <?php echo $fieldInfo['label']; ?> </label>
															<input type="text" class="form-control" name="<?php echo $fieldInfo['name']; ?>" value="<?php echo $row_stickers[$fieldInfo['name']]; ?>"/>
														<?php 
															}
														?>
														<p> &nbsp; </p>														
														<input type="submit" value="Update" class="btn btn-primary">
													</div>
												</form>
											</div>
										<?php 
											}
										?>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				<?php
					foreach($stickersToEdit_NoDb as $key => $value) {
						$imageForEdit	= $value['total_image'];
						
						if($imageForEdit <= 4){
							$col	= 12/$imageForEdit;
						}else {
							$col	= 4;
						}
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
											$oldImageArray	= explode(',', $value['old_image']);
											for($i = 0; $i < $value['total_image']; $i++){
												$imageInfo	= get_image_information('../'.$oldImageArray[$i]);
										?>
											<div class="col-md-<?php echo $col; ?> sticker-grids">
												<form enctype="multipart/form-data" method="post" action="" class="valida" >
													<input type="hidden" name="update_nodatabase" value="1"/>
													<input type="hidden" name="old_image" value="<?php echo $oldImageArray[$i]; ?>"/>
													
													<div class="old-image">
														<img src="../<?php echo $oldImageArray[$i]; ?>?1222259157.415" alt="<?php echo $oldImageArray[$i]; ?>"/>
													</div>
													<div class="form-group">
														<label for="input-b0" class="control-label">Image <span class="image-size">(Size: <?php echo $imageInfo[0]; ?>&times;<?php echo $imageInfo[1]; ?>, Format: <?php echo $imageInfo[2]; ?>)</span></label>
														<input id="input-b0" name="image" type="file" class="file"
															data-show-upload="false" data-name="image"
															data-show-caption="true" 
															data-msg-placeholder="Select {files} for upload..."/>
														
														<p> &nbsp; </p>														
														<input type="submit" value="Update" class="btn btn-primary">
													</div>
												</form>
											</div>
										<?php 
											}
										?>
										</div>
										<div class="clearfix"></div>
									</div>
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
		<script src="js/validator.min.js"></script>
<?php
	include "includes/footer.php";
?>
