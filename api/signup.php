<?php
  header('Access-Control-Allow-Origin: *'); 
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
  include"../config/database.php";
  
$db = new Database();

    extract($_POST);
   // print_r($_REQUEST);

     if(!empty($_REQUEST['email'])) { 

          $email = $_REQUEST['email'];

          // check if data present or not
          $check_sql = "SELECT * FROM ecom_customers WHERE email = '".$_REQUEST['email']."' ";
          // run query
          $check_res  = mysqli_query($db->getConnection(), $check_sql);
          $check_row = mysqli_fetch_assoc($check_res);
         
          if($check_row) {
            $data = array(
              'mssg'=>'Email aready exist'
            );
            echo json_encode($data);
            return;
          }
          
            
          $sql  = "INSERT into ecom_customers (name, email, password, created, modified) values ('".$_REQUEST['name']."', '".$_REQUEST['email']."', '".$_REQUEST['password']."', '".date('Y-m-d H:i:s')."',  '".date('Y-m-d H:i:s')."' )";
         // print_r($sql); 
          $result = mysqli_query($db->getConnection(), $sql);
          print_r($result);

          if ($result) {

              $result = array(
              'status' => 200,
              'mssg' => "User Created"
            );
               echo json_encode($result);
              ///print_r($data);
            } else {
              
              $result = array(
                'status' => 200,
                'mssg' => "Invalid password"
              );
              echo json_encode($result);
            }
          
      } else{

        $result = array(
        'status' => 00,
        'mssg' => "Enter Email"
      );
        echo json_encode($result);
      }
      
    
?>