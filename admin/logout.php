<?php 
include_once('../includes/config.php');
if($fn->logout()){
	header('Location: login.php');
}
?>