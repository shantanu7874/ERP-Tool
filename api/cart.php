<?php
  header('Access-Control-Allow-Origin: *'); 
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
  include"../config/database.php";
  
$db = new Database();

  if(empty($_REQUEST['product_id'])) {

      $msg = array(
      'staus' => 111,
      'mssg' => "Product not Found" 
       );
    echo json_encode($msg);
    return;
  } 

          $sql  = "INSERT into cart (ecom_customer_id, product_id,qty, payment, created, modified) values ('".$_REQUEST['userid']."', '".$_REQUEST['product_id']."','".$_REQUEST['qty']."', '".$_REQUEST['payment']."', '".date('Y-m-d H:i:s')."',  '".date('Y-m-d H:i:s')."' )";
         // print_r($sql); 
          $result = mysqli_query($db->getConnection(), $sql);
        //  print_r($result);

          if ($result) {

              $result = array(
              'status' => 200,
              'mssg' => "Cart Created"
            );
               echo json_encode($result);
              ///print_r($data);
            } else {
              
              $result = array(
                'status' => 100,
                'mssg' => "Cart not craeted"
              );
              echo json_encode($result);
            }
    
?>