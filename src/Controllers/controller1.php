<?php
session_start();

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\ValidationException;

class LoginController{


	public function __construct($container){
		$this->view = $container['view'];
		$this->flash = $container['flash'];
		$this->settings = $container->get('settings')['dbsettings'];

	}
	public function login_redirect($request, $response, $next){
		$this->view->render($response, 'login.twig');
	
	}

	public function login_check($request, $response, $next){
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return $next($request, $response);
		}
		else {
			return $response->withRedirect('/');
		}



	}

	public function postSignup($request, $response, $next){
		$username = $request->getParam('Username');
		$password = $request->getParam('Password');
		$userErr = "";
		$passErr = "";
		$userValidator = v::email()->length(5,200);
		$passValidator = v::alnum()->length(7,11);

		try {
  		$userValidator->check($username);
			} 
		catch(ValidationException $exception) {
   		$userErr = $exception->getMainMessage();
			}

		

		try {
		    $passValidator->assert($password);
		} catch(NestedValidationException $exception) {
		    $errors = $exception->findMessages([
		    'alnum' => 'Password must contain only letters and digits. ',
		    'length' => 'Password must have length of 7 to 11 characters.'
			]);
			$passErr = $errors['alnum'] . $errors['length'];
		}

		$email = $username;
		$split = explode('@',$email);
		$name = $split[0];
		$this->flash->addMessage('username', $name);
		$this->flash->addMessage('passErr', $passErr);
		$this->flash->addMessage('userErr', $userErr);
		if($userErr == "" && $passErr == ""){
			$_SESSION['username'] = $name;
			$_SESSION['loggedin'] = true;
			return $response->withRedirect('/projects');
		}
		else{
		return $response->withRedirect('/');
		}
	}

	public function session($request, $response){
		echo json_encode($_SESSION);
	}

	public function projects_redirect($request, $response){
		$settings = $this->settings; //$settings[servername] 
		$empty= "";


		$connection = new ConnectionController();
		$conn = $connection->connect($settings['servername'], $settings['username'], $settings['password'], $settings['dbname']);


		$result = $conn->prepare("SELECT Name, Budget, projects_id FROM projects");
		$result->execute();
		$output = $result;

		foreach($output as $row){
			$results[] = $row;
		}

		
		if(empty($results))
		{
		 	$empty = "Table is empty. Create a new project to fill table!";
		 	$this->flash->addMessage('empty', $empty);
		 	$this->view->render($response, 'projects.twig');
		 }
		else
		{
		 	$this->flash->addMessage('empty', $empty);
		 	$this->view->render($response, 'projects.twig', array('projects' => $results));
		 }



		
		
		return $response;
	}

	public function logout($request, $response){
		session_start();
		session_unset();
		session_destroy();
		return $response->withRedirect('/');
	}








}