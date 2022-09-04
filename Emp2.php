<?php
session_start();

require('config.php');
class Task extends Dbconfig {
    
    protected $hostName;
    protected $userName;
    protected $password;
	protected $dbName;
	private $empTable = 'tasks';
	private $dbConnect = false;
        private $project_id=0;
    public function __construct(){
        if(!$this->dbConnect){ 		
			$database = new dbConfig();            
            $this -> hostName = $database -> serverName;
            $this -> userName = $database -> userName;
            $this -> password = $database ->password;
			$this -> dbName = $database -> dbName;			
            $conn = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            } else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
             var_dump($sqlQuery);
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}   	
	public function taskList(){		
		$sqlQuery = "SELECT * FROM ".$this->empTable." WHERE project_id='".$_SESSION['project_id']."' ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'AND(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR description LIKE "%'.$_POST["search"]["value"].'%" ';
			
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		
		$sqlQueryTotal = "SELECT * FROM ".$this->empTable." WHERE project_id='".$_SESSION['project_id']."'";
		$resultTotal = mysqli_query($this->dbConnect, $sqlQueryTotal);
		$numRowsTotal = mysqli_num_rows($resultTotal);
		
		$employeeData = array();	
		while( $employee = mysqli_fetch_assoc($result) ) {		
			$empRows = array();			
			$empRows[] = $employee['id'];
			$empRows[] = ucfirst($employee['name']);
			$empRows[] = $employee['description'];	
                        	
                       $empRows[] = '<button type="button" name="update" id="'.$employee["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$empRows[] = '<button type="button" name="delete" id="'.$employee["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			//$empRows[] = $employee['user_id'];
                        $empRows[] = '<button type="button" name="view" id="'.$employee["id"].'" class="btn btn-danger btn-xs view" >View</button>';
			
                        $employeeData[] = $empRows;
		}
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$numRows,
			"iTotalDisplayRecords"	=>  $numRowsTotal,
			"data"	=> 	$employeeData
		);
                echo $_SESSION['project_id'];
		echo json_encode($output);
	}
	public function getEmp(){
            session_start();
		if($_POST["empId"]) {
                    $_SESSION["project_id"]=$_POST["empId"];
			
			$sqlQuery = "
				SELECT * FROM ".$this->empTable." 
				WHERE id = '".$_POST["empId"]."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
                        echo json_encode($row);
		}
	}
	public function updateEmp(){
		if($_POST['empId']) {	
			$updateQuery = "UPDATE ".$this->empTable." 
			SET name = '".$_POST["empName"]."', age = '".$_POST["empAge"]."', skills = '".$_POST["empSkills"]."', address = '".$_POST["address"]."' , designation = '".$_POST["designation"]."'
			WHERE id ='".$_POST["empId"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
		}	
	}
	public function addEmp(){
		$insertQuery = "INSERT INTO ".$this->empTable." (name, age, skills, address, designation, user_id) 
			VALUES ('".$_POST["empName"]."', '".$_POST["empAge"]."', '".$_POST["empSkills"]."', '".$_POST["address"]."', '".$_POST["designation"]."', '".$_SESSION['user_id']."')";
		$isUpdated = mysqli_query($this->dbConnect, $insertQuery);
                $sqlQuery = "
				SELECT max(id) as empId FROM ".$this->empTable." ORDER BY id desc
LIMIT 1";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
                
                $addTasks="INSERT INTO tasks(name, project_id) VALUES('State Facts','".$row['empId']."'),
                ('State Initial Reaction','".$row['empId']."'),
                ('State Changes','".$row['empId']."'),
                ('State Improvements','".$row['empId']."'),
                ('State Why Change Is Important','".$row['empId']."'),
                ('State Future Responsibilities','".$row['empId']."'),
                ('Summarise','".$row['empId']."'),
                ('Model or Categorise What You Mean','".$row['empId']."')";
                $isUpdated2 = mysqli_query($this->dbConnect, $addTasks);
	}
	public function deleteEmp(){
		if($_POST["empId"]) {
			$sqlDelete = "
				DELETE FROM ".$this->empTable."
				WHERE id = '".$_POST["empId"]."'";		
			mysqli_query($this->dbConnect, $sqlDelete);		
		}
	}
        public function taskEmp(){
            //session_start();
		if($_POST["empId"]) {
                    //$id=getEmp();
                    //$_SESSION["project_id"]=$_POST["empId"];
			
			$sqlQuery = "
				SELECT * FROM ".$this->empTable." 
				WHERE project_id = ".$_POST["empId"]."";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
                        echo json_encode($row);
		}
	}
}
//session_abort();
?>