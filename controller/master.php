<?php 
	// include_once : will call file onr time only;
	// include : 
	$conn = new Database();
	//$conn->getConnection();
	//print_r($_POST); exit;
	if(isset($_REQUEST['submit']) ) {
	switch($_REQUEST['submit']) 
	{

		case "country":
		    $country=new Master();
		    
		    if($_POST['id']!="")
		    {
		    	$country->updateCountry();
		    }
		    else
		    {
		    	$country->addCountry();	
		    }
		    break;
	

		case "state":
		
		    $state=new Master();
		    
		    if($_POST['id']!=""){
		    	$state->updateState();
		    } else {
		    	$state->addState();
		    }
		    break;   

		case "city":
		    
		    $city=new Master();
		   
		    if($_POST['id']!="") {
		    	$city->updateCity();
		    }
		    else {
		    	$city->addCity();
		    }
		    break;

		case "deleteCountry":
        $deleteCountrty=new User();
        $deleteCountrty->Countrydelete();
        break; 

    case "deleteState":
  
        $deleteState=new User();
        $deleteState->Statedelete();
        break; 

    case "deleteCity":
 
        $deleteCity=new User();
        $deleteCity->Citydelete();
        break;
      }
    
}

	class Master
	{
		public $conn;

		public function __construct()
		{
			$this->conn=new Database();
		}

		public function addCountry()
		{

			$addCountry= "INSERT into countries (name, createdAt) values('".$_POST['countryName']."','".date('Y-m-d H:i:s')."')";
			//print_r($addCountry); exit;
			$result=mysqli_query($this->conn->getConnection(),$addCountry);

			
			if($result)
			{
				header("Location: ../countryList.php");
			}
		}

		public function updateCountry()
		{
			$update="UPDATE countries SET name='".$_POST['countryName']."' WHERE id='".$_POST['id']."' ";
			$result=mysqli_query($this->conn->getConnection(),$update);
			if($result)
			{
				header("Location: ../countryList.php");
			}
		}


		public function addState()
		{
			$addState = "INSERT into states(state_name, country_id, createdAt) values('".$_POST['stateName']."','".$_POST['countryId']."','".date('Y-m-d H:i:s')."')";
			$result=mysqli_query($this->conn->getConnection(),$addState);
			if($result)
			{
				header("Location: ../stateList.php");
			}
		}

		public function updateState()
		{
			$update="UPDATE states SET state_name='".$_POST['stateName']."',
			                           country_id='".$_POST['countryId']."',
			                           createdAt='".date('Y-m-d H:i:s')."' WHERE id='".$_POST['id']."' ";

			$result=mysqli_query($this->conn->getConnection(),$update);
			if($result)
			{
				header("Location: ../stateList.php");
			}                           
		}

		
		public function addCity()
		{
			$addCity = "INSERT into cities(city_name,state_id, country_id, createdAt) values('".$_POST['cityName']."','".$_POST['stateId']."','".$_POST['countryId']."','".date('Y-m-d H:i:s')."')";
			$result=mysqli_query($this->conn->getConnection(),$addCity);
			if($result)
			{
				header("Location: ../cityList.php");
			}
		}

		public function updateCity()
		{
			$update="UPDATE cities SET city_name='".$_POST['cityName']."',
			                           state_id='".$_POST['stateId']."',
			                           country_id='".$_POST['countryId']."',
			                           createdAt='".date('Y-m-d H:i:s')."' WHERE id='".$_POST['id']."' ";

			$result=mysqli_query($this->conn->getConnection(),$update);
			if($result)
			{
				header("Location: ../cityList.php");
			}                               
		}

		public function Countrydelete()
  	   {
  	      if(isset($_REQUEST['id']))
          {
             $query="DELETE FROM countries Where id='".$_REQUEST['id']."' ";
             $row=mysqli_query($this->conn->getConnection(),$query);
            // print_r($query); exit;
             if($row)
            {
         	  header("Location: ../countryList.php");
              return;
            }
          }
  	   }

  	   public function Statedelete()
  	   {
  	     if(isset($_REQUEST['id']))
         {
           $query="DELETE FROM states Where id='".$_REQUEST['id']."' ";
           $row=mysqli_query($this->conn->getConnection(),$query);
           if($row)
           {
         	 header("Location: ../stateList.php");
             return;
           }
         
         }
       }

        public function Citydelete()
    	{
  	      if(isset($_REQUEST['id']))
          {
            $query="DELETE FROM cities Where id='".$_REQUEST['id']."' ";
            $row=mysqli_query($this->conn->getConnection(),$query);
            if($row)
            {
         	 header("Location: ../cityList.php");
             return;
            }
          }
  	    }

  	  public function getCountries() {
  	   		$sql = "SELECT * FROM countries";
  	   		$result = mysqli_query($this->conn->getConnection(), $sql);

  	   		return $result;
  	   }

  	  public function getStates() {
  	  	
  	  		$sql = "SELECT * FROM states";
  	   		$result = mysqli_query($this->conn->getConnection(), $sql);

  	   		return $result;
  	  }
  	

	}

?>		    
