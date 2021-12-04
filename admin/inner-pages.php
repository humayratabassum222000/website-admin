<?php
	include "includes/header.php";
?>
<?php  
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$id	= $_POST['id'];
		$fields['header']	= mysqli_real_escape_string($conn, $_POST['header']);
		$fields['content']	= mysqli_real_escape_string($conn, $_POST['content']);

		$sql	= UpdateTable('page_contents',$fields,"id='{$id}'");
			
		if($conn->query($sql) == true) {
			adminMessage('green', 'Successfully Updated Page Content');
		} else {
			adminMessage('red', $conn->error);
		}
	}
	
	$result_page	= get_inner_page();
	
?>

		<div class="main-grid">
			<div class="agile-grids">	
				<!-- validation -->
				<div class="grids">
					<div class="progressbar-heading grids-heading">
						<h2>Inner Page Contents</h2>
					</div>
					<div class="forms-grids">
						<div class="w3agile-validation">
							<div class="panel panel-widget agile-validation">
								<div class="my-div">
								<?php 
									while($row_pages = $result_page->fetch_array()) {
								?>
								
									<form enctype="multipart/form-data" method="post" action="" class="valida" style="box-shadow: 0px 0px 5px #ccc; padding: 10px; margin: 20px 0px;">
										<input type="hidden" name="id" value="<?php echo $row_pages['id']; ?>" />
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Page Name</label>
													<input type="text" name="header" value="<?php echo ucfirst($row_pages['page']); ?>" class="form-control" required disabled />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Header</label>
													<input type="text" name="header" value="<?php echo $row_pages['header']; ?>" class="form-control" required />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Content</label>
											<textarea rows="5" name="content" class="form-control content-codes" required><?php echo $row_pages['content']; ?></textarea>
										</div>

										<p>
											<input type="submit" name="sub-1" value="Update" class="btn btn-primary">
										</p>
									</form>
									
								<?php 
									}
									mysqli_free_result($result_page);
								?>
									<div class="clearfix"></div>
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
				$('.form-control.content-codes').summernote({
					height: 300,
					tabsize: 2
				});
			});
		</script>
<?php
	include "includes/footer.php";
?>
