<?php
header('Access-Control-Allow-Origin: *');
include"../config/database.php";

$db = new Database();
$sql = "SELECT * FROM product WHERE id = $_REQUEST['id']";

$result = mysqli_query($db->getConnection()),$sql);
$row = mysqli_fetch_assoc($result);
$response = array(
	'id'=>$row['id'],
	'hsn'=>$row['hsn_no']
);
	

 echo json_encode($response);

?>