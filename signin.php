
<?php include 'config/database.php';
	if (isset($_SESSION['isLogin'])) {
		header('Location: index.php');
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
<body style="background:#F5F5F5">	
	<div class="container" >
		<div class="row justify-content-center ">
			<div class="col-md-12 text-center mr-t20" >
				<img src="dist/img/logo2.png" alt="" height="160" width="160" class="img">
			</div>
			<div class="col-md-4" style="margin-top:50px">
				<div class="card">
					<div class="card-body" style="background:#D3D3D3">
					   	<h1 class="text-center">Login</h1>
						<form  id="myForm" action="controller/auth.php" method="post">
							<label>Email</label> <span id="err_email" class="err"><?php if(!empty($_SESSION['err_mail'])) { echo $_SESSION['err_mail']; unset($_SESSION['err_mail']); } ?></span> 
							<input class="form-control" type="text" oninput="onEmail()"  id="email" name="email" size="20">
							<label>Password</label><span id="err_pass" class="err"><?php if(!empty($_SESSION['err_pass'])) { echo $_SESSION['err_pass']; unset($_SESSION['err_pass']); } ?></span>
							<input class="form-control" type="password" id="password" name="password">
							<input type="hidden" name="submitVal" value="login" size="20">
							<button id="onSubmit" class="btn btn-primary mr-t20" type="button">Login</button>
							<span  class="mr-t30"></span> 
							<a class="btn btn-primary mr-t20" href="signup.php">Sign Up</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script src="plugins/jquery/jquery.min.js"></script><!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript">
	$(function() {
		$('#onSubmit').click(function() {
			var email = $('#email').val();
			var pass = $('#password').val();
			if(email.length == 0) {
				$('#err_email').text("Email Required");
				return;
			}
			if (pass.length == 0) {
				$('#err_pass').text("Password Required");
				return;
			}
			$('#myForm').submit();
		});
	})
	function onEmail() {
		$('#err_email').text("");
	}
</script>