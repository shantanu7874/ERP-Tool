<?php 
	// CRUD - Create, Read, Updating, Delete
	include "../config/database.php";
	
	$conn = new Database();
	$auth = new Auth();
	
	//print_r($_REQUEST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'signup':
			$auth->signup();
			break;

		case 'login':
			$auth->login();
			break;
			
		case 'logout':
			$auth->logout();
			break;
		
		default:
			# code...
			break;
	}
	/**
	 * 
	 */
	class Auth  
	{
		private $conn; 
		function __construct()
		{
			$this->conn = new Database();
		}

		function login() {

			// 1. Check if email exists or notå.

			extract($_POST);
			if (empty($email)) {
				$_SESSION['err_mail'] = "Email Required";
				header('Location: ../index.php');
				return;
			}
			// wrong email input -> correct asel tar true and for wrong false. 
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$_SESSION['err_mail'] = "Enter valid email ";
				header('Location: ../index.php');
				return;
			}
			if (empty($password)) {
				$_SESSION['err_pass'] = "Password Required";
				header('Location: ../index.php');
				return;
			}
			// count works only for array. strlen() gives count of char in a word.
			$pass_length = strlen($password);
			//print_r($pass_length); exit;
			if ($pass_length < 6) {
				$_SESSION['err_pass'] = "Password field should have altleast 8 Char";
				header('Location: ../index.php');
				return;
			}


			$sql = "SELECT * FROM users WHERE email = '".trim($email)."' ";
			$result = mysqli_query($this->conn->getConnection(), $sql);

			$row = mysqli_fetch_assoc($result);

			if ($row) {
				
				// first variable user input password and second varibale form database
				if (md5($password) == $row['password']) {
					$_SESSION['isLogin'] = true;
					$_SESSION['id'] = $row['id'];
					$_SESSION['name'] = $row['name'];
					$_SESSION['email'] = $row['email'];

					header('Location: ../index.php');
				} else {
					
					$_SESSION['err_pass'] = "Invalid password";
					header('Location: ../index.php');
				}
				
			} else {
				
				$_SESSION['err_mail'] = "Email id not found";
				header('Location: ../index.php');
			}
			
		}

		function signup() {
			/*print_r($_POST);
			exit();*/
			extract($_POST);
			$enc_pass =  md5($password);
/*			print_r($conn); exit();
*/
			if(!empty($_POST['email'])) {
				$sql  = "INSERT into users (name, email, password, created, modified) values ('".$name."', '".$_POST['email']."', '".$enc_pass."', '".date('Y-m-d H:i:s')."',  '".date('Y-m-d H:i:s')."' )";

				$result = mysqli_query($this->conn->getConnection(), $sql);

				if($result) {
					$_SESSION['mssg'] = "User Created";
					header('Location: ../signup.php');
					
				} else {
					$_SESSION['mssg'] = "User not created";
					header('Location:../signup.php');
					
				}
			} else {
				$_SESSION['mssg'] = "Please Enter Email";
				header('Location:../signup.php');
			}

		}
		function logout() {
			session_destroy();
			header('Location:../index.php');
		}
	}
	
	
?>