<?php
$admin_url = str_replace('/','',$ad_base);
$pg_slug = $pg_key = $pg_real = 'index';
$slice = $ct_slug = $mactive = $in = $title = '';
$step1 = array();
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 

$pretify = str_replace($url,'',$uri);

if($pretify!=''){
	$step1 = explode('/',rtrim($pretify,' /'));
	$slice = count($step1);
	if($slice==1){
		if($step1[0]!=$admin_url){
			$pg_slug = $step1[0];
		}		
	}
	if($pg_slug=='call_ajax'){
		include_once('fr_ajax.php');
		exit;
	}
}
?>