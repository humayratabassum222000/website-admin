<?php
	include "includes/header.php"; 
?>
<?php 
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$prid					= mysqli_real_escape_string($conn, $_POST['pid']);
		$fields['name']			= mysqli_real_escape_string($conn, $_POST['pname']);
		$fields['brand']		= mysqli_real_escape_string($conn, $_POST['brand']);
		
		$size					= isset($_POST['size']) ? $_POST['size'] : null;
		
			if($size != null) {
				$fields['size']			= implode(',', $size);
			} else {
				$fields['size']			= null;
			}

		
		$size	= isset($_POST['size']) ? $_POST['size'] : null;
		
			if(!empty($size)) {
				$fields['size']			= implode(',', $size);
			} else {
				$fields['size']			= null;
			}

		
		$color	= isset($_POST['color']) ? $_POST['color'] : null;
		
			if(!empty($color)) {
				$fields['colors']	= implode(',', $color);
				$color_count		= count($color);
				
				$imageField	= "";
				for($i	= 0; $i < $color_count; $i++) {
					$each_color_name	= $color[$i];
					$each_color_count	= count($_FILES["{$each_color_name}pr_img"]['name']);

						if($i == $color_count-1) {
							$imageField	.= $each_color_count;
						} else {
							$imageField	.= $each_color_count.',';
						}
					if(!empty($_FILES[$each_color_name."pr_img"]['name'])){
						$fields['images']	= $imageField;
						for($j = 1; $j <= $each_color_count; $j++){
							$imageArray	= $j-1;
							upload_image($each_color_name."pr_img", $imageArray, "../proimg/{$prid}", "../proimg/{$prid}/{$each_color_name}{$j}.jpg");
						}
					}
				}
			} else {
				$fields['colors']	= null;
				
				if(!empty($_FILES["pr_img"]['name'])) {
					deleteDir("../proimg/{$prid}");
					$fields['images']	= count($_FILES["pr_img"]['name']);
					for($j = 1; $j <= $fields['images']; $j++){
						$imageArray	= $j-1;
						upload_image("pr_img", $imageArray, "../proimg/{$prid}", "../proimg/{$prid}/{$j}.jpg");
					}
				}
			}
		
		

		
		$fields['description']	= mysqli_real_escape_string($conn, $_POST['pdis']);
		$fields['price']		= mysqli_real_escape_string($conn, $_POST['pprice']);
		$fields['views']		= 0;
		$fields['discount']		= mysqli_real_escape_string($conn, $_POST['pdiscount']);
		

		$fields['date_added']	= date('Y-m-d');
		$fields['item_left']	= mysqli_real_escape_string($conn, $_POST['pstock']);
		
		$sql	= UpdateTable('products',$fields," id = '{$prid}' ");
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Updated Product');
		} else {
			adminMessage('red', $conn->error);
		} 
	}
	
?>

		<div class="main-grid">
			<div class="agile-grids">	
				<div class="grids">
					<div class="progressbar-heading grids-heading">
						<h2>Update Products</h2>
					</div>
					
					<div class="forms-grids">
						<div class="w3agile-validation">
							<div class="panel panel-widget agile-validation">
								<div class="my-div">
									<form enctype="multipart/form-data" method="post" action="" class="valida" autocomplete="on" novalidate="novalidate">
									
									<!-------------------------------
									-------- Query Section -------->
									<div id="product-query">
										<label for="field-1">Select Folder</label>
										<div class="form-group selection-buttons">
											<?php
												$main_i				= 1;
												$result_main		= get_menu();
												
												while($row_main = $result_main->fetch_array()) {
											
											?>
												<input type="button" data-category-id="<?php echo $main_i; ?>" value="<?php echo htmlspecialchars($row_main['main']) ?>" class="btn btn-danger folder-btn"/>
											<?php
													$main_i++;
												}
												mysqli_free_result($result_main);
											?>
										</div>
										
										<label id="subLabel" style="display: none;">Select Product Name</label>
										<div class="form-group">
										<?php
											$sub_i				= 1;
											$result_main		= get_menu();
											
											while($row_main = $result_main->fetch_array()) {
										
										?>
											<select id="<?php echo $sub_i."-sub" ;?>" style="display: none" class="form-control sub-select">
												<option selected="true"> Select Product</option>
												
											<?php
												$result_products		= get_products(''.addslashes($row_main['main']).'');
												
												while($row_products = $result_products->fetch_array()) {
											
											?>
											
												<option value="<?php echo $row_products['id'] ;?>"><?php echo $row_products['name'] ;?> - <?php echo $row_products['id'] ;?></option>
											
											<?php
												}
												mysqli_free_result($result_products);
											?>
											</select>
										<?php
												$sub_i++;
											}
											mysqli_free_result($result_main);
										?>
										</div>

										<p> &nbsp; </p>
										
										<label for="field-3">Or, Enter Product ID</label>
										<div class="form-group">
											<input type="text" name="pid" id="field-1-id" class="form-control" placeholder="Please Enter Your Product Id To Update" onkeyup="getProduct(this.value)">
										</div>
										
										<p><span style="color: red;display:none;font-size: 13px;" class="not-found">* No Product Found</span></p>
										
										<p style="text-align: center;"><img src="images/giphy.gif" alt="" class="checking" style="display: none; width: 50px"/></p>
									</div>
									<!--------------------------------------
									------- End Query Section ------------->
									
									<div id="q-product-details" >
										<label for="field-1-2">Product Name</label>
										<div class="form-group">
											<input type="text" name="pname" required="true" id="field-1-2" class="form-control" placeholder="Enter Product Name Here...">
										</div>

										<label for="field-1-3">Brand</label>
										<div class="form-group">
											<input type="text" name="brand" id="field-1-3" class="form-control"  placeholder="Enter Product Brand Here..."/>										
										</div>
										
										<label for="field-1-4">Description</label>
										<div class="form-group">
											<textarea name="pdis" id="field-1-4" required="true" class="form-control" style="height:100px;"></textarea>
										</div>
										
										<label for="field-1-5-1">Price</label>
										<div class="input-group wow fadeInUp animated" data-wow-delay=".5s">
											<input type="number" name="pprice" id="field-1-5-1" class="form-control" required="true" placeholder="Enter Product Price Here..." aria-describedby="basic-addon2">
											<span class="input-group-addon" id="basic-addon2"><?php echo $currency; ?></span>
										</div>
										
										<label for="field-1-7">Available Colors&nbsp;<span class="at-required-highlight">*</span></label>
										<div class="form-group">
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="red"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="orange"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="yellow"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="green"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="cyan"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="blue"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="indigo"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="violet"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="purple"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="magenta"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="pink"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="brown"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="white"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="black"></label></div>
											<div class="checkbox-inline"><label class="ava-color"><input type="checkbox" name="color[]" value="skyblue"></label></div>
										</div>
										

										<div class="row">
											<div class="product-image">
												<div class="col-xs-12 col-sm-6 proimg-md" id="proimg1">
													<label for="input-b0" class="control-label">Product Image <span class="image-size">(Size: 960&times;1280)</span></label>
													<input id="input-b0" name="pr_img[]" type="file" class="file" multiple
														data-show-upload="false" data-name="pr_img[]"
														data-show-caption="true" 
														data-msg-placeholder="Select {files} for upload..." />
												</div>
											</div>
											<div class="clearfix"></div>
											<p> &nbsp; </p>
										</div>
										
										<label for="field-1-7">Available Size&nbsp;<span class="at-required-highlight">*</span></label>
										<div class="form-group">
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="XS" id="checkboxXS"> XS</label></div>
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="S" id="checkboxS"> S</label></div>
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="M" id="checkboxM"> M</label></div>
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="L" id="checkboxL"> L</label></div>
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="XL" id="checkboxXL"> XL</label></div>
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="XXL" id="checkboxXXL"> XXL</label></div>
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="2-4 Years" id="checkbox2-4"> 2-4 Years Kids</label></div>
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="4-6 Years" id="checkbox4-6"> 4-6 Years Kids</label></div>
											<div class="checkbox-inline"><label class="ava-size"><input type="checkbox" name="size[]" value="6-8 Years" id="checkbox6-8"> 6-8 Years Kids</label></div>
										</div>
										
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<label for="field-1-8">Discount</label>
												<div class="input-group wow fadeInUp animated" data-wow-delay=".5s">
													<input type="number" min="0" max="100" name="pdiscount" required="true" id="field-1-8" class="form-control" placeholder="Enter Discount Here..." aria-describedby="basic-addon2">
													<span class="input-group-addon" id="basic-addon2">%</span>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<label for="field-1-9">Item In Stock</label>
												<div class="input-group wow fadeInUp animated" data-wow-delay=".5s">
													<input type="number" min="0" name="pstock" required="true" id="field-1-9" class="form-control" placeholder="Enter Stock Here..." aria-describedby="basic-addon2">
													<span class="input-group-addon" id="basic-addon2">Pcs</span>
												</div>
											</div>
											<div class="clearfix"></div>
											<p> &nbsp; </p>
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
		</div>
		
		<script type="text/javascript" src="js/valida.2.1.6.min.js"></script>
		<script type="text/javascript" >
			$(document).ready(function() {
				$('.valida').valida();
			});
		</script>
		<script src="js/validator.min.js"></script>
		<script type="text/javascript" src="js/summernote.js"></script>
		
<?php
	include "includes/footer.php";
?>
