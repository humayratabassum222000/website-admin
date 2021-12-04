<?php
	include "includes/header.php";
?>
	<script src="js/raphael-min.js"></script>
	<script src="js/morris.js"></script>
	<div class="main-grid"> 
		
		
		<div class="agile-grids">
			<div class="col-md-4 charts-right">
				<div class="area-grids">
					<div class="area-grids-heading">
						<h3>Prouducts Charts</h3>
					</div>
					<div id="graph4"></div>
					<script>
						Morris.Donut({
						  element: 'graph4',
						  data: [
						  
						<?php
							$main	 	= get_menu();
							$total_main	= $main->num_rows;
							$i 			= 1;
							
							while($row_main	= $main->fetch_array()) {
								$result_products	= get_products(''.addslashes($row_main['main']).'');
								$num_products		= $result_products->num_rows;
																	
						?>
						
							<?php
								if($i == $total_main) {
							?>
						
							{value: <?php echo $num_products ?>, label: '<?php echo addslashes($row_main['main']); ?>', formatted: '<?php echo $num_products ?>' }
						
							<?php
								} else {
							?>
						
							{value: <?php echo $num_products ?>, label: '<?php echo addslashes($row_main['main']); ?>', formatted: '<?php echo $num_products ?>' },
						
						<?php	
								}
							$i++;
							}
							mysqli_free_result($main);
						?>
						
						  ],
						  formatter: function (x, data) { return data.formatted; }
						});
					</script>

				</div>
			</div>
			<!--<div class="col-md-8 chart-left">
				<div class="agile-Updating-grids">
					<div class="area-grids-heading">
						<h3>Updating data</h3>
					</div>
					<div id="graph1"></div>
					<script>
					var nReloads = 0;
					function data(offset) {
					  var ret = [];
					  for (var x = 0; x <= 360; x += 10) {
						var v = (offset + x) % 360;
						ret.push({
						  x: x,
						  y: Math.sin(Math.PI * v / 180).toFixed(4),
						  z: Math.cos(Math.PI * v / 180).toFixed(4)
						});
					  }
					  return ret;
					}
					var graph = Morris.Line({
						element: 'graph1',
						data: data(0),
						xkey: 'x',
						ykeys: ['y', 'z'],
						labels: ['sin()', 'cos()'],
						parseTime: false,
						ymin: -1.0,
						ymax: 1.0,
						hideHover: true
					});
					function update() {
					  nReloads++;
					  graph.setData(data(5 * nReloads));
					  $('#reloadStatus').text(nReloads + ' reloads');
					}
					setInterval(update, 100);
					</script>
				</div>
			</div>-->
			<div class="clearfix"> </div>
		</div>
		
		<div class="agile-bottom-grids">
			<div class="col-md-6 agile-bottom-right">
				<div class="agile-bottom-grid">
					<div class="area-grids-heading">
						<h3>Today Added Products</h3>
					</div>
					<div id="graph6"></div>
					<script>
					// Use Morris.Bar
					Morris.Bar({
					  element: 'graph6',
					  data: [
					  
					  <?php
							$main	 	= get_menu();
							$total_main	= $main->num_rows;
							$i 			= 1;
							
							while($row_main	= $main->fetch_array()) {
								$result_products	= get_today_added_products(''.addslashes($row_main['main']).'');
								$num_products		= $result_products->num_rows;
																	
						?>
						
							<?php
								if($i == $total_main) {
							?>
						
							{x: '<?php echo addslashes($row_main['main']) ;?>', y: <?php echo $num_products ?>}
						
							<?php
								} else {
							?>
							
							{x: '<?php echo addslashes($row_main['main']) ;?>', y: <?php echo $num_products ?>},
						
						<?php	
								}
							$i++;
							}
							mysqli_free_result($main);
						?>
						

					  ],
					  xkey: 'x',
					  ykeys: ['y'],
					  labels: ['Y'],
					  barColors: function (row, series, type) {
						if (type === 'bar') {
						  var red = Math.ceil(255 * row.y / this.ymax);
						  return 'rgb(' + red + ',0,0)';
						}
						else {
						  return '#000';
						}
					  }
					});
					</script>
				</div>
			</div>
			<div class="col-md-6 agile-bottom-left">
				<div class="agile-bottom-grid">
					<div class="area-grids-heading">
						<h3>Ordering Details</h3>
					</div>
					<div id="graph5"></div>
					<script>
					// Use Morris.Bar
					Morris.Bar({
					  element: 'graph5',
					  data: [
					  
					<?php
						$unread_order		= get_unread_order();
						$unread_order_count	= $unread_order->num_rows;
						
						$processing_order		= get_processing_order();
						$processing_order_count	= $processing_order->num_rows;
					?>
					<?php
						$result_order	= get_order(10000000000);
						$order_count	= $result_order->num_rows;
					?>
					  
						{x: 'Total Order', y: 0, z: 0, a: <?php echo $order_count ; ?>},
						{x: 'Reviewed', y: <?php echo ($order_count-$unread_order_count) ; ?>, z: 0, a: 0},
						{x: 'Unreviwed', y: 0, z: <?php echo $unread_order_count ; ?>, a: 0},
						{x: 'Processing', y: 0, z: 0, a: <?php echo $processing_order_count ; ?>}
					  ],
					  xkey: 'x',
					  ykeys: ['y', 'z', 'a'],
					  labels: ['Y', 'Z', 'A'],
					  stacked: true
					});
					</script>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
		
	</div>	
		
<?php
	include "includes/footer.php";
?>