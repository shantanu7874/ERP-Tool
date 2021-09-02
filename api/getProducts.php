<?php
  header('Access-Control-Allow-Origin: *');
  include"../config/database.php";
  

  $db = new Database();
  $sql = "SELECT * FROM product";

  $result = mysqli_query($db->getConnection(),$sql);
  $response = array();

  while($row = mysqli_fetch_assoc($result)){

    $products = array(
      'id' => $row['id'],
      'productName' => $row['product_name'],
      'mrp' => $row['mrp'],
      'hsn' => $row['hsn_no'],
      'description'=> $row['description'],
      'image' => $row ['product_image']
    );

    array_push($response, $products);
  }
    echo json_encode($response);

?>