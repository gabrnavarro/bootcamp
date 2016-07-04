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
			$empty= "";

			$connection = new ConnectionController();
			$conn = $connection->connect($settings['servername'], $settings['username'], $settings['password'], $settings['dbname']);


			$query = $connection->InsertProject($conn, $Code, $Name, $Budget, $Remarks);
			return $response->withRedirect('/projects');

			}
		public function assign_project_redirect($request, $response){
			$this->view->render($response, 'project_assign.html');


		}




}