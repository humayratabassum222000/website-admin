<?php
ob_start();
include "includes/header.php"; 
?>

<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#table').basictable();
		if(window.location.hash) {
			var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
			$('#'+hash).css('border','2px solid red');
			$('#'+hash).css('box-shadow','inset 0px 0px 10px red');
		}
	});
</script>

<div class="main-grid">
	<div class="agile-grids">	
		<div class="table-heading">
			<h2>All Products</h2>
		</div>
		<div class="agile-tables">
			<div class="w3l-table-info">

				<?php 
				$page 		= isset($_GET["page"]) ? $_GET["page"]:1 ;
				if( $page <= 0 ) {
					echo "<center> <span style=\"color: red; font-size: 30px;\">Invalid Page Number !</span></center>";
					exit;
				} else {
					$page2 		= 	$page*40;
					$offset1 	=	$page2-40;
				}

				$sql	= "SELECT * FROM products ORDER BY id DESC LIMIT 40 OFFSET {$offset1}";
				$result	= $conn->query($sql);

				$total_products	= $conn->query("SELECT * FROM products")->num_rows;
				$last_page		= $total_products/40;

				if(is_float($last_page)) {
					$last_page		= intval($last_page);
					$last_page		= $last_page+1;
				}


				?>
				<style>
					table {
						width: 100%;
					}
					table tr th, table tr td {
						padding: 2px 5px;
					}
					table tr th {
						background: #B5FCFF;
					}
					p.paging {
						float: right;
					}
					p span {
						padding: 5px 10px;
					}
				</style>
				<h2> Total <span style="color: green;" ><?php echo $total_products; ?></span> products Found </h2>
				<a href="index.php">Go Back</a><br/>

				<label> Enter Id: <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Filter by id" style="width: 400px; height: 30px; padding: 0px 5px;"></label> <br/><br/>
				<table id="myTable" width="100%" style="border-collapse: collapse;" border="1">
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Category </th>
						<th>Sub Category </th>

						<th>Price </th>
						<th>Discount </th>
						
						<th>Item Left </th>
						<th>Action </th>
					</tr>
					<?php
					while($row	= $result->fetch_array()) {
						?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['category']; ?></td>
							<td><?php echo $row['subcategory']; ?></td>


							<td><?php echo $row['price']; ?></td>
							<td><?php echo $row['discount']; ?></td>
							
							<td><?php echo $row['item_left']; ?></td>
							<td><a href="<?php echo $base; ?>/details/<?php echo $row['category']; ?>/<?php echo $row['id']; ?>">View</a></td>
						</tr>
						<?php 
					}
					mysqli_free_result($result);
					?>
				</table>

				<script>
					function myFunction() {
						var input, filter, table, tr, td, i;
						input = document.getElementById("myInput");
						filter = input.value.toUpperCase();
						table = document.getElementById("myTable");
						tr = table.getElementsByTagName("tr");
						for (i = 0; i < tr.length; i++) {
							td = tr[i].getElementsByTagName("td")[0];
							if (td) {
								if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
									tr[i].style.display = "";
								} else {
									tr[i].style.display = "none";
								}
							}       
						}
					}
				</script>

				<p class="paging"><?php if($page > 1){ ?><a href="?page=<?php echo $page-1; ?>"><span class="prev">Previous</span><?php } ?></a>  <?php if($page <= $last_page-1){ ?>  <a href="?page=<?php echo $page+1; ?>"><span class="next">Next</span></a> <?php } ?></p>


				
			</div>
		</div>
		<?php
		include "includes/footer.php";
		?>