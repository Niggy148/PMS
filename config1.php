<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'bollox');
define('DB_NAME', 'coderszine_demos');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 try {
     //$link= new PDO("mysql:host=DB_SERVER; dbname=DB_NAME,DB_USERNAME,DB_PASSWORD ");
 } catch (Exception $ex) {

 }
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>