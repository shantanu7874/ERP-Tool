<?php
include '../config/database.php';


$conn = new Database();
$material = new Materials();
	
	//print_r($_REQUEST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'Add':
			$material->add();
			break;

		case 'delete':
			$material->delete();
			break;
			
		case 'Update':
			$material->update();
			break;
		
		default:
			# code...
			break;
	}

class Materials {
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
		$sql  = "INSERT into materials (name, cat_id , type,created, modified) values ('".$_POST['name']."','".$_POST['cat_id']."','".$_POST['type']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

				//print_r($_POST) ; exit;
				$result = mysqli_query($this->conn->getConnection(), $sql);

				//print_r($sql); exit();
				
				if($result) {
					$_SESSION['mssg'] = "Product Added";
					header('Location: ../add_material.php');
					
				} else {
					$_SESSION['mssg'] = "Product not Added";
					header('Location:../add_material.php');
					}

			}		


	function update() {
		//print_r($_POST); exit;
		extract($_POST);

		$sql = "UPDATE materials SET name='".$name."',
									cat_id = '".$cat_id."',
									type = '".$type."',
									modified = '".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
								//	print_r($sql); exit;
		$result = mysqli_query($this->conn->getConnection(), $sql);
		if($result) {
			header("Location: ../material.php");
		}
	}
	function delete() {
		//print_r($_REQUEST); exit();
		if (!empty($_REQUEST['id'])) {
			$sql = "DELETE FROM materials where id = '".$_REQUEST['id']."'";
			$result = mysqli_query($this->conn->getConnection(), $sql);
			if($result) {
				$_SESSION['mssg'] = "Record Deleted";
				header("Location: ../material.php " );
			} else {
				$_SESSION['mssg'] = "Record not Found";
				header("Location: ../material.php " );
			}
		}	
	}
}

?>