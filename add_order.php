<?php include "header.php"  ?>
	
<?php
	
$db = new Database;
	$sql_c = 'SELECT * FROM customers';
	$resultt = mysqli_query($db->getConnection(), $sql_c);

	$sql_p = 'SELECT * FROM product';
	$resul = mysqli_query($db->getConnection(), $sql_p);

	$sql = 'SELECT * FROM users';
	$result = mysqli_query($db->getConnection(), $sql);

	$button = "Add";
	$submitVal = "addOrders";
	$customer_id = ' ';
	$gst_no=' ';
	$packets= ' ' ;
	$id = 0;
	$address = ' ';

	if (!empty($_REQUEST['id'])) {
		$button = "Update";
		$submitVal = "updateOrders";
		$sql = "SELECT * FROM orders where id = '".$_REQUEST['id']."'";
		$result = mysqli_query($db->getConnection(),$sql);
		$row = mysqli_fetch_assoc($result);
		$customer_id = $row['customer_id'];
		$order_date=$row['order_date'];
		$deadline =$row ['deadline'];
		$packets = $row ['packets'] ;
		$id = $row ['id'];
			
	}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   		<!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-6">
	            <h1 class="m-0"> <?php echo $button; ?> </h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">
	            <ol class="breadcrumb float-sm-right">
	              <li class="breadcrumb-item"><a href="#">Home</a></li>
	              <li class="breadcrumb-item active"><?php echo $button; ?> </li>
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
         	<!-- Add Product Begins here -->
          	<div class="col-md-8">
         			<div class="card ">
         				<div class="card-body">
		          		<form action="controller/orders.php" method="post" enctype="multipart/form-data">
		          			<span><?php if(!empty($_SESSION['mssg'])) { echo $_SESSION['mssg']; unset($_SESSION['mssg']); } ?></span><br>
		          			<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label for="">Customer name</label>
			      							<select type="text" class="form-control" name="customer_id" id="name">
							    		 				<?php while($row=mysqli_fetch_assoc($resultt)) { ?>
							    					<option value="<?php echo $row['id'] ?>"><?php echo $row ['customer_name']; ?></option>
							   							 <?php } ?>
						    					</select>
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label >Add Order</label>
		      								<button type="button" class="add btn-sm btn-outline-success com-btn ">+</button>
													<button type="button" class="remove btn-sm btn-outline-danger com-btn">-</button>
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6">
		    								<label>Product Name</label>
							        		<select class="form-control" name="product_id[]">
					     							<?php while($rov=mysqli_fetch_assoc($resul)) { ?>
				     								<option value="<?php echo $rov['id'] ?>"><?php echo $rov['product_name']; ?></option>
				     								<?php } ?>
									     		</select><br>	
					    				</div>
										<div class="row">
		    							<div class="col-md-6">
		    								<label>Packets</label>
							        		<input type="number" class="form-control " name="packets[]" id="" size="5" >
					    				</div>
		    						</div>	
		    						<!-- <div>	
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								
		      							<table width="100%">
													<thead>
														<th class="width-200"><lable>Available in Quantities</lable><br></th>
														<th><label>Packets</label></th>
													</thead>
													<tr>
														<td><input id="aiq1001" onclick="onAiqCheck(100, 1)" type="checkbox" name="aiq1[]" value="100"> 100 &nbsp; &nbsp; </td>
														<td><input disabled id="packets1001" class="form-control hide" type="number" name="packets1[]"  ></td>
													</tr>
													<tr>
														<td><input id="aiq2001" onclick="onAiqCheck(200, 1)" type="checkbox" name="aiq1[]" value="200"> 200  &nbsp; &nbsp; </td>
														<td><input disabled id="packets2001" class="form-control hide" type="text" name="packets1[]"  ></td>
													</tr>
													<tr>
														<td><input id="aiq5001" onclick="onAiqCheck(500, 1)" type="checkbox" name="aiq1[]" value="500" > 500  &nbsp; &nbsp; </td>
														<td><input disabled id="packets5001" class="form-control hide" type="text" name="packets1[]" ></td>
													</tr>
													<tr>
														<td><input id="aiq10001" onclick="onAiqCheck(1000, 1)" type="checkbox" name="aiq1[]" value="1000"> 1000  &nbsp; &nbsp; </td>
														<td><input disabled id="packets10001" class="form-control hide" type="text" name="packets1[]" ></td>
													</tr>
												</table>
		    							</div>
		    						</div>	 -->
									<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<div class="clearfix"> </div>
						     					<input type="hidden" value="1" id="total_chq"><br>
		    								</div>
		    							</div>
										<div class="col-md-12">
											<div class=" mr-t-20" id="new_chq" style="margin-top:20px"></div>
										</div>
									</div>
									<div>	
										<div class="col-md-6 mb-2"> 
											<label>Deadline</label>
												<input type="date" class="form-control" name="deadline" value="<?php echo $deadline ?>">
										</div>
									 </div>	
			    							<div>
			    								<input type="hidden" name="submitVal" value="<?php echo $button; ?>">
													<input type="hidden" name="id" value="<?php echo $id; ?>" >
													<?php if(isset($_SESSION['err_mssg'])) { echo $_SESSION['err_mssg']; unset($_SESSION['err_mssg']);} ?><br>
													<button class="btn btn-primary" name="submit" value="<?php echo $submitVal; ?>" type="submit"><?php echo $button; ?> </button>
									</form>
			    							</div>
			    						</div>
		    						</div>
		    						
								</div>	
		    			</div>
						</div>
       	</div>
      </div>
    </section> 	 
</div>

<script type="text/javascript">
	function onAiqCheck(val, i) {
		var inputId = "aiq"+val+i;
		var check = document.getElementById(inputId).checked;
		if(check) {
			document.getElementById("packets"+val+i).disabled = false;
			document.getElementById("packets"+val+i).style.color = 'green';
		} else {
			document.getElementById("packets"+val+i).disabled = true;
			document.getElementById("packets"+val+i).value = "";
			document.getElementById("packets"+val+i).style.color = 'green';
		}
	}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src="js/javascript.js"></script> -->

<script type="text/javascript">
	 	$('.add').on('click', add);
		$('.remove').on('click', remove);

		function add() {
		  var new_chq_no = parseInt($('#total_chq').val()) + 1;
		  var mat;
			$.ajax({
		 		url: "controller/ajaxController.php?getType=product",
		 		type: 'GET',
		 		success: function(response) {
		 			var b = '';
		 			// Convert string response into json format. using below code
		 			mat = jQuery.parseJSON(response);

		 			for(var i=0; i<mat.length; i++) {
		 			  var a = "<option value='"+mat[i].id+"' >"+mat[i].name+"</option>";
		 			//  console.log(a);
		 			  b = b.concat(a);
		 			  console.log(b);
		 			}
					 var new_input = "<div class='row'  id='new_" + new_chq_no + "'><div class='col-md-6 mb-2'><label>Product name</label> <select class='form-control' name='product_id[]'>"+b+"</select> </div><div class='row'><div class='col-md-6'><label>Packets</label><input type='number' class='form-control' name='packets[]' size='5' ></div></div>"

	 				//   var new_input = "<div class='form-inline mar-t-20 '  id='new_" + new_chq_no + "'><div class='form-group'><label class='pad-right-5' for='materialname'>Product name: </label> <select class='form-control' name='product_id[]'>"+b+"</select> </div><div class='form-group'><table width='100%'><thead><th class='width-200'><lable>Available in Quantities</lable><br></th><th><label>Packets</label></th></thead><tr><td><input id='aiq100"+new_chq_no+"' onclick='onAiqCheck(100, "+new_chq_no+")' type='checkbox' name='aiq"+new_chq_no+"[]' value='100'> 100 &nbsp; &nbsp; </td><td><input disabled id='packets100"+new_chq_no+"' class='form-control hide' type='number' name='packets"+new_chq_no+"[]' ></td></tr><tr><td><input id='aiq200"+new_chq_no+"' onclick='onAiqCheck(200, "+new_chq_no+")' type='checkbox' name='aiq"+new_chq_no+"[]' value='200'> 200  &nbsp; &nbsp; </td><td><input disabled  id='packets200"+new_chq_no+"' class='form-control hide' type='text' name='packets"+new_chq_no+"[]' ></td></tr><tr><td><input id='aiq500"+new_chq_no+"' onclick='onAiqCheck(500, "+new_chq_no+")'' type='checkbox' name='aiq"+new_chq_no+"[]' value='500' > 500  &nbsp; &nbsp; </td><td><input disabled id='packets500"+new_chq_no+"' class='form-control hide' type='text' name='packets"+new_chq_no+"[]'></td></tr><tr><td><input id='aiq1000"+new_chq_no+"' onclick='onAiqCheck(1000, "+new_chq_no+")' type='checkbox' name='aiq"+new_chq_no+"[]' value='1000'> 1000  &nbsp; &nbsp; </td><td><input  disabled id='packets1000"+new_chq_no+"' class='form-control hide' type='text' name='packets"+new_chq_no+"[]'></td></tr></table></div>";
					  $('#new_chq').append(new_input);
						  
						  $('#total_chq').val(new_chq_no);
				}
	 		});
		}
	 		function remove() {
			  var last_chq_no = $('#total_chq').val();

			  if (last_chq_no > 1) {
		    	$('#new_' + last_chq_no).remove();
		    	$('#total_chq').val(last_chq_no - 1);
		 		 }
			}
</script>

<?php include "footer.php" ?>