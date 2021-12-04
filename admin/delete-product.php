<?php
	include "includes/header.php"; 
?>
<?php 
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$prid	= mysqli_real_escape_string($conn, $_POST['pid']);
		if(!file_exists) {
			unlink("../proimg/{$prid}");
		}
		
		$sql	= DeleteTable('products'," id = '{$prid}' ");
		
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Deleted Product');
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
												$result_main		= get_menu();
												
												while($row_main = $result_main->fetch_array()) {
											
											?>
											
												<input type="button" id="res-1-<?php echo htmlspecialchars($row_main['main']) ?>" value="<?php echo htmlspecialchars($row_main['main']) ?>" class="btn btn-danger" onclick="showProducts('<?php echo htmlspecialchars(addslashes($row_main['main'])); ?>')"/>
											
											<?php
												}
												mysqli_free_result($result_main);
											?>
										</div>
										
										<label id="subLabel" style="display: none;">Select Product Name</label>
										<div class="form-group">
										<?php
											$result_main		= get_menu();
											
											while($row_main = $result_main->fetch_array()) {
										
										?>
											<select onchange="updateProductId(this.value)" id="<?php echo htmlspecialchars($row_main['main'])."-products" ;?>" style="display: none" class="form-control" onchange="selectSub(this)">
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
										
										<script>
											//Onchang event from select product
											function updateProductId(prid) {
												$('#field-1-id').val(prid);
												getProduct(prid);
												showDetails();
											}
											
											//Onkeyup event from enter product id
											function getProduct(value) {
												$('.checking').show();
												$('.not-found').hide();
												
												$.post("update-product-1.php",{
													prid: value,
												},
												function(data, status){
													if(data == 0) { 
														$('.not-found').show();
														$('.checking').hide();
														hideDetails();
													}
													else {
														$('.not-found').hide();
														$('.checking').hide();
														
														var result 	= data.split(',');
														
														$('#field-1-2').val(result[0]); 
														$('#field-1-4').val(result[2]); 
														
														showDetails();
													}
												});
											}
											
											function showProducts(main) {
												<?php
													$get_main		= "SELECT main FROM procat GROUP BY main";
													$result_main	= $conn->query($get_main);
													
													//while($row_main = $result_main->fetch_array()) {
													foreach ($result_main as $row_main) {
														$main	= $row_main['main'];
												?>
												
													if (main == '<?php echo mysqli_real_escape_string($conn, $main); ?>'){
																document.getElementById('subLabel').style.display='block';
																document.getElementById('<?php echo mysqli_real_escape_string($conn, $main); ?>-products').style.display='block';
														
														<?php
															$get_main		= "SELECT main FROM procat WHERE main != '".mysqli_real_escape_string($conn, $main)."' GROUP BY main";
															$result_main	= $conn->query($get_main);
															
															while($row_main = $result_main->fetch_array()) {
																$main	= $row_main['main'];
																
														?>														
														
																document.getElementById('<?php echo mysqli_real_escape_string($conn, $main); ?>-products').style.display='none'; 
														
														<?php
															}
															mysqli_free_result($result_main);
														?>
																
													}
													
												<?php
													}
												?>
											}
											function showDetails() {
												$('#q-product-details').fadeIn();
											}
											function hideDetails() {
												$('#q-product-details').hide();
											}
										</script>
									</div>
									<!--------------------------------------
									------- End Query Section ------------->
									
									<div id="q-product-details" >
									
										<label for="field-1-2">Product Name</label>
										<div class="form-group">
											<input type="text" name="pname" required="true" id="field-1-2" class="form-control disabled" placeholder="Enter Product Name Here..." disabled>
										</div>
										
										<label for="field-1-4">Description</label>
										<div class="form-group">
											<textarea name="pdis" id="field-1-4" required="true" class="form-control disabled" style="height:100px;" disabled></textarea>
										</div>
										
										
										<hr/>
										<p>
											<input type="submit" name="sub-1" value="Delete" class="btn btn-warning">
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
