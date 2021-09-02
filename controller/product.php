<?php
include '../config/database.php';


$conn = new Database();
$product = new Products();
	
	//print_r($_REQUEST); exit();
	switch ($_REQUEST['submitVal']) {
		case 'Add':
			$product->add();
			break;

		case 'delete':
			$product->delete();
			break;
			
		case 'Update':
			$product->update();
			break;
		
		default:
			# code...
			break;
	}

class Products {
	private $conn; 
	function __construct()
	{
		$this->conn = new Database();
	}

	function add()

	 {
		extract($_POST);
		//print_r($_POST); exit();
		if (empty($_POST['product_name'])){
					$_SESSION['mssg'] = "Enter Product Name";
					header('Location: ../add_product.php');
					return;
				}
				if (empty($_POST['gst_no'])){
					$_SESSION['mssg'] = "Enter GST %";
					header('Location: ../add_product.php');
					return;
				}
				if (empty($_POST['req_percentage'])){
					$_SESSION['mssg'] = "Enter Qty %";
					header('Location: ../add_product.php');
					return;
				}
		 $material_name_to_string = 0;
		 $req_percentage_to_string = 0;
		 if(!empty($_POST['materials_id'])) {
			$material_name_to_string= implode(", ", $_POST['materials_id']);
		 }
		if(!empty($_POST['req_percentage'])) {
		 	$req_percentage_to_string = implode(", ", array_filter($_POST['req_percentage']));
		 }
		// $arry_to_string = 0;
		// $mrp_arry_to_string = 0;
		// $rate_arry_to_string = 0;
		// if(!empty($_POST['aiq'])) {
		// 	$arry_to_string= implode(", ", $_POST['aiq']);
		// }
		// if(!empty($_POST['mrp'])) {
		// 	$mrp_arry_to_string = implode(", ", array_filter($_POST['mrp']));
		// }
		// if(!empty($_POST['rate'])) {
		// 	$rate_arry_to_string = implode(", ", array_filter($_POST['rate']));
		// }
		//print_r(array_filter($_POST['mrp']));exit;
		$product_image = "";
		// Rules 1. Upload image first;

		if (!empty($_POST['product_name'])) {

			if (!empty($_FILES['product_image']['name'])) {
				$filepath = "../images/products/".$_FILES['product_image']['name'];
				$ext=pathinfo($_FILES['product_image']['name'],PATHINFO_EXTENSION);

				$extension=array('jpeg','jpg','png');

					if (isset($_POST['submit'])) {
						if (in_array($ext, $extension) == false) {
							//print_r("fss"); exit;
							$_SESSION['err_mssg'] = "Upload only jpg, jpeg or PNG file.";
							header("Location: ../add_product.php");
							return;
						}
						if($_FILES['product_image']['size'] >= 100000000) {
							$_SESSION['err_mssg'] = "Upload File less than 1mb";
							header("Location: ../add_product.php");
							return;
						}
				}
				// (tmp_file_location, filepath)
				move_uploaded_file($_FILES['product_image']['tmp_name'], $filepath);

				$product_image = $_FILES['product_image']['name'];
			} 
			for ($i=0; $i <count($_POST['aiq']); $i++)  {
			$product_name = $_POST['product_name']."-".$_POST['aiq'][$i];
			$sql  = "INSERT into product (product_name,materials_id, req_percentage,gst_no, aiq, mrp, rate, discount,hsn_no,description, product_image, created, modified) values ('".$product_name."',
			'".$material_name_to_string."',
			'".$req_percentage_to_string."',
			'".$_POST['gst_no'][$i]."',
			 '".$_POST['aiq'][$i]."',
			  '".$_POST['mrp'][$i]."',
			 '".$_POST['rate'][$i]."', 
			 '".$_POST['discount']."',
			 '".$_POST['hsn_no']."',
			 '".$_POST['description']."',
			 '".$product_image."', 
			  '".date('Y-m-d H:i:s')."', 
			   '".date('Y-m-d H:i:s')."' )";

				//print_r($_POST); exit;

				$result = mysqli_query($this->conn->getConnection(), $sql);

				//print_r($sql); exit();
			}				
				if($result) {
					$_SESSION['mssg'] = "Product Added";
					header('Location: ../add_product.php');
					
				} else {
					$_SESSION['mssg'] = "Product not Added";
					header('Location:../add_product.php');
					}

			}		

	}

	function update() {
		//print_r($_POST); exit;
		extract($_POST);
		$product_image = "";

		if(!empty($oldImg)) {
			$product_image = $oldImg;
		}
		// --- start Code for new image 
		if (!empty($_FILES['product_image']['name'])) {
			$filepath = "../images/products/".$_FILES['product_image']['name'];
			$product_image = $_FILES['product_image']['name'];
			// Image uploading code
			if(pathinfo('images/products/'.$oldImg)) {
				if (!empty($oldImg)){
					unlink('images/products/'.$oldImg);
				}
			}
			move_uploaded_file($_FILES['product_image']['tmp_name'], $filepath);
			
		}
		// --- End
		// 1. Pic not present -> and we are uploading new pic
		// 2. Old image present and we are uploading new pic

		
		if (!empty($_POST['aiq'])) {
			$aiq_string = implode(',', array_filter($_POST['aiq'])); 
		} 
		if (!empty($_POST['mrp'])) {
			$mrp_string = implode(',', array_filter($_POST['mrp']));
		}
		if (!empty($_POST['rate'])) {
			$rate_string = implode(',', array_filter($_POST['rate']));
		}
		//print_r(array_filter($_POST['mrp'])); exit;
		$sql = "UPDATE product SET product_name='".$product_name."',
									gst_no = '".$gst_no."',
									aiq = '".$aiq_string."',
									mrp = '".$mrp_string."',
									rate = '".$rate_string."',
									discount = '".$discount."',
									hsn_no = '".$hsn_no."',
									product_image = '".$product_image."',
									modified = '".date('Y-m-d H:i:s')."' WHERE id = '".$id."'";
									//print_r($sql); exit;
		$result = mysqli_query($this->conn->getConnection(), $sql);
		if($result) {
			header("Location: ../product.php");
		}
	}

	function delete() {
		//print_r($_REQUEST); exit();
		if (!empty($_REQUEST['id'])) {
			$sql = "DELETE FROM product where id = '".$_REQUEST['id']."'";
			$result = mysqli_query($this->conn->getConnection(), $sql);
			if($result) {
				$_SESSION['mssg'] = "Record Deleted";
				header("Location: ../product.php " );
			} else {
				$_SESSION['mssg'] = "Record not Found";
				header("Location: ../product.php " );
			}
		}
		
	}

}	

?>