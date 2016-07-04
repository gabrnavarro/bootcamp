<?php

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\ValidationException;

class PersonsController{


		public function __construct($container){
		$this->view = $container['view'];
		$this->flash = $container['flash'];
		$this->settings = $container->get('settings')['dbsettings'];

		}

		public function create_redirect($request, $response){
			$this->view->render($response, 'persons_create.twig');

		}

		public function create_form_submit($request, $response){
			$Firstname = $request->getParam('Firstname');
			$Lastname = $request->getParam('Lastname');
			$Username = $request->getParam('Username');
			$Password= $request->getParam('Password');
			$LastErr = "";
			$FirstErr = "";
			$userErr = "";
			$passErr = "";

			$alphaValidator = v::alpha()->length(2,50);
			$emailValidator = v::email()->length(5,200);
			$passValidator = v::alnum()->length(7,11)->NoWhitespace();

			try {
	  		$alphaValidator->check($Lastname);
				} 
			catch(ValidationException $exception) {
	   		$LastErr = $exception->getMainMessage();
			}

			try {
	  		$alphaValidator->check($Firstname);
				} 
			catch(ValidationException $exception) {
	   		$FirstErr = $exception->getMainMessage();
			}

			try {
	  		$emailValidator->check($Username);
				} 
			catch(ValidationException $exception) {
	   		$userErr = $exception->getMainMessage();
			}


			try {
			    $passValidator->assert($Password);
				} catch(NestedValidationException $exception) {
			    $errors = $exception->findMessages([
				    'alnum' => 'Password must contain only letters and digits. ',
				    'length' => 'Password must have length of 7 to 11 characters. ',
				    'NoWhitespace' => 'Password must not contain spaces. '			
			    ]);
				$passErr = $errors['alnum'] . $errors['length'] . $errors['NoWhitespace'];
			}


			if($userErr == "" && $passErr == "" && $FirstErr=="" && $LastErr ==""){
			$settings = $this->settings; 
			

			$connection = new ConnectionController();
			$conn = $connection->connect($settings['servername'], $settings['username'], $settings['password'], $settings['dbname']);
		   	$query = $connection->InsertPerson($conn, $Lastname, $Firstname, $Username, $Password);

			echo "insert success";

			return $response->withRedirect('/projects');
			}

			else{
				$this->flash->addMessage('FirstErr', $FirstErr);
				$this->flash->addMessage('LastErr', $LastErr);
				$this->flash->addMessage('userErr', $userErr);
				$this->flash->addMessage('passErr', $passErr);

				return $response->withRedirect('/persons/create');
			}
		}
}