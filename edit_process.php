<?php include "header.php"  ?>
<?php 
	$db = new Database();
	
	/*$uni = "SELECT table1.columnnames....n, table2.columnames....n, FROM table1 
   		INNER JOIN  table2 on 
   		table1.id=table2.columnames";*/

   		$sql = "SELECT customers.customer_name,customers.gst_no,customers.contact, orders.* FROM orders INNER JOIN customers on customers.id= orders.customer_id WHERE orders.id = '".$_REQUEST ['id']." '";

   			//print_r($sql); 

   			$result = mysqli_query($db->getConnection(), $sql);
   			//print_r($result); exit();
   			$row = mysqli_fetch_assoc($result);
   			//print_r($row);
   			
   		$order_items = "SELECT order_product_items.*, product.product_name, product.aiq FROM order_product_items INNER JOIN product on order_product_items.product_id = product.id WHERE order_product_items.order_id = '".$_REQUEST['id']."' ";
   		//print_r($order_items); exit();

   		$result_o = mysqli_query($db->getConnection(),$order_items);
   		$result_p = mysqli_query($db->getConnection(),$order_items);
   			
   			//print_r($row_o); exit();
        $string_to_array_qty = [];
        $string_to_array_pkts = [];
?>


<style type="text/css">
	.table tr td, .table thead th {
		padding: 0.25rem;
		border: none;
	}
	.warning {
		background-color: orange;
		color: #fff;
	}
	.red {
		background-color: red;
		color: #fff;
	} 
	.allok {
		background-color:: green;
		color: #000;
	}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   		<!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-6">
	            <h1 class="m-0"> Shrijee Dashboard </h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">
	            <ol class="breadcrumb float-sm-right">
	              <li class="breadcrumb-item"><a href="#">Home</a></li>
	              <li class="breadcrumb-item active">Dashboard </li>
	            </ol>
	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->
	    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
						<h4>Processing Order No. <?php echo $row['id'] ?> </h4>
			<form action="controller/processing.php" method="post" enctype="multipart/form-data">
				<div class="card">
					<div class="card-body">
						<span style="float: right;">Date: <?php echo date('d-M-y', strtotime($row['order_date'])); ?></span>
						<div class="row">
							<div class="col-md-12" style="margin-bottom: 10px;">
								<strong>Customer Name:</strong>
								<span > <?php echo $row['customer_name']  ?></span>
								<input type="hidden" name="customer_id" value="<?php echo $row['id'] ?>" >	
							</div>
						</div>
						
						<?php 
							while  ($row_order = mysqli_fetch_assoc($result_o)){  ?>
									
									<div class="row">
										<div class="col-md-4">
											<label>Product Name :</label>
											<span><?php echo $row_order['product_name'] ?></span>
											
										</div>
										<div class="col-md-4">
											<!-- <label>Qty</label> -->
											<span><?php //echo $row_order['aiq'] ?></span>
											
										</div>
										<div class="col-md-4">
											<label>Packets</label>
											<span><?php echo $row_order['packets'] ?></span>
											
										</div>
									</div>				
						
						<?php } ?>			
					</div>					
				</div>
				<h4>Materials </h4>
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								
									<?php 
										$n = 0;
									 while($row_order_o = mysqli_fetch_assoc($result_p))
									{  
										$n++;
										// Calculate required product quantity in kg or g
										$aiq_arr = explode(', ', $row_order_o['aiq']);
										$packets_arr = explode(', ', $row_order_o['packets']);
										$a = 0;
										$total_product_qty = 0;
										for ($j=0; $j < count($aiq_arr); $j++) { 
											// code..
											$a = $aiq_arr[$j] * $packets_arr[$j];
											$total_product_qty = $a + $total_product_qty;

										}
										//print_r($total_product_qty); exit;
									 ?>
										<div class="card row">
											<div class="card-body"> 
											<div class="col-md-12">
												<label>Product Name:</label> <?php echo $row_order_o['product_name']; ?> 
												<span style="float:right;"><label>Total Required in Kg: </label> <?php echo ($total_product_qty/1000); ?> Kg <input type="hidden" name="product_kg[]" value="<?php echo ($total_product_qty/1000); ?>"></span>
												<input type="hidden" name="product_id[]" value="<?php echo $row_order_o['id'] ?>" >

											</div>
											<?php // print_r($row_order_o);  
											$mat_row = "SELECT * FROM product WHERE id = '".$row_order_o['product_id']."' " ;
												$result_mat = mysqli_query($db->getConnection(), $mat_row);
												$response_mat = mysqli_fetch_assoc($result_mat);
												//echo "Product Table"; print_r($response_mat); 


												$material_array = explode(', ', $response_mat['materials_id']);
												$material_percent_array = explode(', ', $response_mat['req_percentage']);
												for($i=0; $i<count($material_array); $i++) {
													$getMaterials = "SELECT * FROM materials where id = '".$material_array[$i]."'";
													$mat_avai = "SELECT SUM(qty) AS mat_qty FROM material_in_items WHERE materials_id = '".$material_array[$i]."' ";
													//print_r($mat_avai); exit();
													$result_mat_avai = mysqli_query($db->getConnection(), $mat_avai);
													$row_mat_avai = mysqli_fetch_assoc($result_mat_avai);

													$result_mat_list = mysqli_query($db->getConnection(), $getMaterials); ?>
														
														<table class="table" width="50%">
															<thead>
																<th>Material</th>
																<th>Required</th>
																<th>Available</th>
															</thead>
															<?php while($mat_rows = mysqli_fetch_assoc($result_mat_list)) { echo "<br>"; //print_r($mat_rows);
															$class = "allok";
																if($row_mat_avai['mat_qty'] < 100 && $row_mat_avai['mat_qty'] >= 50) {
																	$class = "warning";
																} elseif ($row_mat_avai['mat_qty'] < 50) {
																	// code...
																	$class = "red";
																}
																?>
															<tr>
																<td><?php echo $mat_rows['name']; ?></td>
																<input type="hidden" name="material_id<?php echo $n ?>[]" value="<?php echo $mat_rows['id'] ?>" >
																<td><?php $c = ($total_product_qty/1000)*($material_percent_array[$i] * 0.01); echo $c; ?> Kg</td>
																<input type="hidden" name="qty_used<?php echo $n ?>[]" value="<?php echo $c ?>" >
																<td class="<?php echo $class ?>"> <?php 
																 echo $row_mat_avai['mat_qty'] ?></td>
															</tr>
														<?php } ?>
														</table>
													
											<?php 	}
												
												// print_r($material_array);
											?>
										</div>
										</div>
								<?php } ?>
								
							</div>
						</div>
						
					</div>
				</div>
				<input type="hidden" name="submitVal" value="Add">
						<input type="hidden" name="order_id" value=" <?php echo $_REQUEST['id'] ?>" >
						<button class="btn btn-primary"  name="submit"  type="submit">Start Process </button>
			</form>
          </div> 
        </div>
	    </div>
	</section>
</div>


<?php include "footer.php" ?>