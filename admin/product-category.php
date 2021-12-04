<?php
	ob_start();
	include "includes/header.php"; 
?>
<?php 
	if(isset($_GET['delete'])) {
		$idc = mysqli_real_escape_string($conn, $_GET['delete']); $ids = explode(',', $idc); $m	= "";
		foreach($ids as $id) {
			$sql = "SELECT id,main,sub FROM procat WHERE id='{$id}'";
			$result = $conn->query($sql); $row = $result->fetch_array(); $deleted_main = $row['main']; $deleted_sub = $row['sub'];
			mysqli_free_result($result);
			
			$sql	= "SELECT id,category FROM products WHERE category='".addslashes($deleted_main)."' AND subcategory='".addslashes($deleted_sub)."'";
			$result	= $conn->query($sql); while($row = $result->fetch_array()) { deleteDir("../proimg/".$row['id']); } mysqli_free_result($result);
			
			
			$delete_products	= DeleteTable('products'," category='".addslashes($deleted_main)."' AND subcategory='".addslashes($deleted_sub)."'");
			$delete_from_procat	= DeleteTable('procat'," id = '{$id}' ");
			
			if($conn->query($delete_from_procat) && $conn->query($delete_products)) { $m .= $id.":Deleted - "; }
			else { $m .= $conn->error; }
			adminMessage('green', $m);
		}
	}
	
	if(isset($_POST['add'])) {
		
		$fields['main']			= mysqli_real_escape_string($conn, strtolower($_POST['main'])); $main	= $fields['main'];
		$fields['main_bn']		= mysqli_real_escape_string($conn, strtolower($_POST['subItems']));
		$sub					= mysqli_real_escape_string($conn, strtolower($_POST['sub']));
		$fields['header']		= mysqli_real_escape_string($conn, strtolower($_POST['sub_header']));
		$fields['position']		= 100;
		
		if(!empty($_FILES["cat_icon"]['name'])) {
			$target_path 	= "../"; 
			$cat_img_base	= $target_path  . basename( $_FILES["cat_icon"]['name']); 

			if((move_uploaded_file($_FILES["cat_icon"]['tmp_name'], $cat_img_base))) {
				if(!file_exists("../images/category-slides")) {
					mkdir("../images/category-slides", 0777, true);
				}
				
				$img_file 	= basename( $_FILES["cat_icon"]['name']);
				
				rename ("../".addslashes($img_file) , "../images/category-slides/".restyle_url($main)."-icon.png");
			}
		}
		
		$adminMessage	= '';
		$subs			= explode(',',$sub);
		$subs_length	= count($subs);
		
		for($sub_key=0 ; $sub_key<$subs_length ; $sub_key++){
			$fields['sub']	= $subs[$sub_key];
			$sql	= InsertInTable('procat',$fields);
			
			if($conn->query($sql) == true) { $adminMessage	.= "<p>Successfully Added Category</p>";} 
			else { $adminMessage	.= $conn->error;}
		}
			
		adminMessage('green',$adminMessage);
	}
	if(isset($_POST['add_sec_menu'])) {
		
		$fields['main']			= mysqli_real_escape_string($conn, strtolower($_POST['main']));
		$fields['main_bn']		= mysqli_real_escape_string($conn, strtolower($_POST['main']));
		$fields['sub']			= mysqli_real_escape_string($conn, strtolower($_POST['main']));
		$fields['header']		= mysqli_real_escape_string($conn, strtolower($_POST['main']));
		$fields['position']		= 0;
		
		$sql	= InsertInTable('procat',$fields);
		if($conn->query($sql) == true) {
			adminMessage('green','Successfully Added Category');
		} else {
			adminMessage('red',$conn->error);
		}
	}
	
	if(isset($_POST['update'])) {
		$main	= strtolower($_POST['main']);
		$target_path 	= "../"; 
		$cat_img_base	= $target_path  . basename( $_FILES["cat_icon"]['name']); 

		if(move_uploaded_file($_FILES["cat_icon"]['tmp_name'], $cat_img_base)) {
			if(!file_exists("../images/category-slides")) {
				mkdir("../images/category-slides", 0777, true);
			}
			
			adminMessage('green', 'Successfully Updated Category');
			
			$img_file 	= basename( $_FILES["cat_icon"]['name']);
		
			rename ("../".addslashes($img_file) , "../images/category-slides/".restyle_url($main)."-icon.png");
		}
	}
	if(isset($_POST['update_main_position'])) {
		$total_main	= $_POST['total_main'];
		
		for($i	= 1; $i <= $total_main ; $i++) {
			$fields['position']	= $i;
			
			$sql	= UpdateTable('procat', $fields, "main='".mysqli_real_escape_string($conn, $_POST[$i])."'");
			
			if($conn->query($sql) == true) { adminMessage('green', 'Successfully Updated Category');} 
			else { adminMessage('red', $conn->error);}
		}
	}
?>

	<div class="main-grid">
		<div class="agile-grids">	
			<!-- validation -->
			<div class="grids">
				<div class="progressbar-heading grids-heading">
					<h2>Product Category</h2>
				</div>
				
				<div class="forms-grids">
					<div class="w3agile-validation">
						<div class="panel panel-widget agile-validation">
							<div class="my-div">
								<h5>Secondary Menu</h5>
								<form enctype="multipart/form-data" method="post" action="product-category.php" class="valida" >										
									<input type="hidden" name="add_sec_menu" value="1" />
									<input type="hidden" name="mainMenu" value="1" />
									
									
									<label for="field-2">Enter Menu Name</label>
									<div class="form-group">
										<input type="text" name="main" required="true" id="field-2" class="form-control" placeholder="eg: Clothing, Footware, Home Applience">
									</div>
									<p>
										<input type="submit" name="sub-1" value="Submit" class="btn btn-primary">
									</p>
								</form>
								<p> &nbsp; </p><p> &nbsp; </p><h5>Main Menu</h5>
								<form enctype="multipart/form-data" method="post" action="product-category.php" class="valida" >										
									<input type="hidden" name="add" value="1" />
									<input type="hidden" name="mainMenu" value="1" />
									
									<label for="field-1-3">Select Category</label>
									<div class="form-group">
										<?php
											$result_main	= get_menu();
											$total_category	= $result_main->num_rows;
											
											if($total_category > 0 ) {
										?>
											<div id="brandDiv">
												<select name="main" id="field-1-3" class="form-control select-main">
												<?php 
													while($row_main = $result_main->fetch_array()) {
												?>
													<option> <?php echo ucfirst($row_main['main']); ?> </option>
												<?php 		
													}
													mysqli_free_result($result_main);
												?>
													<option value="other"> Other </option>
												</select>
											</div>
										<?php 	
											} else {
										?>
											<input type="text" name="main" class="form-control"  placeholder="Enter Category Name Here..."/>
										<?php 
											}
										?>
									</div>
									
									<label for="field-2">Enter Sub Category Header</label>
									<div class="form-group">
										<input type="text" name="sub_header" required="true" id="field-2" class="form-control" placeholder="eg: Clothing, Footware, Home Applience">
									</div>
									
									<label for="field-3">Enter Sub Category</label>
									<div class="form-group">
										<input type="text" name="sub" required="true" id="field-3" class="form-control" placeholder="eg: Shirt, Pant, Mobile">
									</div>
									
									
									<div class="row new-category">
										<div class="col-md-6">
											<label >Upload Category Icon <span class="image-size">(Size: 30&times;30, Format: PNG)</span></label>
											<div class="form-group">
												<input id="input-b0" name="cat_icon" type="file" class="file"
															data-show-upload="false" data-name="cat_icon"
															data-show-caption="true" 
															data-msg-placeholder="Select {files} for upload..." />
											</div>
										</div>
										<div class="clearfix"><p> &nbsp; </p></div>
									</div>										
									
									<hr>

									<p>
										<input type="submit" name="sub-1" value="Submit" class="btn btn-primary">
										<input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-danger">
									</p>
								</form>
								<script>
								$("#input-b0").fileinput({
									rtl: true,
									allowedFileExtensions: ["png"]
								});
								</script>
							</div>
						</div>
					</div>
				</div>
				
			<?php 
				if($total_category > 0) {
			?>
			
				<?php	$result_main	= get_menu();	?>
				<script>
					main	= [
						<?php while($row_main = $result_main->fetch_array()) { ?>
						"<?php echo htmlspecialchars(ucfirst($row_main['main'])); ?>",
						<?php } ?>
					]
				</script>
				<?php mysqli_free_result($result_main);	?>
				
				<div class="forms-grids">
					<div class="w3agile-validation">
						<div class="panel panel-widget agile-validation">
							<div class="my-div">
								<h4>Update Category Images &amp; Slides</h4>
								<p> &nbsp; </p>
								
								<form class="alignments" method="post" action="">
									<input type="hidden" name="update_main_position" />
									<input type="hidden" name="total_main" value=""/>
									
									<div class="current-menu"></div>
									<div class="operators"><button class="btn btn-warning edit"> <i class="fa fa-pencil"></i> Edit </button></div>
									<div class="clearfix"></div>
								</form>
								
								<script>
									$(document).ready(function(){
										$('input[name="total_main"]').val(main.length);
										
										for(var i	= 0; i < main.length; i++){
											$('.alignments .current-menu').append('<button class="btn btn-primary disabled">'+main[i]+'</button>');
										}
										
										$('.operators .btn.edit').click(function(){
											var pos1	 = '<select name="1" onchange="newMenu(this.value)">';
											pos1		+= '	<option value=""> Select 1 Position </option>';
											for(pos_i=0; pos_i<main.length ; pos_i++) {
												pos1		+= '	<option value="'+ main[pos_i] +'">'+ main[pos_i] +'</option>';
											}
											pos1		+= '</select>';
											
											$('.alignments .current-menu').html(pos1);
											$('.alignments .operators').html('<a href="product-category.php" class="btn btn-info reset" >Reset</a>');
										});
									});
									
									prev_name_i	= 1;
									function newMenu(value){
										if(main.length > 1) {
											$('select[name="'+prev_name_i+'"]').addClass('disabled');
											
											array_pos	= main.indexOf(value);
											main.splice(array_pos, 1);
											
											new_name_i	 = prev_name_i+1;
											var pos2	 = '<select name="'+new_name_i+'" onchange="newMenu(this.value)">';
											pos2		+= '	<option value=""> Select '+new_name_i+' Position </option>';
											for(pos_i=0; pos_i<main.length ; pos_i++) {
												pos2		+= '	<option value="'+ main[pos_i] +'">'+ main[pos_i] +'</option>';
											}
											pos2		+= '</select>';
											
											$('.alignments .current-menu').append(pos2);
											prev_name_i++;
										} else {
											$('select[name="'+prev_name_i+'"]').addClass('disabled');
											$('.alignments .operators').html('<input type="submit" class="btn btn-success" value="Update">');
										}
									}
								</script>

								<form enctype="multipart/form-data" method="post" action="product-category.php" class="valida" >										
									<input type="hidden" name="update" value="1" />
									<label for="field-1">Select Category</label>
									<div class="form-group">
									<?php
										$result_main	= get_menu();
									?>
										<div id="brandDiv">
											<select name="main" id="field-1-3" class="form-control">
										
											<?php 
												while($row_main = $result_main->fetch_array()) {
											?>
										
												<option value="<?php echo ucfirst($row_main['main']); ?>"> <?php echo ucfirst($row_main['main']); ?> </option>
											
											<?php 		
												}
												mysqli_free_result($result_main);
											?>
												
											</select>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<label >Upload Category Icon <span class="image-size">(Size: 30&times;30, Format: PNG)</span></label>
											<div class="form-group">
												<input id="input-bu0" name="cat_icon" type="file" class="file"
															data-show-upload="false" data-name="cat_icon"
															data-show-caption="true" 
															data-msg-placeholder="Select {files} for upload..." />
											</div>
										</div>
										<div class="clearfix"><p> &nbsp; </p></div>
									</div>										
									
									<hr>

									<p>
										<input type="submit" name="sub-1" value="Submit" class="btn btn-primary">
										<input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-danger">
									</p>
								</form>
								<script>
								$("#input-bu0").fileinput({
									rtl: true,
									allowedFileExtensions: ["png"]
								});
								</script>
							</div>
						</div>
					</div>
				</div>
				
				<div class="forms-grids">
					<div class="w3agile-validation">
						<div class="panel panel-widget agile-validation">
							<div class="my-div">
								<h4>Delete Category</h4>
								<p> &nbsp; </p>
																	
								<div id="product-query">
									<div class="form-group selection-buttons">
										<?php
											$result_main		= get_menu();
											while($row_main = $result_main->fetch_array()) {
										?>
											<input type="button" value="<?php echo htmlspecialchars($row_main['main']) ?>" class="btn btn-danger" onclick="showSub('<?php echo htmlspecialchars(addslashes($row_main['main'])); ?>')"/>
										<?php
											}
											mysqli_free_result($result_main);
										?>
									</div>
									
									<label id="subLabel" style="display: none;">Select Sub Category</label>
									<div class="form-group">
									<?php
										$result_main		= get_menu();
										while($row_main = $result_main->fetch_array()) {
									?>
										<div id="<?php echo htmlspecialchars($row_main['main'])."-products" ;?>" style="display: none; height: auto;">
											<!--<option selected="true"> Select Sub</option>-->
										<?php
											$result_sub		= get_sub_by_main($row_main['main']);
											while($row_sub = $result_sub->fetch_array()) {
										?>
											<div><label><input type="checkbox" name="delSub[]" value="<?php echo $row_sub['id'] ;?>"/><?php echo $row_sub['header'] ;?> - <?php echo $row_sub['sub'] ;?> - <?php echo $row_sub['main_bn'] ;?> <label></div>
											<!--<option value="<?php echo $row_sub['id'] ;?>"><?php echo $row_sub['header'] ;?> - <?php echo $row_sub['sub'] ;?> - <?php echo $row_sub['main_bn'] ;?></option>-->
										<?php
											}
											mysqli_free_result($result_sub);
										?>
											<div class="clearfix"></div>
											<button class="btn btn-info delete-btn">Delete Selected</button>
										</div>
									<?php
										}
										mysqli_free_result($result_main);
									?>
									</div>
									
									
									<script>
										$('.delete-btn').click(function(){
											var checked = []
											$("input[name='delSub[]']:checked").each(function (){
													checked.push(parseInt($(this).val()));
											});
											var checkst	= checked.join(',');
											window.location='?delete='+checkst;
										});
											
										function showSub(main) {
											<?php
												$result_main		= get_menu();
												foreach ($result_main as $row_main) {
													$main	= $row_main['main'];
											?>
												if (main == '<?php echo addslashes($main) ; ?>'){
														document.getElementById('subLabel').style.display='block';
														document.getElementById('<?php echo addslashes($main) ; ?>-products').style.display='block';
													<?php
														$get_main		= "SELECT main FROM procat WHERE main != '".addslashes($main)."' GROUP BY main";
														$result_main	= $conn->query($get_main);
														
														while($row_main = $result_main->fetch_array()) {
															$main	= $row_main['main'];
													?>
														document.getElementById('<?php echo addslashes($main); ?>-products').style.display='none'; 
													<?php
														}
														mysqli_free_result($result_main);
													?>
												}
											<?php
												}
											?>
										}
									</script>
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
