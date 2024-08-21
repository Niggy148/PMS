<?php
include('Publish.php');
$emp2 = new Publish();
if(!empty($_POST['action']) && $_POST['action'] == 'publishEmps') {
	$emp2->test2();
}
 

