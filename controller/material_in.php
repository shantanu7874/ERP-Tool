<?php
include '../config/database.php';


$conn = new Database();
$material_in = new Materials_in();
	
	//print_r($_REQUEST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'Add':
			$material_in->add();
			break;

		case 'delete':
			$material_in->delete();
			break;
			
		case 'Update':
			$material_in->update();
			break;
		
		default:
			# code...
			break;
	}

class Materials_in {
	private $conn; 
	function __construct()
	{
		$this->conn = new Database();
	}

	function add() {
		extract($_POST);
		print_r($_POST); echo "<br>";
		if (empty($_POST['bill_no'])){
					$_SESSION['mssg'] = "Enter Bill Number";
					header('Location: ../add_material_in.php');
					return;
				}

		 $sql  = "INSERT into materials_in (supplier_id, bill_no,payment ,created, modified) values ('".$_POST ['supplier_id']."','".$_POST['bill_no']."','".$_POST['payment']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

				//print_r($sql) ; exit;
		 		$result = mysqli_query($this->conn->getConnection(), $sql);

				// get last insert id
				$insert_id =" SELECT MAX(id) as id FROM materials_in"; //mysqli_insert_id ($this->conn->getConnection());
				$result_id = mysqli_query($this->conn->getConnection(), $insert_id);
				$last_id = mysqli_fetch_assoc($result_id);
				//print_r($last_id['id']); exit();

 /// find solution;

				// query to insert in materials_in_items
				for($i=0; $i<count($_POST['material_id']); $i++ ) {
					/* print_r($_POST['material_id'][$i]); echo "<br>";
					 print_r($_POST['hsn_no'][$i]); echo "<br>";
					  print_r($_POST['qty'][$i]); echo "<br>";
					   print_r($_POST['amt'][$i]); echo "<br>";*/
					   if (empty($_POST['qty'])){
							$_SESSION['mssg'] = "Enter Bill Number";
							header('Location: ../add_material_in.php');
							return;
						}
						if (empty($_POST['amt'])){
							$_SESSION['mssg'] = "Enter Amount";
							header('Location: ../add_material_in.php');
							return;
						}
					   $sql_mat_in_it =  "INSERT into material_in_items (materials_in_id,materials_id, hsn_no,qty,amt ,created, modified) values ('".$last_id['id']."','".$_POST['materials_id'][$i]."','".$_POST['hsn_no'][$i]."','".$_POST['qty'][$i]."','".$_POST['amt'][$i]."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

					   $result_in = mysqli_query($this->conn->getConnection(), $sql_mat_in_it);
				}
				//print_r($sql_mat_in_it); exit();
				if($result_in) {
					$_SESSION['mssg'] = "Product Added";
					header('Location: ../add_material_in.php');
					
				} else {
					$_SESSION['mssg'] = "Product not Added";
					header('Location:../add_material_in.php');
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
			header("Location: ../material_in.php");
		}
	}
	function delete() {
		//print_r($_REQUEST); exit();
		if (!empty($_REQUEST['id'])) {
			$sql = "DELETE FROM materials where id = '".$_REQUEST['id']."'";
			$result = mysqli_query($this->conn->getConnection(), $sql);
			if($result) {
				$_SESSION['mssg'] = "Record Deleted";
				header("Location: ../material_in.php " );
			} else {
				$_SESSION['mssg'] = "Record not Found";
				header("Location: ../material_in.php " );
			}
		}	
	}
}

?>