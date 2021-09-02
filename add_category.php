<?php include "header.php"  ?>
	
<?php
	
	$db = new Database;
	
	$button = "Add";
	$submitVal = "addCategory";
	$cat_name = '';
	$id = 0;

	if (!empty($_REQUEST['id'])) {
		$button = "Update";
		$submitVal = "updateCategory";
		$sql = "SELECT * FROM category where id = '".$_REQUEST['id']."'";
		$result = mysqli_query($db->getConnection(),$sql);
		$row = mysqli_fetch_assoc($result);
		$cat_name = $row['cat_name'];
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
		          		<form action="controller/category.php" method="post" enctype="multipart/form-data">
		          			<span><?php if(!empty($_SESSION['mssg'])) { echo $_SESSION['mssg']; unset($_SESSION['mssg']); } ?></span><br>
		          			<div class="row">
		    							<div class="col-md-6 mb-2">
		     								<label for="validationServer013">Category name</label> <p class="error"></p>
		      							<input type="text" class="form-control cat_name" name="cat_name" placeholder="Enter Category name" id="cat_name" value="<?php echo $cat_name ?>" oninput="oncat_name()">
		    							</div>
		    						</div>	
		    							<div>
		    								<input type="hidden" name="submitVal" value="<?php echo $button; ?>"><br>
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
		
	$(function(){
		$('#onSubmit').click(function(){

			var cat_name = $('#cat_name').val();
			if(cat_name.length == 0){
				$('#mssg').text("Category Required");
					return;
			} 
			$('#myForm').submit();

		});
	});
	function oncat_name(){
		$('#mssg').text("Enter Category");
	}

$('.cat_name').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
            e.preventDefault();
            $('.error').show();
            $('.error').text('Please Enter Text only');
            return false;
            }
        });

</script>