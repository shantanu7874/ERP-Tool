<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, PUT');
  include"../config/database.php";

$db = new Database();
$sql = "SELECT * FROM product WHERE hsn_no = '".$_REQUEST['hsn']."' GROUP BY product_name ";
$sql_aiq = "SELECT id, aiq, mrp FROM product WHERE hsn_no = '".$_REQUEST['hsn']."' ";
//print_r($sql); exit();

$result = mysqli_query($db->getConnection(),$sql);
$result_aiq = mysqli_query($db->getConnection(),$sql_aiq);
//print_r($resul_aiq);
$row = mysqli_fetch_assoc($result);
$aiq_array = array();
while($row_aiq = mysqli_fetch_assoc($result_aiq)){ 
	$aiq = array(
		'id' => $row_aiq['id'],
		'qty' => $row_aiq['aiq'],
		'mrp' => $row_aiq['mrp']
	);
	array_push($aiq_array, $aiq);
 }
 //print_r($aiq); exit();
$response = array(
	'id'=>$row['id'],
	'hsn'=>$row['hsn_no'],
	'image'=> $row['product_image'],
	'productName'=>$row['product_name'],
	'description'=>$row['description'],
	'mrp'=>$row['mrp'],
	'aiq' =>  $aiq_array
);

echo json_encode($response);
	

 

?>