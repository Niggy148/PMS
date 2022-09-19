<?php

//use PhpOffice;

session_start();
//$_SESSION['project_id']="0";
require('config.php');

class Publish extends Dbconfig
{
      
    protected $hostName;
    protected $userName;
    protected $password;
	protected $dbName;
	private $empTable = 'crud_emp';
        private $empTable2 = 'tasks';
        private $empTable3 = 'req';
	private $PHPWord=null;
	private $dbConnect = false;
        //private $PHPWord = null;
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
        //test();
    }
    
    public function test()
 {
        
        //require_once 'bootstrap.php';         
require_once 'vendor/autoload.php';
     //$this->load->library('PHPWord');
     // Create a new PHPWord Object
     $PHPWord = new \PhpOffice\PhpWord\PhpWord();
//$PHPWord = new \PhpOffice\PhpWord\TemplateProcessor('mytemplate.odt');     
$section = $PHPWord->createSection();
     
      $section->addText('Project Management System - CHEW');
      $section->addTextBreak(1);
      $sql = "SELECT * FROM crud_emp where id='".$_SESSION['project_id']."'";
$result = mysqli_query($this->dbConnect, $sql);

// Associative array
$row = mysqli_fetch_assoc($result);
//printf ("%s (%s)\n", $row["Lastname"], $row["Age"]);
     $section->addText($row['name'], array('name' => 'Tahoma', 'size' => 16, 'bold' => true, 'underline'=>'single'));
     $PHPWord->addFontStyle('myOwnStyle', array('name' => 'Verdana', 'size' => 12, 'color' => '1B2232', 'underline'=>'single'));
      $section->addText($row['designation']);
     // You can also putthe appended element to local object an call functions like this:
      $sql = "SELECT * FROM tasks where project_id='".$_SESSION['project_id']."'";
$result = mysqli_query($this->dbConnect, $sql);

// Associative array
//$row = mysqli_fetch_assoc($result);
$i=0;
$arr=array();
while (($data = mysqli_fetch_assoc($result)))
        {
    $arr[$i]=$data['id'];
    $PHPWord->addFontStyle('myOwnStyle2', array('name' => 'Tahoma', 'bold'=>true, 'size' => 14, 'underline'=>'single'));
     $section->addTextBreak(1);
    $myTextElement = $section->addText($data['name'], array('name'=>'Tahoma', 'size'=>12, 'underline'=>'single'));
     $myTextElement = $section->addText($data['description']);
     $i++;
}
     
     $section->addTextBreak(1);
     $styleTable = array('borderColor' => '006699', 'unit'=>\PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,'width'=>100*50, 'borderSize' => 6, 'cellMargin' => 50, 'borderStyle'=>'solid');
     $styleFirstRow = array('bgColor' => '66BBFF');
     $PHPWord->addTableStyle('myTable', $styleTable, $styleFirstRow);
     $table = $section->addTable('myTable');
     $table->addRow();
     $cell = $table->addCell(2000);
     $cell->addText('Specification of Requirements');
     for ($i=0;$i<8;$i++){
     $sql = "SELECT * FROM req where task_id='".$arr[$i]."'";
$result = mysqli_query($this->dbConnect, $sql);
while ($data = mysqli_fetch_assoc($result)){
    $table->addRow(); 
    $cell = $table->addCell(2000);
     $cell->addText($data['req']);
     $cell = $table->addCell(2000);
     $cell->addText($data['spec']);
}
     }
     //$objWriter = IOFactory::createWriter($PHPWord, 'Word2007');
     //$objWriter->save('helloworld.docx');
     //exit;
       
      
     //download
     		
     $filename='helloworld.odt'; //save our document as this file name
     header('Content-Type:application/octet-stream');
     header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
     header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
     header('Cache-Control: max-age=0'); //no cache
      // XML Writer compatibility
     
\PhpOffice\PhpWord\Settings::setCompatibility(false);

    // Saving the document as OOXML file...
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, "ODText");
    ob_start();
    //$path=Storage::get('/home/nigel/helloworld.odt');
    $objWriter->save('php://output');
    //$PHPWord->saveAs($filename);
    
     $sqlQuery = "
				SELECT * FROM crud_emp  
				WHERE id = '".$_POST["empId"]."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
                        echo json_encode($row);
 }
    
   public function test2(){
       $_SESSION['project_id']=$_POST['empId'];
       $file="helloworld.odt downloaded.  Location in browser preferences.";
       echo json_encode($file);
   } 
    
}