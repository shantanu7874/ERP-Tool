<?php
include '../config/database.php';


$conn = new Database();
$order = new Orders();
	
	//print_r($_REQUEST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'Add':
			$order->add();
			break;

		case 'delete':
			$order->delete();
			break;
			
		case 'Update':
			$order->update();
			break;
		case 'processing':
			$order->changeStatus($_REQUEST['status'], $_REQUEST['id']);
			break;
		default:
			# code...
			break;
	}

class Orders {
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
		//print_r($_POST); exit;
		$sql  = "INSERT into orders (customer_id,order_date,deadline,user_id,created, modified) values ('".$_POST['customer_id']."','".date('Y-m-d')."','".$_POST['deadline']."','".$_SESSION['id']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

			//	print_r($_POST) ; echo "<br>";
				$result = mysqli_query($this->conn->getConnection(), $sql);

				//print_r($sql); exit();

				$insert_id =" SELECT MAX(id) as id FROM orders"; //mysqli_insert_id ($this->conn->getConnection());
				
				$result_id = mysqli_query($this->conn->getConnection(), $insert_id);
				$last_id = mysqli_fetch_assoc($result_id);

				 
				  for($i=0; $i<count($_POST['product_id']); $i++ ) {
					
				 	$packets_to_string = 0;
				
				 	if (empty($_POST['packets'])){
					$_SESSION['mssg'] = "Enter Packets";
					header('Location: ../add_order.php');
					return;
					}

					$sql_mat_in_it =  "INSERT into order_product_items (order_id, product_id, packets,created, modified) values ('".$last_id['id']."','".$_POST['product_id'][$i]."','".$_POST['packets'][$i]."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";


					   $result_in = mysqli_query($this->conn->getConnection(), $sql_mat_in_it);
					 //  print_r($sql_mat_in_it); exit();
				
					}
				
				if($result) {
					$_SESSION['mssg'] = "Order Added";
					header('Location: ../add_order.php');
					
				} else {
					$_SESSION['mssg'] = "Order not Added";
					header('Location:../add_order.php');
					}

			}		

	function update() {
		//print_r($_POST); exit;
		extract($_POST);

		$sql = "UPDATE orders SET customer_id='".$customer_id."',
									order_date='".$order_date."',
									deadline='".$deadline."',
									user_id='".$user_id."',
									modified = '".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
								//	print_r($sql); exit;
		$result = mysqli_query($this->conn->getConnection(), $sql);
		if($result) {
			header("Location: ../orders.php");
		}
	}
	function delete() {
		//print_r($_REQUEST); exit();
		if (!empty($_REQUEST['id'])) {
			$sql = "DELETE FROM orders where id = '".$_REQUEST['id']."'";
			$result = mysqli_query($this->conn->getConnection(), $sql);
			if($result) {
				$_SESSION['mssg'] = "Record Deleted";
				header("Location: ../orders.php " );
			} else {
				$_SESSION['mssg'] = "Record not Found";
				header("Location: ../orders.php " );
			}
		}	
	}
	function changeStatus($status, $id){
			$sql = "Update orders SET status = '".$status."' WHERE id = '".$id."' ";
			//print_r($sql); exit();
			$result = mysqli_query($this->conn->getConnection(), $sql);
			if($url = "controller/orders.php?submitVal=processing&status=completed&id=".$row['id']) {
				header("Location: ../orders.php " );
			}

	}
}

?>