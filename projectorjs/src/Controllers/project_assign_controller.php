<?php

class ProjectAssignController{
			public function __construct($container){
			$this->view = $container['view'];
			$this->flash = $container['flash'];
			$this->settings = $container->get('settings')['dbsettings'];

			}
			
			public function send_member_info($request, $response){
			$settings = $this->settings; //$settings[servername] 
			

			$connection = new ConnectionController();
			$conn = $connection->connect($settings['servername'], $settings['username'], $settings['password'], $settings['dbname']);


			$idnow = $_GET["projects_id"];

			
			$query = $connection->GetMems($conn, $idnow);
			$result = $query;
			$results =[];

			foreach($result as $row){
			$results[] = $row;				//Current members
			}


			echo json_encode($results);


		}

		public function send_nonmember_info($request, $response){
			$settings = $this->settings; //$settings[servername] 
			

			$connection = new ConnectionController();
			$conn = $connection->connect($settings['servername'], $settings['username'], $settings['password'], $settings['dbname']);


			$idnow = $_GET["projects_id"];
			$query1 = $connection->GetNonMems($conn, $idnow);
			$result1 = $query1;
			$results1 = [];

			foreach($result1 as $row1){
			$results1[] = $row1;			//Nonmembers
			}

			echo json_encode($results1);

		}

		public function add_member($request, $response){
			$settings = $this->settings; //$settings[servername] 
			

			$connection = new ConnectionController();
			$conn = $connection->connect($settings['servername'], $settings['username'], $settings['password'], $settings['dbname']);
			$params = json_decode(file_get_contents('php://input'),true);
			$_POST = $params;
		    $mem_id = $_POST['name'];
		    $proj_id = $_POST['projects_id'];
		    
		    $query = $connection->AddMem($conn, $mem_id, $proj_id);
		    $result = $query;

		    foreach($result as $row){
		    	$results[]=$row;
		    }
			echo json_encode($results);


		}



		public function remove_member($request, $response){
			$settings = $this->settings; //$settings[servername] 

			$connection = new ConnectionController();
			$conn = $connection->connect($settings['servername'], $settings['username'], $settings['password'], $settings['dbname']);

			$params = json_decode(file_get_contents('php://input'),true);
			$_POST = $params;
		    $mem_id = $_POST['name'];
			
		    $query = $connection->RemoveMem($conn, $mem_id);
		    $result = $query;

		    foreach($result as $row){
		    	$results[]=$row;
		    }
			echo json_encode($results);

		}


}