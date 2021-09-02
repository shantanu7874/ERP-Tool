<?php
include '../config/database.php';


$conn = new Database();
$customer = new Customer();
	
	//print_r($_REQUEST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'Add':
			$customer->add();
			break;

		case 'delete':
			$customer->delete();
			break;
			
		case 'Update':
			$customer->update();
			break;
		
		default:
			# code...
			break;
	}

class Customer {
	private $conn; 
	function __construct()
	{
		$this->conn = new Database();
	}

	function add() {
		extract($_POST);
		//print_r($_POST); exit();
		if (empty($_POST['customer_name'])){
					$_SESSION['mssg'] = "Enter Customer Name";
					header('Location: ../add_customer.php');
					return;
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$_SESSION['mssg'] = "Enter valid email ";
				header('Location: ../add_customer.php');
				return;
			}
				}

		if (empty($_POST['contact'])){
					$_SESSION['mssg'] = "Enter Contact No";
					header('Location: ../add_customer.php');
					return;
				}		
		$sql  = "INSERT into customers (customer_name, gst_no , email, contact, address, created, modified) values ('".$_POST['customer_name']."','".$_POST['gst_no']."','".$_POST['email']."','".$_POST['contact']."','".$_POST['address']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

				//print_r($_POST) ; exit;
				$result = mysqli_query($this->conn->getConnection(), $sql);

				//print_r($sql); exit();
				
				if($result) {
					$_SESSION['mssg'] = "Customer Added";
					header('Location: ../add_customer.php');
					
				} else {
					$_SESSION['mssg'] = "Customer not Added";
					header('Location:../add_customer.php');
					}

			}		


	function update() {
		//print_r($_POST); exit;
		extract($_POST);

		$sql = "UPDATE customers SET customer_name='".$customer_name."',
									gst_no = '".$gst_no."',
									email = '".$email."',
									contact = '".$contact."',
									address = '".$address."',
									modified = '".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
								//	print_r($sql); exit;
		$result = mysqli_query($this->conn->getConnection(), $sql);
		if($result) {
			header("Location: ../customer.php");
		}
	}
	function delete() {
		//print_r($_REQUEST); exit();
		if (!empty($_REQUEST['id'])) {
			$sql = "DELETE FROM customers where id = '".$_REQUEST['id']."'";
			$result = mysqli_query($this->conn->getConnection(), $sql);
			if($result) {
				$_SESSION['mssg'] = "Record Deleted";
				header("Location: ../customer.php " );
			} else {
				$_SESSION['mssg'] = "Record not Found";
				header("Location: ../customer.php " );
			}
		}	
	}
}

?>