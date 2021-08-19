<?php
include '../config/database.php';


$conn = new Database();
$invoice = new Invoice();
	
	//print_r($_POST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'Add':
			$invoice->add();
			break;
			
		case 'Update':
			$invoice->update();
			break;
		
	}

class Invoice {
	private $conn; 
	function __construct()
	{
		$this->conn = new Database();
	}

	function add() {
		extract($_POST);

		// 1. Check if invoice is generated ? 2. if yes then get count number. $row['count'] + 1
			$sql_check = "SELECT * FROM invoice WHERE order_id = '".$_REQUEST['order_id']."'";
			$res_check = mysqli_query($this->conn->getConnection(), $sql_check);
			$row_check = mysqli_fetch_assoc($res_check);
				if ($row_check) {
					// update count here
					$p_count = $row_check['print_count'] + 1;
					$invoice_update = "UPDATE invoice set print_count = '".$p_count."'";
					$res_update = mysqli_query($this->conn->getConnection(),$invoice_update);
					header('Location: ../invoice.php?id='.$_REQUEST['order_id'].'&print=true');
					
				}else{
					// insert invoice data

				$sql  = "INSERT into invoice (order_id, customer_id , date,invoice_no,subtotal,gst_total,amount_to_pay,print_count, created, modified) values ('".$_POST['order_id']."','".$_POST['customer_id']."','".date('Y-m-d H:i:s')."','".$_POST['invoice_no']."','".$_POST['subtotal']."','".$_POST['gst_total']."','".$_POST['amount_to_pay']."',1,'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

					//print_r($sql); exit();
					$result = mysqli_query($this->conn->getConnection(), $sql);
					
				
				// get last insert id
				$insert_id =" SELECT MAX(id) as id FROM invoice"; //mysqli_insert_id ($this->conn->getConnection());
				$result_id = mysqli_query($this->conn->getConnection(), $insert_id);
				$last_id = mysqli_fetch_assoc($result_id);

				for($i=0; $i<count($_POST['product_id']); $i++ ) {
					
					   $sql_invoice =  "INSERT into invoice_items (invoice_id,product_id,product_name, hsn_no,mrp,packets ,rate, total, gst, final_amt, created, modified) values ('".$last_id['id']."','".$_POST['product_id'][$i]."','".$_POST['product_name'][$i]."','".$_POST['hsn_no'][$i]."','".$_POST['mrp'][$i]."','".$_POST['packets'][$i]."','".$_POST['rate'][$i]."','".$_POST['total'][$i]."','".$_POST['gst'][$i]."','".$_POST['final_amt'][$i]."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."' )";

					   	//print_r($sql_invoice); exit;

					   $result_invoice = mysqli_query($this->conn->getConnection(), $sql_invoice);
					   //print_r($sql_invoice); exit(); 
				}


				//update order table staus
				$sql_update = "UPDATE orders SET status = 'delivered' WHERE id = '".$_POST['order_id']."'" ;
				$result = mysqli_query($this->conn->getConnection(), $sql_update);
				//print_r($sql); exit();
				
				if($result) {
					$_SESSION['mssg'] = "Product Added";
					header('Location: ../invoice-print.php?id='.$_POST['order_id']);
					
				} else {
					$_SESSION['mssg'] = "Product not Added";
					header('Location:../orders.php');
					}
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

<script type="text/javascript">
	
	window.onload = function{

		var p = getElementById('print') 
			p= print

		if (p){
			window.open("_blank");
		}
	}
</script>