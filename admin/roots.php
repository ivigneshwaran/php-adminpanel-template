<?php	
	$slice = $ct_slug =  '';
	$step1 = array();
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

	$pretify = str_replace($ad_base,'',$uri);

	if($pretify!=''){
		$step1 = explode('/',rtrim($pretify,' /'));
		$slice = count($step1);
		if(end($step1)=='call_ajax'){
			include_once('ad_ajax.php');
			die;
		}
	}
?>