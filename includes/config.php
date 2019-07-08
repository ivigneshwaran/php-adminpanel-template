<?php
if(!isset($_SESSION)){ session_start(); }

require_once("base.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wwwmanim_knee";

$dbaccess = 'mysqli'; //mysqli, pdo

if($dbaccess=='mysqli'){
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	mysqli_set_charset($conn,"utf8");
	
	require_once("sql_functions.php");
}else if($dbaccess=='pdo'){
	/*try {
		$conn = new PDO("mysql:host=$servername;dbname=abctamil", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected successfully"; 
	}catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}*/
	//require_once("pdo_functions.php");
}
?>