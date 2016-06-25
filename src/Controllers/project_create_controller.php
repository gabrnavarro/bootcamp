<?php

class ProjectController{


		public function __construct($container){
		$this->view = $container['view'];
		$this->flash = $container['flash'];
		$this->settings = $container->get('settings')['dbsettings'];

		}

		public function create_redirect($request, $response){


			$this->view->render($response, 'project_create.twig');
		}

		public function create_form_submit($request, $response){
			$Code = $request->getParam('Code');
			$Name = $request->getParam('Name');
			$Budget = $request->getParam('Budget');
			$Remarks = $request->getParam('Remarks');

			echo $Code . $Name . $Budget . $Remarks;

			$settings = $this->settings; //$settings[servername] 
			$servername = $settings['servername'];
			$username = $settings['username'];
			$password = $settings['password'];
			$dbname = $settings['dbname'];
			$empty= "";


			try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
			catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }

		    $conn->exec("INSERT into projects(Code, Name, Budget, Remarks) values('$Code', '$Name','$Budget', '$Remarks')");
			echo "insert success";

			return $response->withRedirect('/projects');

			}
		public function assign_project_redirect($request, $response){
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

			$query1 = $conn->prepare("SELECT person_id, Firstname, Lastname from persons where $idnow!=project_id OR project_id IS NULL");
			$query1->execute();
			$result1 = $query1;
			$results1 = [];
		
			foreach($result1 as $row1){
			$results1[] = $row1;
			}

			


			$this->view->render($response, 'project_assign.twig', array('nonmembers'=>$results1));


		}




}