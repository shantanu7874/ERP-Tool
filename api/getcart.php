<?php
  header('Access-Control-Allow-Origin: *'); 
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
  include"../config/database.php";
  
$db = new Database();

/*$uni = "SELECT table1.columnnames....n, table2.columnames....n, FROM table1 
      INNER JOIN  table2 on 
      table1.id=table2.columnames";*/

$sql = " SELECT *, SUM(cart.qty) as cart_qty, product.id, product.product_name FROM cart INNER JOIN product on cart.product_id = product.id       WHERE ecom_customer_id = '".$_REQUEST['userid']."' GROUP BY product_id ";
 $result = mysqli_query($db->getConnection(), $sql);
    //$row = mysqli_fetch_assoc($result);
    $response = array();

    while($row = mysqli_fetch_assoc($result)){

    $products = array(

      'id' => $row['id'],
      'productName' => $row['product_name'],
      'product_id' => $row['product_id'],
      'aiq' => $row['aiq'],
      'image'=> $row['product_image'],
      'mrp' => $row['mrp'],
      'qty' => $row['cart_qty']

    );
    array_push($response, $products);
    
}

echo json_encode($response);
?>