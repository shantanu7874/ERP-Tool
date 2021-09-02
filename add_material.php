<?php include "header.php"  ?>
	
<?php
	
$db = new Database;
	$sql = 'SELECT * FROM category';
	$result = mysqli_query($db->getConnection(), $sql);


	$button = "Add";
	$submitVal = "addMaterial";
	$name = '';
	$cat_id= " ";
	$id = 0;
	$type = '';

	if (!empty($_REQUEST['id'])) {
		$button = "Update";
		$submitVal = "updateMaterial";
		$sql = "SELECT * FROM materials where id = '".$_REQUEST['id']."'";
		$result = mysqli_query($db->getConnection(),$sql);
		$row = mysqli_fetch_assoc($result);
		$name = $row['name'];
		$cat_id = " ";
		$type = $row ['type'] ;
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
		          		<form action="controller/material.php" method="post" name="myForm" id="myForm" enctype="multipart/form-data">
		          			<span><?php if(!empty($_SESSION['mssg'])) { echo $_SESSION['mssg']; unset($_SESSION['mssg']); } ?></span><br>
		          			<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label for="validationServer013">Material name</label>
		      							<input type="text" class="form-control txtOnly " name="name" id="material_name" size="20" value="<?php echo $name ?>" required>
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label >Category</label>
		      							<select class="form-control" name="cat_name" id="name">
													<?php while($row=mysqli_fetch_assoc($result)) { ?>
														<option value="<?php echo $row['cat_name'] ?>" ><?php echo $row ['cat_name']; ?></option>
														<?php } ?>
													</select>
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6">
		    								<label>Type</label>
		    									<div class="form-check">
							        			<select class="form-check-input form-control" id="type" name="type" value="" >
										        	<option>Raw Product</option>
										        	<option>Mid Product</option>
										        	<option>Final Product</option>
							        			</select><br>
							    				</div>
					    				</div>
		    						</div>
		    						<div>
		    								<input type="hidden" name="submitVal" value="<?php echo $button; ?>">
												<input type="hidden" name="id" value="	<?php echo $id; ?>" >
													<?php if(isset($_SESSION['err_mssg'])) { echo $_SESSION['err_mssg']; unset($_SESSION['err_mssg']);} ?>	<br>
													<button class="btn btn-primary" name="submit" value="<?php echo $submitVal; ?>" type="submit"><?php echo $button; ?> </button>
										</div>
		    					</form>
		    				</div>
							</div>
          	</div>
          </div>
        </div>
     </section> 	 

         	<!-- /Add Product close -->
</div>



<?php include "footer.php" ?>


<script type="text/javascript">

$(function() {
        $('#onSubmit').click(function(){
            var material_name = $('#material_name').val();
            

            if (material_name == 0) {
                $('#mssg').text("Material Name Required")
            }
            

        })
        
    })

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
</script>