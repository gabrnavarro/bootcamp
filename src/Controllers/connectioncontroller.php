<?php

class ConnectionController{
	public function __construct(){
			}

	public function connect($servername, $username, $password, $dbname){
		
			try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
			catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }
		    return $conn;


	}

	public function InsertPerson($conn, $Lastname, $Firstname, $Username, $Password) {
			$stmt =  $conn->prepare("INSERT into persons(Lastname, Firstname, Username, Password) values(:Lastname, :Firstname, :Username, :Password)");
		    $stmt->bindParam(':Lastname', $Lastname);
		    $stmt->bindParam(':Firstname', $Firstname);
		    $stmt->bindParam(':Username', $Username);
		    $stmt->bindParam(':Password', $Password);

		    $stmt->execute();
	}

	public function InsertProject($conn, $Code, $Name, $Budget, $Remarks){

		$stmt = $conn->prepare("INSERT into projects(Code, Name, Budget, Remarks) values(:Code, :Name, :Budget, :Remarks)");
		    $stmt->bindParam(':Code', $Code);
		    $stmt->bindParam(':Name', $Name);
		    $stmt->bindParam(':Budget', $Budget);
		    $stmt->bindParam(':Remarks', $Remarks);

		    $stmt->execute();
			echo "insert success";
	}

	public function GetMems($conn, $idnow){
		$query = $conn->prepare("SELECT * from persons where :idnow=persons.project_id");
			$query->bindParam(':idnow', $idnow);
			$query->execute();
			return $query;

	}

	public function GetNonMems($conn, $idnow){
		$query1 = $conn->prepare("SELECT persons.person_id, persons.Firstname, persons.Lastname from persons where :idnow!=persons.project_id or project_id is NULL");
			$query1->bindParam(':idnow', $idnow);
			$query1->execute();
			return $query1;
	}

	public function AddMem($conn, $mem_id, $proj_id){
		$conn->exec("UPDATE persons set project_id= $proj_id where person_id=$mem_id");

		    $query = $conn->prepare("SELECT persons.person_id, persons.Lastname, persons.Firstname from persons where persons.person_id = :mem_id");
		    $query->bindParam(':mem_id', $mem_id);
		    $query->execute();
		    return $query;
	}
	public function RemoveMem($conn, $mem_id){
		$conn->exec("UPDATE persons set project_id= 0 where person_id=$mem_id");
			
			$query = $conn->prepare("SELECT persons.person_id, persons.Lastname, persons.Firstname from persons where persons.person_id = :mem_id");
			$query->bindParam(':mem_id', $mem_id);
		    $query->execute();
		    return $query;
	}
}