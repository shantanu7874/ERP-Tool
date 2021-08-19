<?php
include '../config/database.php';


$conn = new Database();
$category = new Categories();
	
	//print_r($_REQUEST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'Add':
			$category->add();
			break;

		case 'delete':
			$category->delete();
			break;
			
		case 'Update':
			$category->update();
			break;
		
		default:
			# code...
			break;
	}

class Categories {
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
		$sql  = "INSERT into category (cat_name,created, modified) values ('".$_POST['cat_name']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

				//print_r($_POST) ; exit;
				$result = mysqli_query($this->conn->getConnection(), $sql);

				//print_r($sql); exit();
				
				if($result) {
					$_SESSION['mssg'] = "Category Added";
					header('Location: ../add_category.php');
					
				} else {
					$_SESSION['mssg'] = "Category not Added";
					header('Location:../add_category.php');
					}

			}		

	function update() {
		//print_r($_POST); exit;
		extract($_POST);

		$sql = "UPDATE category SET name='".$name."',
									modified = '".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
								//	print_r($sql); exit;
		$result = mysqli_query($this->conn->getConnection(), $sql);
		if($result) {
			header("Location: ../category.php");
		}
	}
	function delete() {
		//print_r($_REQUEST); exit();
		if (!empty($_REQUEST['id'])) {
			$sql = "DELETE FROM category where id = '".$_REQUEST['id']."'";
			$result = mysqli_query($this->conn->getConnection(), $sql);
			if($result) {
				$_SESSION['mssg'] = "Record Deleted";
				header("Location: ../category.php " );
			} else {
				$_SESSION['mssg'] = "Record not Found";
				header("Location: ../category.php " );
			}
		}	
	}
}
?>