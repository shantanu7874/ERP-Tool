<?php
  header('Access-Control-Allow-Origin: *'); 
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
  include"../config/database.php";
  

  $db = new Database();
  $sql = "SELECT * FROM product GROUP BY cat_name";

  $result = mysqli_query($db->getConnection(),$sql);
  $response = array();

  while($row = mysqli_fetch_assoc($result)){

    $products = array(
      'id' => $row['id'],
      'productName' => $row['product_name'],
      'cat_name' => $row ['cat_name']
    );

    array_push($response, $products);
  }
    echo json_encode($response);

?>