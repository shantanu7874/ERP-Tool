
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
	<title>Project</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	
</head>
<body>
	<h1 class="text-center">Sign Up</h1>
	<label>
		<?php 
			if (!empty($_SESSION['mssg'])) {
				echo $_SESSION['mssg'];
				unset($_SESSION['mssg']);
			}
			
		?>
	</label>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form action="controller/auth.php" name="mySignUpForm"  method="post">
					<div class="form-group">
						<label>Name</label>
						<input class="form-control" type="text" name="name">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input class="form-control" type="email" name="email">
					</div>
					<div class="form-group">
						<label>Country</label>
						<select class="form-control" name="country" id="country">
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
					</div>
					<div class="form-group">
						<label>City</label>
						<select>
							<option></option>
						</select>
					</div>

					<div class="form-group">
						<label>Password</label>
						<input class="form-control" type="password" name="password">
					</div>

					<input type="hidden" name="submitVal" value="signup">
					<button class="btn btn-primary mr-t20" type="submit">Submit</button>
					<span  class="mr-t20">Or</span> 
					<a class="btn btn-default mr-t20"  href="index.php">Login</a>
				</form>
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