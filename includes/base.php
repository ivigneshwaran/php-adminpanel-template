<?php
// Base URL Start=================

$url = '/knee/';

if(isset($_SERVER['HTTPS'])) {
	$base_url = 'https://'.$_SERVER['HTTP_HOST'].$url;
}
else{
	$base_url = 'http://'.$_SERVER['HTTP_HOST'].$url;
}
// Base URL End=================
?>