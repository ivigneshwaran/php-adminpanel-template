<?php
	include_once('../includes/config.php');
	$err = '';
	//echo sha1('admin#123');
	//$ip = $_SERVER['REMOTE_ADDR'];
/*	$details = json_decode(file_get_contents("http://ipinfo.io/".$ip."/json"));
		
	$log  = "IP: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		//"Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
		"User: ".$_POST['username'].PHP_EOL.
		"Pass: ".$_POST['password'].PHP_EOL.
		"City: ".$details->city.PHP_EOL.
		"Region: ".$details->region.PHP_EOL.
		"Country: ".$details->country.PHP_EOL.
		"Location: ".$details->loc.PHP_EOL.
		"-------------------------".PHP_EOL;
	
	file_put_contents('../../gol.txt', $log, FILE_APPEND); */
	
	if(isset($_POST['submit'])){
		if(!$fn->dblogin($_POST['username'],$_POST['password'])){
			$err = 'Username or Password wrong!';
		}else{
			header('Location: index.php');
			die;
		}
	}
//echo $fn->Encr('admin@987');
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
      @import url(http://fonts.googleapis.com/css?family=Exo:100,200,400);
@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

body{
	margin: 0;
	padding: 0;
	background: #fff;
    overflow: hidden;
	color: #fff;
	font-family: Arial;
	font-size: 12px;
}

.body{
	position: absolute;
	top: -20px;
	left: -20px;
	right: -40px;
	bottom: -40px;
	width: auto;
	height: auto;
	background-image: url(../img/bg.jpg);
	background-size: cover;
	-webkit-filter: blur(1px);
	z-index: 0;
}

.grad{
	position: absolute;
	top: -20px;
	left: -20px;
	right: -40px;
	bottom: -40px;
	width: auto;
	height: auto;
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
	z-index: 1;
	opacity: 0.7;
}

.header{
	position: relative;
	/*top: calc(50% - 35px);
	left: calc(50% - 255px);*/
	z-index: 2;
}

.header div{
	/*float: left;*/
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 35px;
	font-weight: 200;
}

.header div span{
	color: #5379fa !important;
	font-weight:bold;
	font-size: 50px;
}

.login{
	position: relative;
	/*top: calc(50% - 75px);
	left: calc(50% - 50px);
	width: 350px;*/
	height: 150px;
	padding: 10px;
	z-index: 2;
}

.login input[type=text]{
	width: 260px;
	height: 40px;
	background: transparent;
	border: 1px solid rgba(255,255,255,0.6);
	border-radius: 2px;
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 16px;
	font-weight: 400;
	padding: 4px;
}

.login input[type=password]{
	width: 260px;
	height: 40px;
	background: transparent;
	border: 1px solid rgba(255,255,255,0.6);
	border-radius: 2px;
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 16px;
	font-weight: 400;
	padding: 4px;
	margin-top: 10px;
}

.login input[type=submit]{
	width: 260px;
	height: 35px;
	background: #fff;
	border: 1px solid #fff;
	cursor: pointer;
	border-radius: 2px;
	color: #a18d6c;
	font-family: 'Exo', sans-serif;
	font-size: 16px;
	font-weight: 400;
	padding: 6px;
	margin-top: 10px;
}

.login input[type=submit]:hover{
	opacity: 0.8;
}

.login input[type=submit]:active{
	opacity: 0.6;
}

.login input[type=text]:focus{
	outline: none;
	border: 1px solid rgba(255,255,255,0.9);
}

.login input[type=password]:focus{
	outline: none;
	border: 1px solid rgba(255,255,255,0.9);
}

.login input[type=submit]:focus{
	outline: none;
}

::-webkit-input-placeholder{
   color: rgba(255,255,255,0.6);
}

::-moz-input-placeholder{
   color: rgba(255,255,255,0.6);
}
.logerr{
	position: absolute;
    top: -10px;
    left: 52px;
	color: #FFF800;
}
.logo{
	position: relative;
    	width: 100px;
    	margin: 5px;
	border-radius: 5px;
	background: rgba(255,255,255,0.8);
}

@media screen and (min-width:768px){
	.header{
		text-align: right;
		position: relative;
		top: 65px;
	}
}
@media screen and (max-width:767px){
	.row{
		text-align: center;
	}
}
</style>
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="body"></div>
	<div class="grad"></div>
	<div class="col-md-12" style="margin-top:250px">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="header">
					<div>Make<span>Login</span></div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 ">
				<br>
				<form method="post">
					<div class="login">
						<?php if($err!=''){echo '<div class="logerr">'.$err.'</div>'; } ?>
						<input type="text" placeholder="username" name="username"><br>
						<input type="password" placeholder="password" name="password"><br>
						<input type="submit" name="submit" value="Login">
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</body>
</html>
