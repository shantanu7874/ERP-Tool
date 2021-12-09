<?php include "header.php"  ?>
	
<?php
	 
$db = new Database;

	$ssql = 'SELECT * FROM materials';
	$resul = mysqli_query($db->getConnection(), $ssql);
	$sql_cat = "SELECT * FROM category";
	$result_cat = mysqli_query($db->getConnection(),$sql_cat);

	$button = "Add";
	$submitVal = "addProduct";
	$product_name = '';
	$discount = '';
	$aiq100 = false;
	$id = 0;
	$aiq_array = [];
	$mrp_array = [];
	$product_image = '';

	if (!empty($_REQUEST['id'])) {
		$button = "Update";
		$submitVal = "updateProduct";
		$sql = "SELECT * FROM product where id = '".$_REQUEST['id']."'";
		$result = mysqli_query($db->getConnection(),$sql);
		$row = mysqli_fetch_assoc($result);
		$product_name = $row['product_name'];
		$aiq_array = explode(',', $row['aiq']);
		$mrp_array = explode(',', $row['mrp']);
		$id = $row['id'];
		$product_image = $row['product_image'];
		$discount = $row['discount'];		
	}
?>

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
         	<!-- Add Product Begins here -->
          	<div class="col-md-8">
         			<div class="card ">
         				<div class="card-body">
		          		<form action="controller/product.php" method="post" enctype="multipart/form-data">
		          			<span><?php if(!empty($_SESSION['mssg'])) { echo $_SESSION['mssg']; unset($_SESSION['mssg']); } ?></span><br>
		          			<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label for="validationServer013">Product name</label>
		      							<input type="text" class="form-control txtOnly"name="product_name" id="product_name" size="20" required>
		    							</div>
		    							<div class="col-md-6 mb-2">
		     								<label >GST %</label>
		      								<input type="number" class="form-control numOnly" id="gst_no" name="gst_no" style="width:80px" >
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-8">
		    								<label>Category Name</label>
		    								<select class="form-control" name="cat_name">
		    									<?php while ($row_cat = mysqli_fetch_assoc($result_cat)){ ?>
		    									<option value="<?php echo $row_cat ['cat_name'] ?>" name="cat_name"><?php echo $row_cat['cat_name'] ?></option>
		    									<?php } ?>
		    								</select>
		    							</div>
		    							
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label >HSN No.</label>
		      								<input type="text" class="form-control alphnumOnly"name="hsn_no"  >
		    							</div>
		    							<div class="col-md-6 mb-2">
		     								<label for="validationServer013">Discount</label>
		      							<select name="discount" class="form-control numOnly" style="width:80px">
													<option value="0">--</option>
														<?php for($i=1; $i<=10; $i++) { ?>
													<option <?php if(($i*5) == $discount){ echo "Selected";} ?> value="5"><?php echo $i*5 ?> %</option>
														<?php } ?>
												</select>
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label >Add Material </label>
		      							<button type="button" class="add btn-sm btn-outline-success com-btn ">+</button>
												<button type="button" class="remove btn-sm btn-outline-danger com-btn">-</button>
		    							</div>
		    						</div>	

		    						<div class="row">
			    						<div class="col-md-6 mb-2">
			     								<label >Material name</label>
			      							<select class="form-control txtOnly" name="materials_id[]">
						     						<?php while($rov=mysqli_fetch_assoc($resul)) { ?>
					     						<option value="<?php echo $rov['id'] ?>"><?php echo $rov['name']; ?></option>
					     							<?php } ?>
										     	</select>
			    						</div>
			    						<div class="col-md-6 mb-2">
			     								<label >QTY (%)</label>
			      							<input type="text" class="form-control numOnly" name="req_percentage[]" id="req_percentage[]"  style="width: 120px;" required>
			    						</div>
			    							<div class="clearfix"> </div>
						     				<input type="hidden" value="1" id="total_chq"><br>	
			    					</div>
			    					<div class="row ">
											<div class="col-md-12">
												<div class=" mr-t-20" id="new_chq" style="margin-top:20px"></div>
											</div>
										</div>
			    					<div class="row">
			    						<table width="100%">
												<thead>
													<th class="width-200">
														<lable >Available in Quantities</lable><br>
													</th>
													<th>
														<label >MRP</label>
													</th>
													<th>
														<label >Rate</label>
													</th>
												</thead>
												<tr>
												<td><input id="aiq10" onclick="onAiqCheck(10)" type="checkbox" name="aiq[]" value="10" <?php 
														if(in_array('10', $aiq_array) == true) {
															echo "checked"; 
														}
													 ?> > 10 &nbsp; &nbsp; </td>
													<td><input <?php if(in_array('10', $aiq_array) == true) { echo "enable"; } else { echo "disabled"; } ?>  id="mrp10" class="form-control hide numOnly" type="number" name="mrp[]" value ="<?php 
														if(in_array('10', $aiq_array) == true) {
															$a = array_search('10', $aiq_array);
															echo trim($mrp_array[$a]); 
														} 
													 ?>" ></td>
													 <td><input <?php if(in_array('10', $aiq_array) == true) { echo "enable"; } else { echo "disabled"; } ?>  id="rate10" class="form-control hide numOnly" type="number" name="rate[]" value ="<?php 
														if(in_array('10', $aiq_array) == true) {
															$a = array_search('10', $aiq_array);
															echo trim($rate_array[$a]); 
														} 
													 ?>" ></td>
												</tr><td><input id="aiq50" onclick="onAiqCheck(50)" type="checkbox" name="aiq[]" value="50" <?php 
														if(in_array('50', $aiq_array) == true) {
															echo "checked"; 
														}
													 ?> > 50 &nbsp; &nbsp; </td>
													<td><input <?php if(in_array('50', $aiq_array) == true) { echo "enable"; } else { echo "disabled"; } ?>  id="mrp50" class="form-control hide numOnly" type="number" name="mrp[]" value ="<?php 
														if(in_array('50', $aiq_array) == true) {
															$a = array_search('50', $aiq_array);
															echo trim($mrp_array[$a]); 
														} 
													 ?>" ></td>
													 <td><input <?php if(in_array('50', $aiq_array) == true) { echo "enable"; } else { echo "disabled"; } ?>  id="rate50" class="form-control hide numOnly" type="number" name="rate[]" value ="<?php 
														if(in_array('50', $aiq_array) == true) {
															$a = array_search('50', $aiq_array);
															echo trim($rate_array[$a]); 
														} 
													 ?>" ></td>
												</tr>
												<td><input id="aiq100" onclick="onAiqCheck(100)" type="checkbox" name="aiq[]" value="100" <?php 
														if(in_array('100', $aiq_array) == true) {
															echo "checked"; 
														}
													 ?> > 100 &nbsp; &nbsp; </td>
													<td><input <?php if(in_array('100', $aiq_array) == true) { echo "enable"; } else { echo "disabled"; } ?>  id="mrp100" class="form-control hide numOnly" type="number" name="mrp[]" value ="<?php 
														if(in_array('100', $aiq_array) == true) {
															$a = array_search('100', $aiq_array);
															echo trim($mrp_array[$a]); 
														} 
													 ?>" ></td>
													 <td><input <?php if(in_array('100', $aiq_array) == true) { echo "enable"; } else { echo "disabled"; } ?>  id="rate100" class="form-control hide numOnly" type="number" name="rate[]" value ="<?php 
														if(in_array('100', $aiq_array) == true) {
															$a = array_search('100', $aiq_array);
															echo trim($rate_array[$a]); 
														} 
													 ?>" ></td>
												</tr>
													<td><input id="aiq250" onclick="onAiqCheck(250)" type="checkbox" name="aiq[]" value="250" <?php 
														if(in_array('250', $aiq_array) == true) {
															echo "checked"; 
														}
													 ?> > 250 &nbsp; &nbsp; </td>
													<td><input <?php if(in_array('250', $aiq_array) == true) { echo "enable"; } else { echo "disabled"; } ?>  id="mrp250" class="form-control hide numOnly" type="number" name="mrp[]" value ="<?php 
														if(in_array('250', $aiq_array) == true) {
															$a = array_search('250', $aiq_array);
															echo trim($mrp_array[$a]); 
														} 
													 ?>" ></td>
													 <td><input <?php if(in_array('250', $aiq_array) == true) { echo "enable"; } else { echo "disabled"; } ?>  id="rate250" class="form-control hide numOnly" type="number" name="rate[]" value ="<?php 
														if(in_array('250', $aiq_array) == true) {
															$a = array_search('250', $aiq_array);
															echo trim($rate_array[$a]); 
														} 
													 ?>" ></td>
												</tr>
												<tr>
													<td><input id="aiq200" onclick="onAiqCheck(200)" type="checkbox" name="aiq[]" value="200" 
														<?php 
														if(in_array('200', $aiq_array) == true) {
															echo "checked";
														}
													 ?>> 200  &nbsp; &nbsp; </td>
													<td><input <?php if(in_array('200', $aiq_array) != true) { echo "disabled"; }  ?> id="mrp200" class="form-control hide numOnly" type="text" name="mrp[]" value ="<?php 
														if(in_array('200', $aiq_array) == true) {
															$a = array_search('200', $aiq_array);
															echo trim($mrp_array[$a]);
														} 
													 ?>" ></td>
													 <td><input <?php if(in_array('200', $aiq_array) != true) { echo "disabled"; }  ?> id="rate200" class="form-control hide numOnly" type="text" name="rate[]" value ="<?php 
														if(in_array('200', $aiq_array) == true) {
															$a = array_search('200', $aiq_array);
															echo trim($rate_array[$a]);
														} 
													 ?>" ></td>
												</tr>
												<tr>
													<td><input id="aiq500" onclick="onAiqCheck(500)" type="checkbox" name="aiq[]" value="500" <?php 
														if(in_array('500', $aiq_array) == true) {
															echo "checked";
														}
													 ?>> 500  &nbsp; &nbsp; </td>
													<td><input <?php if(in_array('500', $aiq_array) != true) { echo "disabled"; }  ?> id="mrp500" class="form-control hide numOnly" type="text" name="mrp[]" value ="<?php 
														if(in_array('500', $aiq_array) == true) {
															$a = array_search('500', $aiq_array);
															echo trim($mrp_array[$a]); 
															//echo $mrp_array[0];
														}
													 ?>"></td>
													 <td><input <?php if(in_array('500', $aiq_array) != true) { echo "disabled"; }  ?> id="rate500" class="form-control hide" type="text" name="rate[]" value ="<?php 
														if(in_array('500', $aiq_array) == true) {
															$a = array_search('500', $aiq_array);
															echo trim($rate_array[$a]); 
															//echo $mrp_array[0];
														}
													 ?>"></td>
												</tr>
												<tr>
													<td><input id="aiq1000" onclick="onAiqCheck(1000)" type="checkbox" name="aiq[]" value="1000" <?php 
														if(in_array('1000', $aiq_array) == true) {
															echo "checked";
														}
													 ?>> 1000  &nbsp; &nbsp; </td>
													<td><input <?php if(in_array('1000', $aiq_array) != true) { echo "disabled"; }  ?> id="mrp1000" class="form-control hide numOnly" type="text" name="mrp[]" value ="<?php 
														if(in_array('1000', $aiq_array) == true) {
															$a = array_search('1000', $aiq_array);
															echo trim($mrp_array[$a]); 
															//echo $mrp_array[0];
														} 
													 ?>"></td>
													 <td><input <?php if(in_array('1000', $aiq_array) != true) { echo "disabled"; }  ?> id="rate1000" class="form-control hide numOnly" type="text" name="rate[]" value ="<?php 
														if(in_array('1000', $aiq_array) == true) {
															$a = array_search('1000', $aiq_array);
															echo trim($rate_array[$a]); 
															//echo $mrp_array[0];
														} 
													 ?>"></td>
												</tr>
											</table>	
			    					</div>
			    					<div class="row">
			    						<div class=" mb-2">
		     								<label class="col-md-12"> Description </label>
			    							<textarea name="description" id="editor" class="description-text form-control"></textarea> <br>
												
			    						</div>
			    					</div>
			    					<div class="row">
			    						<div class=" col-md-12 ">
		     								<label class="col-md-12"> Product Image </label>
			    							<input type="file" name="product_image"><br>
												<img width="300px" src="images/products/<?php echo $product_image; ?>">
			    						</div>
			    					</div>
			    					<input type="hidden" name="oldImg" value="<?php echo $product_image; ?>">
										<input type="hidden" name="submitVal" value="<?php echo $button; ?>">
										<input type="hidden" name="id" value="<?php echo $id; ?>" >
											<?php if(isset($_SESSION['err_mssg'])) { echo $_SESSION['err_mssg']; unset($_SESSION['err_mssg']);} ?><br>
											<div>
												<button class="btn btn-primary" name="submit" value="<?php echo $submitVal; ?>" type="submit"><?php echo $button; ?> </button>
											</div>
										
		          		</form>	
          			</div>
          	</div>
          </div>	 

         	<!-- /Add Product close -->
         </div>
	    </div>
	</section>
</div>




<?php include "footer.php" ?>
<script type="text/javascript">
  function onAiqCheck(val) {
    var inputId = "aiq"+val;
    var check = document.getElementById(inputId).checked;
    if(check) {
      document.getElementById("mrp"+val).disabled = false;
      document.getElementById("mrp"+val).style.color = 'green';
	  document.getElementById("rate"+val).disabled = false;
      document.getElementById("rate"+val).style.color = 'green';
    } else {
      document.getElementById("mrp"+val).disabled = true;
      document.getElementById("mrp"+val).value = "";
      document.getElementById("mrp"+val).style.color = 'green';
	  document.getElementById("rate"+val).disabled = true;
      document.getElementById("rate"+val).value = "";
      document.getElementById("rate"+val).style.color = 'green';
    }
  }
</script>

<!-- <script type="text/javascript" src="js/javascript.js"></script> -->

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
          
           var new_input = "<div class='form-inline mar-t-20 '  id='new_" + new_chq_no + "'   ><div class='form-group'><label class='pad-right-5' for='materialname'>Material name: </label> <select class='form-control' name='materials_id[]'>"+b+"</select> </div><div class='form-group'><label class='pad-right-5'>Qty (%)</label> <input class='form-control' type='text' name='req_percentage[]' size='15' ></div>" ;
 
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
            var product_name = $('#product_name').val();
            var gst_per = $('#gst_no').val();
            var qty = $('#req_percentage[]').val();

            if (product_name == 0) {
                $('#mssg').text("Product Name Required")
            }
            if (gst_per == 0) {
                $('#mssg').text("Gst % Required")
            }
            if (qty == 0) {
                $('#mssg').text("QTY Required")
            }

        })
        
    })
$('.numOnly').keypress(function (e) {
            var regex = new RegExp("^[0-9]+$");
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
            var regex = new RegExp("^[a-z A-Z]");
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
            var regex = new RegExp("^[a-zA-Z0-9]+$");
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

<script src="ckeditor/ckeditor/ckeditor.js"></script>
<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>
