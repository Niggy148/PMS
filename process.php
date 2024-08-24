<?php
include('Emp2.php');
//include('Publish.php');
$emp = new Emp();

//$emp2 = new Publish();
if(!empty($_POST['action']) && $_POST['action'] == 'empList') {
	$emp->getData();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addEmp') {
	$emp->addEmp();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getEmp') {
	$emp->getEmp();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateEmp') {
	$emp->updateEmp();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteEmp') {
	$emp->deleteEmp();
}
if(!empty($_POST['action']) && $_POST['action'] == 'viewEmps') {
	$emp->viewEmp();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listTasks') {
	$emp->taskList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getTask') {
	$emp->getTask();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateTask') {
	$emp->updateTask();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listReqs') {
	$emp->listReq();
}
if(!empty($_POST['action']) && $_POST['action'] == 'viewReqs') {
	$emp->viewReq();
} 
if(!empty($_POST['action']) && $_POST['action'] == 'addReqs') {
	$emp->addReq();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getReq') {
	$emp->getReq();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateReq') {
	$emp->updateReq();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteReq') {
	$emp->deleteReq();
}


if(!empty($_POST['action']) && $_POST['action'] == 'publishEmps') {
	$emp2->test();
}
 