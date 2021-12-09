<?php
  header('Access-Control-Allow-Origin: *'); 
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  header('Access-Control-Allow-Methods: GET, POST, PUT');
  include"../config/database.php";
  
$db = new Database();
      // 1. Check if email exists or notå.
      //print_r($_REQUEST);
      // if (empty($email)) {
      //   $_SESSION['err_mail'] = "Email Required";
        
      //   return;
      // }
      // // wrong email input -> correct asel tar true and for wrong false. 
      // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      //   $_SESSION['err_mail'] = "Enter valid email ";
       
      //   return;
      // }
      // if (empty($password)) {
      //   $_SESSION['err_pass'] = "Password Required";
        
      //   return;
      // }
      // // count works only for array. strlen() gives count of char in a word.
      // $pass_length = strlen($password);
      // //print_r($pass_length); exit;
      // if ($pass_length < 6) {
      //   $_SESSION['err_pass'] = "Password field should have altleast 8 Char";
       
      //   return;
      // }


      $sql = "SELECT * FROM users WHERE email = '".$_REQUEST['email']."'";
      //print_r($sql); 

      $result = mysqli_query($db->getConnection(), $sql);
      $row = mysqli_fetch_assoc($result);
      //print_r($row);
     
      if ($row) {
       
        // first variable user input password and second varibale form database
        if (md5($_REQUEST['password']) == $row['password']) {
          $data = array(
            'id'=> $row['id'],
            'email'=>$_REQUEST['email'],
            'name'=>$row ['name'],
            'mssg' => "ALL_OK"
          );
           echo json_encode($data);
          //print_r($data); exit();
        } else {
          
          $data = array(
            'status' => 200,
            'mssg' => "Invalid password"
          );
          echo json_encode($data);
        }
       
        
      } else {
        
         $data = array(
            'status' => "EMAIL_NOT_FOUND",
            'mssg' => "Email id not found",
          );
          echo json_encode($data);
      }
      
    
?>