<?php
include '../config/database.php';


$conn = new Database();
$processing = new Processing();
	
	//print_r($_REQUEST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'Add':
			$processing->add();
			break;
			
		case 'Update':
			$processing->update();
			break;
		
	}

class Processing {
	private $conn; 
	function __construct()
	{
		$this->conn = new Database();
	}

	function add() {
		extract($_POST);
	//	print_r($_POST); exit();
		$a=1;

		for ($i=0; $i<count($_POST['product_id']) ; $i++)  { 
			//print_r(count($_POST['material_id'])); exit();
			for ($j=0; $j<count($_POST['material_id'.$a]); $j++) {
				//print_r($_POST); exit();
				$sql  = "INSERT into processing (order_id, product_id , material_id, qty_used,product_kg, packets, created, modified) values ('".$_POST['order_id']."','".$_POST['product_id'][$i]."','".$_POST['material_id'.$a][$j]."','".$_POST['qty_used'.$a][$j]."','".$_POST['product_kg'][$i]."','".$_POST['packets'][$i]."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";



					//
					$result = mysqli_query($this->conn->getConnection(), $sql);
			}
			$a++;
		}

				//update order table staus
				$sql_update = "UPDATE orders SET status = 'processing' WHERE id = '".$_POST['order_id']."'" ;


				$result = mysqli_query($this->conn->getConnection(), $sql_update);
				//print_r($sql); exit();
				
				if($result) {
					$_SESSION['mssg'] = "Order Added";
					header('Location: ../orders.php');
					
				} else {
					$_SESSION['mssg'] = "Order not Added";
					header('Location:../orders.php');
					}

		



	}
	function update() {
		//print_r($_POST); exit;
		extract($_POST);

		$sql = "UPDATE orders SET status='".$status."'";
								//	print_r($sql); exit;
		$result = mysqli_query($this->conn->getConnection(), $sql);
		if($result) {
			header("Location: ../orders.php");
		}
	}
	
}

?>