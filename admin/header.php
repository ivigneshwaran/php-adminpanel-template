<?php //include_once('../beaver.php'); 
include_once('../includes/config.php');
include_once('../includes/ad-base.php');
if(!$fn->login()){
	header('Location: login.php');
}
include_once('roots.php');
$options = [
    'cost' => 12,
];
//echo password_hash("Chandra@2019", PASSWORD_BCRYPT, $options); die;
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title; ?></title>
     <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="../js/jquery-1.9.1.js"></script>
	<script src="../js/jquery-migrate-1.2.1.min.js"></script>
	<!--<script src="../js/jquery.min.js"></script>
	<script src="../js/jquery-migrate-1.2.1.min.js"></script>-->
	<script src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
	<!--<script src="https://cdn.ckeditor.com/4.11.4/standard-all/ckeditor.js"></script>-->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<script src="../js/admin.js"></script>
	<script src="../js/notify.js"></script>
	<script>ad_base='<?php echo $ad_base; ?>';</script>
	<link href="../css/notify.css" rel="stylesheet" type="text/css">
	<style>
    #page-wrapper{
		min-height: 700px;
	}
	.navbar-inverse .navbar-nav>.active>ul>.active>a, .navbar-inverse .navbar-nav>.active>ul>.active>a:focus, .navbar-inverse .navbar-nav>.active>ul>.active>a:hover {
		color: #fff;
		background-color: #080808;
	}
	.notify-message{
		width: 600px;
		text-align: center;
		top: 80px;
	}
	.rd-left{
		float:left;
		word-wrap: break-word;
	}
	.rd-right{
		float:right;
	}
	.lists {
		height: 200px;
		width: 300px;
		border: 1px solid #000000;
	}
	.out-head{
		background: #ddd !important;
		font-weight: bold;
	}
	.in-head{
		background: #f5f5f5;
		font-weight: bold;
	}
	.fa-chevron-right, .fa-chevron-left{
		margin-left: -22px;
		margin-right: 7px;
		cursor: pointer;
	}
	.rd-cntrl{
		position:relative;
		z-index: 99;
		float: right;
	}
	#blanket {
		background-color: #111;
		opacity: 0.65;
		position: fixed;
		z-index: 1;
		top: 0px;
		left: 0px;
	}
	#sortable { list-style-type: none; margin: 0; padding: 0; }
	#sortable li { margin: 0px 2px 3px 2px; float: left; width: 122px; height: 150px; text-align: center; border: 1px solid #999;}
	.ui-sortable-placeholder { height: 1.5em; line-height: 1.2em; border: 3px solid #999;}
	</style>
</head>
<body>
<?php 
function mactiv($chk1,$chk2){
	echo ($chk1==$chk2) ? 'active' : '';
}
function in($chk1,$chk2){
	echo ($chk1==$chk2) ? 'in' : '';
}
?>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Welcome to Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php $fn->user(); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu" style="width: 170px;">
						<li>
                            <a href="../"><i class="fa fa-fw fa-globe"></i> kneeworld.in</a>
                        </li>                        
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="<?php mactiv('index',$mactive); ?>">
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="<?php mactiv('addcat',$mactive); ?>">
                        <a href="pages.php?action=addcat"><i class="glyphicon glyphicon-th-list"></i> Category</a>
                    </li>                   
					<li class="<?php mactiv('pages',$mactive); ?>">
						<a href="javascript:;" data-toggle="collapse" data-target="#pages"><i class="glyphicon glyphicon-picture"></i> Pages <i class="fa fa-fw fa-caret-down"></i></a>
						<ul id="pages" class="collapse <?php in('pg',$in); ?>">
							<li class="<?php mactiv('all',$smactive); ?>">
								<a href="pages.php">All Pages</a>
							</li>
							<li class="<?php mactiv('addnew',$smactive); ?>">
								<a href="pages.php?action=addnew">Add New</a>
							</li>							
						</ul>
                    </li>                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
		<div id="blanket" style="display: none;"></div>