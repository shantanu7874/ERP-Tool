<?php 
	
	session_start();
	class Database 
	{
		
		private $servername = "localhost";
		private $username = "root";
		private $password = "";
		private $db = "shrijee";
		private $conn;

		public function getConnection() 
		{
		
		$this->conn = null;

		try
			{
				$this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

			}
			catch(Exception $e)
			{
				die("Connection Failed". $connection->connect_error );
			}
			return $this->conn;
		}

	}
	// if($conn) {
	// 	echo "Connection Successfull"; 
	// } else {
	// 	echo "Connection Failed";
	// }

	// // $conn_object = new mysqli($localhost, $username, $password, $database);
	// //print_r($conn_object);
	// if ($conn_object->connect_error) {
	// 	die("Connection failed: " . $conn->connect_error);
	// } else {
	// 	echo "Connection Successfull";
	// }


?>