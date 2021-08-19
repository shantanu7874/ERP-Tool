<?php
include '../config/database.php';


$conn = new Database();
$supplier = new Suppliers();
	
	//print_r($_POST['submitVal']); exit();
	switch ($_REQUEST["submitVal"]) {
		case "Add":
			$supplier->add();
			break;

		case "delete":
			$supplier->delete();
			break;
			
		case 'Update':
			$supplier->update();
			break;
		
		default:
			# code...
			break;
	}

class Suppliers {
	private $conn; 
	function __construct()
	{
		$this->conn = new Database();
	}

	function add() {
		extract($_POST);
		/*if (empty($_POST['mssg'])){
					$_SESSION['mssg'] = "Enter Product Name";
					header('Location: ../add_product.php');
					return;
				}*/
		$sql  = "INSERT into supplier (supplier_name,gst_no,contact_no,address,created, modified) values ('".$_POST['supplier_name']."','".$_POST['gst_no']."','".$_POST['contact_no']."','".$_POST['address']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

				//print_r($_POST) ; exit;
				$result = mysqli_query($this->conn->getConnection(), $sql);

				//print_r($sql); exit();
				
				if($result) {
					$_SESSION['mssg'] = "Supplier Added";
					header('Location: ../add_supplier.php');
					
				} else {
					$_SESSION['mssg'] = "Category not Added";
					header('Location:../add_supplier.php');
					}

			}		

	function update() {
		//print_r($_POST); exit;
		extract($_POST);

		$sql = "UPDATE supplier SET supplier_name='".$supplier_name."',
									gst_no='".$gst_no."',
									contact_no='".$contact_no."',
									address='".$address."',
									modified = '".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
								//	print_r($sql); exit;
		$result = mysqli_query($this->conn->getConnection(), $sql);
		if($result) {
			header("Location: ../supplier.php");
		}
	}
	function delete() {
		//print_r($_REQUEST); exit();
		if (!empty($_REQUEST['id'])) {
			$sql = "DELETE FROM supplier where id = '".$_REQUEST['id']."'";
			$result = mysqli_query($this->conn->getConnection(), $sql);
			if($result) {
				$_SESSION['mssg'] = "Record Deleted";
				header("Location: ../supplier.php " );
			} else {
				$_SESSION['mssg'] = "Record not Found";
				header("Location: ../supplier.php " );
			}
		}	
	}
}

?>