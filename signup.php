
<?php include 'config/database.php';
	if (isset($_SESSION['isLogin'])) {
		header('Location: dashboard.php');
	}

	include "controller/master.php";
	$master = new Master();
	$result = $master->getCountries();

	//print_r($result); exit;
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<style type="text/css">
		.err {
			padding-left: 8px;
			font-style: italic;
			font-size: 13px;
			color: red;
		}
		.mr-t20{
			margin-top: 20px;
		}
		.mr-t30{
			margin-top: 50px;
		}

	</style>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 text-center mr-t20" >
				<img src="dist/img/logo2.png" alt="" height="120" width="120" class="img">
			</div>
			<div class="col-md-6 " style="margin-top:50px">
				<div class="card" >
					<div class="card-body" style="background:#D3D3D3">
					   	<h1 class="text-center">Signup</h1>
					   	<label>
							<?php 
								if (!empty($_SESSION['mssg'])) {
								echo $_SESSION['mssg'];
								unset($_SESSION['mssg']);
								}
			
							?>
						</label>
					<div class="col-md-12 text-center mr-t20">
				<form action="controller/auth.php" name="mySignUpForm"  method="post">
					<div class="form-group ">
						<label>Name</label>
						<input class="form-control" type="text" name="name" size="20">
						<label>Email</label>
						<input class="form-control" type="email" name="email" size="20">
					</div>
					<div class="form-group  ">
						<label>Country</label>
						<select class="form-control" name="country" id="country" >
							<?php while($country=mysqli_fetch_assoc($result)) { ?>
							<option value="<?php echo $country['id']; ?>" ><?php echo $country['name']; ?></option>
							<?php } ?>
						</select>
					</div>
					
					<div class="form-group">
						<label>State</label>
						<select class="form-control" name="state" id="states">	
							<option value="0">--Select--</option>
						</select>
						<label>City</label>
						<select class="form-control" name="city" id="city">
							<option value="0">--Select--</option>
						</select>
					</div>
				

					<div class="form-group">
						<label>Password</label>
						<input class="form-control" type="password" name="password">
					</div>

					<input type="hidden" name="submitVal" value="signup">
					<button class="btn btn-primary mr-t20" type="submit">Submit</button>
					<span  class="mr-t20"></span> 
					<a class="btn btn-primary mr-t20" href="index.php">Login</a>
				</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<script>
	
	$(function() {
		$('#country').change(function(){
			var country_id = $('#country').val();
			$.ajax({
				url: "controller/ajaxController.php?country_id="+country_id+"&getType=states",
				type: "GET",
				success: function(response) {
					$('#states').html(response);
				}
			});
		});
	});
	

</script>
<script>
	// Jquery Validation
	$(function() {
		$("form[name='mySignUpForm']").validate({
			rules: {
				name: 'required',
				email: {
					required: true,
					email: 'required'

				},
				password: {
					required: true,
					minlength: 5
				}
			},
			message: {
				name: "Name Required",
				email: "Valid email Required",
				password: {
					required: "Password Required",
					minlength: "Please Enter min 5 characters",
				} 
			},
			submitHandler: function(form) {
				form.submit();
			}
		})
	})

</script>


<!-- <script type="text/javascript" src="js/javascript.js"></script> -->