<?php
session_start();
//$_SESSION['project_id']="0";
require('config.php');
class Emp extends Dbconfig {
    
    protected $hostName;
    protected $userName;
    protected $password;
	protected $dbName;
	private $empTable = 'crud_emp';
        private $empTable2 = 'tasks';
        private $empTable3 = 'req';
	
	private $dbConnect = false;
        //private $project_id=0;
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
	public function empList(){		
		$sqlQuery = "SELECT * FROM ".$this->empTable." WHERE user_id='".$_SESSION['user_id']."' ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'AND(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR designation LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR address LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR skills LIKE "%'.$_POST["search"]["value"].'%") ';
                        //$sqlQuery .= ' OR user_id LIKE "%'.$_SESSION["user_id"].'%") ';
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
		
		$sqlQueryTotal = "SELECT * FROM ".$this->empTable." WHERE user_id='".$_SESSION['user_id']."'";
		$resultTotal = mysqli_query($this->dbConnect, $sqlQueryTotal);
		$numRowsTotal = mysqli_num_rows($resultTotal);
		
		$employeeData = array();	
		while( $employee = mysqli_fetch_assoc($result) ) {		
			$empRows = array();			
			$empRows[] = $employee['id'];
			$empRows[] = ucfirst($employee['name']);
			$empRows[] = $employee['address'];
			$empRows[] = $employee['designation'];	
                        	
                       $empRows[] = '<button type="button" name="update" id="'.$employee["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$empRows[] = '<button type="button" name="delete" id="'.$employee["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			//$empRows[] = $employee['user_id'];
                        $empRows[] = '<button type="button" name="view" id="'.$employee["id"].'" class="btn btn-danger btn-xs view" >View</button>';
			$empRows[] = '<button type="button" name="publish" id="'.$employee["id"].'" class="btn btn-warning btn-xs publish">Publish</button>';
			
                        $employeeData[] = $empRows;
		}
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$numRows,
			"iTotalDisplayRecords"	=>  $numRowsTotal,
			"data"	=> 	$employeeData
		);
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
			SET name = '".$_POST["empName"]."', start_date = '".$_POST["start_date"]."', end_date = '".$_POST["end_date"]."', address = '".$_POST["address"]."' , designation = '".$_POST["designation"]."'
			WHERE id ='".$_POST["empId"]."'";
                       
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
		}	
	}
	public function addEmp(){
		$insertQuery = "INSERT INTO ".$this->empTable." (name, start_date, end_date, address, designation, user_id) 
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
        public function viewEmp(){
            //session_start();
		if($_POST["empId"]) {
                    //$id=getEmp();
                    $_SESSION["project_id"]=$_POST["empId"];
			
			$sqlQuery = "
				SELECT * FROM ".$this->empTable." 
				WHERE id = ".$_POST["empId"]."";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
                        echo json_encode($row);
		}
	}
       public function taskList(){
           session_start();
           //$_SESSION['project_id']="0";
          // echo $_POST['id'];
		$sqlQuery2 = "SELECT id, name, description FROM ".$this->empTable2." WHERE project_id='".$_SESSION['project_id']."' ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery2 .= 'AND(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery2 .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery2 .= ' OR descripion LIKE "%'.$_POST["search"]["value"].'%" ';
			}
		if(!empty($_POST["order"])){
			$sqlQuery2 .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery2 .= 'ORDER BY id ASC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery2 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
                //console.log($sqlQuery2);
               $result2 = mysqli_query($this->dbConnect, $sqlQuery2);
		$numRows2 = mysqli_num_rows($result2);
		
		$sqlQueryTotal2 = "SELECT * FROM ".$this->empTable2." WHERE project_id='".$_SESSION['project_id']."'";
		$resultTotal2 = mysqli_query($this->dbConnect, $sqlQueryTotal2);
		$numRowsTotal2 = mysqli_num_rows($resultTotal2);
		
		$employeeData2 = array();	
		while( $employee2 = mysqli_fetch_assoc($result2) ) {		
			$empRows2 = array();			
			$empRows2[] = $employee2['id'];
			$empRows2[] = ucfirst($employee2['name']);
			$empRows2[] = $employee2['description'];	
                        	
                       $empRows2[] = '<button type="button" name="update" id="'.$employee2["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			 $empRows2[] = '<button type="button" name="view" id="'.$employee2["id"].'" class="btn btn-danger btn-xs view" >View</button>';
			
                        $employeeData2[] = $empRows2;
		}
		$output2 = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$numRows2,
			"iTotalDisplayRecords"	=>  $numRowsTotal2,
			"data"	=> 	$employeeData2
		);
		echo json_encode($output2);
	}
        
        public function getTask(){
            //session_start();
		if($_POST["taskId"]) {
                    //$_SESSION["task_id"]=$_POST["taskId"];
			
			$sqlQuery = "
				SELECT * FROM ".$this->empTable2." 
				WHERE id = '".$_POST["taskId"]."'";
                        //$sqlQuery="select * from tasks where id=1";
                        $result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
                        echo json_encode($row);
		}
	}
        public function updateTask(){
            	if($_POST['taskId']) {	
			$updateQuery = "UPDATE ".$this->empTable2." 
			SET name = '".$_POST["taskName"]."', description = '".$_POST["taskDescription"]."' 
			WHERE id ='".$_POST["taskId"]."'";
                       
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
		}	
	}
        public function listReq(){
           session_start();
           //$_SESSION['project_id']="0";
          // echo $_POST['id'];
		$sqlQuery2 = "SELECT id, req, spec FROM ".$this->empTable3." WHERE task_id='".$_SESSION['task_id']."' ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery2 .= 'AND(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery2 .= ' OR req LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery2 .= ' OR spec LIKE "%'.$_POST["search"]["value"].'%" ';
			}
		if(!empty($_POST["order"])){
			$sqlQuery2 .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery2 .= 'ORDER BY id ASC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery2 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
                console.log($sqlQuery2);
               $result2 = mysqli_query($this->dbConnect, $sqlQuery2);
		$numRows2 = mysqli_num_rows($result2);
		
		$sqlQueryTotal2 = "SELECT * FROM ".$this->empTable3." WHERE task_id='".$_SESSION['task_id']."'";
		$resultTotal2 = mysqli_query($this->dbConnect, $sqlQueryTotal2);
		$numRowsTotal2 = mysqli_num_rows($resultTotal2);
		
		$employeeData2 = array();	
		while( $employee2 = mysqli_fetch_assoc($result2) ) {		
			$empRows2 = array();			
			$empRows2[] = $employee2['id'];
			$empRows2[] = ucfirst($employee2['req']);
			$empRows2[] = $employee2['spec'];	
                        	
                       $empRows2[] = '<button type="button" name="update" id="'.$employee2["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			 $empRows2[] = '<button type="button" name="delete" id="'.$employee2["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			
                        $employeeData2[] = $empRows2;
		}
		$output2 = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$numRows2,
			"iTotalDisplayRecords"	=>  $numRowsTotal2,
			"data"	=> 	$employeeData2
		);
		echo json_encode($output2);
	}
        public function viewReq(){
            //session_start();
		if($_POST["taskId"]) {
                    //$id=getEmp();
                    $_SESSION["task_id"]=$_POST["taskId"];
			
			$sqlQuery = "
				SELECT * FROM ".$this->empTable2." 
				WHERE id = ".$_POST["taskId"]."";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
                        echo json_encode($row);
		}
	}
        
        public function addReq(){
            	$insertQuery = "INSERT INTO ".$this->empTable3." (req, spec, task_id) 
			VALUES ('".$_POST["req"]."', '".$_POST["spec"]."', '".$_SESSION['task_id']."')";
		 //$_SESSION['error']=$insertQuery;
		$isUpdated = mysqli_query($this->dbConnect, $insertQuery);
                
	}
        
        public function getReq(){
            //session_start();
		if($_POST["reqId"]) {
                    //$_SESSION["task_id"]=$_POST["taskId"];
			
			$sqlQuery = "
				SELECT * FROM ".$this->empTable3." 
				WHERE id = '".$_POST["reqId"]."'";
                        //$sqlQuery="select * from tasks where id=1";
                        $result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
                        echo json_encode($row);
		}
	}
        public function updateReq(){
            	if($_POST['reqId']) {	
			$updateQuery = "UPDATE ".$this->empTable3." 
			SET req = '".$_POST["req"]."', spec = '".$_POST["spec"]."' 
			WHERE id ='".$_POST["reqId"]."'";
                       
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
		}	
	}
        public function deleteReq(){
		if($_POST["reqId"]) {
			$sqlDelete = "
				DELETE FROM ".$this->empTable3."
				WHERE id = '".$_POST["reqId"]."'";		
			mysqli_query($this->dbConnect, $sqlDelete);		
		}
	}
}

//echo "hi ";
//session_abort();
