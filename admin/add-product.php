<?php
	include "includes/header.php";
?>
<?php  
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$fields['id']			= mysqli_real_escape_string($conn, $_POST['pid']);
		$fields['name']			= mysqli_real_escape_string($conn, $_POST['pname']);
		$fields['type']			= mysqli_real_escape_string($conn, $_POST['type']);
		$fields['category']		= mysqli_real_escape_string($conn, $_POST['category']);
		$fields['subcategory']	= mysqli_real_escape_string($conn, $_POST["subcategory"]);
		$fields['brand']		= mysqli_real_escape_string($conn, $_POST['brand']);
		
		$size					= isset($_POST['size']) ? $_POST['size'] : null;
		
			if(!empty($size)) {
				$fields['size']			= implode(',', $size);
			} else {
				$fields['size']			= null;
			}

		
		$color	= isset($_POST['color']) ? $_POST['color'] : null;
		
			if(!empty($color)) {
				$fields['colors']		= implode(',', $color);
				$color_count			= count($color);
				$fields['images']	= "";
				
				for($i	= 0; $i < $color_count; $i++) {
					$each_color_name	= $color[$i];
					$each_color_count	= count($_FILES["{$each_color_name}pr_img"]['name']);

						if($i == $color_count-1) {
							$fields['images']	.= $each_color_count;
						} else {
							$fields['images']	.= $each_color_count.',';
						}
					for($j = 1; $j <= $each_color_count; $j++){
						
						$target_path 	= "../"; 
						
						$target_path 	= $target_path  . basename( $_FILES["{$each_color_name}pr_img"]['name'][$j-1]); 
						
						if(move_uploaded_file($_FILES["{$each_color_name}pr_img"]['tmp_name'][$j-1], $target_path)) {
							//CREATE DIRECTORY IF NOT EXIXTS
							if (!file_exists("../proimg/{$fields['id']}")) {
								mkdir("../proimg/{$fields['id']}", 0777, true);
							}
							
							//RENAME AND MOVE TARGET FILE
							$file 	= basename( $_FILES["{$each_color_name}pr_img"]['name'][$j-1]);
							
							if(file_exists("{$target_path}")){
								rename("../{$file}" , "../proimg/{$fields['id']}/{$each_color_name}{$j}.jpg");
							}
						}
					}
				}
			} else {
				$fields['colors']	= null;
				$fields['images']	= count($_FILES["pr_img"]['name']);
				
				for($j = 1; $j <= $fields['images']; $j++){
					
					$target_path 	= "../"; 
					
					$target_path 	= $target_path  . basename( $_FILES["pr_img"]['name'][$j-1]); 
					
					if(move_uploaded_file($_FILES["pr_img"]['tmp_name'][$j-1], $target_path)) {
						//CREATE DIRECTORY IF NOT EXIXTS
						if (!file_exists("../proimg/{$fields['id']}")) {
							mkdir("../proimg/{$fields['id']}", 0777, true);
						}
						
						//RENAME AND MOVE TARGET FILE
						$file 	= basename( $_FILES["pr_img"]['name'][$j-1]);
						
						if(file_exists("{$target_path}")){
							//resize(19, 19, "../{$file}" , "../proimg/{$fields['id']}/{$j}");
							rename("../{$file}" , "../proimg/{$fields['id']}/{$j}.jpg");
							//watermark_image("../proimg/{$fields['id']}/{$j}.jpg",'images/stamp.png', 'images/stamp-logo.png', "../proimg/{$fields['id']}/{$j}.jpg");
						}
					}
				}
			}
		

		
		$fields['description']	= mysqli_real_escape_string($conn, $_POST['pdis']);
		$fields['price']		= mysqli_real_escape_string($conn, $_POST['pprice']);
		$fields['views']		= 0;
		$bdtDiscount			= mysqli_real_escape_string($conn, $_POST['pdiscount']);
		$fields['discount']		= ($bdtDiscount/$fields['price'])*100;
		

		$fields['date_added']	= date('Y-m-d');
		$fields['item_left']	= mysqli_real_escape_string($conn, $_POST['pstock']);
		
		

		$sql	= InsertInTable('products',$fields);
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Uploaded Product');
		} else {
			adminMessage('red', $conn->error);
		}
	}
?>

		<div class="main-grid">
			<div class="agile-grids">	
				<div class="grids">
					<div class="progressbar-heading grids-heading">
						<h2>Add Products</h2>
					</div>
					<div class="forms-grids">
						<div class="w3agile-validation">
							<div class="panel panel-widget agile-validation">
								<div class="my-div">
									<form enctype="multipart/form-data" method="post" action="" class="valida" >
										<input type="hidden" name="pid" value="<?php echo get_product_id(); ?>" id="field-1" required="true" class="form-control">
										
										<ul class="nav nav-tabs">
											<li class="active" id="step1-btn"><a>Select Category</a></li>
											<li id="step2-btn"><a>Product Details</a></li>
										 </ul>
										 
										<div class="tab-content">
											<div id="step1" class="tab-pane fade in active">
												<div class="row">
													<div class="col-xs-12 col-sm-4">
														<p><span class="badge">1</span> Select Main Category</p>
														<div class="form-group">
															<ul>
																<?php
																	$main_i	= 1;
																	$result_main	= get_menu();
																	while($row_main = $result_main->fetch_array()) {
																		$main	= $row_main['main'];
																?>
																
																<li id="m<?php echo $main_i; ?>" class="sl-main" data-main="<?php echo htmlspecialchars($main); ?>"> <?php echo htmlspecialchars(ucwords($main)); ?> <i class="fa fa-chevron-right"></i></li>
																
																<?php
																		$main_i++;
																	}
																	mysqli_free_result($result_main);
																?>
															</ul>													
														</div>
													</div>

													<div class="col-xs-12 col-sm-4">
														<p id="subLabel"><span class="badge">2</span> Select Sub Category</p>
														<div class="form-group">
														<?php
															$sub_i	= 1;
															$result_main	= get_menu();
															while($row_main = $result_main->fetch_array()) {
																$main	= $row_main['main'];
														?>
															<ul id="sm<?php echo $sub_i; ?>" class="sl-sub-ul" style="display: none;">
														<?php
																$result_sub		= get_sub_by_main($main);
																
																while($row_sub = $result_sub->fetch_array()) {
																	$sub_header	= $row_sub['header'];
																	$sub		= $row_sub['sub'];
																	$main_bn	= $row_sub['main_bn'];
														?>
																<li class="sl-sub" data-sub="<?php echo htmlspecialchars($sub); ?>"> <?php echo htmlspecialchars(ucwords($sub_header)); ?><?php if(!empty($sub)) {echo " - ".htmlspecialchars(ucwords($sub));} ?><?php if(!empty($main_bn)) {echo " - ".htmlspecialchars(ucwords($main_bn));} ?> </li>
														<?php
																}
																mysqli_free_result($result_sub);
														?>
															</ul>
														<?php
																$sub_i++;
															}
															mysqli_free_result($result_main);
														?>
														</div>
													</div>
													<div class="col-xs-12 col-sm-4">
														<p>&nbsp;</p>
														<input type="hidden" name="category" value="" />
														<input type="hidden" name="subcategory" value="" />
														
														<p class="selected-p">Selected Main Category: <span class="main"></span></p>
														<p class="selected-p">Selected Sub Category: <span class="sub"></span></p>
														<a data-toggle="tab" href="#step2" id="next-btn"><button class="btn btn-success">Continue <i class="fa fa-arrow-right"></i></button> </a>
													</div>
												</div>
											</div>
											
											<div id="step2" class="tab-pane fade">
												<ul class="list-inline">
													<li class="title"><i class="fa fa-file-text-o"></i> Category </li>
													<li><span class="main"></span> &nbsp; <i class="fa fa-arrow-right"></i></li>
													<li><span class="sub"></span> </i></li>
												</ul>

												<label for="field-1-2">Product Name</label>
												<div class="form-group">
													<input type="text" name="pname" required="true" id="field-1-2" class="form-control" placeholder="Enter Product Name Here...">
												</div>
												
												<label for="field-1-4">Description</label>
												<div class="form-group">
													<textarea name="pdis" id="field-1-4" required="true" class="form-control" style="height:100px;"></textarea>
												</div>
													
												<div class="row">
													<div class="col-md-6 col-sm-12">
														<label for="field-1-5-1">Price</label>
														<div class="input-group wow fadeInUp animated" data-wow-delay=".5s">
															<input type="number" name="pprice" id="field-1-5-1" class="form-control" required="true" onblur="if(this.value == ''){this.value='0';}" placeholder="Enter Product Price Here..." aria-describedby="basic-addon2">
															<span class="input-group-addon" id="basic-addon2"><?php echo $currency; ?></span>
														</div>
													</div>
													<div class="col-md-6 col-sm-12">
														<label for="field-1-3">Brand</label>
														<div class="form-group">
															<input type="text" name="brand" list="brand-list" class="form-control"  placeholder="Enter Product Brand Here..."/>
															<datalist id="brand-list">
																<?php 
																	$result_brands	= get_brands();
																	while($row_brands = $result_brands->fetch_array()) {
																?>
																	<option value="<?php echo $row_brands['brand']; ?>"> <?php echo $row_brands['brand']; ?> </option>
																<?php 		
																	}
																?>
															</datalist>
														</div>
													</div>
													<div class="clearfix"></div>
													<p> &nbsp; </p>
												</div>
												
												
												<label >Product Type</label>
												<div class="form-group">
												<input type="text" name="type"  id="field-1-2" class="form-control" placeholder="Enter Product type Here...">
													
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
															<input id="input-b0" name="pr_img[]" type="file" class="file" multiple required
																data-show-upload="false" data-name="pr_img[]"
																data-show-caption="true" 
																data-msg-placeholder="Select {files} for upload..." />
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
												
												<label for="field-1-7">Available Size&nbsp;<span class="at-required-highlight">*</span></label>
												<div class="form-group">
												
												    <div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="
Haley"> 
Haley</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="KG"> KG</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="XS"> XS</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="S"> S</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="M"> M</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="L"> L</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="XL"> XL</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="XXL"> XXL</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="2-4 Years"> 2-4 Years Kids</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="4-6 Years"> 4-6 Years Kids</label></div>
													<div class="checkbox-inline"><label><input type="checkbox" name="size[]" value="6-8 Years"> 6-8 Years Kids</label></div>
												</div>
												
												<div class="row">
													<div class="col-md-6 col-sm-12">
														<label for="field-1-8">Discount</label>
														<div class="input-group wow fadeInUp animated" data-wow-delay=".5s">
															<input type="number" min="0" max="100" name="pdiscount" required="true" id="field-1-8" class="form-control" value="0" onfocus="this.value=''" onblur="if(this.value == ''){this.value='0';}" aria-describedby="basic-addon2">
															<span class="input-group-addon" id="basic-addon2">BDT</span>
														</div>
													</div>
													<div class="col-md-6 col-sm-12">
														<label for="field-1-9">Item In Stock</label>
														<div class="input-group wow fadeInUp animated" data-wow-delay=".5s">
															<input type="number" min="0" name="pstock" required="true" id="field-1-9" class="form-control" value="100" onfocus="this.value=''" onblur="if(this.value == ''){this.value='100';}" aria-describedby="basic-addon2">
															<span class="input-group-addon" id="basic-addon2">Pcs</span>
														</div>
													</div>
													<div class="clearfix"></div>
													<p> &nbsp; </p>
												</div>
												
												<hr/>

												<p>
													<input type="submit" name="sub-1" value="Submit" class="btn btn-primary">
													<a href="add-product.php" class="btn btn-danger">Reset </a>
												</p>
											</div>
										</div>
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
		
		<script type="text/javascript" src="js/summernote.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#field-1-4').summernote({
					height: 300,
					tabsize: 2
				});
			});
		</script>
<?php
	include "includes/footer.php";
?>
