<?php include "header.php"  ?>
	
<?php
	
$db = new Database;
	
	$button = "Add";
	$submitVal = "addCustomer";
	$customer_name = '';
	$gst_no='';
	$email='';
	$contact='';
	$address='';
	$id = 0;

	if (!empty($_REQUEST['id'])) {
		$button = "Update";
		$submitVal = "updateCustomer";
		$sql = "SELECT * FROM customers where id = '".$_REQUEST['id']."'";
		$result = mysqli_query($db->getConnection(),$sql);
		$row = mysqli_fetch_assoc($result);
		$customer_name = $row['customer_name'];
		$gst_no = $row['gst_no'];
		$email = $row['email'];
		$contact = $row['contact'];
		$address = $row['address'];
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
		          		<form action="controller/customer.php" method="post" enctype="multipart/form-data" name="customerform">
		          			<span><?php if(!empty($_SESSION['mssg'])) { echo $_SESSION['mssg']; unset($_SESSION['mssg']); } ?></span><br>
		          			<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label for="">Customer name</label>
		      							<input type="text" class="form-control txtOnly" id="customer_name" name="customer_name" value="<?php echo $customer_name ?>" size="20" required>
		    							</div>
		    							<div class="col-md-6 mb-2">
		     								<label for="validationServer013">GST NO.</label>
		      							<input type="text" class="			form-control alphnumOnly" name="gst_no"id="gst_no" value="<?php echo $gst_no ?>">
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label> Email </label>
		      							<input type="email" name="email" class="form-control emailOnly" id="email" value="<?php echo $email ?>">
		    							</div>
		    						</div>
		    						<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label> Contact No </label>
		      							<input type="number" name="contact_no" class="form-control numOnly" id="contact_no" value="<?php echo $contact_no ?>">
		    							</div>
		    						</div>	

		    						<div class="row">
			    						<div class="col-md-6 mb-2">
			     							<label >Address</label>
			      							<textarea type="text" name="address" class="form-control alphnumOnly" id="address" value="<?php echo $address ?>"></textarea>
			    						</div>
			    					</div>
			    					<div>	
											<input type="hidden" name="submitVal" value="<?php echo $button; ?>">
											<input type="hidden" name="id"value="<?php echo $id; ?>" >
													<?php if(isset($_SESSION['err_mssg'])) { echo $_SESSION['err_mssg']; unset($_SESSION['err_mssg']);} ?><br>
											
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
 $('.emailOnly').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z0-9.'@#-_]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
            e.preventDefault();
            $('.error').show();
            $('.error').text('Please Enter Vaild Email');
            return false;
            }
        });

</script>