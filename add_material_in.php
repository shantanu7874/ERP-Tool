<?php include "header.php"  ?>
	
<?php
	
$db = new Database;
	$ssql = 'SELECT * FROM materials';
	$resul = mysqli_query($db->getConnection(), $ssql);

	$sqll = 'SELECT * FROM supplier';
	$resultt = mysqli_query($db->getConnection(), $sqll);

	
	$button = "Add";
	$submitVal = "addMaterial_in";
	$supplier_name = '';
	$bill_no= " ";
	$id = 0;
	$payment = '';

	if (!empty($_REQUEST['id'])) {
		$button = "Update";
		$submitVal = "updateMaterial_in";
		$sql = "SELECT * FROM materials_in where id = '".$_REQUEST['id']."'";
		$result = mysqli_query($db->getConnection(),$sql);
		$row = mysqli_fetch_assoc($result);
		$supplier_name = $row['supplier_name'];
		$bill_no = " ";
		$payment = $row ['payment'] ;
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
	              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
		          		<form action="controller/material_in.php" method="post" enctype="multipart/form-data">
		          			<span><?php if(!empty($_SESSION['mssg'])) { echo $_SESSION['mssg']; unset($_SESSION['mssg']); } ?></span><br>
		          			<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label for="validationServer013">Supplier name</label>
			      							<select type="text" class="form-control" name="supplier_id" id="name">
							    		 				<?php while($row=mysqli_fetch_assoc($resultt)) { ?>
							    					<option value="<?php echo $row['id'] ?>"><?php echo $row ['supplier_name']; ?></option>
							   							 <?php } ?>
						    					</select>
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label >Bill No.</label>
		      								<input class="form-control" type="text" name="bill_no" id="bill">
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6">
		    								<label>Payment</label>
		    									
							        			<select class="form-control" type="text"  value="" name="payment">
							     						<option>Cash</option>
							     						<option>Cheque</option>
							     						<option>A/c Transfer</option>
							     						<option>UnPaid</option>
						     						</select><br>
							    				
					    				</div>
		    						</div>
		    						
		    							
		    						<div>	
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label for="">Material name</label>
		      							<select class="form-control" name="materials_id[]">
				     					<?php while($rov=mysqli_fetch_assoc($resul)) { ?>
			     							<option value="<?php echo $rov['id'] ?>"><?php echo $rov['name']; ?></option>
			     							<?php } ?>
								     	</select>
		    							</div>
		    							<div class="col-md-6 mb-2">
		     								<label for="">HSN No.</label>
		     									<input class="form-control alphnumOnly" type="text" id="hsn_no" name="hsn_no[]" size="15">
		    							</div>
		    							</div>
		    							<div class="row">
			    							<div class="col-md-6 mb-2">
			    								<label>QTY</label>
			    								<input class="form-control numOnly" id="qty" type="text" name="qty[]" size="10" >
			    							</div>
			    							<div class="col-md-6 mb-2"> 
			    								<label>Amount</label>
			    									<input class="form-control numOnly" type="text" id="amt" name="amt[]" size="8" >
			    							</div>
			    						</div>
		    						</div>
		    						<div class="row">
			    						<div id="new_chq" style="margin-top:20px"></div>
						     				<div class="clearfix"> </div>
						     				<input type="hidden" value="1" id="total_chq"><br>
						     				<button type="button" class="add btn-sm btn-outline-success com-btn ">+</button>
											<button type="button" class="remove btn-sm btn-outline-danger com-btn">-</button><br>
										</div>
										<div class="row">
											<input type="hidden" name="submitVal" value="<?php echo $button; ?>">
												<input type="hidden" name="id" value="<?php echo $id; ?>" >
												<?php if(isset($_SESSION['err_mssg'])) { echo $_SESSION['err_mssg']; unset($_SESSION['err_mssg']);} ?>
												<br>
												<button class="btn btn-primary" name="submit" value="<?php echo $submitVal; ?>" type="submit"><?php echo $button; ?> </button>
										</div>
									</form>
								</div>	
		    			</div>
						</div>
       	</div>
      </div>
    </section> 	 
</div>

<?php include "footer.php" ?>

<script type="text/javascript">
	 	$('.add').on('click', add);
		$('.remove').on('click', remove);

		function add() {
		  var new_chq_no = parseInt($('#total_chq').val()) + 1;
			var mat;
		
			$.ajax({
		 		url: "controller/ajaxController.php?getType=materials",
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
		 			
	 				 var new_input = "<div class='form-inline mar-t-20'  id='new_" + new_chq_no + "'   ><div class='form-group'><label class='pad-right-5' for='materialname'>Material name: </label> <select class='form-control' name='material_id[]'>"+b+"</select> </div><div class='form-group'><label class='pad-right-5'>HSN NO.</label> <input class='form-control alphnumOnly' type='text'id='hsn_no' name='hsn_no[]' size='15' > </div><div class='form-group'><label class='pad-right-5'>Qty:</label> <input class='form-control numOnly' type='text' id='qty' name='qty[]'size='10' ></div><div class='form-group'><label class='pad-right-5'>Amount:</label> <input class='form-control numOnly' type='text' id='amt' name='amt[]' size='8' ></div></div>" ;
 
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

<script type="text/javascript">
    $(function() {
        $('#onSubmit').click(function(){
            var bill_no = $('#bill_no').val();
            var hsn_no = $('#hsn_no').val();
            var qty = $('#qty').val();

            if (bill_no == 0) {
                $('#mssg').text("Product Name Required")
            }
            if (hsn_no == 0) {
                $('#mssg').text("HSN No. Required")
            }
            if (qty == 0) {
                $('#mssg').text("QTY Required")
            }

        })
        
    })
$('.numOnly').keypress(function (e) {
            var regex = new RegExp("^[0-9.]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
            e.preventDefault();
            $('.error').show();
            $('.error').color();
            $('.error').text('Please Enter numbers');
            return false;
            }
        });

$('.txtOnly').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
            e.preventDefault();
            $('.error').show();
            $('.error').color();
            $('.error').text('Please Enter Alphabate');
            return false;
            }
        });

 $('.alphnumOnly').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z0-9,]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
            e.preventDefault();
            $('.error').show();
            $('.error').color();
            $('.error').text('Please Enter Alphabate');
            return false;
            }
        });

</script>