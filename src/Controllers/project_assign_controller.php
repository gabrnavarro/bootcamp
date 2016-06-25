<?php

class ProjectAssignController{
			public function __construct($container){
			$this->view = $container['view'];
			$this->flash = $container['flash'];
			$this->settings = $container->get('settings')['dbsettings'];

			}
			
			public function send_member_info($request, $response){
			$settings = $this->settings; //$settings[servername] 
			$servername = $settings['servername'];
			$username = $settings['username'];
			$password = $settings['password'];
			$dbname = $settings['dbname'];


			try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
			catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }

			$idnow = $_GET["projects_id"];

			$query = $conn->prepare("SELECT * from persons where $idnow=persons.project_id");
			$query->execute();
			$result = $query;
			$query1 = $conn->prepare("SELECT persons.person_id, persons.Firstname, persons.Lastname from persons where $idnow!=persons.project_id or project_id is NULL");
			$query1->execute();
			$result1 = $query1;
			$results =[];
			$results1 = [];

			foreach($result as $row){
			$results[] = $row;				//Current members
			}

		
			foreach($result1 as $row1){
			$results1[] = $row1;			//Nonmembers
			}

			echo json_encode($results);


		}

		public function add_member($request, $response){
			$settings = $this->settings; //$settings[servername] 
			$servername = $settings['servername'];
			$username = $settings['username'];
			$password = $settings['password'];
			$dbname = $settings['dbname'];


			try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
			catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }
		    $mem_id = $_POST['name'];
		    $proj_id = $_POST['projects_id'];
		    $conn->exec("UPDATE persons set project_id= $proj_id where person_id=$mem_id");

		    $query = $conn->prepare("SELECT persons.person_id, persons.Lastname, persons.Firstname from persons where persons.person_id = $mem_id");
		    $query->execute();
		    $result = $query;

		    foreach($result as $row){
		    	$results[]=$row;
		    }
			echo json_encode($results);


		}

		public function remove_member($request, $response){
			$settings = $this->settings; //$settings[servername] 
			$servername = $settings['servername'];
			$username = $settings['username'];
			$password = $settings['password'];
			$dbname = $settings['dbname'];

			try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
			catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }

		    $mem_id = $_POST['name'];
			$conn->exec("UPDATE persons set project_id= 0 where person_id=$mem_id");
			
			$query = $conn->prepare("SELECT persons.person_id, persons.Lastname, persons.Firstname from persons where persons.person_id = $mem_id");
		    $query->execute();
		    $result = $query;

		    foreach($result as $row){
		    	$results[]=$row;
		    }
			echo json_encode($results);

		}


}